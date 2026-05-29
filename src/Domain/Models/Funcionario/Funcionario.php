<?php

namespace App\Domain\Models\Funcionario;

use App\Domain\Models\Traits\ModelTrait;
use App\Infra\Persistence\Filial\FilialRepository;
use App\Infra\Persistence\User\UserRepository;

class Funcionario {

    use ModelTrait;

    public const TABLE = 'funcionarios';

    public int $id;
    public ?string $uuid;
    public int $usuarios_id;
    public int $filiais_id;
    public string $cargo;
    public ?string $created_at;
    public ?string $updated_at;

    public function usuario(){
        return $this->belongsTo(UserRepository::class, $this->usuarios_id);
    }

    public function filial(){
        return $this->belongsTo(FilialRepository::class, $this->filiais_id);
    }

    public function create(array $data) : Funcionario {
        $funcionario = new Funcionario();
        $funcionario->setFields($data);
        $funcionario->uuid = $data['uuid'] ?? $this->generateUUID();
        return $funcionario;
    }

}