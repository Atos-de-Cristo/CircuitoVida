<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div>
    @can('aluno')
    <livewire:dashboard-user :key="rand()" />
    @else   
      <livewire:dashboard-admin :key="rand()" />      
    @endcan
  </div>
</x-app-layout>