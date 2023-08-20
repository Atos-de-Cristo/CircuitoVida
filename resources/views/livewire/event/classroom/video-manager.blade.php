<div>
    <livewire:video-player :videoId="$videoId"/>
    <p>Estado do video: {{$videoState}}</p>
    <p>Duração do video: {{number_format($videoDuration/60, 2)}} minutos</p>
</div>
