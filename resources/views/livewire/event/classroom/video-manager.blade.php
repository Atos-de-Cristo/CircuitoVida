<div>
    @if (session()->has('message'))
    {{dd(session('message'))}}
        {{-- <x-alert-message :message="session('message')" :messageType="session('message')" /> --}}
    @endif
    <livewire:video-player :videoId="$lesson->video"/>
    {{-- <p>Estado do video: {{$videoState}}</p>
    <p>Duração do video: {{$videoDuration}} segundos</p>
    @if ($timeTotal)
        <p>{{$timeTotal}}s assistido</p>
    @endif --}}
</div>
