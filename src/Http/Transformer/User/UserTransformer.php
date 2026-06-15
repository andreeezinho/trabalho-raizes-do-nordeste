<?php

namespace App\Http\Transformer\User;

use App\Domain\Models\User\User;

class UserTransformer {

    public function transform(User $data) : array {
        return [
            'uuid' => $data->uuid,
            'nome' => $data->nome,
            'email' => $data->email,
            'telefone' => $data->telefone,
            'data_nasc' => $data->data_nasc,
            'ativo' => $data->ativo,
            'icone' => $data->icone,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $users) : array {
        return array_map(function(User $data) {
            return self::transform($data);
        }, $users);
    }

}