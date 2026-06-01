<?php

use App\Config\Router;
use App\Config\Auth;
use App\Config\Container;
use App\Config\DependencyProvider;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RecuperarSenha\RecuperarSenhaController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Filial\FilialController;
use App\Http\Controllers\Funcionario\FuncionarioController;
use App\Http\Controllers\Meta\MetaController;
use App\Http\Controllers\Pedido\PedidoController;
use App\Http\Controllers\Pedido\PedidoProdutoController;
use App\Http\Controllers\Produto\ProdutoController;

$router = new Router();
$auth = new Auth();
$container = new Container();
$dependencyProvider = new DependencyProvider($container);
$dependencyProvider->register();

$authController = $container->get(AuthController::class);
$userController = $container->get(UserController::class);
$recuperarSenhaController = $container->get(RecuperarSenhaController::class);
$clienteController = $container->get(ClienteController::class);
$filialController = $container->get(FilialController::class);
$funcionarioController = $container->get(FuncionarioController::class);
$metaController = $container->get(MetaController::class);
$pedidoController = $container->get(PedidoController::class);
$pedidoProdutoController = $container->get(PedidoProdutoController::class);
$produtoController = $container->get(ProdutoController::class);

// - Rotas

//autenticacao
$router->create("POST", "/auth", [$authController, 'login'], null);
$router->create("POST", "/google-auth", [$authController, 'loginWithGoogle'], null);
$router->create("GET", "/google-link", [$authController, 'generateGoogleAuthLink'], null);
$router->create("GET", "/me", [$authController, 'profile'], $auth);

//usuarios
$router->create("GET", "/usuarios", [$userController, 'index'], $auth);
$router->create("POST", "/usuarios", [$userController, 'store'], $auth);
$router->create("PUT", "/usuarios/{uuid}", [$userController, 'update'], $auth);
$router->create("PATCH", "/usuarios/{uuid}/password", [$userController, 'updatePassword'], $auth);
$router->create("POST", "/usuarios/{uuid}/icon", [$userController, 'updateIcon'], $auth);
$router->create("DELETE", "/usuarios/{uuid}", [$userController, 'destroy'], $auth);

//recuperar-senha   
$router->create("POST", "/recuperar-senha/enviar-codigo", [$recuperarSenhaController, 'sendVerificationCode'], null);
$router->create("PUT", "/recuperar-senha", [$recuperarSenhaController, 'changePassword'], null);

//clientes
$router->create("GET", "/clientes", [$clienteController, 'index'], $auth);
$router->create("POST", "/clientes", [$clienteController, 'store'], $auth);
$router->create("PUT", "/clientes/{uuid}", [$clienteController, 'update'], $auth);
$router->create("DELETE", "/clientes/{uuid}", [$clienteController, 'destroy'], $auth);

//filiais
$router->create("GET", "/filiais", [$filialController, 'index'], $auth);
$router->create("POST", "/filiais", [$filialController, 'store'], $auth);
$router->create("PUT", "/filiais/{uuid}", [$filialController, 'update'], $auth);
$router->create("DELETE", "/filiais/{uuid}", [$filialController, 'destroy'], $auth);

//funcionarios
$router->create("GET", "/funcionarios", [$funcionarioController, 'index'], $auth);
$router->create("POST", "/funcionarios", [$funcionarioController, 'store'], $auth);
$router->create("PUT", "/funcionarios/{uuid}", [$funcionarioController, 'update'], $auth);
$router->create("DELETE", "/funcionarios/{uuid}", [$funcionarioController, 'destroy'], $auth);

//metas
$router->create("GET", "/metas", [$metaController, 'index'], $auth);
$router->create("POST", "/metas", [$metaController, 'store'], $auth);
$router->create("PUT", "/metas/{uuid}", [$metaController, 'update'], $auth);
$router->create("DELETE", "/metas/{uuid}", [$metaController, 'destroy'], $auth);

//pedidos
$router->create("GET", "/pedidos", [$pedidoController, 'index'], $auth);
$router->create("POST", "/pedidos", [$pedidoController, 'store'], $auth);
$router->create("PUT", "/pedidos/{uuid}", [$pedidoController, 'update'], $auth);
$router->create("DELETE", "/pedidos/{uuid}", [$pedidoController, 'destroy'], $auth);

//pedido-produto
$router->create("GET", "/pedido-produto", [$pedidoProdutoController, 'index'], $auth);
$router->create("POST", "/pedido-produto", [$pedidoProdutoController, 'store'], $auth);
$router->create("PUT", "/pedido-produto/{uuid}", [$pedidoProdutoController, 'update'], $auth);
$router->create("DELETE", "/pedido-produto/{uuid}", [$pedidoProdutoController, 'destroy'], $auth);

//produtos
$router->create("GET", "/produtos", [$produtoController, 'index'], $auth);
$router->create("POST", "/produtos", [$produtoController, 'store'], $auth);
$router->create("PUT", "/produtos/{uuid}", [$produtoController, 'update'], $auth);
$router->create("DELETE", "/produtos/{uuid}", [$produtoController, 'destroy'], $auth);

return $router;