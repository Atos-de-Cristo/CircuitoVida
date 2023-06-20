<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left py-4 font-bold text-xl">Lista de Inscrições</h1>
    </div>
    <div class="card-white">
        <div class="mt-2 sm:mt-0 flex space-x-2">
            <livewire:event-category-add/>
        </div>
        <table class="table-fixed w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left px-2 w-8"># </th>
                    <th class="text-left px-2 ">Nome</th>
                    <th class="text-left px-2 w-16">Cursos</th>
                    <th class="text-left px-2 w-20"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->categories as $category)
                    <tr>
                        <td class="border px-2 py-2">{{$category->id}}</td>
                        <td class="border">{{$category->name}}</td>
                        <td class="border px-2 py-2">{{$category->events->count()}}</td>
                        <td class="border px-2 py-2"><livewire:event-category-add :id="$category->id"/></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <span class="text-red-500">Nenhuma categoria cadastrada</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
