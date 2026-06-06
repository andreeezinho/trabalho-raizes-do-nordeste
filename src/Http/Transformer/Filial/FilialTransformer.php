<?php

namespace App\Http\Transformer\Filial;

use App\Domain\Models\Filial\Filial;

class FilialTransformer {

    public function transform(Filial $data) : array {
        return [
            'id' => $data->id,
            'uuid' => $data->uuid,
            'num_filial' => $data->num_filial,
            'local' => $data->local,
            'ativo' => $data->ativo,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $filiais) : array {
        return array_map(function(Filial $data) {
            return self::transform($data);
        }, $filiais);
    }

}