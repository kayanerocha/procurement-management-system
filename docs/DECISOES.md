# Decisões Tomadas

## Modelagem do Banco de Dados

O banco de dados é composto por cinco tabelas, descritas abaixo:
- `suppliers`: dedicada a armazenar informações de fornecedores, contém nome, cnpj, email, telefone, status, datas de criação e atualização dos registros;
- `products`: dedicada a armazenar informações de produtos, contém nome, descrição, código interno, status, datas de criação e atualização dos registros;
- `product_supplier`: responsável por estabelecer o relacionamentos muitos para muitos entre fornecedor e produto, vinculando um fornecedor com vários produtos, assim como um produto com vários fornecedores;
- `orders`: dedicada a armazenar informações de pedidos, contém id do fornecedor, status, observações, datas de criação e atualização dos registros;
- `order_items`: dedicada a armazenar informações dos itens dos pedidos, contém id do produto, id do pedido, quantidade, preço unitário, preço total, datas de criação e atualização dos registros.

![Diagrama Entidade Relacionamento](eer-diagram.png)

## Decisões de Arquitetura

Esse sistema foi construído com um arquitetura containerizada utilizando Docker e WSL2 para facilitar o levantamento do ambiente de desenvolvimento e separar as responsabilidades.

As tecnologias utilizadas são:
- Backend: Laravel 13 e PHP 8.4;
- Frontend: Vue.js, pois é uma tecnologia de rápido aprendizado;
- Banco de dados: MySQL;
- Filas: Redis;
- Servidor web: Nginx;
- Ambiente: Docker + WSL.

### Organização do Containers

1. `app`: Laravel e PHP-FPM
    - Utiliza o `php:8.4-fpm`
    - Executa o Laravel via PHP-FPM
    - Possui extensões importantes:
        - `pdo_mysql`: conexão com MySQL
        - `redis`: integração com Redis
        - `xdebug`: debugging
    - Compatilha o código por um volume: `.:/var/www`
2. `nginx`: servidor web
    - Responsável por servir a aplicação
    - Expõe a porta `8000`
    - Encaminha requisições PHP para o container `app`
3. `node`: frontend
    - Responsável pelo frontend
    - Utiliza a imagem `node:20`
    - Roda na porta `5173`
4. `mysql`: banco de dados
    - Responsável pelo banco de dados
    - Utiliza a imagem `mysql:8`
    - Persistência de dados no volume `mysql_data`
    - Porta externa: `3307`
    - Porta interna: `3306`
5. `redis`: filas
    - Utiliza a imagem `redis:alpine`
    - Roda na porta `6379`
6. `queue`: filas
    - Responsável pelo processamento assíncrono
    - Roda com o comando `php artisan queue:work` dentro do container `app` ou fora do container com `docker-compose exec app php artisan queue:work`

### Fluxo da Aplicação

- Fluxo completo: Usuário -> Nginx -> Laravel -> MySQL / Redis / Queue Worker
- Fluxo do frontend: Vue.js -> Axios -> API Laravel

## Uso de Filas e Jobs

As filas são gerenciadas pelo Laravel usando o driver Redis, enviando tarefas para uma fila, o Redis armazena e um worker executa essas tarefas. Isso permite executar processos de fora assíncrona, sem travar a requisição do usuário.
O driver está configurando no `.env` com a variável `QUEUE_CONNECTION=redis`.

### Fluxo

1. Controller dispara um Job (vinculo e desvinculo de produto com parceiros);
2. Job é enviado para o Redis;
3. Worker lê o job e executa o método `handle()`;
4. O job é removido da fila (ou reenviado em caso de falha).

## Melhorias
- Finalização da criação de pedidos;
- Traduzir as mensagens de validação;
- Exibição do andamento da execução dos Jobs;
- Cadastro e autenticação de usuários;
- Criar mais componentes reutilizáveis no frontend;
- Melhorar a segurança das requisições;
- Uso de Observers para logs;
- Envio de notificações para o e-mail do fornecedor para cada pedido realizado com ele;
- Disponibilizar para os fornecedores funcionalidades de atualização dos seus dados, produtos e acompanhar pedidos.

# Uso de Inteligência Artificial

Foi Utilizado o Chat GPT apenas para auxiliar a estruturar o ambiente de desenvolvimento, pois é algo que tenho pouco conhecimento, mas sabia que usar Docker seria o melhor caminho.