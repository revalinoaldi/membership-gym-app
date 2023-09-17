<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'memberships';

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id', 'id');
    }

    public function kunjungan()
    {
        return $this->hasMany(KunjunganMember::class, 'member_id', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(TransactionMembership::class, 'membership_id', 'id')->latest();
    }

    public function isUser(){
        return $this->hasOne(IsMembership::class, 'membership_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'kode_member';
    }
}
