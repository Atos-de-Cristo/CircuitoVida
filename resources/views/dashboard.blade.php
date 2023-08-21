<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div>
    @can('aluno')
        <livewire:dashboard-user :key="rand()" />
    @endcan
    @can('admin')
        <livewire:dashboard-admin :key="rand()" />
    @endcan
    @can('monitor')
        <livewire:dashboard-monitor :key="rand()" />
    @endcan
  </div>
</x-app-layout>
