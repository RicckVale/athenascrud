<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePessoasRequest;
use App\Http\Requests\UpdatePessoasRequest;
use App\Http\Resources\PessoasCollection;
use App\Http\Resources\PessoasResource;
use App\Models\Pessoas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PessoasController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $query = Pessoas::query();
        $pessoas = $query->paginate(5);

        foreach ($pessoas as $pessoa) {
            $classificacao = '';
            switch ($pessoa->categoria) {
                case 1:
                case 2:
                    $classificacao = 'Ouro';
                    break;
                case 3:
                    $classificacao = 'Prata';
                    break;
            }

            $pessoa->classificacao = $classificacao;
        }


        $pessoasListResource = new PessoasCollection($pessoas);

        return response()->json(
            $pessoasListResource
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePessoasRequest $request): JsonResponse
    {
        return response()->json(
            PessoasResource::make(Pessoas::create($request->all())),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $pessoas): JsonResponse
    {
        $pessoas = Pessoas::query()->findOrFail($pessoas);
        $classificacao = "";
        switch ($pessoas->categoria) {
            case 1:
            case 2:
                $classificacao = "Ouro";
                break;
            case 3:
                $classificacao = "Prata";
                break;

        }
        $pessoas['classificacao'] = $classificacao;
        return response()->json(
            PessoasResource::make($pessoas)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $pessoas
     * @param  UpdatePessoasRequest  $request
     * @return JsonResponse
     */
    public function update(int $pessoas, Request $request): JsonResponse
    {
        Pessoas::query()->find($pessoas)->update($request->all());

        return response()->json(
            PessoasResource::make(
                Pessoas::query()->findOrFail($pessoas)
            ),
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $pessoas
     * @return Response
     */
    public function destroy(int $pessoas): Response
    {
        Pessoas::destroy($pessoas);
        return response()->noContent();
    }
}
