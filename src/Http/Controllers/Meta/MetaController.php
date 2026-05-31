<?php

namespace App\Http\Controllers\Meta;

use App\Http\Request\Request;
use App\Http\Controllers\Controller;
use App\Domain\Repositories\Meta\MetaRepositoryInterface;
use App\Domain\Repositories\Filial\FilialRepositoryInterface;
use App\Http\Transformer\Meta\MetaTransformer;

class MetaController extends Controller {

    protected $metaRepository;
    protected $filialRepository;
    protected $metaTransformer;

    public function __construct(
        MetaRepositoryInterface $metaRepository,
        FilialRepositoryInterface $filialRepository,
        MetaTransformer $metaTransformer
    ){
        $this->metaRepository = $metaRepository;
        $this->filialRepository = $filialRepository;
        $this->metaTransformer = $metaTransformer;
    }

    public function index(Request $request){
        $params = $request->all();

        $metas = $this->metaRepository->all($params);

        return $this->respJson([
            'message' => 'Metas listadas',
            'data' => $this->metaTransformer->transformArray($metas)
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validate = $this->validate($data, [
            'valor' => 'required',
            'concluida' => 'required|int',
            'ativo' => 'int|max:1',
            'expires_at' => 'required|string',
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $meta = $this->metaRepository->create($data);

        if(is_null($meta)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar meta'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Cadastro realizado com sucesso',
            'data' => $this->metaTransformer->transform($meta)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $meta = $this->metaRepository->findBy('uuid', $uuid);

        if(is_null($meta)){
            return $this->respJson([
                'message' => 'Meta não encontrada'
            ], 422);
        }

        $validate = $this->validate($data, [
            'valor' => 'required',
            'concluida' => 'required|int',
            'ativo' => 'int|max:1',
            'expires_at' => 'required|string',
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $meta = $this->metaRepository->update($data, $meta->id);

        if(is_null($meta)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar meta'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar meta',
            'data' => $this->metaTransformer->transform($meta)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $meta = $this->metaRepository->findBy('uuid', $uuid);

        if(is_null($meta)){
            return $this->respJson([
                'message' => 'Meta não encontrada'
            ], 422);
        }

        $meta = $this->metaRepository->delete($meta->id);

        if(!$meta){
            return $this->respJson([
                'message' => 'Não foi possível deletar meta'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Meta deletada'
        ], 201);
    }

}