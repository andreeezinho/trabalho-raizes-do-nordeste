<?php

namespace App\Http\Transformer\Cliente;

use App\Domain\Models\Cliente\Cliente;
use App\Http\Transformer\User\UserTransformer;

class ClienteTransformer{

    protected $userTransformer;

    public function __construct()
    {
        $this->userTransformer = new UserTransformer();
    }

    public function transform(Cliente $data) : array {
        return [
            'id' => $data->id,
            'uuid' => $data->uuid,
            'usuario' => $this->userTransformer->transform($data->usuario()),
            'pontos' => $data->pontos,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $clientes) : array {
        return array_map(function(Cliente $data) {
            return self::transform($data);
        }, $clientes);
    }

}