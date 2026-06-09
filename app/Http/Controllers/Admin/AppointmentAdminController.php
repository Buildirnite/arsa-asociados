<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Support\AppointmentSlots;
use App\Support\PracticeAreas;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AppointmentAdminController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->input('estado');

        $appointments = Appointment::query()
            ->when(in_array($filter, ['pendiente', 'confirmada', 'cancelada'], true),
                fn ($q) => $q->where('status', $filter))
            ->orderByDesc('scheduled_at')
            ->paginate(20)
            ->withQueryString();

        $pending = Appointment::where('status', 'pendiente')->count();

        return view('admin.citas.index', compact('appointments', 'pending'));
    }

    public function create(): View
    {
        return view('admin.citas.form', [
            'appointment' => new Appointment(['status' => 'confirmada']),
            'areas'       => PracticeAreas::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Appointment::create($this->validated($request, enforceFuture: true));

        return redirect()
            ->route('admin.citas.index')
            ->with('success', 'Cita creada.');
    }

    public function edit(Appointment $appointment): View
    {
        return view('admin.citas.form', [
            'appointment' => $appointment,
            'areas'       => PracticeAreas::all(),
        ]);
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        // En edición se permite mantener fechas pasadas (registros históricos),
        // pero igual se valida que no choque con otra cita.
        $appointment->update($this->validated($request, enforceFuture: false, ignoreId: $appointment->id));

        return redirect()
            ->route('admin.citas.index')
            ->with('success', 'Cita actualizada.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()
            ->route('admin.citas.index')
            ->with('success', 'Cita eliminada.');
    }

    /** Cambio rápido de estado desde el listado (confirmar/cancelar). */
    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pendiente,confirmada,cancelada'],
        ]);

        $appointment->update(['status' => $validated['status']]);

        return back()->with('success', 'Cita actualizada.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, bool $enforceFuture, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:150'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'area'         => ['nullable', 'string', 'max:80'],
            'message'      => ['nullable', 'string', 'max:1000'],
            'scheduled_at' => array_merge(['required', 'date'], $enforceFuture ? ['after_or_equal:today'] : []),
            'status'       => ['required', 'in:pendiente,confirmada,cancelada'],
        ]);

        // No permitir dos citas (activas) en el mismo horario o muy cerca.
        if ($validated['status'] !== 'cancelada'
            && AppointmentSlots::hasConflict(Carbon::parse($validated['scheduled_at']), $ignoreId)) {
            throw ValidationException::withMessages([
                'scheduled_at' => 'Ya existe una cita en ese horario (o muy cerca). Elija otro.',
            ]);
        }

        return $validated;
    }
}
