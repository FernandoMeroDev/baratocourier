<div>
    <div class="mt-3">
        <a href="{{route('packages.download', [
            'package' => 1,
            'use_styles_of' => $franchisee->id
        ])}}" target="_blank">
            <flux:button>
                Mostrar Guía
            </flux:button>
        </a>
    </div>
    <div class="sm:grid">
        <div class="col-span-2">
            <livewire:users.franchisee.edit.waybills.block
                :$franchisee
                :field="'logo'"
                :label="'Logotipo'"
            />
        </div>
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'courier_name'"
            :label="'Nombre de Courier'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'address'"
            :label="'Dirección'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'phone_number'"
            :label="'Número de teléfono'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'barcode'"
            :label="'Código de Barras'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'waybill_number'"
            :label="'Número de Guía'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'waybill_text_reference'"
            :label="'Texto de Referencia en Guía'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'weight'"
            :label="'Peso en LB'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'created_at'"
            :label="'Fecha'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'tracking_number'"
            :label="'Número de Seguimiento'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'reference'"
            :label="'Texto de Referencia'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'category'"
            :label="'Categoría'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'shipping_address'"
            :label="'Dirección de Envío'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'shipping_method'"
            :label="'Método de Envío'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'client_code'"
            :label="'Código de cliente'"
        />
        <livewire:users.franchisee.edit.waybills.text
            :$franchisee
            :field="'client_name'"
            :label="'Nombre de cliente'"
        />
        <div class="flex items-end justify-end">
            <flux:button wire:click="restoreDefaultStyles">
                Reiniciar Estilos
            </flux:button>
        </div>
    </div>
</div>
