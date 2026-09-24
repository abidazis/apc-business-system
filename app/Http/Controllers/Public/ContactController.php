<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\Activity;
use App\Support\Settings;
use App\Support\WhatsApp;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'organization' => ['nullable', 'string', 'max:160'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:160'],
            'message' => ['nullable', 'string', 'max:1000'],
            'product_interest' => ['nullable', 'string', 'max:255'],
        ], [], [
            'name' => 'Nama',
            'organization' => 'Organisasi/Instansi',
            'phone' => 'WhatsApp',
            'email' => 'Email',
            'message' => 'Pesan',
            'product_interest' => 'Produk yang Diminati',
        ]);

        // Create lead from contact form
        $lead = Lead::create([
            'contact_name' => $data['name'],
            'organization' => $data['organization'] ?? null,
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'source' => 'website_contact',
            'status' => 'new',
            'notes' => $this->buildNotes($data),
        ]);

        Activity::record('lead.created', $lead, ['source' => 'contact_form']);

        // Build WhatsApp message
        $business = Settings::get('business_short', 'APC');
        $message = "Halo {$business}, saya sudah mengirim pesan melalui website.\n\n";
        $message .= "Nama: {$data['name']}\n";
        if (! empty($data['organization'])) {
            $message .= "Organisasi: {$data['organization']}\n";
        }
        if (! empty($data['product_interest'])) {
            $message .= "Produk Diminati: {$data['product_interest']}\n";
        }
        if (! empty($data['message'])) {
            $message .= "\nPesan:\n{$data['message']}";
        }
        $message .= "\n\nMohon informasinya, terima kasih.";

        $waUrl = WhatsApp::url($message);

        return redirect()->to($waUrl)->with('contact_submitted', true);
    }

    private function buildNotes(array $data): string
    {
        $notes = [];
        if (! empty($data['message'])) {
            $notes[] = "Pesan: {$data['message']}";
        }
        if (! empty($data['product_interest'])) {
            $notes[] = "Produk Minat: {$data['product_interest']}";
        }
        $notes[] = 'Sumber: Form Kontak Website';

        return implode("\n", $notes);
    }
}
