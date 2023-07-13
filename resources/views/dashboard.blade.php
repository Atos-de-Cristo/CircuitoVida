<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        @can('aluno')
            <livewire:dashboard-user :key="rand()"/>
        @else
        <div class="mx-auto max-w-screen-2xl">
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
           
            <div class="rounded-2xl bg-white py-6 px-7 shadow-xl  dark:bg-slate-700">
              <div class="flex h-11 w-11 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
               <x-svg.student/>
              </div>
              <div class="mt-2 flex items-end justify-between">
                <div>
                  <h4 class="text-xl font-bold text-black dark:text-white">
                    100
                  </h4>
                  <span class="text-sm font-medium">Total Alunos</span>
                </div>
  
                <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                  0.43%
                  <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""></path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="rounded-2xl bg-white py-6 px-7 shadow-xl  dark:bg-slate-700">
              <div class="flex h-11 w-11 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
               <x-svg.module/>
              </div>
              <div class="mt-2 flex items-end justify-between">
                <div>
                  <h4 class="text-xl font-bold text-black dark:text-white">
                    100
                  </h4>
                  <span class="text-sm font-medium">Total Cursos</span>
                </div>
  
                <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                  0.43%
                  <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""></path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="rounded-2xl bg-white py-6 px-7 shadow-xl  dark:bg-slate-700">
              <div class="flex h-11 w-11 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
               <x-svg.board/>
              </div>
              <div class="mt-2 flex items-end justify-between">
                <div>
                  <h4 class="text-xl font-bold text-black dark:text-white">
                    100
                  </h4>
                  <span class="text-sm font-medium">Total Aulas</span>
                </div>
  
                <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                  0.43%
                  <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""></path>
                  </svg>
                </span>
              </div>
            </div>
            <div class="rounded-2xl bg-white py-6 px-7 shadow-xl  dark:bg-slate-700">
              <div class="flex h-11 w-11 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                <x-svg.teacher />
              </div>
              <div class="mt-2 flex items-end justify-between">
                <div>
                  <h4 class="text-xl font-bold text-black dark:text-white">
                    100
                  </h4>
                  <span class="text-sm font-medium">Total Monitores</span>
                </div>
  
                <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
                  0.43%
                  <svg class="fill-meta-3" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""></path>
                  </svg>
                </span>
              </div>
            </div>
          
  
             
        
          </div>
        </div>
      
              
        @endcan
    </div>
</x-app-layout>
