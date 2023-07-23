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
         <div class="opacity-20 hover:scale-110">
            <x-icon-graduation-cap class=" h-24 w-24" />
          </div>
          <div class="text-center mr-10">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg font-roboto">Alunos</p>
          </div>          
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4 bg-white  flex justify-between items-center">
          <div class="opacity-20 hover:scale-110">
            <x-icon-display class=" h-20 w-20" />
          </div>
          <div class="text-center mr-10">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg font-roboto">Cursos</p>
          </div>          
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4  bg-white  flex justify-between items-center">
          <div class=" opacity-20 hover:scale-110">
            <x-icon-circle-play class=" h-20 w-20" />
          </div>
          <div class="text-center mr-10">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg font-roboto">Aulas</p>
          </div>          
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4  bg-white  flex justify-between items-center">
          <div class="opacity-20 hover:scale-110">
            <x-icon-person-chalkboard class="w-20 h-20" />
          </div>
          <div class="text-center mr-10">
            <h3 class="text-5xl font-bold">150</h3>
            <p class="text-lg font-roboto">Monitores</p>
          </div>          
        </div>
      </div>
     
    </div>
    <div class="py-2 flex flex-col">
      <x-dashboard-bar/>      
    </div>
   


    @endcan
  </div>
</x-app-layout>