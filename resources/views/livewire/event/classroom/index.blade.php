<div>
    <div class="flex flex-col md:flex-row items-start justify-between mb-2">
        <div class="flex items-center mb-2 md:mb-0">
            <x-icon-cubes class="w-8 h-8" />
            <div class="ml-2 text-xl font-bold">
               <strong>{{ $lessonData->module->name }}</strong>
            </div>
        </div>
        <div class=" hidden md:inline">
            <ol class="flex items-center space-x-2  text-sm">
                <li class="breadcrumb-item">
                    <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">Voltar</a>
                </li>
                <span class="text-gray-500">/</span>
                <li class="breadcrumb-item active">Atividades &amp; Materiais</li>
            </ol>
        </div>
    </div>
    <div class="card-white py-2 px-4">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div class="font-bold  flex items-center">
                <x-icon-circle-play class="w-5 h-5" />
               <strong class="ml-2">{{ $lessonData->title }}</strong>
            </div>
            @can('admin')
            @livewire('event-frequency', [$eventId, $lessonId])
            @endcan
        </div>
    </div>
    @if ($lessonData->video)
    <div class="card-white py-2 px-4">
        <div class="w-full">
            <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                <livewire:video-manager :videoId="$lessonData->video"/>
            </div>
        </div>
    </div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <x-icon-paste />
                    <span class="ml-2">Atividades</span>
                </div>
                @can('admin')
                <livewire:event-activity-actions :activityId="null" :lessonId="$lessonId" :key="rand()">
                    @endCan
            </div>
            <div
                class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md  mt-2 mb-4">
                <div class="h-48 overflow-auto px-4 py-4">
                    @livewire('event-activity-list', ['lessonId' => $lessonId])
                </div>
            </div>
        </div>
        <div class="sm:col-span-2 md:col-span-1">
            <div class="text-xl font-bold mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <x-icon-cloud-arrow-up  />
                    <span class="ml-2">Materiais</span>
                </div>
                @can('admin')
                <livewire:attachment :lessonId='$lessonId' :attachmentId='null' :key="rand()" />
                @endCan
            </div>
            <div
                class="bg-white border-t-2 dark:border-indigo-900 dark:bg-slate-700 overflow-hidden shadow-xl rounded-md mt-2 mb-4">
                <div class="h-48 overflow-auto px-4 py-4">
                    @forelse ($lessonData->attachments as $attachment)
                    <div class="flex items-center justify-between ">
                        <div class="flex items-center">
                            <x-icon-paperclip  />
                            <a href="{{ $attachment->path }}" target="_blank"
                                class="font-bold text-md text-blue-500 hover:underline ml-2">
                                {{ $attachment->name }}.{{ pathinfo($attachment->path, PATHINFO_EXTENSION) }}
                            </a>
                        </div>
                        @can('admin')
                        <div class="flex items-center mr-2">
                            <livewire:attachment :lessonId='$lessonId' :attachmentId='$attachment->id'
                                :key="rand().$attachment->id" />
                        </div>
                        @endcan
                    </div>
                    @empty
                    <span class="text-red-500">Nenhum anexo cadastrado</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="text-xl font-bold flex items-center justify-between w-full">
            <div class="flex items-center">
                <h3 class="flex  items-end">
                    <svg class="w-6 h-6 text-slate-600 dark:text-slate-200 mr-2" viewBox="0 0 16 16" version="1.1">
                        <path fill="currentColor" d="M8 0c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM8.9 13h-2v-2h2v2zM11 8.1c-0.4 0.4-0.8 0.6-1.2 0.7-0.6 0.4-0.8 0.2-0.8 1.2h-2c0-2 1.2-2.6 2-3 0.3-0.1 0.5-0.2 0.7-0.4 0.1-0.1 0.3-0.3 0.1-0.7-0.2-0.5-0.8-1-1.7-1-1.4 0-1.6 1.2-1.7 1.5l-2-0.3c0.1-1.1 1-3.2 3.6-3.2 1.6 0 3 0.9 3.6 2.2 0.4 1.1 0.2 2.2-0.6 3z"></path>
                      </svg>

                    Dúvidas?
                    <small class="ml-2">Deixe seu comentário</small>
                </h3>
            </div>

        </div>
        <div
            >
            <livewire:forum :lessonId="$lessonId" :key="rand()" />
        </div>
    </div>
</div>
