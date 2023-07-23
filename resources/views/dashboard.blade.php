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
   
<button data-popover-target="popover-default" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Default popover</button>
<div data-popover id="popover-default" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">Popover title</h3>
    </div>
    <div class="px-3 py-2">
        <p>And here's some amazing content. It's very engaging. Right?</p>
    </div>
    <div data-popper-arrow></div>
</div>

    @endcan
  </div>
</x-app-layout>