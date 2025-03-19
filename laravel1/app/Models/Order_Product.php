<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order_Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['product_id', 'order_id', 'price', 'quantity'];

    // Relationships
    public function product() { return $this->belongsTo(Product::class); }
    public function order() { return $this->belongsTo(Orders::class); }
}
