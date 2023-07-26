<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left py-4 font-bold text-xl">Lista de Categorias</h1>
    </div>
 
    <x-card>
        <x-slot name="headerCard">
            <x-search-form placeholder="Buscar categoria..."/>
            @can('admin')
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <livewire:event-category-add :key="rand()" />
            </div>
            @endcan
        </x-slot>

        <x-slot name="contentCard">        
               
                    @forelse ($this->categories as $category)
                
                        <div class="py-2 border  px-4 w-full flex flex-row items-center justify-between">
                            <div class="flex-1">
                                <span class="dark:text-white text-gray-600">{{ $category->name }}</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-sm text-gray-400 mr-2">{{ $category->events->count() }} cursos</span>
                            </div>
                            <div class="flex items-center">
        
                                <livewire:event-category-add :id="$category->id" :key="rand()" />
                            </div>
                        </div>
                        @empty
                        <span class="text-red-500">Nenhuma categoria cadastrada</span>
                        @endforelse
                               
 
        </x-slot>
        <x-slot name="footerCard">
            
        </x-slot>
    </x-card>
</div>
