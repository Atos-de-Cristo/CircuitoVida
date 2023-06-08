<div>
    @foreach ($activities as $activity)
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('svg/activity.svg') }}" alt="Ícone">
                <a
                    href="{{ route('eventActivityQuestion', ['id' => $activity->id]) }}"
                    class="font-bold text-xl text-indigo-900 hover:text-indigo-600 ml-2"
                >{{ $activity->title }}</a>
            </div>
            <div class="flex items-center mr-2">
                <button wire:click.prevent="editActivity({{ $activity->id }})" class="mr-2">
                    <img src="{{ asset('svg/edit.svg') }}" alt="Ícone">
                </button>
                <button wire:click.prevent="dellActivity({{ $activity->id }})">
                    <img src="{{ asset('svg/delete.svg') }}" alt="Ícone">
                </button>
            </div>
        </div>
    @endforeach
</div>
