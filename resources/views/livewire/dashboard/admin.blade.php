  

<div class="w-full mt-5 flex flex-col sm:flex-row gap-2">
    <div class="flex">
        <div class="rounded-lg p-4 w-full bg-slate-700 ">
            <x-dashboard-bar type="bar" title="Alunos por curso" :labels="$labels" :data="$data"  />
        </div>
    </div>
    <div class="flex">
        <div class="rounded-lg p-4 w-full bg-slate-700 ">
            <x-dashboard-bar type="line" title="Aulas por curso"  :labels="$labels" :data="$lessons"  />
        </div>
    </div>
   
  </div>