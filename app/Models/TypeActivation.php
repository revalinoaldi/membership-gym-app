<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeActivation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'type_activations';

    public function getRouteKeyName()
    {
        return 'type';
    }
}
