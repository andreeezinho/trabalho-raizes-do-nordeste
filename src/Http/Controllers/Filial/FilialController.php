<?php

namespace App\Http\Controllers\Filial;

use App\Http\Controllers\Controller;
use App\Http\Request\Request;
use App\Domain\Repositories\Filial\FilialRepositoryInterface;
use App\Http\Transformer\Filial\FilialTransformer;

class FilialController extends Controller{

    protected $filialRepository;
    protected $filialTransformer;

    public function __construct(FilialRepositoryInterface $filialRepository, FilialTransformer $filialTransformer){
        parent::__construct();
        $this->filialRepository = $filialRepository;
        $this->filialTransformer = $filialTransformer;
    }

    public function index(Request $request){
        $params = $request->all();

        $filiais = $this->filialRepository->all($params);

        return $this->respJson([
            'message' => 'Filiais listadas',
            'data' => $this->filialTransformer->transformArray($filiais)
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validate = $this->validate($data, [
            'num_filial' => 'int',
            'local' => 'string',
            'ativo' => 'max:1'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $filial = $this->filialRepository->create($data);

        if(is_null($filial)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar filial'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Cadastro realizado com sucesso',
            'data' => $this->filialTransformer->transform($filial)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $filial = $this->filialRepository->findBy('uuid', $uuid);

        if(is_null($filial)){
            return $this->respJson([
                'message' => 'Filial não encontrada'
            ], 422);
        }

        $validate = $this->validate($data, [
            'num_filial' => 'int',
            'local' => 'string',
            'ativo' => 'max:1'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $filial = $this->filialRepository->update($data, $filial->id);

        if(is_null($filial)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar filial'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar filial',
            'data' => $this->filialTransformer->transform($filial)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $filial = $this->filialRepository->findBy('uuid', $uuid);

        if(is_null($filial)){
            return $this->respJson([
                'message' => 'Filial não encontrada'
            ], 422);
        }

        $filial = $this->filialRepository->delete($filial->id);

        if(!$filial){
            return $this->respJson([
                'message' => 'Não foi possível deletar filial'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Filial deletada'
        ], 201);
    }

}