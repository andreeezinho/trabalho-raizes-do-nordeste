<?php

namespace App\Domain\Models\Pedido;

use App\Domain\Models\Traits\ModelTrait;
use App\Infra\Persistence\Pedido\PedidoRepository;
use App\Infra\Persistence\Produto\ProdutoRepository;

class PedidoProduto {

    use ModelTrait;

    public const TABLE = 'pedido_produto';

    public int $id;
    public ?string $uuid;
    public int $quantidade;
    public int $pedidos_id;
    public int $produtos_id;
    public ?string $created_at;
    public ?string $updated_at;

    public function pedido(){
        return $this->belongsTo(PedidoRepository::class, $this->pedidos_id);
    }

    public function produto(){
        return $this->belongsTo(ProdutoRepository::class, $this->produtos_id);
    }

    public function create(array $data) : PedidoProduto {
        $pedido_produto = new PedidoProduto();
        $pedido_produto->setFields($data);
        $pedido_produto->uuid = $data['uuid'] ?? $this->generateUUID();
        return $pedido_produto;
    }

}