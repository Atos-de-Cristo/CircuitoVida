<div>
    <iframe
        id="{{ $playerId }}"
        type="text/html"
        width="100%"
        height="600px"
        src="http://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&origin={{ URL::to('/') }}"
        frameborder="0"
    ></iframe>

    @push('scripts2')
        <script>
            var player;

            function onYouTubeIframeAPIReady() {
                console.info('onYouTubeIframeAPIReady')
                    player = new YT.Player('{{ $playerId }}', {
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
                            iv_load_policy: 3,
                            disablekb: 0
                        },
                    });
            }

            function onPlayerReady(event) {
                console.info('onPlayerReady')
                    window.livewire.emit('onPlayerReady', event.target.getDuration());

            }

            function onPlayerStateChange(event) {
                console.info('onPlayerStateChange')
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
                console.info('beforeunload')
                try {
                    window.livewire.emit('playerStateChanged', '03');
                } catch (e) {
                    console.error(e)
                }
            });
        </script>
    @endpush
</div>
