<div>
    <x-table class="w-full mb-3">
        <x-slot:thead>
            <x-table.th></x-table.th>
            <x-table.th>
                Dirección
            </x-table.th>
        </x-slot:thead>

        @forelse ($addresses as $address)
            <x-table.tr>
                <td class="w-5 px-3 py-1">
                    <flux:button icon="pencil" {{-- x-on:click="$dispatch('edit-address', { address_id: {{$address->id}} })" --}}></flux:button>
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
        x-on:created-shipping-address.window="$flux.modal('create-shipping-address').close(); $refresh"
    >
        <livewire:clients.edit.shipping-address.create :$client />
    </flux:modal>
</div>
