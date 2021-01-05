<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;
use App\Uuid;

class Permission extends OriginalPermission
{
    use CrudTrait, Uuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at'];
}
