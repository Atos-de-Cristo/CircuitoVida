@props(['placeholder' => 'Buscar',])
<div class="font-bold flex items-center">
    <div class="relative mr-4 flex">
        <input wire:model.debounce.300ms.page="search" {{ $attributes->merge(['placeholder' => $placeholder]) }}
            class="input-form-search"
            type="text">
       
     <div class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
        <x-icon-magnifying-glass />
    </div>
 </div>
</div>