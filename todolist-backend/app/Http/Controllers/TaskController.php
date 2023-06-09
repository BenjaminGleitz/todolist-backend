<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * HTTP method : GET
     * URL : '/tasks'
     */
    public function list()
    {
        $tasksList = Task::all();
        // dump($tasksList);

        // On utilise notre méthode utilitaire pour retourner la liste des tâches
        return $this->sendJsonResponse($tasksList);
    }

    /**
     * HTTP method : GET
     * URL : '/tasks/{id}'
     */
    public function item($taskId)
    {

      $taskById = Task::find($taskId);
      // dump($TaskId);

      if ($taskById === null) {
        abort(404);
      }
      return response()->json($taskById);
    }

    /**
     * HTTP method : POST
     * URL : '/tasks'
     */
    public function add(Request $request)
    {
        if ($request->filled(['title', 'categoryId'])) {

            // on crée un nouvel objet à partir de la classe Task
            $newTask = new Task();

            // on récupère les valeurs fournies dans la requête
            $title = $request->input('title'); // 'title' est le nom du champ envoyé dans le JSON
            $categoryId = $request->input('categoryId');

            // on met à jour les valeurs des propriétés/attributs de notre
            // nouvelle tâche
            $newTask->title = $title;
            $newTask->category_id = $categoryId;

            // Comme il y a déjà des valeurs par défaut dans la BDD,
            // completion et status sont facultatifs, donc change ces
            // propriétés uniquement si elles sont fournies
            if ($request->filled('completion')) {
                $newTask->completion = $request->input('completion');
            }
            if ($request->filled('status')) {
                $newTask->status = $request->input('status');
            }

            // On sauve en base de données l'objet Task
            $newTaskInserted = $newTask->save();

            // Si l'ajout a fonctionné
            if ($newTaskInserted === true) {
                return $this->sendJsonResponse($newTask, Response::HTTP_CREATED);
            }
            // Sinon, il y a eu un souci dans la création de la nouvelle tâche
            else {
                return $this->sendEmptyResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
                // abort(500);
            }
        }
        // Sinon, c'est que les données requises n'ont pas été fournies
        // ('title' et/ou 'categoryId')
        else {
            // return $this->sendEmptyResponse(400);
            return $this->sendEmptyResponse(Response::HTTP_BAD_REQUEST);
            // ou abort(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * HTTP method : PUT ou PATCH
     * URL : /tasks/{id}
     */
    public function update(Request $request, int $taskId)
    {
        // on récupère la tâche à modifier
        $taskToUpdate = Task::find($taskId);

        // Si la tâche existe ?
        if ($taskToUpdate !== null) {

            // Est-ce que la requête est en PUT ?
            if ($request->isMethod('put')) {

                // On vérifie que les données à mettre à jour sont présentes
                if ($request->filled(['title', 'categoryId', 'completion', 'status'])) {
                    // Mise à jour de l'objet
                    $taskToUpdate->title = $request->input('title');
                    $taskToUpdate->category_id = $request->input('categoryId');
                    $taskToUpdate->completion = $request->input('completion');
                    $taskToUpdate->status = $request->input('status');
                }
                // sinon, il manque des informations => mauvaise requête
                else {
                    return $this->sendEmptyResponse(Response::HTTP_BAD_REQUEST);
                }
            }
            // Sinon, c'est qu'on est en PATCH
            else {
                // On va stocker dans un variable le fait qu'il y ait au moins
                // une des 4 informations fournies
                $oneDataAtLeast = false; // on part du principe qu'il n'y a aucune information fournie

                // Pour chaque information, on regarde si elle est fournie
                // si c'est le cas, on alors on met à jour la tâche pour cette information
                // et on est sûr qu'il y a au moins 1 information mise à jour
                if ($request->filled('title')) {
                    $taskToUpdate->title = $request->input('title');
                    $oneDataAtLeast = true;
                }
                if ($request->filled('categoryId')) {
                    $taskToUpdate->category_id = $request->input('categoryId');
                    $oneDataAtLeast = true;
                }
                if ($request->filled('completion')) {
                    $taskToUpdate->completion = $request->input('completion');
                    $oneDataAtLeast = true;
                }
                if ($request->filled('status')) {
                    $taskToUpdate->status = $request->input('status');
                    $oneDataAtLeast = true;
                }

                // Si on n'a pas au moins 1 information, alors c'est une BAD REQUEST
                if (!$oneDataAtLeast) {
                    return $this->sendEmptyResponse(Response::HTTP_BAD_REQUEST);
                }
            }

            // On sauve dans la BDD
            // et on teste si la modification a fonctionné
            if ($taskToUpdate->save()) {
                return $this->sendEmptyResponse(Response::HTTP_CREATED);
            } else {
                return $this->sendEmptyResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        // Sinon, la tâche n'existe pas => not found 404
        else {
            return $this->sendEmptyResponse(Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * HTTP method : DELETE
     * URL : /tasks/{id}
     */
    public function delete($taskId) {

      // On récupère la tâche à supprimer
      $taskToDelete = Task::find($taskId);
      // Si la tâche existe ? (find retourne null s'il ne trouve pas la tâche)
      if ($taskToDelete !== null) {
          if ($taskToDelete->delete()) {
              return $this->sendEmptyResponse(Response::HTTP_NO_CONTENT);
          } else {
              return $this->sendEmptyResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
          }
      } else {
          return $this->sendEmptyResponse(Response::HTTP_NOT_FOUND);
      }
  }
}