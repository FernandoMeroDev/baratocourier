<div>
    <form wire:submit="store" class="space-y-6">
        
        <x-users.create.base-form />

        {{-- Add Extra Fields --}}

        <div class="flex justify-between">
            <flux:button type="submit" variant="primary">Registrar Usuario</flux:button>

            <a href="{{route('users.index')}}">
                <flux:button>Cancelar</flux:button>
            </a>
        </div>

        <flux:error name="form.*" />
    </form>
</div>