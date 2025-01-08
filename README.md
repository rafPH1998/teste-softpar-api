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
- Mysql versão 5+
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


## Tabela de tasks
Essa tabela tem como finalidade para o sistema armazenar as informações atreladas as tarefas do usuário. De forma bem básica e funcional

<table>
  <thead>
    <tr>
      <th>Colunas</th>
      <th>Tipo</th>
      <th>Finalidade</th>
    </tr>
  </thead>
 <tbody>
    <tr>
      <td>id</td>
      <td>primary_key</td>
      <td>incrementar automaticamente o id de um novo registro</td>
    </tr>
    <tr>
      <td>title</td>
      <td>string</td>
      <td>Armazenar o título escrita pelo usuário</td>
    </tr>
    <tr>
      <td>description</td>
      <td>string</td>
      <td>Armazenar a descrição escrita pelo usuário</td>
    </tr>
     <tr>
      <td>status</td>
      <td>text</td>
      <td>Armazenar o status para um melhor controle</td>
    </tr>
    <tr>
      <td>completed_at</td>
      <td>timestamp</td>
      <td>Armazenar a data que aquela tarefa foi concluída</td>
    </tr>
    <tr>
      <td>completed</td>
      <td>boolean</td>
      <td>Armazenar para ter um melhor controle na tela</td>
    </tr>
  </tbody>
</table>

### Funcionalidades e Rotas da API


## Tarefas:

- **`GET /api/tasks`** - Lista todas as tarefas da base de dados

**Resposta da API**:

```json
[
    {
        "id": 10,
        "title": "Comprar novos livros para livraria",
        "description": "Atualmente a livraria está acabando os livros",
        "status": "completed",
        "created_at": "06/01/2025",
        "updated_at": "06/01/2025",
        "completed_at": "06/01/2025 21:02",
        "completed": true
    },
    {
        "id": 11,
        "title": "Estudar",
        "description": "Estudar para o vestibular",
        "status": "completed",
        "created_at": "06/01/2025",
        "updated_at": "06/01/2025",
        "completed_at": "06/01/2025 21:02",
        "completed": true
    }
]
```

- **`GET /api/tasks/2`** - Lista uma tarefa específica pelo seu ID

**Resposta da API**:

```json
{
    "id": 12,
    "title": "Comprar pão",
    "description": "Ir ao mercado comprar pão pela manhã",
    "status": "completed",
    "created_at": "06/01/2025",
    "updated_at": "06/01/2025",
    "completed_at": "06/01/2025 21:02",
    "completed": true
}
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


- **`PATCH /api/tasks/{taskId}/update-status`** - Atualiza o status da tarefa específico pelo seu ID.
- **`DELETE /api/tasks/{id}`** - Deleta uma tarefa existente pelo seu ID.

