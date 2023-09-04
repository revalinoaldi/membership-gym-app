<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsMembership extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'user_is_membership';

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function member(){
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }
}
