<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    //

    public function index()
    {
        // $lists = TodoList::whereUserId(auth()->id())->get();

        //we use this instead of the above
        $lists = auth()->user()->todo_lists;
        return response($lists);
    }

    public function show($id)
    {
        $list = TodoList::findOrFail($id);
        return response($list);
    }

    //show cleanest with typehinted that will search automatically the parameter
    // public function show(TodoList $list)
    // {
    //     return response($list);
    // }

    public function store(TodoListRequest $request)
    {

        // $request['user_id'] = auth()->id();
        // $request->validate(['name' => ['required']]);
        // $list = TodoList::create($request->all());

        //we use this instead of the above
        $list = auth()->user()->todo_lists()->create($request->validated());


        //or       $list = TodoList::create(['name' => $request->name]);
        return response($list, Response::HTTP_CREATED);
        //or we can do very simply it contain status code also
        return $list;
    }

    public function destroy(TodoList $todo_list)
    {
        //   $todo_list->tasks->each->delete();

        //clean way than above but instead we create the boot method inside the todolist Model

        $todo_list->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(TodoListRequest $request, TodoList $todo_list)
    {
        //we commented it because we made the verification now inside todolistrequest.php
        // $request->validate();

        $todo_list->update($request->all());
        return response($todo_list);
    }
}
