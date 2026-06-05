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

    public function findProductsInOrder(int $pedidos_id){
        $stmt = $this->conn->prepare(
            "SELECT * FROM " . $this->model->getTable() . "
            WHERE
                pedidos_id = :pedidos_id
            ORDER BY 
                created_at ASC
        ");

        $stmt->execute([":pedidos_id" => $pedidos_id]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::$className);
        $result = $stmt->fetchAll();

        if(empty($result)){
            return null;
        }

        return $result;
    }

}