<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model{
	
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
    protected $table = 'locations';

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
