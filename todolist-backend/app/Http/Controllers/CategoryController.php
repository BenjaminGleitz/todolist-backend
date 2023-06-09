<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->sendJsonResponse($categoriesList);
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

      
      return response()->json($categoryById);
    }

    /**
     * HTTP method : POST
     * URL : '/categories/{id}'
     */
    public function add(Request $request)
    {
      if ($request->filled('name')) {

        // on crée un nouvel objet à partir de la classe Task
        $newCategory = new Category();

        // on récupère les valeurs fournies dans la requête
        $name = $request->input('name'); // 'name' est le nom du champ envoyé dans le JSON
        $status = $request->input('status');
        // on met à jour les valeurs des propriétés/attributs de notre
        // nouvelle tâche
        $newCategory->name = $name;
        $newCategory->status = $status;


        // On sauve en base de données l'objet Task
        $newCategoryInserted = $newCategory->save();

        // Si l'ajout a fonctionné
        if ($newCategoryInserted === true) {
            // après le save() l'objet $newCategory s'est vu rajouté
            // les attributs created_at, updated_at et id
            // l'id étant nécessaire côté front, il est important
            // de retourner tout l'objet $newCategory en retour de la requête
            // alors retourner le code de réponse HTTP 201 "Created"
            // https://restfulapi.net/http-status-201-created/
            // et les données de la tâche au format JSON
            return $this->sendJsonResponse($newCategory, Response::HTTP_CREATED);
        }
        // Sinon, il y a eu un souci dans la création de la nouvelle tâche
        else {
            return $this->sendEmptyResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            // abort(500);
        }
      }
      // Sinon, c'est que les données requises n'ont pas été fournies
      // ('name' et/ou 'categoryId')
      else {
          // return $this->sendEmptyResponse(400);
          return $this->sendEmptyResponse(Response::HTTP_BAD_REQUEST);
          // ou abort(Response::HTTP_BAD_REQUEST);
      }
    }

    public function update(Request $request, int $categoryId) 
    {
      if (filled('name')) {
        
        $categoryToUpdate = Category::find($categoryId);

        $categoryToUpdate->name = $request->input('name');

        $categoryUpdated = $categoryToUpdate->save();

        // Si l'ajout a fonctionné
        if ($categoryUpdated === true) {
          return $this->sendJsonResponse($categoryToUpdate, Response::HTTP_CREATED);
        } 
        else {
          return $this->sendEmptyResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
      }
    }

    public function delete(Request $request, int $categoryId) 
    {
        $categoryToDelete = Category::find($categoryId);
        if ($categoryToDelete !== null) {
            if ($categoryToDelete->delete()) {
                return $this->sendEmptyResponse(Response::HTTP_NO_CONTENT);
            } else {
                return $this->sendEmptyResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return $this->sendEmptyResponse(Response::HTTP_NOT_FOUND);
        }
    }
}