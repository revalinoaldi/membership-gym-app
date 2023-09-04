<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganDayin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kunjungan_dayin';

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kunjungan()
    {
        return $this->hasMany(KunjunganMember::class, 'kunjungan_id', 'id');
    }
}
