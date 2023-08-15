<div>
    <x-form-section submit="store">
        <x-slot name="title">
            {{ __('Perfil') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete seu perfil.') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-3">
                <x-label for="cpf" value="{{ __('CPF') }}" />
                <x-input id="cpf" type="text" class="mt-1 block w-full" wire:model.defer="form.cpf" />
                <x-input-error for="form.cpf" class="mt-2" />
            </div>
        
            <div class="col-span-6 sm:col-span-3">
                <x-label for="sex" value="{{ __('Sexo') }}" />
                <select id="sex" wire:model.defer="form.sex"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                </select>
                <x-input-error for="form.sex" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="birth" value="{{ __('Data de Nascimento') }}" />
                <input type="date" wire:model.defer="form.birth"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                <x-input-error for="form.birth" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="marital_status" value="{{ __('Estado Civil') }}" />
                <select id="marital_status" wire:model.defer="form.marital_status"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Selecione</option>
                    @foreach ($this->optMaritalStatus as $opt)
                    <option value="{{ $opt->name }}">{{ $opt->value }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.marital_status" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="phone" value="{{ __('Contato') }}" />
                <x-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="form.phone" />
                <x-input-error for="form.phone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="leader" value="{{ __('Lider de Célula') }}" />
                <x-input id="leader" type="text" class="mt-1 block w-full" wire:model.defer="form.leader" />
                <x-input-error for="form.leader" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="date_baptism" value="{{ __('Data de Batismo') }}" />
                <input type="date" wire:model.defer="form.date_baptism"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                <x-input-error for="form.date_baptism" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="church" value="{{ __('Qual igreja você foi batizado?') }}" />
                <x-input id="church" type="text" class="mt-1 block w-full" wire:model.defer="form.church" />
                <x-input-error for="form.church" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-3">
                <x-label for="deficiency" value="{{ __('Possui alguma deficiência qual?') }}" />
                <x-input id="deficiency" type="text" class="mt-1 block w-full" wire:model.defer="form.deficiency" />
                <x-input-error for="form.deficiency" class="mt-2" />
            </div>           
            
         </x-slot>
        <x-slot name="actions">
            @if (session()->has('message'))
            <x-alert-message :message="session('message')['text']" :messageType="session('message')['type']" />
            @endif

            <x-button wire:click.prevent="store()">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
