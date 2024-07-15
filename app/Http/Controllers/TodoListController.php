<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Http\Resources\TodoListResource;
use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends BaseController
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $todoLists = TodoList::with('user')->get()->sortByDesc('created_at');
    $data = TodoListResource::collection($todoLists);
    return $this->sendSuccess($data, 'Data todos berhasil diambil');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(TodoListRequest $request)
  {
    $input = $request->validated();
    $todoList = TodoList::create($input);

    return $this->sendSuccess($todoList, 'Data todo list berhasil ditambahkan');
  }

  /**
   * Display the specified resource.
   */
  public function show(TodoList $todoList)
  {
    $todoList = TodoList::with('user')->where('id', $todoList->id)->first();
    $data = new TodoListResource($todoList);

    return $this->sendSuccess($data, 'Data todo list berhasil diambil');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(TodoList $todoList)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(TodoListRequest $request, String $id)
  {
    $input = $request->validated();
    $todoList = TodoList::where('id', $id)->first();
    $updateTodoList = $todoList->update([
      'user_id' => $input['user_id'],
      'name' => $input['name'],
      'work' => $input['work'],
      'duedate' => $input['duedate'],
    ]);

    return $this->sendSuccess($updateTodoList, 'Data todo list berhasil diupdate');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $todoList = TodoList::where('id', $id)->first();
    $delete = $todoList->delete();

    return $this->sendSuccess($delete, 'Data todo list berhasil dihapus');
  }
}
