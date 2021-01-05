<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use DB;
class Order extends Model
{
    use CrudTrait, SoftDeletes;

    public function __construct(array $attributes = [])
    {
        $this->creating([$this, 'onCreating']);

        parent::__construct($attributes);
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'orders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'tanggal_kirim' => 'date'
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id')->orderby('created_at', 'desc');
    }

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class, 'order_id')
            ->where('order_id', $this->id);
    }

    public function destination()
    {
        return $this->belongsTo('App\Models\Expedition', 'ekspedisi', 'code');
    }

    public function onCreating(\App\Models\Order $row)
    {
        $row->setAttribute('kode_truk', (self::max('kode_truk') + 1));
        // Placeholder for catching any exceptions
        if (!\Auth::user()->id) {
            return false;
        }

        $row->setAttribute('user_id', \Auth::user()->id);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getDeliveryDateAttribute($value)
    {
        return $this->tanggal_kirim;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
