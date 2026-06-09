<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Support\AppointmentSlots;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** Próximo lunes a mediodía, para tener una fecha laborable estable. */
    private function nextMonday(): Carbon
    {
        return Carbon::now()->next(Carbon::MONDAY)->startOfDay();
    }

    public function test_booking_page_renders(): void
    {
        $this->get(route('agendar.create'))
            ->assertOk()
            ->assertSee('Reserve su primera consulta');
    }

    public function test_slots_endpoint_returns_times_for_a_working_day(): void
    {
        $monday = $this->nextMonday();

        $this->getJson(route('agendar.slots', ['date' => $monday->toDateString()]))
            ->assertOk()
            ->assertJsonStructure(['slots'])
            ->assertJsonFragment(['09:00']);
    }

    public function test_sunday_has_no_slots(): void
    {
        $sunday = Carbon::now()->next(Carbon::SUNDAY)->startOfDay();

        $this->assertSame([], AppointmentSlots::slotsForDay($sunday));
    }

    public function test_can_book_an_appointment(): void
    {
        Mail::fake();
        $monday = $this->nextMonday();

        $this->post(route('agendar.store'), [
            'name'  => 'Juan Pérez',
            'email' => 'juan@ejemplo.cl',
            'phone' => '+56 9 1111 1111',
            'area'  => 'Derecho Civil',
            'date'  => $monday->toDateString(),
            'slot'  => '10:30',
        ])->assertRedirect(route('agendar.create'));

        $this->assertDatabaseHas('appointments', [
            'email'  => 'juan@ejemplo.cl',
            'status' => 'pendiente',
        ]);
    }

    public function test_taken_slot_is_not_offered_again(): void
    {
        $monday = $this->nextMonday();

        Appointment::create([
            'name' => 'Ocupado', 'email' => 'x@x.cl',
            'scheduled_at' => $monday->copy()->setTime(10, 30),
            'status' => 'pendiente',
        ]);

        $slots = AppointmentSlots::availableForDay($monday);

        $this->assertNotContains('10:30', $slots);
    }

    public function test_cannot_double_book_the_same_slot(): void
    {
        Mail::fake();
        $monday = $this->nextMonday();

        Appointment::create([
            'name' => 'Primero', 'email' => 'a@a.cl',
            'scheduled_at' => $monday->copy()->setTime(11, 15),
            'status' => 'pendiente',
        ]);

        $this->post(route('agendar.store'), [
            'name'  => 'Segundo',
            'email' => 'b@b.cl',
            'date'  => $monday->toDateString(),
            'slot'  => '11:15',
        ])->assertSessionHasErrors('slot');

        $this->assertDatabaseCount('appointments', 1);
    }

    public function test_admin_can_confirm_an_appointment(): void
    {
        $appt = Appointment::create([
            'name' => 'Cliente', 'email' => 'c@c.cl',
            'scheduled_at' => $this->nextMonday()->copy()->setTime(9, 0),
            'status' => 'pendiente',
        ]);

        $this->withSession(['admin_authenticated' => true])
            ->patch(route('admin.citas.updateStatus', $appt), ['status' => 'confirmada'])
            ->assertRedirect();

        $this->assertSame('confirmada', $appt->fresh()->status);
    }

    public function test_cancelled_appointment_frees_the_slot(): void
    {
        $monday = $this->nextMonday();

        Appointment::create([
            'name' => 'Cancelada', 'email' => 'z@z.cl',
            'scheduled_at' => $monday->copy()->setTime(12, 0),
            'status' => 'cancelada',
        ]);

        $this->assertContains('12:00', AppointmentSlots::availableForDay($monday));
    }
}
