<?php

namespace App\Http\Controllers\Produto;

use App\Http\Request\Request;
use App\Http\Controllers\Controller;
use App\Domain\Repositories\Produto\ProdutoRepositoryInterface;
use App\Domain\Repositories\Filial\FilialRepositoryInterface;
use App\Http\Transformer\Produto\ProdutoTransformer;

class ProdutoController extends Controller {

    protected $produtoRepository;
    protected $filialRepository;
    protected $produtoTransformer;

    public function __construct(ProdutoRepositoryInterface $produtoRepository, FilialRepositoryInterface $filialRepository, ProdutoTransformer $produtoTransformer){
        $this->produtoRepository = $produtoRepository;
        $this->filialRepository = $filialRepository;
        $this->produtoTransformer = $produtoTransformer;
    }

    public function index(Request $request){
        $params = $request->all();

        $produtos = $this->produtoRepository->all($params);

        return $this->respJson([
            'message' => 'Produtos listados',
            'data' => $this->produtoTransformer->transformArray($produtos)
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validate = $this->validate($data, [
            'nome' => 'required|string',
            'codigo' => 'required|string',
            'preco' => 'required',
            'estoque' => 'required|int',
            'ativo' => 'int|max:1',
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $produto = $this->produtoRepository->create($data);

        if(is_null($produto)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar produto'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Cadastro realizado com sucesso',
            'data' => $this->produtoTransformer->transform($produto)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $produto = $this->produtoRepository->findBy('uuid', $uuid);

        if(is_null($produto)){
            return $this->respJson([
                'message' => 'Produto não encontrado'
            ], 422);
        }

        $validate = $this->validate($data, [
            'nome' => 'required|string',
            'codigo' => 'required|string',
            'preco' => 'required',
            'estoque' => 'required|int',
            'ativo' => 'int|max:1',
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $produto = $this->produtoRepository->update($data, $produto->id);

        if(is_null($produto)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar produto'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar produto',
            'data' => $this->produtoTransformer->transform($produto)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $produto = $this->produtoRepository->findBy('uuid', $uuid);

        if(is_null($produto)){
            return $this->respJson([
                'message' => 'Produto não encontrado'
            ], 422);
        }

        $produto = $this->produtoRepository->delete($produto->id);

        if(!$produto){
            return $this->respJson([
                'message' => 'Não foi possível deletar produto'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Produto deletado'
        ], 201);
    }

}