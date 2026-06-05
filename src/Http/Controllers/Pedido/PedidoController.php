<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Request\Request;
use App\Http\Controllers\Controller;
use App\Domain\Repositories\Pedido\PedidoRepositoryInterface;
use App\Domain\Repositories\Filial\FilialRepositoryInterface;
use App\Domain\Repositories\Cliente\ClienteRepositoryInterface;
use App\Domain\Repositories\Produto\ProdutoRepositoryInterface;
use App\Http\Transformer\Pedido\PedidoTransformer;

class PedidoController extends Controller {

    protected $pedidoRepository;
    protected $filialRepository;
    protected $produtoRepository;
    protected $clienteRepository;
    protected $pedidoTransformer;

    public function __construct(
        PedidoRepositoryInterface $pedidoRepository,
        FilialRepositoryInterface $filialRepository,
        ProdutoRepositoryInterface $produtoRepository,
        ClienteRepositoryInterface $clienteRepository,
        PedidoTransformer $pedidoTransformer
    ){
        $this->pedidoRepository = $pedidoRepository;
        $this->filialRepository = $filialRepository;
        $this->produtoRepository = $produtoRepository;
        $this->clienteRepository = $clienteRepository;
        $this->pedidoTransformer = $pedidoTransformer;
    }

    public function index(Request $request){
        $params = $request->all();

        $pedidos = $this->pedidoRepository->all($params);

        return $this->respJson([
            'message' => 'Pedidos listados',
            'data' => $this->pedidoTransformer->transformArray($pedidos)
        ]);
    }

    public function store(Request $request){
        $data = $request->all();

        $validate = $this->validate($data, [
            'pagamento' => 'required',
            'canalPedido' => 'required|string'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $pedido = $this->pedidoRepository->create($data);
    
        if(is_null($pedido)){
            return $this->respJson([
                'message' => 'Não foi possível cadastrar pedido'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Cadastro realizado com sucesso',
            'data' => $this->pedidoTransformer->transform($pedido)
        ], 201);
    }

    public function update(Request $request, $uuid){
        $data = $request->all();

        $pedido = $this->pedidoRepository->findBy('uuid', $uuid);

        if(is_null($pedido)){
            return $this->respJson([
                'message' => 'Pedido não encontrado'
            ], 422);
        }

        $validate = $this->validate($data, [
            'pagamento' => 'required',
            'canalPedido' => 'required|string'
        ]);

        if(is_null($validate)){
            return $this->respJson([
                'message' => 'Dados inválidos',
                'errors' => $this->getErrors()
            ], 422);
        }

        $pedido = $this->pedidoRepository->update($data, $pedido->id);

        if(is_null($pedido)){
            return $this->respJson([
                'message' => 'Não foi possível atualizar pedido'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Sucesso ao atualizar pedido',
            'data' => $this->pedidoTransformer->transform($pedido)
        ], 201);
    }

    public function destroy(Request $request, $uuid){
        $Pedido = $this->pedidoRepository->findBy('uuid', $uuid);

        if(is_null($Pedido)){
            return $this->respJson([
                'message' => 'Pedido não encontrado'
            ], 422);
        }

        $Pedido = $this->pedidoRepository->delete($Pedido->id);

        if(!$Pedido){
            return $this->respJson([
                'message' => 'Não foi possível deletar Pedido'
            ], 500);
        }

        return $this->respJson([
            'message' => 'Pedido deletado'
        ], 201);
    }

}