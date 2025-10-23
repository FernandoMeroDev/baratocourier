@props([
    'waybillsCount',
    'waybillNumber',
    'loopLast',
    'shipment'
])

@php
$classes = $shipment ? 'text-green-500' : 'text-red-500'
@endphp
@if($waybillsCount > 1)
    @if( ! $loopLast)
        <span class="{{$classes}}">{{$waybillNumber . ', '}}</span>
    @else
        <span class="{{$classes}}">{{$waybillNumber . '.'}}</span>
    @endif
@else
    <span class="{{$classes}}">{{$waybillNumber}}</span>
@endif