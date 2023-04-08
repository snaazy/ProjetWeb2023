<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Formation;
use App\Models\Cours;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = ['mdp'];

    protected $passwordColumn = 'mdp';

    protected $fillable = ['nom', 'prenom', 'login', 'mdp', 'formation_id', 'type'];

    protected $attributes = [
        'type' => 'user'
    ];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function cours(): HasMany
    {
        return $this->hasMany(Cours::class);
    }

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function setPasswordAttribute(string $value)
    {
        $this->attributes['mdp'] = bcrypt($value);
    }
}
