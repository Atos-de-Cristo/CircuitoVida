<div>
    <div id="{{ $playerId }}"></div>

    @push('scripts')
        <script>
            var player;

            function onYouTubeIframeAPIReady() {
                player = new YT.Player('{{ $playerId }}', {
                    height: '490px',
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
                console.info(event.target.getCurrentTime())
                console.info(player.getCurrentTime())
                switch (event.data) {
                    case YT.PlayerState.PLAYING:
                        window.livewire.emit('playerStateChanged', 'executando');
                        break;
                    case YT.PlayerState.PAUSED:
                        window.livewire.emit('playerStateChanged', 'pausada');
                        break;
                    case YT.PlayerState.ENDED:
                        window.livewire.emit('playerStateChanged', 'finalizada');
                        break;
                    default:
                        window.livewire.emit('playerStateChanged', 'processando...');
                        break;
                }
            }

            // window.addEventListener('beforeunload', function (event) {
            //     // Este código será executado quando o usuário estiver prestes a sair da página
            //     // ou mudar para outra página
            //     console.info('FECHOU')
            // });
        </script>
    @endpush
</div>
