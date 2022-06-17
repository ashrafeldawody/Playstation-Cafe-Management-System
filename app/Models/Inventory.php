<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $guarded = [];
}
