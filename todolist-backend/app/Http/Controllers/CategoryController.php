<?php

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    /**
     * HTTP method : GET
     * URL : '/categories'
     */
    public function list()
    {
        $categoriesList = [
            1 => [
              'id' => 1,
              'name' => 'Chemin vers O\'clock',
              'status' => 1
            ],
            2 => [
              'id' => 2,
              'name' => 'Courses',
              'status' => 1
            ],
            3 => [
              'id' => 3,
              'name' => 'O\'clock',
              'status' => 1
            ],
            4 => [
              'id' => 4,
              'name' => 'Titre Professionnel',
              'status' => 1
            ]
        ];

        // https://laravel.com/docs/8.x/responses#strings-arrays
        // Par défaut si on retourne un array, Lumen va le retourner
        // encoder au format JSON
        // return $categoriesList;

        // Mais on peut aussi utiliser https://lumen.laravel.com/docs/8.x/responses#json-responses
        // ce qui pourra être utile si on veut renvoyer des données
        // qui ne sont pas de type array
        return response()->json($categoriesList);
    }

    /**
     * HTTP method : GET
     * URL : '/categories/{id}'
     */
    public function item($categoryId)
    {
        // Attention avec les dump côté API
        // car si je dump, j'envoie des headers classiques text/html
        // hors on voudra renvoyer du JSON (application/json)
        // Les dump doivent être utilisés de façon temporaire
        // et enlever dès qu'on peut pour éviter les problèmes
        // avec le front (code js)
        // dump($categoryId);

        // dump($categoryId);

        $categoriesList = [
            1 => [
              'id' => 1,
              'name' => 'Chemin vers O\'clock',
              'status' => 1
            ],
            2 => [
              'id' => 2,
              'name' => 'Courses',
              'status' => 1
            ],
            3 => [
              'id' => 3,
              'name' => 'O\'clock',
              'status' => 1
            ],
            4 => [
              'id' => 4,
              'name' => 'Titre Professionnel',
              'status' => 1
            ]
        ];

        if (array_key_exists($categoryId, $categoriesList)) {
        // if (isset($categoriesList[$categoryId])) {
            // On récupère la catégorie à retourner
            $categoryToReturn = $categoriesList[$categoryId];

            // On retourne la réponse au format JSON
            return response()->json($categoryToReturn);
        } else {
            abort(404);
        }
    }
}