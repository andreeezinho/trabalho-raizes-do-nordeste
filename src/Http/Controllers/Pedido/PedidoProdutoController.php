<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Request\Request;
use App\Http\Controllers\Controller;
use App\Domain\Repositories\Pedido\PedidoProdutoRepositoryInterface;
use App\Domain\Repositories\Pedido\PedidoRepositoryInterface;
use App\Domain\Repositories\Produto\ProdutoRepositoryInterface;
use App\Http\Transformer\Pedido\PedidoProdutoTransformer;

class PedidoProdutoController extends Controller {

    protected $produtoPedidoRepository;
    protected $pedidoRepository;
    protected $produtoRepository;
    protected $pedidoProdutoTransformer;

    public function __construct(
        PedidoProdutoRepositoryInterface $produtoPedidoRepository,
        PedidoRepositoryInterface $pedidoRepository,
        ProdutoRepositoryInterface $produtoRepository,
        PedidoProdutoTransformer $pedidoProdutoTransformer
    ){
        $this->produtoPedidoRepository = $produtoPedidoRepository;
        $this->pedidoRepository = $pedidoRepository;
        $this->produtoRepository = $produtoRepository;
        $this->pedidoProdutoTransformer = $pedidoProdutoTransformer;
    }

    public function index(Request $request){
        $params = $request->all();

        $pedidoProduto = $this->produtoPedidoRepository->all($params);

        return $this->respJson([
            'message' => 'Pedidos e produtos listados',
            'data' => $this->pedidoProdutoTransformer->transformArray($pedidoProduto)
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validate = $this->validate($data, [
            'quantidade' => 'required|int',
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $pedidoProduto = $this->produtoPedidoRepository->create($data);

        if(is_null($pedidoProduto)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar produto no pedido'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Produto inserido na venda',
            'data' => $this->pedidoProdutoTransformer->transform($pedidoProduto)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $pedidoProduto = $this->produtoPedidoRepository->findBy('uuid', $uuid);

        if(is_null($pedidoProduto)){
            return $this->respJson([
                'message' => 'Produto no pedido não encontrado'
            ], 422);
        }

        $validate = $this->validate($data, [
            'quantidade' => 'required|int',
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $pedidoProduto = $this->produtoPedidoRepository->update($data, $pedidoProduto->id);

        if(is_null($pedidoProduto)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar produto no pedido'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar produto no pedido',
            'data' => $this->pedidoProdutoTransformer->transform($pedidoProduto)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $pedidoProduto = $this->produtoPedidoRepository->findBy('uuid', $uuid);

        if(is_null($pedidoProduto)){
            return $this->respJson([
                'message' => 'Produto no pedido não encontrado'
            ], 422);
        }

        $pedidoProduto = $this->produtoPedidoRepository->delete($pedidoProduto->id);

        if(!$pedidoProduto){
            return $this->respJson([
                'message' => 'Não foi possível deletar produto no pedido'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Produto no pedido deletado'
        ], 201);
    }

}