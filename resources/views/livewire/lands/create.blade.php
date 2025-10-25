<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <flux:heading size="lg">Registrar Desembarque</flux:heading>
            <flux:text class="mt-2">Ingrese la información del registro del desembarque.</flux:text>
        </div>

        <div class="space-y-2">
            <flux:input 
                label="Fecha de Desembarque" wire:model="land_date" type="date" 
                required
                {{-- [TODO] Add Client side validation --}}
            />
        </div>

        <div class="flex">
            <flux:button type="submit" variant="primary">Registrar Desembarque</flux:button>
            
            <flux:spacer />
        </div>
    </form>
</div>
