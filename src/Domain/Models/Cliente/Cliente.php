<?php

namespace App\Domain\Models\Cliente;

use App\Domain\Models\Traits\ModelTrait;
use App\Infra\Persistence\User\UserRepository;

class Cliente {

    use ModelTrait;

    public const TABLE = 'clientes';

    public int $id;
    public ?string $uuid;
    public int $usuarios_id;
    public int $pontos;
    public ?string $created_at;
    public ?string $updated_at;

    public function usuario(){
        return $this->belongsTo(UserRepository::class, $this->usuarios_id);
    }

    public function create(array $data) : Cliente {
        $cliente = new Cliente();
        $cliente->setFields($data);
        $cliente->uuid = $data['uuid'] ?? $this->generateUUID();
        return $cliente;
    }



}