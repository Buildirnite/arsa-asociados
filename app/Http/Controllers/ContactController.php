<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Protección anti-bots. Si se detecta spam, fingimos éxito sin guardar
        // ni enviar nada: así el bot no sabe que fue bloqueado.
        if ($this->isSpam($request)) {
            return back()->with('success', '¡Mensaje enviado! Nos pondremos en contacto a la brevedad.');
        }

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create($validated);

        Mail::send([], [], function ($mail) use ($validated) {
            $mail->to(config('app.mail_contact_address', 'catalynaarmas@gmail.com'))
                ->replyTo($validated['email'], $validated['name'])
                ->subject('Nueva consulta de ' . $validated['name'])
                ->html(
                    view('emails.contact', $validated)->render()
                );
        });

        // Confirmación automática al cliente. Si falla, no debe afectar el flujo.
        try {
            Mail::send([], [], function ($mail) use ($validated) {
                $mail->to($validated['email'], $validated['name'])
                    ->subject('Hemos recibido su consulta — Arsa & Asociados')
                    ->html(
                        view('emails.contact-confirmation', $validated)->render()
                    );
            });
        } catch (\Throwable $e) {
            report($e);
        }

        return back()
            ->with('success', '¡Mensaje enviado! Nos pondremos en contacto a la brevedad.')
            ->withInput([]);
    }

    /**
     * Detecta envíos automatizados mediante dos trampas:
     *  1. Honeypot: un campo oculto que solo los bots rellenan.
     *  2. Time-trap: un humano tarda más de 3 segundos en completar el formulario.
     */
    protected function isSpam(Request $request): bool
    {
        if (filled($request->input('website'))) {
            return true;
        }

        $loadedAt = (int) $request->input('form_loaded_at');

        return $loadedAt > 0 && (now()->timestamp - $loadedAt) < 3;
    }
}
