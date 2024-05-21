<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $categories;

    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categories->get();

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCategory $request)
    {
        $categories = $this->categories->create($request->all());

        return new CategoryResource($categories);

    }

    /**
     * Display the specified resource.
     *
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $categorie = $this->categories->where('url', $url)->firstOrFail();

        return new CategoryResource($categorie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCategory $request, $url)
    {
        $categorie = $this->categories->where('url', $url)->firstOrFail();

        $categorieUdate = $categorie->update($request->all());

        return response()->json(['message' => 'Categoria atualizada com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    public function destroy($url)
    {
        $categorie = $this->categories->where('url', $url)->firstOrFail();

        $categorie->delete();

        return response()->json(['message' => 'Categoria removida com sucesso']);
    }
}
