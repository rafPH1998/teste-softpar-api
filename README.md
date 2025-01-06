### Passo a passo e comandos para rodar a API
### OBS: É obrigatório que você tenha o docker instalado na sua máquina para realizar esse procedimento
Clone Repositório
```sh
git clone https://github.com/rafPH1998/teste-softpar-api.git
```
```sh
cd teste-softpar-api
```


Crie o Arquivo .env
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```dosini

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=nome_banco
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container app
```sh
docker-compose exec app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Rodar as migrations
```sh
php artisan migrate
```

Rodar o comando abaixo para gerar um usuário e você se autenticar
```sh
php artisan db:seed
```

Agora você poderá se autenticar com o usuário
```sh
email: test@example.com
senha: password
```

Acesse o projeto
[http://localhost:8085](http://localhost:8085)

# Caso não possua o docker instalado

- PHP versão 8+
- Composer 2.7.4

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```


### Objetivo do Desafio
O desafio consiste em desenvolver uma API em laravel que simule uma TODO list (lista de tarefas) com funcionalidades básicas de: listar, adicionar uma nova tarefa, atualizar tarefa, atualizar status da tarefa e deletar tarefa.


### Estrutura do banco

<svg viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg">
    <!-- Users Table -->
    <rect x="50" y="50" width="200" height="160" fill="#B8E6FF" stroke="#000" />
    <rect x="50" y="50" width="200" height="25" fill="#87CEEB" stroke="#000" />
    <text x="125" y="68" text-anchor="middle" font-family="Arial">Users</text>
    
    <line x1="50" y1="75" x2="250" y2="75" stroke="#000" />
    <text x="60" y="95">id</text>
    <text x="160" y="95">integer</text>
    <text x="60" y="120">name</text>
    <text x="160" y="120">varchar</text>
    <text x="60" y="145">email</text>
    <text x="160" y="145">varchar</text>
    <text x="60" y="170">password</text>
    <text x="160" y="170">varchar</text>
    <text x="60" y="195">created_at</text>
    <text x="160" y="195">timestamp</text>

    <!-- Tasks Table -->
    <rect x="350" y="50" width="300" height="300" fill="#B8E6FF" stroke="#000" />
    <rect x="350" y="50" width="300" height="25" fill="#87CEEB" stroke="#000" />
    <text x="475" y="68" text-anchor="middle" font-family="Arial">Tasks</text>
    
    <line x1="350" y1="75" x2="650" y2="75" stroke="#000" />
    <text x="360" y="105">id</text>
    <text x="560" y="105">integer</text>
    <text x="360" y="135">title</text>
    <text x="560" y="135">varchar</text>
    <text x="360" y="165">description</text>
    <text x="560" y="165">text</text>
    <text x="360" y="195">user_id</text>
    <text x="560" y="195">integer</text>
    <text x="360" y="225">status</text>
    <text x="560" y="225">enum</text>
    <text x="360" y="255">created_at</text>
    <text x="560" y="255">timestamp</text>
    <text x="360" y="285">updated_at</text>
    <text x="560" y="285">timestamp</text>
    <text x="360" y="315">completed_at</text>
    <text x="560" y="315">timestamp</text>
    <text x="360" y="345">completed</text>
    <text x="560" y="345">boolean</text>

    <!-- Relationship Lines -->
    <line x1="250" y1="90" x2="350" y2="195" stroke="#000" />
    <circle cx="250" cy="90" r="3" fill="#000" />
    <path d="M 350,190 L 350,200 L 340,195 Z" fill="#000" />
</svg>

### Funcionalidades e Rotas da API

#### Autenticação:

- **`POST /api/auth`** - Autentica o usuário.

**Corpo**:

```json
{
    "email": "test@example.com",
    "password": "password",
    "device_name": "teste"
}
```

**Resposta**:
```json
{
   "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}


#### Tarefas:

- **`GET /api/tasks`** - Lista todas as tarefas da base de dados

**Corpo**:

```json
[
    {
        "id": 1,
        "title": "Comprar pão teste",
        "description": "Ir ao mercado comprar pão",
        "user_id": 1,
        "status": "completed",
        "created_at": "06/01/2025",
        "updated_at": "06/01/2025",
        "completed_at": "06/01/2025 21:02",
        "completed": true
    }
]
```

- **`POST /api/tasks`** - Cadastra uma nova tarefa

**Corpo**:

```json
{
    "title": "Comprar abacate",
    "description": "Ir ao mercado comprar abacate"
}
```

- **`PUT /api/tasks/{id}`** - Atualiza dados da tarefa.

**Corpo**:

```json
{
    "title": "Comprar abacate atualizado",
    "description": "Ir ao mercado comprar abacate atualizado"
}
```


- **`PATCH /api/tasks/{taskId}`** - Atualiza o status da tarefa específico pelo seu ID.
- **`DELETE /api/tasks/{id}`** - Deleta uma tarefa existente pelo seu ID.


### Importante ressaltar que todas as solicitações o usuário precisa estar autenticado primeiro e é necessário passar o token em cada requisição. Acesse um postman ou insomnia para ter o sucesso das solicitações, procure pela aba Authorization, escolha a opção Authorization, em seguida opção Bearer Token e cole o seu token que foi retornado da requisição após a autenticação.

```json
{
    "Authorization": "Bearer {seu-token-aqui}"
}
```