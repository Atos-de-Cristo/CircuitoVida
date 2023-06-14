<div>
    <form class="">
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-md ">
            <div class="bg-gray-50 dark:bg-gray-700 text-center rounded-md">
                <h2 class="text-lg text-gray-800 dark:text-white font-bold p-2 mb-4">Corrigir Questões</h2>
            </div>
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                @forelse ($this->questions as $item)
                    <div class="flex mb-4 border border-gray-300  dark:border-gray-700 rounded-md p-4">
                        <div class="flex flex-col flex-1 justify-between">
                            <h3 class="text-lg font-semibold mb-2">{{ $item->question->title }}</h3>
                            <small>{{ $item->response }}</small>
                        </div>
                        <div class="flex flex-row">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button
                                    type="button"
                                    wire:click.prevent="checkQuestion('correto', {{$item->id}})"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                >
                                    Correto
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button wire:click="checkQuestion('errado', {{$item->id}})" type="button" class="btn-default">
                                    Errado
                                </button>
                            </span>
                        </div>
                    </div>
                @empty
                    <span class="text-red-500">Nenhuma questão cadastrada</span>
                @endforelse
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 rounded py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <button wire:click="closeCorrectAnswers()" type="button" class="btn-default">
                        Fechar
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
