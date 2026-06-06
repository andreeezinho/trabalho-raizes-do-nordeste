<?php

namespace App\Http\Transformer\Pedido;

use App\Domain\Models\Pedido\PedidoProduto;
use App\Http\Transformer\Pedido\PedidoTransformer;
use App\Http\Transformer\Produto\ProdutoTransformer;

class PedidoProdutoTransformer {

    protected $pedidoTransformer;
    protected $produtoTransformer;

    public function __construct(){
        $this->pedidoTransformer = new PedidoTransformer();
        $this->produtoTransformer = new ProdutoTransformer();
    }

    public function transform(PedidoProduto $data) : array {
        return [
            'id' => $data->id,
            'uuid' => $data->uuid,
            'quantidade' => $data->quantidade,
            'pedido' => $this->pedidoTransformer->transform($data->pedido()),
            'produto' => $this->produtoTransformer->transform($data->produto()),
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $pedido_produto) : array {
        return array_map(function(PedidoProduto $data) {
            return self::transform($data);
        }, $pedido_produto);
    }

}