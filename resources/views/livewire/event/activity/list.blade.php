<div>
    <table class="table-fixed w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="text-left px-2 w-8">#</th>
                <th class="text-left px-2">Tipo</th>
                <th class="text-left px-2">Pergunta</th>
                <td class="text-left px-2">Opçoes</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td class="border px-2 py-2">{{ $activity->id }}</td>
                <td class="border px-2 py-2">{{ $activity->type }}</td>
                <td class="border px-2 py-2">{{ $activity->title }}</td>
                <td class="border px-2 py-2"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
