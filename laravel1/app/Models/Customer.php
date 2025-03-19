<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'email', 'address', 'phone'];

    // Relationships
    public function carts() { return $this->hasMany(Cart::class); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }
    public function orders() { return $this->hasMany(Orders::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function products() { return $this->hasManyThrough(Product::class, Cart::class, 'customer_id', 'id', 'id', 'product_id'); }
}
