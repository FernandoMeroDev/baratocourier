<div>
    <x-fieldset.simple>
        <flux:heading>
            Registrar Ingreso
        </flux:heading>

        <div class="my-3">
            @foreach($shipping_bags as $bag)
            <div class="space-y-2">
                <label class="flex items-center">
                    <input 
                        type="radio" value="{{$bag->id}}" name="bags" class="mr-3"
                        x-on:change="$dispatch('changed-bag', { id: {{$bag->id}} })"
                    />
                    Saca {{$bag->number}}
                </label>
            </div>
            @endforeach
        </div>

        <div>
            <flux:button wire:click="addBag">
                Agregar Saca
            </flux:button>
        </div>
    </x-fieldset.simple>
</div>
