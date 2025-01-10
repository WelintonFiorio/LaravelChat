<?php

// app/Traits/HttpResponses.php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\MessageBag;

trait HttpResponses
{
    /**
     * Retorna uma resposta JSON padronizada.
     *
     * @param  string  $message  A mensagem a ser retornada na resposta.
     * @param  string|int  $status  O código de status HTTP.
     * @param  array|Model|JsonResource|Collection  $data  Os dados a serem retornados na resposta.
     * @return \Illuminate\Http\JsonResponse  A resposta JSON com a mensagem, status e dados fornecidos.
     */
    public function response(string $message, string|int $status, array|Model|JsonResource|Collection $data = [])
    {
        return response()->json(
            [
                'message' => $message,
                'status' => $status,
                'data' => $data
            ], $status
        );
    }

    /**
     * Retorna uma resposta de erro JSON padronizada.
     *
     * @param  string  $message  A mensagem de erro a ser retornada na resposta.
     * @param  string|int  $status  O código de status HTTP para erro.
     * @param  array|MessageBag  $errors  Os erros específicos (se houver).
     * @param  array  $data  Dados adicionais que possam ser fornecidos.
     * @return \Illuminate\Http\JsonResponse  A resposta JSON com a mensagem, status e erros fornecidos.
     */
    public function error(string $message, string|int $status, array|MessageBag $errors = [], array $data = [])
    {
        return response()->json(
            [
                'message' => $message,
                'status' => $status,
                'errors' => $errors,
                'data' => $data
            ], $status
        );
    }
}
