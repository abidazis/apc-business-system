<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\Settings;
use App\Support\WhatsApp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsAndWhatsAppTest extends TestCase
{
    use RefreshDatabase;

    public function test_whatsapp_number_normalizes_indonesian_format(): void
    {
        Settings::set('whatsapp', '0812-3456-7890');
        $this->assertEquals('6281234567890', Settings::whatsappNumber());
    }

    public function test_whatsapp_url_contains_wa_me(): void
    {
        Settings::set('whatsapp', '6281200000000');
        $url = WhatsApp::url('Halo');
        $this->assertStringContainsString('wa.me/6281200000000', $url);
        $this->assertStringContainsString(rawurlencode('Halo'), $url);
    }

    public function test_settings_have_defaults(): void
    {
        $this->assertNotEmpty(Settings::get('business_name'));
        $this->assertEquals('IDR', Settings::get('currency'));
    }

    public function test_super_admin_can_update_settings(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
        $this->actingAs($user)
            ->post('/admin/settings', [
                'business_name' => 'APC Baru',
                'business_short' => 'APC',
                'whatsapp' => '6281200000000',
                'invoice_prefix' => 'INV',
                'order_prefix' => 'ORD',
                'currency' => 'IDR',
                'currency_symbol' => 'Rp',
            ])
            ->assertRedirect();
        $this->assertEquals('APC Baru', Settings::get('business_name'));
    }
}
