<?php

namespace App\Http\Controllers;


use App\Models\Task;
// use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * HTTP method : GET
     * URL : '/tasks'
     */
    public function list()
    {
        $tasksList = Task::all();

        return $this->sendJsonResponse($tasksList);
    }

    /**
     * HTTP method : GET
     * URL : '/tasks/{id}'
     */
    public function item($taskId)
    {

      $taskById = Task::find($taskId);
      // dump($taskById);

      if ($taskById === null) {
        abort(404);
      }

      
      return response()->json($taskById);
    }
}