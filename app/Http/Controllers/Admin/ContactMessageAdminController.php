<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageAdminController extends Controller
{
    public function index(): View
    {
        $messages  = ContactMessage::orderByDesc('created_at')->paginate(20);
        $unread    = ContactMessage::whereNull('read_at')->count();

        return view('admin.mensajes.index', compact('messages', 'unread'));
    }

    public function markRead(ContactMessage $message): RedirectResponse
    {
        if (! $message->isRead()) {
            $message->update(['read_at' => now()]);
        }

        return back()->with('success', 'Mensaje marcado como leído.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return back()->with('success', 'Mensaje eliminado.');
    }
}
