<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriasRequest;
use App\Http\Requests\UpdateCategoriasRequest;
use App\Http\Resources\CategoriasCollection;
use App\Http\Resources\CategoriasResource;
use App\Models\Categorias;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriasController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $query = Categorias::query();
        $categorias = $query->paginate(5);
        $categoriasListResource = new CategoriasCollection($categorias);

        return response()->json(
            $categoriasListResource
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriasRequest $request): JsonResponse
    {
        return response()->json(
            CategoriasResource::make(Categorias::create($request->all())),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $categorias): JsonResponse
    {
        return response()->json(
            CategoriasResource::make(Categorias::query()->findOrFail($categorias))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $categorias
     * @param  UpdateCategoriasRequest  $request
     * @return JsonResponse
     */
    public function update(int $categorias, Request $request): JsonResponse
    {
        Categorias::query()->find($categorias)->update($request->all());

        return response()->json(
            CategoriasResource::make(
                Categorias::query()->findOrFail($categorias)
            ),
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $categorias
     * @return Response
     */
    public function destroy(int $categorias): Response
    {
        Categorias::destroy($categorias);
        return response()->noContent();
    }
}
