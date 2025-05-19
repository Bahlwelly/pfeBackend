<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Plainte extends Model
{
    use HasFactory;
    protected $table = 'plaintes';

    protected $fillable=[
        'user_id',
        'details',
        'adresse',
        'commune',
        'image',
        'examen'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}