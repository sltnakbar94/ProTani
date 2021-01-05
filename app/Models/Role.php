<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Models\Role as OriginalRole;
use App\Uuid;

class Role extends OriginalRole
{
    use CrudTrait, Uuid;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at'];
}
