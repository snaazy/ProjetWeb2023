<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'cours';


    protected $fillable = [
        'intitule',
        'user_id',
        'formation_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    // Ajoutez cette méthode si vous avez besoin de récupérer les étudiants associés à un cours
    public function students()
    {
        return $this->belongsToMany(User::class, 'cours_users', 'cours_id', 'user_id');
    }

    public function plannings()
{
    return $this->hasMany(Planning::class);
}

}