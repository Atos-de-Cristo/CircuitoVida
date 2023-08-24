<div>
    <div id="{{ $playerId }}"></div>

    @push('scripts')
        <script>
            var player;

            function onYouTubeIframeAPIReady() {
                player = new YT.Player('{{ $playerId }}', {
                    height: '600px',
                    width: '100%',
                    videoId: '{{ $videoId }}',
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    },
                    playerVars: {
                        autoplay: 0,
                        controls: 2,
                        rel: 0,
                        modestbranding: 1,
                        showinfo: 0,
                        enablejsapi: 0,
                        iv_load_policy: 3,
                        disablekb: 0
                    },
                });
            }

            function onPlayerReady(event) {
                window.livewire.emit('onPlayerReady', event.target.getDuration());
            }

            function onPlayerStateChange(event) {
                switch (event.data) {
                    case YT.PlayerState.PLAYING:
                        window.livewire.emit('playerStateChanged', '01');
                        break;
                    case YT.PlayerState.PAUSED:
                        window.livewire.emit('playerStateChanged', '02');
                        break;
                    case YT.PlayerState.ENDED:
                        window.livewire.emit('playerStateChanged', '03');
                        break;
                    default:
                        window.livewire.emit('playerStateChanged', '04');
                        break;
                }
            }

            window.addEventListener('beforeunload', function (event) {
                window.livewire.emit('playerStateChanged', '03');
            });
        </script>
    @endpush
</div>
