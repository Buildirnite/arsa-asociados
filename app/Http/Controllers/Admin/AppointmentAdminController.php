<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pendiente,confirmada,cancelada'],
        ]);

        $appointment->update(['status' => $validated['status']]);

        return back()->with('success', 'Cita actualizada.');
    }
}
