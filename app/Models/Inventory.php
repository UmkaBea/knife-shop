<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{   
    protected $table = 'inventory';

    protected $fillable = ['user_id', 'knife_id'];

    public function knife()
    {
        return $this->belongsTo(Knife::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
