<?php

namespace App\Infra\Persistence\Pedido;

use App\Domain\Models\Pedido\PedidoProduto;
use App\Domain\Repositories\Pedido\PedidoProdutoRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class PedidoProdutoRepository extends BaseRepository implements PedidoProdutoRepositoryInterface {

    public static $className = PedidoProduto::class;

    public function __construct() {
        parent::__construct();
        $this->model = new PedidoProduto();
    }

}