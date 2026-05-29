<?php

namespace App\Infra\Persistence\Funcionario;

use App\Domain\Models\Funcionario\Funcionario;
use App\Domain\Repositories\Funcionario\FuncionarioRepositoryInterface;
use App\Infra\Persistence\BaseRepository;

class FuncionarioRepository extends BaseRepository implements FuncionarioRepositoryInterface {

    public static $className = Funcionario::class;

    public function __construct() {
        parent::__construct();
        $this->model = new Funcionario();
    }

}