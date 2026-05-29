<?php

namespace App\Infra\Persistence\Pedido;

use App\Domain\Models\Pedido\Pedido;
use App\Domain\Repositories\Pedido\PedidoRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class PedidoRepository extends BaseRepository implements PedidoRepositoryInterface {

    public static $className = Pedido::class;

    public function __construct() {
        parent::__construct();
        $this->model = new Pedido();
    }

}