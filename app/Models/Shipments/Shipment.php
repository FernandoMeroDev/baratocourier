<?php

namespace App\Models\Shipments;

use App\Models\Packages\Package;
use App\Models\Packages\Waybills\Waybill;
use App\Models\traits\SequentialFormater;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory, SequentialFormater;

    protected $fillable = [
        'number',
        'shipping_date',
        'reference',
        'shipment_datetime',
        'upshipment_datetime',
        'status',
        'arrival_min_date',
        'arrival_max_date',
        'shipment_type_id',
        'user_id',
    ];

    public static array $valid_statuses = [
        'shipment' => 'Embarcado', 
        'unshipment' => 'Sin Embarcar', 
        'landed' => 'Desembarcado'
    ];

    public function readable_number(): string
    {
        return $this->user->franchisee->client_domain . $this->formatSequential($this->number);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ShipmentType::class, 'shipment_type_id', 'id');
    }

    public function bags(): HasMany
    {
        return $this->hasMany(ShippingBag::class);
    }

    public function packages(): Collection
    {
        return Package::join('waybills', 'waybills.package_id', '=','packages.id')
            ->join('shipping_bags', 'shipping_bags.id', '=', 'waybills.shipping_bag_id')
            ->join('shipments', 'shipments.id', '=', 'shipping_bags.shipment_id')
            ->select('packages.*')->groupBy('packages.id')
            ->where('shipments.id', $this->id)->get();
    }

    public function waybills(): Collection
    {
        return Waybill::join('shipping_bags', 'shipping_bags.id', '=', 'waybills.shipping_bag_id')
            ->join('shipments', 'shipments.id', '=', 'shipping_bags.shipment_id')
            ->select('waybills.*')->groupBy('waybills.id')
            ->where('shipments.id', $this->id)->get();
    }

    public function checkWaybill(Waybill $waybill): bool
    {
        $waybills = Waybill::join('shipping_bags', 'shipping_bags.id', '=', 'waybills.shipping_bag_id')
            ->join('shipments', 'shipments.id', '=', 'shipping_bags.shipment_id')
            ->select('waybills.*')->groupBy('waybills.id')
            ->where('shipments.id', $this->id)->get();
        return $waybills->contains($waybill->id);
    }
}
