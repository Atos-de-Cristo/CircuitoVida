<div>
    @if (session()->has('message'))
    <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
    @endif
    <div class="flex flex-col md:flex-row items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <div class="ml-2 text-xl font-bold">
                Relatórios do Circuito Vida
            </div>
        </div>
        <div class="hidden md:inline">
            <ol class="flex items-center space-x-2 text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Home</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Relatórios</li>
            </ol>
        </div>
    </div>
    <x-card>
        <x-slot name="headerCard">
            <div class="flex flex-1 flex-col md:flex-row gap-4 lg:gap-8 xl:gap-16 items-baseline justify-between">
                <div class="flex-1">
                    <label for="start_date" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Data de Início
                    </label>
                    <div class="relative">
                        <input type="date" 
                            wire:model.defer="start_date" 
                            id="start_date"
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 dark:focus:border-indigo-400 dark:focus:ring-indigo-400/20 transition-all duration-200">
                    </div>
                    @error('start_date') 
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="flex-1">
                    <label for="end_date" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Data de Fim
                    </label>
                    <div class="relative">
                        <input type="date" 
                            wire:model.defer="end_date" 
                            id="end_date"
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 dark:focus:border-indigo-400 dark:focus:ring-indigo-400/20 transition-all duration-200">
                    </div>
                    @error('end_date') 
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="flex-1">
                    <label for="status" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Status do Evento
                    </label>
                    <div class="relative">
                        <select wire:model.defer="status" 
                                id="status"
                                class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 dark:focus:border-indigo-400 dark:focus:ring-indigo-400/20 transition-all duration-200">
                            @foreach($this->eventStatusOptions as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('status') 
                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="flex items-end">
                    <div class="space-y-4 w-full">
                        <button wire:click="generatePreview" 
                                wire:loading.attr="disabled"
                                wire:target="generatePreview"
                                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 dark:from-indigo-500 dark:to-purple-500 dark:hover:from-indigo-600 dark:hover:to-purple-600 text-white font-semibold py-4 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/30 dark:focus:ring-indigo-400/30 disabled:opacity-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:transform-none disabled:shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Gerar Preview
                            </span>
                        </button>
                        <button wire:click="resetDates" 
                                class="w-full bg-gradient-to-r from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 dark:from-slate-600 dark:to-slate-700 dark:hover:from-slate-700 dark:hover:to-slate-800 text-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-slate-500/30 dark:focus:ring-slate-400/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Resetar Datas
                        </button>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="contentCard">
                         <div class="flex-1 flex flex-col">
                 <!-- Estado: Gerando Relatório -->
                 <div wire:loading wire:target="generatePreview" class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-200/50 dark:border-indigo-800/50 rounded-2xl p-8 text-center shadow-lg flex-1">
                     <div class="flex items-center justify-center mb-4">
                         <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-full">
                             <svg class="animate-spin w-8 h-8 text-white" fill="none" viewBox="0 0 24 24">
                                 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                 <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                             </svg>
                         </div>
                     </div>
                     <h3 class="text-lg font-bold text-indigo-800 dark:text-indigo-200 mb-2">Gerando relatório...</h3>
                     <p class="text-indigo-700 dark:text-indigo-300">Por favor, aguarde enquanto processamos os dados do período selecionado.</p>
                 </div>

                 <!-- Estado: Nenhum evento encontrado -->
                 <div wire:loading.remove wire:target="generatePreview">
                     @if ($reportData && (is_array($reportData['detalhe_por_curso']) ? count($reportData['detalhe_por_curso']) : $reportData['detalhe_por_curso']->count()) == 0)
                         <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200/50 dark:border-amber-800/50 rounded-2xl p-8 text-center shadow-lg">
                             <div class="flex items-center justify-center mb-4">
                                 <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-full">
                                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                     </svg>
                                 </div>
                             </div>
                             <h3 class="text-lg font-bold text-amber-800 dark:text-amber-200 mb-2">Nenhum evento encontrado</h3>
                             <p class="text-amber-700 dark:text-amber-300">Não foram encontrados eventos para o período e status selecionados. Tente ajustar os filtros.</p>
                         </div>
                     @else
                         <!-- Estado: Pronto para gerar -->
                         @if (!$reportData)
                             <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200/50 dark:border-blue-800/50 rounded-2xl p-8 text-center shadow-lg flex-1">
                                 <div class="flex items-center justify-center mb-4">
                                     <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-full">
                                         <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                         </svg>
                                     </div>
                                 </div>
                                 <h3 class="text-lg font-bold text-blue-800 dark:text-blue-200 mb-2">Pronto para gerar relatório</h3>
                                 <p class="text-blue-700 dark:text-blue-300">Selecione o período e status desejados e clique em "Gerar Preview" para visualizar os dados do relatório.</p>
                             </div>
                                                  @endif

                         <!-- Estado: Relatório gerado -->
                         @if ($reportData)
                        <div class="flex-1">
                            <div class="flex flex-1 items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-2 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-slate-800 dark:text-slate-200">Preview do Relatório</h4>
                                </div>
                                <div class="flex space-x-4">
                                    <button wire:click="downloadPdf" 
                                            class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 dark:from-red-500 dark:to-pink-500 dark:hover:from-red-600 dark:hover:to-pink-600 text-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-500/30 dark:focus:ring-red-400/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download PDF
                                    </button>
                                    <button wire:click="clearReport" 
                                            class="bg-gradient-to-r from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 dark:from-slate-600 dark:to-slate-700 dark:hover:from-slate-700 dark:hover:to-slate-800 text-white font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-slate-500/30 dark:focus:ring-slate-400/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Limpar
                                    </button>
                                </div>
                            </div>
            
                            <div class="flex-1">
                                <!-- Período -->
                                <div class="text-center mb-10">
                                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-6 border border-indigo-100 dark:border-indigo-800/50">
                                        <h5 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">{{ $reportData['periodo'] }}</h5>
                                        <p class="text-slate-600 dark:text-slate-400 font-medium">Gerado em: {{ $reportData['data_geracao'] }}</p>
                                    </div>
                                </div>
            
                                <!-- Panorama Geral -->
                                <div class="mb-10">
                                    <div class="flex items-center mb-8">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg mr-4">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <h6 class="text-xl font-bold text-slate-800 dark:text-slate-200">PANORAMA GERAL</h6>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-8 rounded-2xl text-center border border-blue-200/50 dark:border-blue-800/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">{{ $reportData['panorama_geral']['total_pessoas_participando'] }}</div>
                                            <div class="text-sm text-blue-700 dark:text-blue-300 font-semibold">Total de Pessoas Participando</div>
                                        </div>
                                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 p-8 rounded-2xl text-center border border-green-200/50 dark:border-green-800/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-3">{{ $reportData['panorama_geral']['total_inscricoes_em_cursos'] }}</div>
                                            <div class="text-sm text-green-700 dark:text-green-300 font-semibold">Total de Inscrições em Cursos</div>
                                        </div>
                                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 p-8 rounded-2xl text-center border border-emerald-200/50 dark:border-emerald-800/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-3">{{ $reportData['panorama_geral']['total_aprovados'] }}</div>
                                            <div class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">Total de Aprovados</div>
                                        </div>
                                        <div class="bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 p-8 rounded-2xl text-center border border-orange-200/50 dark:border-orange-800/50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="bg-gradient-to-r from-orange-500 to-red-600 p-3 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-3">{{ $reportData['panorama_geral']['total_reprovados_desistentes'] }}</div>
                                            <div class="text-sm text-orange-700 dark:text-orange-300 font-semibold">Total de Reprovados e Desistentes</div>
                                        </div>
                                    </div>
                                </div>
            
                                <!-- Panorama por Categorias -->
                                @if ((is_array($reportData['dados_por_categoria']) ? count($reportData['dados_por_categoria']) : $reportData['dados_por_categoria']->count()) > 0)
                                    <div class="mb-10">
                                        <div class="flex items-center mb-8">
                                            <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-2 rounded-lg mr-4">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                            </div>
                                            <h6 class="text-xl font-bold text-slate-800 dark:text-slate-200">PANORAMA POR CATEGORIAS</h6>
                                        </div>
                                        <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full">
                                                    <thead class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                                                        <tr>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider border-b border-purple-200/50 dark:border-purple-800/50">CATEGORIA</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider border-b border-purple-200/50 dark:border-purple-800/50">TOTAL CURSOS</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider border-b border-purple-200/50 dark:border-purple-800/50">INSCRITOS</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider border-b border-purple-200/50 dark:border-purple-800/50">CONCLUÍRAM</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider border-b border-purple-200/50 dark:border-purple-800/50">REP./DESIST.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-200/50 dark:divide-slate-700/50">
                                                        @foreach ($reportData['dados_por_categoria'] as $categoria)
                                                            <tr class="hover:bg-gradient-to-r hover:from-purple-50/50 hover:to-pink-50/50 dark:hover:from-purple-900/10 dark:hover:to-pink-900/10 transition-all duration-300">
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-2 rounded-lg mr-3">
                                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ is_object($categoria) ? $categoria->categoria : $categoria['categoria'] }}</span>
                                                                    </div>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                                        {{ is_object($categoria) ? $categoria->total_cursos : $categoria['total_cursos'] }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                                        {{ is_object($categoria) ? $categoria->total_inscritos : $categoria['total_inscritos'] }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                                        {{ is_object($categoria) ? $categoria->total_concluiram : $categoria['total_concluiram'] }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                                                        {{ is_object($categoria) ? $categoria->total_rep_desist : $categoria['total_rep_desist'] }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
            
                                <!-- Detalhamento por Curso -->
                                @if ((is_array($reportData['detalhe_por_curso']) ? count($reportData['detalhe_por_curso']) : $reportData['detalhe_por_curso']->count()) > 0)
                                    <div class="mb-10">
                                        <div class="flex items-center mb-8">
                                            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-2 rounded-lg mr-4">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <h6 class="text-xl font-bold text-slate-800 dark:text-slate-200">PANORAMA POR CURSOS</h6>
                                        </div>
                                        <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full">
                                                    <thead class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20">
                                                        <tr>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-teal-700 dark:text-teal-300 uppercase tracking-wider border-b border-teal-200/50 dark:border-teal-800/50">CURSO</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-teal-700 dark:text-teal-300 uppercase tracking-wider border-b border-teal-200/50 dark:border-teal-800/50">CATEGORIA</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-teal-700 dark:text-teal-300 uppercase tracking-wider border-b border-teal-200/50 dark:border-teal-800/50">PERÍODO</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-teal-700 dark:text-teal-300 uppercase tracking-wider border-b border-teal-200/50 dark:border-teal-800/50">INSCRITOS</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-teal-700 dark:text-teal-300 uppercase tracking-wider border-b border-teal-200/50 dark:border-teal-800/50">CONCLUÍRAM</th>
                                                            <th class="px-8 py-6 text-left text-sm font-bold text-teal-700 dark:text-teal-300 uppercase tracking-wider border-b border-teal-200/50 dark:border-teal-800/50">REP./DESIST.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-200/50 dark:divide-slate-700/50">
                                                        @foreach ($reportData['detalhe_por_curso'] as $curso)
                                                            <tr class="hover:bg-gradient-to-r hover:from-teal-50/50 hover:to-cyan-50/50 dark:hover:from-teal-900/10 dark:hover:to-cyan-900/10 transition-all duration-300">
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-2 rounded-lg mr-3">
                                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ is_object($curso) ? $curso->event_name : $curso['event_name'] }}</span>
                                                                    </div>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                                        {{ is_object($curso) ? $curso->category_name : $curso['category_name'] }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <div class="text-sm text-slate-600 dark:text-slate-400">
                                                                        <div class="font-medium">{{ \Carbon\Carbon::parse(is_object($curso) ? $curso->start_date : $curso['start_date'])->format('d/m/Y') }}</div>
                                                                        <div class="text-xs text-slate-500 dark:text-slate-500">até {{ \Carbon\Carbon::parse(is_object($curso) ? $curso->end_date : $curso['end_date'])->format('d/m/Y') }}</div>
                                                                    </div>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                                        {{ is_object($curso) ? $curso->inscritos : $curso['inscritos'] }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                                        {{ is_object($curso) ? $curso->concluiram : $curso['concluiram'] }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-8 py-6 whitespace-nowrap">
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                                                        {{ is_object($curso) ? $curso->rep_desist : $curso['rep_desist'] }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Aprovados por Curso (Nomes) -->
                                @if ((is_array($reportData['detalhe_por_curso']) ? count($reportData['detalhe_por_curso']) : $reportData['detalhe_por_curso']->count()) > 0)
                                    <div class="mb-10">
                                        <div class="flex items-center mb-8">
                                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-2 rounded-lg mr-4">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <h6 class="text-xl font-bold text-slate-800 dark:text-slate-200">APROVADOS POR CURSO</h6>
                                        </div>
                                        <div class="space-y-6">
                                            @foreach ($reportData['detalhe_por_curso'] as $curso)
                                                @php
                                                    $eventId = is_object($curso) ? $curso->event_id : $curso['event_id'];
                                                    $nomes = $reportData['concluintes_por_curso'][$eventId] ?? [];
                                                @endphp
                                                @if (count($nomes) > 0)
                                                    <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50">
                                                        <div class="px-6 py-4 border-b border-slate-200/50 dark:border-slate-700/50 flex items-center justify-between">
                                                            <div class="flex items-center">
                                                                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-2 rounded-lg mr-3">
                                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                                    </svg>
                                                                </div>
                                                                <div class="flex flex-col">
                                                                    <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ is_object($curso) ? $curso->event_name : $curso['event_name'] }}</span>
                                                                    <span class="text-xs text-slate-600 dark:text-slate-400">Período: {{ \Carbon\Carbon::parse(is_object($curso) ? $curso->start_date : $curso['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(is_object($curso) ? $curso->end_date : $curso['end_date'])->format('d/m/Y') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="text-xs text-emerald-700 dark:text-emerald-300 font-semibold">
                                                                Aprovados: {{ count($nomes) }}
                                                            </div>
                                                        </div>
                                                        <div class="px-6 py-4">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                                @foreach ($nomes as $nome)
                                                                    <div class="flex items-center space-x-2">
                                                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                                                        <span class="text-sm text-slate-700 dark:text-slate-300">{{ $nome }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                         @endif
                     @endif
                 </div>
             </div>
        </x-slot>
        <x-slot name="footerCard">
            <script>
                document.addEventListener('livewire:load', function () {
                    window.addEventListener('download-pdf', event => {
                        const { url, filename, data } = event.detail;
                        
                        // Criar um formulário temporário para fazer o download
                        const form = document.createElement('form');
                        form.method = 'GET';
                        form.action = url;
                        
                        // Adicionar parâmetros
                        Object.keys(data).forEach(key => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = data[key];
                            form.appendChild(input);
                        });
                        
                        // Adicionar ao DOM, submeter e remover
                        document.body.appendChild(form);
                        form.submit();
                        document.body.removeChild(form);
                    });
                });
            </script>
        </x-slot>
    </x-card>
</div>
