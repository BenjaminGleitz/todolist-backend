<?php

namespace App\Http\Controllers;


use App\Models\Category;
// use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * HTTP method : GET
     * URL : '/categories'
     */
    public function list()
    {
        
        // On veut toutes les catégories présentes en base de données
        // $results = DB::select('SELECT * FROM categories');
        // var_dump($results); exit();
        // Les résultats sont des objets "sans classe", et donc sans Model
        // Ce n'est pas de l'active record, on n'aime pas ça :'-(

        // Donc on va utiliser notre ORM Eloquent qui nous facilite le code :-)
        // https://laravel.com/docs/6.x/eloquent
        $categoriesList = Category::all();
        // dump($categoriesList);

        // https://laravel.com/docs/8.x/responses#strings-arrays
        // Par défaut si on retourne un array, Lumen va le retourner
        // encoder au format JSON
        // return $categoriesList;

        // Mais on peut aussi utiliser https://lumen.laravel.com/docs/8.x/responses#json-responses
        // ce qui pourra être utile si on veut renvoyer des données
        // qui ne sont pas de type array
        // return response()->json($categoriesList);

        // On utilise notre méthode utilitaire pour retourner la liste des catégories
        return response()->json($categoriesList);
    }

    /**
     * HTTP method : GET
     * URL : '/categories/{id}'
     */
    public function item($categoryId)
    {

      $categoryById = Category::find($categoryId);
      // dump($categoryById);

      if ($categoryById === null) {
        abort(404);
      }
    }
}