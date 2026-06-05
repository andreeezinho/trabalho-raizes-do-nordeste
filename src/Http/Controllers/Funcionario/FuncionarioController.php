<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Request\Request;
use App\Http\Controllers\Controller;
use App\Domain\Repositories\Funcionario\FuncionarioRepositoryInterface;
use App\Domain\Repositories\Filial\FilialRepositoryInterface;
use App\Domain\Repositories\User\UserRepositoryInterface;
use App\Http\Transformer\Funcionario\FuncionarioTransformer;

class FuncionarioController extends Controller {

    protected $funcionarioRepository;
    protected $filialRepository;
    protected $userRepository;
    protected $funcionarioTransformer;

    public function __construct(FuncionarioRepositoryInterface $funcionarioRepository, FilialRepositoryInterface $filialRepository, UserRepositoryInterface $userRepository, FuncionarioTransformer $funcionarioTransformer){
        parent::__construct();
        $this->funcionarioRepository = $funcionarioRepository;
        $this->filialRepository = $filialRepository;
        $this->userRepository = $userRepository;
        $this->funcionarioTransformer = $funcionarioTransformer;
    }

    public function index(Request $request){
        $params = $request->all();

        $funcionarios = $this->funcionarioRepository->all($params);

        return $this->respJson([
            'message' => 'Funcionarios listados',
            'data' => $this->funcionarioTransformer->transformArray($funcionarios)
        ]);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $funcionario = $this->funcionarioRepository->findBy('uuid', $uuid);

        if(is_null($funcionario)){
            return $this->respJson([
                'message' => 'Funcionario não encontrado'
            ], 422);
        }

        $validate = $this->validate($data, [
            'cargo' => 'string',
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $funcionario = $this->funcionarioRepository->update($data, $funcionario->id);

        if(is_null($funcionario)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar funcionario'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar funcionario',
            'data' => $this->funcionarioTransformer->transform($funcionario)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $funcionario = $this->funcionarioRepository->findBy('uuid', $uuid);

        if(is_null($funcionario)){
            return $this->respJson([
                'message' => 'Funcionario não encontrado'
            ], 422);
        }

        $funcionario = $this->funcionarioRepository->delete($funcionario->id);

        if(!$funcionario){
            return $this->respJson([
                'message' => 'Não foi possível deletar funcionario'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Funcionario deletado'
        ], 201);
    }

}