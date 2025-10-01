<div>
    <form wire:submit="create">
        {{ $this->form }}
        <x-turnstile-widget wire:ignore
    theme="light"
    language="id-ID"
    size="normal"
    callback="callbackFunction"
    errorCallback="errorCallbackFunction"
    class="mt-4"
/>
       <x-filament::button type='submit' size="xl" class="mt-4 w-full"  wire:target="create"
    wire:loading.attr="disabled">
       {{-- default state --}}
   Submit
</x-filament::button>
    </form>
    
   <x-filament::modal id="user-info" alignment="center"  icon="heroicon-o-document-check"
    icon-color="primary">
    <x-slot name="heading">
        Layanan Berhasil Dibuat
    </x-slot>
<x-slot name="description">
        Berikut Adalah Nomor Layanan Anda: 
    </x-slot>
    <div class="flex flex-row mx-auto items-center">
<div class="font-bold">{{ $this->no_layanan }}</div>
<x-filament::icon-button
    icon="heroicon-m-clipboard-document"
    color="gray"
     x-on:click="navigator.clipboard.writeText('{{ $this->no_layanan }}')"
/>
    </div>
    <x-slot name="footer">
        <div class="text-center"> Terimakasih, Anda dapat memantau proses layanan di whatsapp SATRIA</div>
    </x-slot>
</x-filament::modal>
</div>