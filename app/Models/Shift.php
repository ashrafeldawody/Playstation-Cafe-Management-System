<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
