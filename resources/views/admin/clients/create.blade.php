<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">Create Client</h1>
            <p class="portal-muted mt-1">Client accounts are created only by the admin.</p>
        </div>
    </x-slot>

    <div class="portal-container max-w-3xl">
        <form method="POST" action="{{ route('admin.clients.store') }}" class="portal-card">
            @csrf
            @include('admin.clients.partials.form', ['client' => null])
        </form>
    </div>
</x-app-layout>

