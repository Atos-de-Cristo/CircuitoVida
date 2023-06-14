<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="card-white  overflow-hidden shadow-xl sm:rounded-lg">
        @can('user')
            <livewire:dashboard-user />
        @endcan
        @cannot('user')
        <h1>dashboard admin</h1>
        @endcannot
    </div>
</x-app-layout>
