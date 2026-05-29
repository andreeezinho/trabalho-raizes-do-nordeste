<?php

namespace App\Domain\Models\Produto;

use App\Domain\Models\Traits\ModelTrait;
use App\Infra\Persistence\Filial\FilialRepository;

class Produto{

    use ModelTrait;

    public const TABLE = 'produtos';

    public int $id;
    public ?string $uuid;
    public string $nome;
    public string $codigo;
    public float $preco;
    public int $estoque;
    public int $filiais_id;
    public int $ativo;
    public ?string $created_at;
    public ?string $updated_at;

    public function filial(){
        return $this->belongsTo(FilialRepository::class, $this->filiais_id);
    }

    public function create(array $data) : Produto {
        $produto = new Produto();
        $produto->setFields($data);
        $produto->uuid = $data['uuid'] ?? $this->generateUUID();
        return $produto;
    }

}