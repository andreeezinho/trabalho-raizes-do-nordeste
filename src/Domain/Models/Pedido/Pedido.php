<?php

namespace App\Domain\Models\Pedido;

use App\Domain\Models\Traits\ModelTrait;
use App\Infra\Persistence\Cliente\ClienteRepository;
use App\Infra\Persistence\Filial\FilialRepository;

class Pedido {

    use ModelTrait;

    public const TABLE = 'pedidos';

    public int $id;
    public ?string $uuid;
    public string $situacao;
    public int $pagamento;
    public string $status;
    public int $filiais_id;
    public int $clientes_id;
    public string $canalPedido;
    public ?string $created_at;
    public ?string $updated_at;

    public function filial(){
        return $this->belongsTo(FilialRepository::class, $this->filiais_id);
    }

    public function cliente(){
        return $this->belongsTo(ClienteRepository::class, $this->clientes_id);
    }

    public function create(array $data) : Pedido {
        $pedido = new Pedido();
        $pedido->setFields($data);
        $pedido->uuid = $data['uuid'] ?? $this->generateUUID();
        return $pedido;
    }

}