
<div class="mx-auto max-w-screen-2xl">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="dark:bg-slate-700 bg-white rounded-lg p-4  flex justify-between items-center">
            <div class="opacity-20 hover:scale-110">
                <x-icon-graduation-cap class=" h-24 w-24" />
            </div>
            <div class="text-center mr-10">
                <h3 class="text-5xl font-bold">{{$this->students}}</h3>
                <p class="text-lg font-roboto">Alunos Ativos</p>
            </div>
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4 bg-white  flex justify-between items-center">
            <div class="opacity-20 hover:scale-110">
                <x-icon-display class=" h-20 w-20" />
            </div>
            <div class="text-center mr-10">
                <h3 class="text-5xl font-bold">{{$this->events}}</h3>
                <p class="text-lg font-roboto">Cursos Ativos</p>
            </div>
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4  bg-white  flex justify-between items-center">
            <div class=" opacity-20 hover:scale-110">
                <x-icon-circle-play class=" h-20 w-20" />
            </div>
            <div class="text-center mr-10">
                <h3 class="text-5xl font-bold">{{$this->Lessons}}</h3>
                <p class="text-lg font-roboto">Aulas Ativas</p>
            </div>
        </div>
        <div class="dark:bg-slate-700 rounded-lg p-4  bg-white  flex justify-between items-center">
            <div class="opacity-20 hover:scale-110">
                <x-icon-person-chalkboard class="w-20 h-20" />
            </div>
            <div class="text-center mr-10">
                <h3 class="text-5xl font-bold">{{$this->monitores}}</h3>
                <p class="text-lg font-roboto">Monitores</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-full mt-5 gap-4">
        <div class="flex w-full">
            <div class="rounded-lg p-4 w-full dark:bg-slate-700 bg-white">
                <livewire:graph :code="rand()" type="bar" title="Inscritos por curso" :labels="$labels" :values="$sumInscriptions" />
            </div>
        </div>
        <div class="flex flex-row gap-4 w-full">
            <div class="rounded-lg p-4 w-full dark:bg-slate-700 bg-white">
                {{-- <livewire:graph :key="rand()" type="doughnut" title="Status do curso" :labels="$labels" :values="$sumInscriptions" /> --}}
            </div>
            <div class="rounded-lg p-4 w-full dark:bg-slate-700 bg-white">
                {{-- <livewire:graph :key="rand()" type="doughnut" title="Inscritos por curso 2" :labels="$labels" :values="$sumInscriptions" /> --}}
            </div>
        </div>
    </div>
</div>
