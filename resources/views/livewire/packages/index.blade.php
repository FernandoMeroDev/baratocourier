@use('App\Models\Packages\Package')
<div>
    <flux:heading size="lg">Mis Paquetes</flux:heading>

    <div class="grid grid-cols-2 gap-3 my-3">
        <flux:select 
            wire:model.live="search_package_status" placeholder="Seleccionar Estado"
        >
            <flux:select.option value="">Todos</flux:select.option>
            @foreach(Package::$valid_statuses as $code => $name)
                <flux:select.option value="{{$code}}">{{$name}}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select 
            title="Seleccione para ordenar por campo" wire:model.live="search_field" placeholder="Ordenar por..."
        >
            <flux:select.option value="created_at">Fecha de Registro de Paquete</flux:select.option>
            <flux:select.option value="shop_name">Tienda</flux:select.option>
            <flux:select.option value="estimated_date">F. Estimada</flux:select.option>
            <flux:select.option selected value="registered_date">F. Registrada</flux:select.option>
            <flux:select.option selected value="tracking_number">Tracking</flux:select.option>
            <flux:select.option selected value="status">Estado</flux:select.option>
        </flux:select>

        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="col-span-2" />
    </div>

    <x-table class="w-full my-3">
        <x-slot:thead>
            <x-table.th>
                Tienda
            </x-table.th>
            <x-table.th>
                Cliente
            </x-table.th>
            <x-table.th>
                F. Estimada
            </x-table.th>
            <x-table.th>
                F. Registrada
            </x-table.th>
            <x-table.th>
                Tracking
            </x-table.th>
            <x-table.th>
                Estado
            </x-table.th>
            <x-table.th>
                Acciones
            </x-table.th>
        </x-slot:thead>

        @forelse ($packages as $package)
            <x-table.tr>
                <td class="p-3">
                    {{$package->shop->name}}
                </td>
                <td class="p-3">
                    {{$package->client_name . ' ' . $package->client_lastname}}
                </td>
                <td class="p-3">
                    {{$package->shipment()->shipping_date ?? '---------'}}
                </td>
                <td class="p-3">
                    {{$package->shipment()->shipment_datetime ?? '---------'}}
                </td>
                <td class="p-3">
                    {{$package->tracking_number ?? '---------'}}
                </td>
                <td class="p-3">
                    {{$package->status}}
                </td>
                <td class="w-5 px-3 py-1">
                    <div class="flex">
                        <a href="#" class="mr-2">
                            <flux:button icon="pencil"></flux:button>
                        </a>
                        <a href="#">
                            <flux:button icon="trash" variant="danger"></flux:button>
                        </a>
                    </a>
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

    <x-pagination :paginator="$packages" />
</div>