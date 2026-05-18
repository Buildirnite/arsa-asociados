<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private array $validPayload = [
        'name'    => 'María González',
        'email'   => 'maria@ejemplo.cl',
        'phone'   => '+56 9 1234 5678',
        'message' => 'Buenos días, quisiera consultar sobre mi caso.',
    ];

    public function test_contact_form_stores_message_in_database(): void
    {
        Mail::fake();

        $this->post('/contacto', $this->validPayload)->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'name'  => 'María González',
            'email' => 'maria@ejemplo.cl',
        ]);
        $this->assertDatabaseCount('contact_messages', 1);
    }

    public function test_contact_form_requires_name_email_and_message(): void
    {
        $response = $this->post('/contacto', []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_form_validates_email_format(): void
    {
        $response = $this->post('/contacto', array_merge($this->validPayload, [
            'email' => 'no-es-un-email',
        ]));

        $response->assertSessionHasErrors(['email']);
    }

    public function test_contact_form_rate_limits_after_three_submissions(): void
    {
        Cache::flush();
        Mail::fake();

        for ($i = 0; $i < 3; $i++) {
            $this->post('/contacto', $this->validPayload)->assertRedirect();
        }

        $this->post('/contacto', $this->validPayload)->assertStatus(429);
    }
}
