<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $primaryKey = 'nombre_venta';
    public $incrementing = false;
    protected $keyType = 'string';

    public function cartas(){

        return $this->hasMany(Cards::class);

}
}