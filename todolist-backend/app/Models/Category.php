<?php

namespace App\Models;

// On utilise le "CoreModel" de Lumen qui nous permet d'écrire nos modèles
// plus facilement avec moins de code
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Automatiquement, Eloquent va par défaut chercher dans la table
    // correspondant au nom du modèle en minuscule et mis au pluriel :
    // Modèle Category => Lumen va chercher dans la table 'categories'
    // Si jamais, ça ne correspond au nom de notre table, on peut toujours
    // préciser à Lumen le nom de la table pour ce modèle en rajoutant
    // un propriété :
    // protected $table = 'mon_nom_de_table';
    // A partir des champs de la table 'categories', Eloquent va déduire
    // automatiquement les propriétés du modèle Category !


    // En écrivant cette méthode, cela permet de définir une relation
    // entre les modèles Category et Task
    //
    // Grâce à cette relation :
    //   => Eloquent sera capable d'aller chercher à la demande toutes
    // les tâches liées à une catégorie
    //
    // Et comme il peut y avoir plusieurs tâches dans une catégorie donnée :
    //  => on a donc une relation de type One to Many
    //
    // https://laravel.com/docs/6.x/eloquent-relationships#one-to-many
    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }
}