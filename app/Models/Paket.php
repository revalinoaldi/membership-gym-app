<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'pakets';

    public function transaksi()
    {
        return $this->hasMany(TransactionMembership::class, 'paket_id', 'id');
    }

    public function membership()
    {
        return $this->hasMany(Membership::class, 'paket_id', 'id');
    }

    public function activation()
    {
        return $this->belongsTo(TypeActivation::class, 'type_activation_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
