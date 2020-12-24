<p align="center"><a href="https://plantaoativo.com/" target="_blank"><img src="https://plantaoativo.com/wp-content/uploads/2020/03/logo-pa.png"></a></p><br>

<h1 align="center">Plantão Ativo API Desafio</h1>

| Informações |
|:------------:|
| Esta REST API foi desenvolvida em resposta ao desafio proposto pelo [Plantão Ativo](https://plantaoativo.com/). Sua principal funcionalidade é ser um gerenciador de postagens com seus respectivos títulos, autores, conteúdos e tags. <br><br> Junto com a API, segue um Front-end em react para teste mais visuais relacionados a integração dos Endpoints com uma UI (User Interface). Lembrando que para a realização de testes unitários não se faz obrigatório a instalação do Front-end, pois sua função é demonstrar como uma aplicação real faria o uso da API. |

## Documentação
Para ser redirecionado a documentação clique [aqui](https://pa-desafio.herokuapp.com/).

## Instalação
## Pré-requesitos

[PHP](https://www.php.net/downloads.php) >= 7.2.5<br>
[Composer](https://getcomposer.org/download/)<br>
[MySQL](https://www.mysql.com/downloads/) >= 5.6<br>

## Projeto
**1** - Faça o download do repositório
```bash
$ git clone https://github.com/Clys-man/pa-desafio.git
```
**2**  - Na pasta do projeto faça a cópia do arquivo `.env.example` e renomeie-o para `.env`
```bash
$ cp .env.example .env
```
**3**  - No arquivo `.env` configure as variáveis de ambiente da aplicação com suas informações
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
**4**  - Baixe os pacotes necessários para inicialização do projeto
```bash
$ composer install
```
**5**  - Suba as Migrations para o banco de dados
```bash
$ php artisan migrate --seed
```
`Nota:` O comando acima também irá fazer o povoamento do banco de dados com informações, caso não queira remova o paramêtro `--seed`<br><br>
**6**  - Crie as chaves de criptografia usadas pelo Passport
```bash
$ php artisan passport:install
```
**7**  - Crie as chaves de criptografia usadas pelo Passport
```bash
$ php artisan serve
```
**8**  - Abra seu navegador e acesse: http://127.0.0.1:8000/

## Informações Sobre a API
Os Endpoints suportados pela API são:

`POST`
| Endpoints      | Descrição                       |
|:--------------|:----------------------------------|
| `/auth/login`      | Realiza a autenticação e gerar o token de acesso.
| `/auth/register`      | Realiza o registro de um novo usuário.

`GET`
| Endpoints      | Descrição                       |
|:--------------|:----------------------------------|
| `/api/posts`      | Retorna a lista de todos os posts, 30 por página
| `/api/tags`    | Retorna a lista de todas os tags, 30 por página
| `/api/users` | Retorna a lista de todos os posts, 30 por página |

`GET`
| Endpoints      | Descrição                       |
|:--------------|:----------------------------------|
| `/api/posts/{id}`      | Retorna as informações de um post específico
| `/api/tags/{id}`    | Retorna as informações de uma tag específica
| `/api/users/{id}` | Retorna as informações de um usuário específico |

`POST`
| Endpoints      | Descrição                       |
|:--------------|:----------------------------------|
| `/api/posts/`      | Realiza a criação de um novo post
| `/api/tags/`    | Realiza a criação de uma nova tag

`PUT`
| Endpoints      | Descrição                       |
|:--------------|:----------------------------------|
| `/api/posts/{id}`      | Realiza a edição de um post específico
| `/api/tags/{id}`    | Realiza a edição de uma tag específica

`DELETE`
| Endpoints      | Descrição                       |
|:--------------|:----------------------------------|
| `/api/posts/{id}`      | Realiza a remoção de um post específico
| `/api/tags/{id}`    | Realiza a remoção de uma tag específica

## Parâmetros
Os parâmetros `client_id` , `tag` e `page` são recebidos na propia URI.

| parâmetro                    | descrição                 | 
|:-----------------------------|:----------------------------|:----------------------------|:----------------------------|
| `client_id`                      | Identificado do client da requisição | string | requirido|
| `tag`| Filtras os posts pelas tags | string | opcional|
| `page`                   | Número da pagina para listagem | number | opcional|

Para a listagem de mais parâmetros ou informações mais específicas de cada Endpoint acesse a [documentação](https://pa-desafio.herokuapp.com/)


## Front-end
<img src="https://i.imgur.com/adv8QH1.png">

> **Como falado ateriomente, foi desenvolvida um parte visual para integração da API, o guia de instalação e configuração esta disponível em [Plantão Ativo Blog React](https://github.com/Clys-man/login-page-react)**

## Autor

| [<img src="https://avatars0.githubusercontent.com/u/62316222?v=3&s=115" width="150"><br><sub>@Clys-man</sub>](https://github.com/Clys-man) |
| :---: |
