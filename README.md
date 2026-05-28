# Trabalho - Raízes do Nordeste 

API RestFull Desenvolvida com PHP puro (sem frameworks externos) com objetivo de ser utilizada como base para iniciar projetos futuros com o básico já feito.

O projeto busca implementar tecnologias e padrões que garantem a organização, escalabilidade e manutenções futuras. 

## Tecnologias, Padrões e Arquiteturas
- PHP 8.5
- Organização de Rotas Personalizadas
- Autenticação via JWT
- Autenticação via OAuth2 (Google API)
- Composer
- DDD
- Clean Architecture
- Arquitetura Hexagonal

## Arquitetura do Projeto
A arquitetura do projeto segue princípios de **DDD**, **Clean Architecture** e **Arquitetura Hexagonal**
```
app
├── logs
├── public
└── src
    ├── Config
    ├── Domain
    │   ├── Models
    │   └── Repositories
    ├── Http
    │   ├── Controllers
    │   ├── Request
    │   └── Transformer
    ├── Infra
    │   ├── Persistence
    │   └── Services
    ├── Routers
    ├── Utils
    ├── composer.json
    ├── composer.lock
    ├── .env
    ├── index.php
```

## Funcionalidades 

- Autenticação e Segurança via JWT
- Rotas dinâmicas e personalizadas
- Sistema de logs personalizáveis
- Upload dinâmico de arquivos
- Sistema de notificação de email
- Customização de variáveis de ambiente via `.env`

## Execução do Projeto

### 1 - Clonar repositório

```bash
git clone https://github.com/andreeezinho/sistema-pdv.git
```

### 2 - Remover '.example.' de `src/.env.example`

### 3 - Inserir valores nas variáveis
Insira os valores de acordo com o seus dados
```bash
SITE_NAME=''
API_URL=''
PERMITTED_HOST='' #host permitido para utilizar a API, use * para liberar para todos (não recomendado) ou o ip correto do front-end (ex: http://localhost:5173)

DB_HOST=''
DB_NAME=''
DB_USER=''
DB_PASSWORD=''

JWT_SECRET=''

#email e codigo para sistema conseguir enviar email
EMAIL=''
EMAIL_CODE=''

CONTACT_DOC=''
CONTACT_NUMBER=''
CONTACT_EMAIL=''
```

### 4 - Executar o script `bd.sql` para o banco de dados
```bash
mysql -u root -p {nome_do_banco_de_dados} < bd.sql
```

O script vem com um usuário padrão com todas as permissões inicialmente:

```
email: admin@admin.com
senha: password
```

### 5 - Executar projeto
```bash
php -S localhost:8888 -t ./
```

## Endpoints
O endpoint para fazer a autenticação com o usuário não necessita de validação de nenhum token, somente das suas credenciais

**POST** `/auth`

 - **Headers:** `""`
 - **Resposta:** 
    ```bash
    {
        "message": "Sucesso ao logar"
        "data": {token}
    }
    ```

### Endpoints Protegidos
Todos os endpoints que são protegitos por autenticação necessitam de um token `Bearer` via JWT

**GET** `/usuarios`

 - **Headers:** `"Authorization: Bearer {token}"`
 - **Resposta:** 
    ```bash
    {
        "message": "Usuários listados"
        "data": [
            {
                "uuid": "0661993e-7ae8-4146-8602-403f5edb92ea",
                "nome": "Administrador André",
                "email": "admin@admin.com",
                "telefone": "(75) 9988-7766",
                "data_nasc": "10/02/2006",
                "ativo": 1,
                "icone": "69701adfcf4bd_1768954591.jpg",
                "created_at": "2025-03-01 16:04:15",
                "updated_at": "2026-01-20 21:16:31"
            }
        ]
    }
    ```