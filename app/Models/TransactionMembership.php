<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMembership extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'transaction_memberships';

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id', 'id');
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'kode_transaksi';
    }
}
