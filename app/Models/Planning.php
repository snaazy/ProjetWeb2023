<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'date_debut',
        'date_fin',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'cours_id');
    }
}
