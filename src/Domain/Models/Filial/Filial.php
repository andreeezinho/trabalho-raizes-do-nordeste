<?php

namespace App\Domain\Models\Filial;

use App\Domain\Models\Traits\ModelTrait;

class Filial{

    use ModelTrait;

    public const TABLE = 'filiais';

    public int $id;
    public ?string $uuid;
    public int $num_filial;
    public ?string $local;
    public int $ativo;
    public ?string $created_at;
    public ?string $updated_at;

    public function create(array $data) : Filial {
        $filial = new Filial();
        $filial->setFields($data);
        $filial->uuid = $data['uuid'] ?? $this->generateUUID();
        return $filial;
    }

}