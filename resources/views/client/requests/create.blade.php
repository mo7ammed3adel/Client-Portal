<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">New Request</h1>
            <p class="portal-muted mt-1">Add the brief, notes, and an optional visual reference.</p>
        </div>
    </x-slot>

    <div class="portal-container max-w-3xl">
        <form method="POST" action="{{ route('client.requests.store') }}" enctype="multipart/form-data" class="portal-card">
            @csrf
            <div class="portal-card-body space-y-5">
                <div>
                    <label for="title" class="portal-label">Title</label>
                    <input id="title" name="title" value="{{ old('title') }}" class="portal-input" required>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <label for="description" class="portal-label">Description</label>
                    <textarea id="description" name="description" rows="6" class="portal-input" required>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <label for="notes" class="portal-label">Notes</label>
                    <textarea id="notes" name="notes" rows="3" class="portal-input">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <div>
                    <label for="reference" class="portal-label">Reference Image</label>
                    <input id="reference" name="reference" type="file" accept="image/*" class="portal-input file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700">
                    <p class="mt-2 text-xs text-slate-500">PNG or JPG up to 4MB.</p>
                    <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('client.requests.index') }}" class="portal-button-secondary">Cancel</a>
                    <button class="portal-button">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

