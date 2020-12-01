<?php

namespace App\Http\Controllers\api;

use App\Api\ErrorMessage;
use App\Http\Controllers\Controller;
use App\Models\SituacaoEtilismo;
use Illuminate\Http\Request;

class SituacaoEtilismoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *      path="/api/situacao-etilismo",
     *      operationId="getSituacaoEtilismo",
     *      tags={"Recursos"},
     *      summary="Lista situação etilismo",
     *      description="Retorna todos as situações de etilismo cadastrado no sistema",
     *      security={{"apiAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Executado com sucesso",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          {
     *                              "id": 1,
     *                              "descricao": "Etilista"
     *                          }
     *                      }
     *                  )
     *              )
     *          }
     *       ),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return SituacaoEtilismo::all();
        } catch (\Exception $e) {
            $message = new ErrorMessage($e->getMessage());
            return response()->json($message->getMessage(), 500);
        }
    }
}
