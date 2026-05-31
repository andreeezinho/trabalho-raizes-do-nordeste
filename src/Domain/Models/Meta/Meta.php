<?php

namespace App\Domain\Models\Meta;

use App\Domain\Models\Traits\ModelTrait;
use App\Infra\Persistence\Filial\FilialRepository;

class Meta {

    use ModelTrait;

    public const TABLE = 'metas';

    public int $id;
    public ?string $uuid;
    public int $filiais_id;
    public ?string $nome;
    public float $valor;
    public int $concluida;
    public int $ativo;
    public string $expires_at;
    public ?string $created_at;
    public ?string $updated_at;

    public function filial(){
        return $this->belongsTo(FilialRepository::class, $this->filiais_id);
    }

    public function create(array $data) : Meta {
        $meta = new Meta();
        $meta->setFields($data);
        $meta->uuid = $data['uuid'] ?? $this->generateUUID();
        return $meta;
    }

}