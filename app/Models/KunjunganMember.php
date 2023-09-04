<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganMember extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kunjungan_member';

    public function kunjungan()
    {
        return $this->belongsTo(KunjunganDayin::class, 'kunjungan_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'member_id', 'id');
    }
}
