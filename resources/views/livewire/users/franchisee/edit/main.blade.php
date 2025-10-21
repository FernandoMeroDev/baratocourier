@use('Database\Seeders\Data\USAStates')

<div>
    <form wire:submit="update" class="space-y-6">
        
        <x-users.update.base-form />

        <flux:input
            wire:model="form.phone_number"
            label="Número de Teléfono"
            required maxlength="10"
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
            <x-users.franchisees.logo>
                <img id="fanchiseeLogoImg" src="{{ $form->logo->temporaryUrl() }}" alt="Previsualización de la Imagen">
            </x-users.franchisees.logo>
        @elseif($form->franchisee?->logo)
            <x-users.franchisees.logo>
                <img id="fanchiseeLogoImg" src="{{route('franchisees.logo', $form->franchisee->logo)}}" alt="Imagen del Logotipo">
            </x-users.franchisees.logo>
        @endif

        <x-fieldset.simple title="Dirección">
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
        </x-fieldset.simple>

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

        <flux:input
            wire:model="form.waybill_text_reference"
            label="Referencia de Texto en Guía"
            required
        />

        <div class="flex justify-between">
            <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>

            <flux:button wire:click="delete()" variant="danger">Eliminar</flux:button>
        </div>

        <flux:error name="form.*" />
    </form>
</div>