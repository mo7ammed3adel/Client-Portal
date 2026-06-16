<div class="portal-card-body space-y-5">
    <div>
        <label for="name" class="portal-label">Full Name</label>
        <input id="name" name="name" value="{{ old('name', $client?->name) }}" class="portal-input" required>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <label for="email" class="portal-label">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $client?->email) }}" class="portal-input" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="password" class="portal-label">{{ $client ? 'New Password' : 'Password' }}</label>
            <input id="password" name="password" type="password" class="portal-input" @if (! $client) required @endif>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div>
            <label for="password_confirmation" class="portal-label">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="portal-input" @if (! $client) required @endif>
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.clients.index') }}" class="portal-button-secondary">Cancel</a>
        <button class="portal-button">{{ $client ? 'Save Changes' : 'Create Client' }}</button>
    </div>
</div>

