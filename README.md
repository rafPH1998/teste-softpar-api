# Passo a passo e comandos para rodar a API 
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

Rodar o comando abaixo para gerar alguns dados fictícios
```sh
php artisan db:seed
```


Acesse o projeto
[http://localhost:8085](http://localhost:8085)

# Caso não possua o docker instalado

- PHP versão 8+
- Mysql
- Servidor Apache ou nginx
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
O desafio consiste em desenvolver uma API que simule uma TODO list (lista de tarefas) com funcionalidades básicas de: listar, adicionar uma nova tarefa, atualizar tarefa, atualizar status da tarefa e deletar tarefa.

### Tecnologias utilizadas
- **`PHP`** 
- **`Laravel 11`** 
- **`Mysql`** 
- **`Docker`** 


### Estrutura do banco


## Tebela de tasks

<table>
  <thead>
    <tr>
      <th>Colunas</th>
      <th>Tipo</th>
    </tr>
  </thead>
 <tbody>
    <tr>
      <td>id</td>
      <td>primary_key</td>
    </tr>
    <tr>
      <td>title</td>
      <td>string</td>
    </tr>
    <tr>
      <td>description</td>
      <td>string</td>
    </tr>
     <tr>
      <td>status</td>
      <td>text</td>
    </tr>
    <tr>
      <td>completed_at</td>
      <td>timestamp</td>
    </tr>
    <tr>
      <td>completed</td>
      <td>boolean</td>
    </tr>
  </tbody>
</table>

### Funcionalidades e Rotas da API


## Tarefas:

- **`GET /api/tasks`** - Lista todas as tarefas da base de dados

**Corpo**:

```json
[
    {
        "id": 1,
        "title": "Comprar pão teste",
        "description": "Ir ao mercado comprar pão",
        "status": "completed",
        "created_at": "06/01/2025",
        "updated_at": "06/01/2025",
        "completed_at": "06/01/2025 21:02",
        "completed": true
    }
]
```


- **`GET /api/tasks?status=completed&date_start=2025-02-15&date_end=2025-02-20&order_by=title`** - Você pode ter o recurso de filtrar por alguns dados, tais como: status, data inicial, data final e pode solicitar uma ordenação por título ou data.


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

