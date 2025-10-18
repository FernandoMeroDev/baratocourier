<div>
    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
        <flux:select title="Seleccione para ordenar y buscar por campo" wire:model.live="search_field" placeholder="Seleccione Campo...">
            <flux:select.option selected value="identity_card">Cédula</flux:select.option>
            <flux:select.option value="name">Nombre</flux:select.option>
            <flux:select.option value="residential_address">Dirección de Residencia</flux:select.option>
            <flux:select.option value="email">Email</flux:select.option>
            <flux:select.option value="phone_number">Teléfono</flux:select.option>
        </flux:select>
    </div>

    <x-table class="w-full mb-3">
        <x-slot:thead>
            <x-table.th></x-table.th>
            <x-table.th>
                Cédula
            </x-table.th>
            <x-table.th>
                Nombre
            </x-table.th>
            <x-table.th>
                Dir. Residencia
            </x-table.th>
            <x-table.th>
                Email
            </x-table.th>
            <x-table.th>
                Teléfono
            </x-table.th>
        </x-slot:thead>

        @forelse ($clients as $client)
            <x-table.tr>
                <td class="w-5 px-3 py-1">
                    <flux:button icon="pencil" x-on:click="$dispatch('edit-client', { client_id: {{$client->id}} })"></flux:button>
                </td>
                <td class="p-3">
                    {{$client->identity_card}}
                </td>
                <td class="p-3">
                    {{$client->name}}
                </td>
                <td class="p-3">
                    {{$client->residential_address}}
                </td>
                <td class="p-3">
                    {{$client->email}}
                </td>
                <td class="p-3">
                    {{$client->phone_number}}
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
                <flux:button {{-- x-on:click="$flux.modal('create-inventory-record').show()" --}} icon="plus"></flux:button>
            </td>
            <td class="p-3">
                Nuevo Registro
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </x-table.tr>
    </x-table>

    <x-pagination :paginator="$clients" />
</div>