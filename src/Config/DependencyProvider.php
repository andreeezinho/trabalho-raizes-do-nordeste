<?php

namespace App\Config;

use App\Domain\Repositories\User\UserRepositoryInterface;
use App\Infra\Persistence\User\UserRepository;
use App\Domain\Repositories\RecuperarSenha\RecuperarSenhaRepositoryInterface;
use App\Infra\Persistence\RecuperarSenha\RecuperarSenhaRepository;
use App\Domain\Repositories\Cliente\ClienteRepositoryInterface;
use App\Infra\Persistence\Cliente\ClienteRepository;
use App\Domain\Repositories\Filial\FilialRepositoryInterface;
use App\Infra\Persistence\Filial\FilialRepository;
use App\Domain\Repositories\Funcionario\FuncionarioRepositoryInterface;
use App\Infra\Persistence\Funcionario\FuncionarioRepository;
use App\Domain\Repositories\Meta\MetaRepositoryInterface;
use App\Infra\Persistence\Meta\MetaRepository;
use App\Domain\Repositories\Pedido\PedidoRepositoryInterface;
use App\Infra\Persistence\Pedido\PedidoRepository;
use App\Domain\Repositories\Pedido\PedidoProdutoRepositoryInterface;
use App\Infra\Persistence\Pedido\PedidoProdutoRepository;
use App\Domain\Repositories\Produto\ProdutoRepositoryInterface;
use App\Infra\Persistence\Produto\ProdutoRepository;

class DependencyProvider {

    private $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function register(){

        $this->container
            ->set(
                UserRepositoryInterface::class,
                new UserRepository()
            );

        $this->container
            ->set(
                RecuperarSenhaRepositoryInterface::class,
                new RecuperarSenhaRepository()
            );

        $this->container
            ->set(
                ClienteRepositoryInterface::class,
                new ClienteRepository()
            );

        $this->container
            ->set(
                FilialRepositoryInterface::class,
                new FilialRepository()
            );

        $this->container
            ->set(
                FuncionarioRepositoryInterface::class,
                new FuncionarioRepository()
            );

        $this->container
            ->set(
                MetaRepositoryInterface::class,
                new MetaRepository()
            );

        $this->container
            ->set(
                PedidoRepositoryInterface::class,
                new PedidoRepository()
            );

        $this->container
            ->set(
                PedidoProdutoRepositoryInterface::class,
                new PedidoProdutoRepository()
            );

        $this->container
            ->set(
                ProdutoRepositoryInterface::class,
                new ProdutoRepository()
            );

    }

}