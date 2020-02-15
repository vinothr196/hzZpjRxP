<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleMakes extends Model {
  protected $guarded = ['id'];

  /**
    * Get all vehicle-models of a make
    * one-to-many relationship
    */
  public function vehicle_models()
  {
  	return $this->hasMany('App\Models\VehicleModels', 'vehicle_make_id');
  }
}
