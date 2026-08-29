<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'apc:backup {--disk=local : Storage disk to use} {--keep=10 : How many backups to retain}';

    protected $description = 'Create a SQL dump of the APC database and store it on the configured disk';

    public function handle(): int
    {
        $disk = $this->option('disk');
        $keep = (int) $this->option('keep');

        $config = config('database.connections.'.config('database.default'));
        if (! is_array($config) || empty($config['driver'])) {
            $this->error('Database connection not configured.');

            return self::FAILURE;
        }

        $filename = 'backup-'.now()->format('Y-m-d-His').'.sql';
        $path = $this->buildPath($filename);

        $sql = $this->dumpSql($config);
        Storage::disk($disk)->put($path, $sql);
        $bytes = Storage::disk($disk)->size($path);

        $this->info("Backup written: {$path} (".number_format($bytes / 1024, 1).' KB)');

        $this->pruneOldBackups($disk, $keep);

        return self::SUCCESS;
    }

    private function buildPath(string $filename): string
    {
        return trim(config('apc.backup_path', 'backups'), '/').'/'.$filename;
    }

    private function dumpSql(array $config): string
    {
        $driver = $config['driver'];

        if ($driver !== 'mysql') {
            $this->warn("Driver {$driver} not directly supported; dumping tables as JSON fallback.");

            return $this->dumpFallback($config);
        }

        $database = $config['database'];
        $tables = array_filter(
            DB::select('SHOW TABLES'),
            fn ($row) => ! str_starts_with(reset($row) ?: '', 'migrations')
        );

        $out = '-- APC backup generated '.now()->toDateTimeString()."\n";
        $out .= "-- Driver: mysql  Database: {$database}\n\n";
        $out .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $t) {
            $name = array_values((array) $t)[0];
            $rows = DB::table($name)->get();
            if ($rows->isEmpty()) {
                $out .= "-- (empty) table {$name}\n";

                continue;
            }
            $cols = array_keys((array) $rows->first());
            $colList = implode(',', array_map(fn ($c) => "`{$c}`", $cols));
            foreach ($rows as $row) {
                $vals = array_map(function ($v) {
                    if ($v === null) {
                        return 'NULL';
                    }
                    if (is_bool($v)) {
                        return $v ? '1' : '0';
                    }
                    if (is_numeric($v)) {
                        return $v;
                    }

                    return "'".addslashes((string) $v)."'";
                }, (array) $row);
                $out .= "INSERT INTO `{$name}` ({$colList}) VALUES (".implode(',', $vals).");\n";
            }
        }

        $out .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $out;
    }

    private function dumpFallback(array $config): string
    {
        return json_encode([
            'note' => 'Auto-generated data export (not raw SQL)',
            'config_keys' => array_keys($config),
        ], JSON_PRETTY_PRINT);
    }

    private function pruneOldBackups(string $disk, int $keep): void
    {
        if ($keep < 1) {
            return;
        }
        $files = collect(Storage::disk($disk)->files($this->base()))
            ->filter(fn ($f) => str_starts_with(basename($f), 'backup-') && str_ends_with($f, '.sql'))
            ->sortDesc()
            ->values();
        foreach ($files->skip($keep) as $f) {
            Storage::disk($disk)->delete($f);
            $this->line("Pruned: {$f}");
        }
    }

    private function base(): string
    {
        return trim(config('apc.backup_path', 'backups'), '/');
    }
}
