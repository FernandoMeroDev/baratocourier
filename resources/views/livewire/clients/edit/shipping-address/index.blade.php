<div>
    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
    </div>

    <x-table class="w-full mb-3">
        <x-slot:thead>
            <x-table.th></x-table.th>
            <x-table.th>
                Dirección
            </x-table.th>
            <x-table.th>
                Enviar a:
            </x-table.th>
            <x-table.th>
                Cédula
            </x-table.th>
            <x-table.th>
                Teléfono
            </x-table.th>
        </x-slot:thead>

        @forelse ($addresses as $address)
            <x-table.tr>
                <td class="w-5 px-3 py-1">
                    <flux:button icon="pencil" x-on:click="$dispatch('edit-shipping-address', { id: {{$address->id}} })"></flux:button>
                </td>
                <td class="p-3">
                    {{
                        $address->line_1
                        . ', ' . $address->line_2
                        . ', ' . $address->city_name
                        . ', ' . $address->province->name
                        . ', Código: ' . $address->zip_code . '.'
                    }}
                </td>
                <td class="p-3">
                    {{
                        $address->target->name
                        . ', ' . $address->target->lastname
                    }}
                </td>
                <td class="p-3">
                    {{$address->target->identity_card}}
                </td>
                <td class="p-3">
                    {{$address->target->phone_number}}
                </td>
            </x-table.tr>
        @empty
            <x-table.tr>
                <td></td>
                <td class="p-3">
                    No hay resultados...
                </td>
            </x-table.tr>
        @endforelse
        <x-table.tr>
            <td class="p-3">
                <flux:button x-on:click="$flux.modal('create-shipping-address').show()" icon="plus"></flux:button>
            </td>
            <td class="p-3">
                Nuevo Registro
            </td>
            <td></td>
        </x-table.tr>
    </x-table>

    <x-pagination :paginator="$addresses" />

    <flux:modal 
        name="create-shipping-address"  class="md:w-96"
        x-on:created-shipping-address.window="$wire.$refresh(); $flux.modal('create-shipping-address').close()"
    >
        <livewire:clients.edit.shipping-address.create :$client />
    </flux:modal>

    <flux:modal 
        name="edit-shipping-address"  class="md:w-96"
        x-on:edited-shipping-address.window="$wire.$refresh(); $flux.modal('edit-shipping-address').close()"
        x-on:deleted-shipping-address.window="$wire.$refresh(); $flux.modal('edit-shipping-address').close()"
        x-on:edit-shipping-address.window="$flux.modal('edit-shipping-address').show()"
    >
        <livewire:clients.edit.shipping-address.edit :$client />
    </flux:modal>
</div>
