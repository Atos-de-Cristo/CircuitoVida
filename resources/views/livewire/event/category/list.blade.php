<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left py-4 font-bold text-xl">Lista de Categorias</h1>
    </div>
    <div class="card-white">
        <div class="mt-2 sm:mt-0 flex space-x-2">

        </div>
        <div class="flex flex-col mb-4 sm:flex-row justify-between items-center">
            <x-search-form placeholder="Buscar categoria..."/>
            @can('admin')
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <livewire:event-category-add :key="rand()" />
            </div>
            @endcan
        </div>
        <div>
            <ul class="border rounded-md divide-y divide-gray-200">
                @forelse ($this->categories as $category)
                <li class="py-2 px-4 flex items-center justify-between">
                    <div class="flex-1">
                        <span class="dark:text-white text-gray-600">{{ $category->name }}</span>
                    </div>
                    <div class="flex-1">
                        <span class="text-sm text-gray-400 mr-2">{{ $category->events->count() }} cursos</span>
                    </div>
                    <div class="flex items-center">

                        <livewire:event-category-add :id="$category->id" :key="rand()" />
                    </div>
                </li>
                @empty
                <span class="text-red-500">Nenhuma categoria cadastrada</span>
                @endforelse
            </ul>

        </div>

    </div>
</div>
