<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model{
	
    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = '__pk';	
	
	 /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
    ];

    protected $hidden = [
    ];

	
	
	
}
