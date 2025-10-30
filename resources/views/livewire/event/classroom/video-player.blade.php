<div>
    <div id="video-container-{{ $playerId }}">
        <iframe
            id="{{ $playerId }}"
            type="text/html"
            width="100%"
            height="600px"
            src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&origin={{ URL::to('/') }}&rel=0&modestbranding=1&showinfo=0&iv_load_policy=3&controls=1&autoplay=0"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            referrerpolicy="strict-origin-when-cross-origin"
            title="YouTube video player"
            onload="checkIframeContent('{{ $playerId }}', '{{ $videoId }}')"
        ></iframe>
        
        <!-- Fallback caso o iframe seja bloqueado -->
        <div id="fallback-{{ $playerId }}" style="display: none;" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Vídeo não pode ser reproduzido aqui</h3>
            <p class="text-gray-600 mb-4">Devido às políticas do YouTube, este vídeo precisa ser assistido diretamente no YouTube.</p>
            <a href="https://www.youtube.com/watch?v={{ $videoId }}" 
               target="_blank" 
               class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                Assistir no YouTube
            </a>
        </div>
    </div>

    <script>
        function checkIframeContent(playerId, videoId) {
            const iframe = document.getElementById(playerId);
            const fallback = document.getElementById('fallback-' + playerId);
            
            // Aguarda um tempo para o iframe carregar
            setTimeout(() => {
                try {
                    // Tenta detectar se o iframe foi bloqueado
                    // Isso é uma aproximação, pois não podemos acessar o conteúdo do iframe devido ao CORS
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    
                    // Se chegou até aqui sem erro, provavelmente está funcionando
                    console.log('Iframe carregado com sucesso');
                } catch (e) {
                    // Se houve erro de CORS, isso é normal para YouTube embeds funcionais
                    // Apenas logamos para debug
                    console.log('CORS esperado para YouTube embed');
                }
                
                // Verifica se o iframe tem altura zero (indicativo de bloqueio)
                if (iframe.offsetHeight === 0) {
                    iframe.style.display = 'none';
                    fallback.style.display = 'block';
                }
            }, 2000);
            
            // Adiciona listener para erro de carregamento
            iframe.addEventListener('error', function() {
                iframe.style.display = 'none';
                fallback.style.display = 'block';
            });
        }
    </script>

    {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/p2LKbbg9gXM?si=L43L_xdsd5PUa5_E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> --}}

    {{-- @push('scripts2')
        <script>
            var player;

            function onYouTubeIframeAPIReady() {
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
    @endpush --}}
</div>
