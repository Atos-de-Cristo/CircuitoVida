<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        @livewire('teams.update-team-name-form', ['team' => $team])

        @livewire('teams.team-member-manager', ['team' => $team])

        @if (Gate::check('delete', $team) && ! $team->personal_team)
            <x-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('teams.delete-team-form', ['team' => $team])
            </div>
        @endif
    </div>
</x-app-layout>
