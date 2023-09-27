<div>
    <div id="{{ $playerId }}"></div>

    @push('scripts')
        <script>
            var player;

            function onYouTubeIframeAPIReady() {
                try {
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
                } catch (e) {
                    console.erro(e)
                }
            }

            function onPlayerReady(event) {
                try {
                    window.livewire.emit('onPlayerReady', event.target.getDuration());
                } catch (e) {
                    console.error(e)
                }
            }

            function onPlayerStateChange(event) {
                try {
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
                } catch (e) {
                    console.error(e)
                }
            }

            window.addEventListener('beforeunload', function (event) {
                try {
                    window.livewire.emit('playerStateChanged', '03');
                } catch (e) {
                    console.error(e)
                }
            });
        </script>
    @endpush
</div>
