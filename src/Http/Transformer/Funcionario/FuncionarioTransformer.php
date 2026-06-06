<?php

namespace App\Http\Transformer\Funcionario;

use App\Domain\Models\Funcionario\Funcionario;
use App\Http\Transformer\User\UserTransformer;
use App\Http\Transformer\Filial\FilialTransformer;

class FuncionarioTransformer {

    protected $userTransformer;
    protected $filialTransformer;

    public function __construct(){
        $this->userTransformer = new UserTransformer();
        $this->filialTransformer = new FilialTransformer();
    }

    public function transform(Funcionario $data) : array {
        return [
            'id' => $data->id,
            'uuid' => $data->uuid,
            'usuario' => $this->userTransformer->transform($data->usuario()),
            'filial' => $this->filialTransformer->transform($data->filial()),
            'cargo' => $data->cargo,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }

    public function transformArray(array $funcionarios) : array {
        return array_map(function(Funcionario $data) {
            return self::transform($data);
        }, $funcionarios);
    }

}