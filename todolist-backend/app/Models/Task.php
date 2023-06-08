<?php

namespace App\Models;

// On utilise le "CoreModel" de Lumen qui nous permet d'écrire nos modèles
// plus facilement avec moins de code
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }
}