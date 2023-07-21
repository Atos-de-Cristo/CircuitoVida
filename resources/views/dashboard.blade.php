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
    <div class="mx-auto max-w-screen-2xl">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="dark:bg-slate-700 bg-white rounded-lg p-4  flex justify-between items-center">
          <div class="text-center">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg">Alunos</p>
          </div>
          <div class="">
            <x-icon-graduation-cap class=" h-24 w-24" />
          </div>
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4 bg-white  flex justify-between items-center">
          <div class="text-center">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg">Cursos</p>
          </div>
          <div class="">
            <x-icon-display class=" h-20 w-20" />
          </div>
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4  bg-white  flex justify-between items-center">
          <div class="text-center">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg">Aulas</p>
          </div>
          <div class="">
            <x-icon-circle-play class=" h-20 w-20" />
          </div>
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4  bg-white  flex justify-between items-center">
          <div class="text-center">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg">Monitores</p>
          </div>
          <div class="">
            <x-icon-person-chalkboard class="w-20 h-20" />
          </div>
        </div>
      </div>
    </div>
    @endcan
  </div>
</x-app-layout>