<div>
    <x-accordion.simple :wire-ignore-self="true">
        <x-slot:title>
            {{$label}}
        </x-slot:title>
    
        <div class="grid grid-cols-2 gap-3">
            <flux:input label="Posición" wire:model.live="position" type="number" min="1" step="1" max="9999" />

            <flux:input label="Tamaño" wire:model.live="size" />
            
            <div class="col-span-2">
                <flux:select label="Alineación" wire:model.live="align" placeholder="Seleccione...">
                    <flux:select.option value="center">Centro</flux:select.option>
                    <flux:select.option value="left">Izquierda</flux:select.option>
                    <flux:select.option value="right">Derecha</flux:select.option>
                </flux:select>
            </div>

            <flux:input label="Margen Superior" wire:model.live="margin_top" min="1" step="1" max="9999" />

            <flux:input label="Margen Inferior" wire:model.live="margin_bottom" min="1" step="1" max="9999" />

            <div class="col-span-2">
                <flux:select label="Estilo de Fuente" wire:model.live="font_style" placeholder="Seleccione...">
                    <flux:select.option value="normal">Normal</flux:select.option>
                    <flux:select.option value="italic">Italica</flux:select.option>
                </flux:select>
            </div>

            <div class="col-span-2">
                <flux:select label="Negrita" wire:model.live="font_weight" placeholder="Seleccione...">
                    <flux:select.option value="normal">Normal</flux:select.option>
                    <flux:select.option value="bold">Negrita</flux:select.option>
                </flux:select>
            </div>
        </div>
    </x-accordion.simple>
</div>