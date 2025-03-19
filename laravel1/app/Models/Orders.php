<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Orders extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order';
    protected $dates = ['deleted_at'];
    protected $fillable = ['total_price', 'customer_id', 'order_date'];

    // Relationships
    public function customer() { return $this->belongsTo(Customer::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function orderProducts() { return $this->hasMany(Order_Product::class); }

    // Accessor and Mutator for order_date
    protected function orderDate(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s'),
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y H:i:s')
        );
    }
}
