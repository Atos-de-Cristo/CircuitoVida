<div>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <h1 class="float-left py-4 font-bold text-xl">Lista de Categorias</h1>
    </div>

    <x-card>
        <x-slot name="headerCard">
            <div class="flex gap-x-2">
                <div>
                    <select wire:model="type" class="input-form">
                        <option value="">Todos os tipo</option>
                        <option value="created">Criado</option>
                        <option value="updated">Editado</option>
                        <option value="deleted">Deletado</option>
                    </select>
                </div>

                <div>
                    <select wire:model="userId" class="input-form">
                        <option value="">Todos os Usuários</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select wire:model="module" class="input-form">
                        <option value="">Todas as Tabelas</option>
                        @foreach ($models as $key => $model)
                            <option value="{{ $key }}">{{ $model }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-slot>

        <x-slot name="contentCard">
            <table class="w-full border-collapse border">
                <thead>
                    <tr>
                        <th class="p-2 border">Evento</th>
                        <th class="p-2 border">Usuário</th>
                        <th class="p-2 border">Módulo</th>
                        <th class="p-2 border">Data e Hora</th>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr>
                            <td class="p-2 border">{{ $audit->event }}</td>
                            <td class="p-2 border">{{ $audit->user->name }}</td>
                            <td class="p-2 border">{{ $audit->auditable_type }}</td>
                            <td class="p-2 border">{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="p-2 border">
                                <livewire:audit-log-detail :old_values="$audit->old_values" :new_values="$audit->new_values" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $audits->links() }}
            </div>
        </x-slot>
        <x-slot name="footerCard">

        </x-slot>
    </x-card>
</div>
