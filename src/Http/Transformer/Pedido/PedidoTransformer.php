<?php

namespace App\Http\Transformer\Pedido;

use App\Domain\Models\Pedido\Pedido;
use App\Http\Transformer\Filial\FilialTransformer;
use App\Http\Transformer\Cliente\ClienteTransformer;

class PedidoTransformer {

    protected $filialTransformer;
    protected $clienteTransformer;

    public function __construct(){
        $this->filialTransformer = new FilialTransformer();
        $this->clienteTransformer = new ClienteTransformer();
    }

    public function transform(Pedido $data) : array {
        return [
            'uuid' => $data->uuid,
            'situacao' => $data->situacao,
            'forma_pagamento' => $data->forma_pagamento,
            'pagamento' => $data->pagamento,
            'status' => $data->status,
            'filial' => $this->filialTransformer->transform($data->filial()),
            'cliente' => $this->clienteTransformer->transform($data->cliente()),
            'canalPedido' => $data->canalPedido,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $pedidos) : array {
        return array_map(function(Pedido $data) {
            return self::transform($data);
        }, $pedidos);
    }

}