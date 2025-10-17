@use('Database\Seeders\Data\USAStates')

<div>
    <form wire:submit="store" class="space-y-6">
        
        <x-users.create.base-form />

        <flux:input
            wire:model="form.phone_number"
            label="Número de Teléfono"
            required
            placeholder="0999999999"
        />

        <flux:input
            wire:model="form.courier_name"
            label="Nombre de Courier"
            required
        />

        <div class="overflow-x-scroll flex justify-between items-end">
            <flux:input type="file" wire:model="form.logo" label="Logo" />
            <flux:button wire:click="$set('form.logo', null)" icon="trash" size="xs" />
        </div>
        @if (
            $form->logo
            && (
                $this->form->logo?->getMimeType() == 'image/jpeg'
                || $this->form->logo?->getMimeType() == 'image/png'
                || $this->form->logo?->getMimeType() == 'image/webp'
            )
        ) 
            <div class="min-h-32 w-full flex justify-center border rounded border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <img src="{{ $form->logo->temporaryUrl() }}" alt="Previsualización de la Imagen">
            </div>
        @endif

        <div class="border border-gray-300 dark:border-gray-700 rounded-xl p-4 relative">
            <span class="absolute -top-3 left-4 bg-white dark:bg-gray-900 px-2 text-sm font-medium text-gray-600 dark:text-gray-300">
                Dirección
            </span>
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-2">
                    <flux:input
                        wire:model="form.address_line"
                        required
                    />
                </div>

                <flux:field>
                    <flux:label>Estado</flux:label>

                    <flux:select wire:model="form.state" placeholder="Seleccione...">
                        @foreach(USAStates::$data as $short_name => $name)
                            <flux:select.option value="{{$name}}">{{$name}}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:error name="form.state" />
                </flux:field>

                <flux:input
                    wire:model="form.city"
                    label="Ciudad"
                    required
                />

                <div class="col-span-2">
                    <flux:input
                        wire:model="form.zip_code"
                        label="Código Postal"
                        required
                    />
                </div>
            </div>
        </div>

        <flux:input
            wire:model="form.guide_domain"
            label="Dominio de Guía"
            required
        />

        <flux:input
            wire:model="form.client_domain"
            label="Dominio de Cliente"
            required
        />

        <div class="flex justify-between">
            <flux:button type="submit" variant="primary">Registrar Usuario</flux:button>

            <a href="{{route('users.index')}}">
                <flux:button>Cancelar</flux:button>
            </a>
        </div>

        <flux:error name="form.*" />
    </form>
</div>
