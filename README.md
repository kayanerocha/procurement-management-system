
# Sistema Web de Gestão de Produtos e Fornecedores

Este repositório é dedicado ao projeto Sistema Web de Gestão de Produtos e Fornecedores, o qual tem como objetivo permitir o gerenciamento de fornecedores e produtos, e realizar pedidos.

# Como Executar o Projeto

Importante destacar que esse projeto utiliza Docker.

- Clone o projeto e acessa a pasta
    ```bash
    $ git clone https://github.com/kayanerocha/procurement-management-system.git
    $ cd procurement-management-system
    ```

- Crie o arquivo `.env`
    ```bash
    $ cp .env.example .env
    ```

- Inserir valores na variáveis de ambiente abaixo:
    - `DB_USERNAME`
    - `DB_ROOT_PASSWORD`
    - `DB_PASSWORD`

- Inicie o ambiente Docker
    > Precisa ter Docker.
    ```
    $ docker-compose up -d --build
    ```

- Instale as dependências
    ```bash
    $ docker-compose exec node npm install
    ```

- Execute as migrations
    ```bash
    $ docker-compose exec app php artisan migrate
    ```

- Inicie o servidor de desenvolvimento do front-end
    ```bash
    $ docker-compose exec node npm run dev
    ```

- Acessar a rota abaixo:
    ```bash
    $ http://localhost:8000/suppliers
    ```

- Rodar o comando abaixo para a execução dos Jobs
    ```bash
    $ docker-compose exec -it app php artisan queue:work
    ```

## Tecnologias

**Front-end:** Vue.js, Node, Axios e TailwindCSS

**Back-end:** PHP e Laravel

**Banco de Dados:** MySQL

