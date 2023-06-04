<div>
    @if ($isOpenQuestions)
        @livewire('event-activity-question', [$atvId])
    @endif
    <table class="table-fixed w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="text-left px-2 w-8">#</th>
                <th class="text-left px-2">Titulo</th>
                <td class="text-left px-2">Questões</td>
                <th class="text-left px-2">Resposta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td class="border px-2 py-2">{{ $activity->id }}</td>
                <td class="border px-2 py-2 ">
                    <p>{{ $activity->title }}</p>
                    <small>{{$activity->description}}</small>
                </td>
                <td class="border px-2 py-2">
                    <button wire:click.prevent="openModalQuestions({{ $activity->id }})" class="btn-primary">
                        @if (count($activity->questions) > 0)
                            {{count($activity->questions)}}
                        @else
                            0
                        @endif
                        questões
                    </button>
                </td>
                <td class="border px-2 py-2">

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
