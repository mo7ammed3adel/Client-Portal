<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $contacts = ContactRequest::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.contacts.index', compact('contacts', 'status'));
    }

    public function show(ContactRequest $contact): View
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'reviewed']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function update(Request $request, ContactRequest $contact): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,reviewed,closed'],
        ]);

        $contact->update($validated);

        return back()->with('status', 'تم تحديث حالة الرسالة.');
    }

    public function destroy(ContactRequest $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('status', 'تم حذف الرسالة.');
    }
}
