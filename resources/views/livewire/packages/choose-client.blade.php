<form wire:submit="choose" class="space-y-6">
    <div>
        <flux:heading size="lg">Seleccionar Cliente</flux:heading>
    </div>

    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
        <flux:select title="Seleccione para ordenar y buscar por campo" wire:model.live="search_field" placeholder="Seleccione Campo...">
            <flux:select.option selected value="identity_card">Cédula</flux:select.option>
            <flux:select.option value="name">Nombres</flux:select.option>
            <flux:select.option value="lastname">Apellidos</flux:select.option>
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
                Nombres
            </x-table.th>
            <x-table.th>
                Apellidos
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
                <td class="p-3 h-full flex justify-center items-center">
                    <input wire:model="choosed_id" type="radio" value="{{$client->id}}" class="size-5" id="client-{{$client->id}}" />
                </td>
                <td class="p-3">
                    <label for="client-{{$client->id}}">
                        {{$client->identity_card}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="client-{{$client->id}}">
                        {{$client->name}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="client-{{$client->id}}">
                        {{$client->lastname}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="client-{{$client->id}}">
                        {{$client->residential_address}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="client-{{$client->id}}">
                        {{$client->email}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="client-{{$client->id}}">
                        {{$client->phone_number}}
                    </label>
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
    </x-table>

    <x-pagination :paginator="$clients" />

    <div class="flex">
        <flux:button type="submit" x-on:click="$wire.packages_amount = 'single'">Registrar un solo Paquete</flux:button>

        <flux:spacer />
    </div>

    <div class="flex">
        <flux:button type="submit" variant="primary" x-on:click="$wire.packages_amount = 'multiple'">Fraccionar Paquete</flux:button>

        <flux:spacer />
    </div>

    <flux:error name="*" />
</form>