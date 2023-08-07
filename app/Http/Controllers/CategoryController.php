<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->cannot('viewAny', Category::class)) {
            abort(403);
        }

        return view('categories.index', ['categories'=>Category::paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->cannot('create', Category::class)) {
            abort(403);
        }

        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->cannot('create', Category::class)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'name' => 'required'
        ]);

        Category::create($incomingFields);

        Log::create([
            'title' => 'Category '.$incomingFields['name'].' created',
            'description' => nl2br('Name: '.$incomingFields['name'])
        ]);

        return redirect('categories');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (auth()->user()->cannot('view', $category)) {
            abort(403);
        }

        return view('categories.show', ['category'=>$category]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if (auth()->user()->cannot('update', $category)) {
            abort(403);
        }
        
        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if (auth()->user()->cannot('update', $category)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'name' => 'required'
        ]);

        $category->update($incomingFields);

        Log::create([
            'title' => 'Category '.$category->name.' updated',
            'description' => nl2br('Name: '.$incomingFields['name'])
        ]);

        return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (auth()->user()->cannot('delete', $category)) {
            abort(403);
        }

        $category->delete();

        Log::create([
            'title' => 'Category '.$category->name.' deleted',
            'description' => nl2br('Name: '.$category->name)
        ]);

        return redirect('categories');
    }
}
