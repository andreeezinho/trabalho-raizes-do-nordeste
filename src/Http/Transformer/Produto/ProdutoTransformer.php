<?php

namespace App\Http\Transformer\Produto;

use App\Domain\Models\Produto\Produto;
use App\Http\Transformer\Filial\FilialTransformer;

class ProdutoTransformer {

    protected $filialTransformer;

    public function __construct(){
        $this->filialTransformer = new FilialTransformer();
    }

    public function transform(Produto $data) : array {
        return [
            'id' => $data->id,
            'uuid' => $data->uuid,
            'nome' => $data->nome,
            'codigo' => $data->codigo,
            'preco' => $data->preco,
            'estoque' => $data->estoque,
            'ativo' => $data->ativo,
            'filial' => $this->filialTransformer->transform($data->filial()),
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $produtos) : array {
        return array_map(function(Produto $data) {
            return self::transform($data);
        }, $produtos);
    }

}