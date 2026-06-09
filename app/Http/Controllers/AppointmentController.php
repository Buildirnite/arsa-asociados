<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Support\AppointmentSlots;
use App\Support\PracticeAreas;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

use function Illuminate\Support\defer;

class AppointmentController extends Controller
{
    public function create(): View
    {
        return view('appointments.create', [
            'areas' => PracticeAreas::all(),
        ]);
    }

    /** Devuelve los horarios disponibles de una fecha (consumido por JS). */
    public function slots(Request $request): JsonResponse
    {
        $request->validate(['date' => ['required', 'date']]);

        $date = Carbon::parse($request->input('date'))->startOfDay();

        if (! AppointmentSlots::isBookableDate($date)) {
            return response()->json(['slots' => [], 'message' => 'No atendemos en esa fecha.']);
        }

        return response()->json(['slots' => AppointmentSlots::availableForDay($date)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'area'    => ['nullable', 'string', 'max:80'],
            'message' => ['nullable', 'string', 'max:1000'],
            'date'    => ['required', 'date'],
            'slot'    => ['required', 'date_format:H:i'],
        ]);

        $date = Carbon::parse($validated['date'])->startOfDay();

        if (! AppointmentSlots::isBookableDate($date)) {
            throw ValidationException::withMessages(['date' => 'La fecha elegida no está disponible.']);
        }

        if (! in_array($validated['slot'], AppointmentSlots::availableForDay($date), true)) {
            throw ValidationException::withMessages(['slot' => 'Ese horario ya fue reservado. Por favor elija otro.']);
        }

        [$h, $m] = explode(':', $validated['slot']);
        $scheduledAt = $date->copy()->setTime((int) $h, (int) $m);

        if (AppointmentSlots::hasConflict($scheduledAt)) {
            throw ValidationException::withMessages(['slot' => 'Ese horario ya fue reservado. Por favor elija otro.']);
        }

        $appointment = Appointment::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'area'         => $validated['area'] ?? null,
            'message'      => $validated['message'] ?? null,
            'scheduled_at' => $scheduledAt,
            'status'       => 'pendiente',
        ]);

        // Los correos SMTP (Gmail) tardan varios segundos. Se envían después de
        // responder para que el usuario vea la confirmación al instante.
        defer(fn () => $this->notify($appointment));

        return redirect()
            ->route('agendar.confirmacion')
            ->with('appointment_id', $appointment->id);
    }

    /** Página de confirmación con el detalle de la cita recién agendada. */
    public function confirmation(Request $request): View|RedirectResponse
    {
        $id = $request->session()->get('appointment_id');
        $appointment = $id ? Appointment::find($id) : null;

        if (! $appointment) {
            return redirect()->route('agendar.create');
        }

        // Mantener el detalle si el usuario refresca la página.
        $request->session()->keep('appointment_id');

        return view('appointments.confirmation', ['appointment' => $appointment]);
    }

    private function notify(Appointment $appointment): void
    {
        // Aviso al estudio.
        try {
            Mail::send([], [], function ($mail) use ($appointment) {
                $mail->to(config('app.mail_contact_address', 'catalynaarmas@gmail.com'))
                    ->replyTo($appointment->email, $appointment->name)
                    ->subject('Nueva cita agendada — ' . $appointment->scheduled_at->format('d/m/Y H:i'))
                    ->html(view('emails.appointment-admin', ['appointment' => $appointment])->render());
            });
        } catch (\Throwable $e) {
            report($e);
        }

        // Confirmación al cliente.
        try {
            Mail::send([], [], function ($mail) use ($appointment) {
                $mail->to($appointment->email, $appointment->name)
                    ->subject('Confirmación de su cita — Arsa & Asociados')
                    ->html(view('emails.appointment-confirmation', ['appointment' => $appointment])->render());
            });
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
