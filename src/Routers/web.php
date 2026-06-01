<?php

use App\Config\Router;
use App\Config\Auth;
use App\Config\Container;
use App\Config\DependencyProvider;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RecuperarSenha\RecuperarSenhaController;
use App\Http\Controllers\Tributacao\TributacaoController;
use App\Http\Controllers\GrupoProduto\GrupoProdutoController;
use App\Http\Controllers\Produto\ProdutoController;
use App\Http\Controllers\Pagamento\PagamentoController;
use App\Http\Controllers\Endereco\EnderecoController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Pdv\PdvController;
use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\NotaFiscal\NotaFiscalController;
use App\Http\Controllers\NotaFiscal\NotaFiscalEntradaController;

$router = new Router();
$auth = new Auth();
$container = new Container();
$dependencyProvider = new DependencyProvider($container);
$dependencyProvider->register();

$authController = $container->get(AuthController::class);
$userController = $container->get(UserController::class);
$recuperarSenhaController = $container->get(RecuperarSenhaController::class);

// - Rotas

//autenticacao
$router->create("POST", "/auth", [$authController, 'login'], null);
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

return $router;