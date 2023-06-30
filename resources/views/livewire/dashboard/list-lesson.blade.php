<div>
    @foreach ($this->inscriptions as $modules)
        <table class="table-fixed w-full">
            <tbody>
                @foreach ($modules['lessons'] as $lesson)
                    <tr>
                        <td>
                            {{$modules['event']}}
                        </td>
                        <td>
                            {{$modules['module']}}
                        </td>
                        <td>
                            <x-svg.play-lesson size="h-5 w-5" />
                            <a href="{{ route('classroom', ['id' => $lesson['id'], 'eventId' => $modules['event_id']]) }}"
                                class="font-bold text-md text-blue-500 hover:underline ml-2"
                                x-data="{ open: null }">
                                {{ $lesson['title'] }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>
