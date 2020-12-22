<p align="center"><a href="https://plantaoativo.com/" target="_blank"><img src="https://plantaoativo.com/wp-content/uploads/2020/03/logo-pa.png" width="400"></a></p>

<h1 align="center">Plantão Ativo API Desafio</h1>

| Informações |
|:------------:|
| Esta REST API foi desenvolvida em resposta ao desafio proposto pelo [Plantão Ativo](https://plantaoativo.com/). Sua principal funcionalidade é ser um gerenciador de postagens com seus respectivos titulos, autores, conteúdos e tags. <br><br> Junto com API segue um Front-end em react, para teste mais visuais relacionados a integração dos Endpoints com uma UI(User Interface). Lembrando que para a realização de testes unitários não se faz obrigatorio a instalação do Front-end, pois ele visa apenas como uma aplicação real faria o uso da API. |


## Postman
Esta API está disponivel em uma Collection do Postman. 

[![Executar no Postman](https://run-beta.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/)

## Documentação
Para ser redirecionado a documentação clique [aqui](https://disease.sh/docs/)

## Instalação
## Pré-Requesitos

[PHP](https://www.php.net/downloads.php) >= 7.2.5<br>
[Composer](https://getcomposer.org/download/)<br>
[MySQL](https://www.mysql.com/downloads/) >= 5.6<br>

### Projeto
1. Faça o download do repositorio
```bash
$ git clone https://github.com/Clys-man/pa-desafio.git
```
2. Na pasta do projeto faça a copia do arquivo `.env.example` e renomeie-o para `.env`
```bash
$ cp .env.example .env
```
3. No arquivo `.env` configure as variáveis de ambiente da aplicação com suas informações
4. Baixe os pacotes necessários para inicialização do projeto
```bash
$ composer install
```
7. Suba as Migrations para o banco de dados
```bash
$ php artisan migrate --seed
```
`Nota:` O comando acima tambem ira fazer o povoamento do banco de dados com informações, caso não queira remova `--seed`<br><br>
 8. Crie as chaves de criptografia usadas pelo Passport
```bash
$ php artisan passport:install
```
8. Crie as chaves de criptografia usadas pelo Passport
```bash
$ php artisan serve
```
10. Abra seu navegador e acesse: http://localhost:8000

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
