<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
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

        return back()
            ->with('success', '¡Mensaje enviado! Nos pondremos en contacto a la brevedad.')
            ->withInput([]);
    }
}
