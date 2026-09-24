<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_creates_lead(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'John Doe',
            'organization' => 'SMPN 1 Cikarang',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'message' => 'Saya interested in paskibra attributes.',
            'product_interest' => 'Atribut Paskibra',
        ]);

        $response->assertRedirectContains('wa.me');

        $this->assertDatabaseHas('leads', [
            'contact_name' => 'John Doe',
            'organization' => 'SMPN 1 Cikarang',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'source' => 'website_contact',
            'status' => 'new',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/kontak', []);

        $response->assertSessionHasErrors(['name', 'phone']);
    }

    public function test_contact_form_requires_valid_email(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'John Doe',
            'phone' => '081234567890',
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
