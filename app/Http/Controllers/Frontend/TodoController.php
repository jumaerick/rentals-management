<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $todos = Todo::all();
        // dd($todos);

        return view('welcome', compact('todos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:256|unique:todos,name',
            'description'=>'required',
        ]);
        if ($validator->fails()) {

            return redirect('/todos')

                ->withErrors($validator)

                ->withInput();

        }
        $validated = $validator->validated();
        Todo::create(['name'=>$validated['name'], 'description'=>$validated['description']]);
        return redirect('/todos');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
