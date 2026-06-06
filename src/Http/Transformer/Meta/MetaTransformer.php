<?php

namespace App\Http\Transformer\Meta;

use App\Domain\Models\Meta\Meta;
use App\Http\Transformer\Filial\FilialTransformer;

class MetaTransformer {

    protected $filialTransformer;

    public function __construct(){
        $this->filialTransformer = new FilialTransformer();
    }

    public function transform(Meta $data) : array {
        return [
            'id' => $data->id,
            'uuid' => $data->uuid,
            'nome' => $data->nome,
            'valor' => $data->valor,
            'concluida' => $data->concluida,
            'ativo' => $data->ativo,
            'filial' => $this->filialTransformer->transform($data->filial()),
            'expires_at' => $data->expires_at,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $metas) : array {
        return array_map(function(Meta $data) {
            return self::transform($data);
        }, $metas);
    }

}