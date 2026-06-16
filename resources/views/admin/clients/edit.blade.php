<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">Edit Client</h1>
            <p class="portal-muted mt-1">{{ $client->email }}</p>
        </div>
    </x-slot>

    <div class="portal-container max-w-3xl">
        <form method="POST" action="{{ route('admin.clients.update', $client) }}" class="portal-card">
            @csrf
            @method('PATCH')
            @include('admin.clients.partials.form', ['client' => $client])
        </form>
    </div>
</x-app-layout>

