### Como rodar
Clonar o projeto
```sh
git clone https://github.com/TilsonM17/wedev-challeng-backEdn
```
Entrar na pasta do projeto
```sh
cd wedev-challeng-backEdn
```
Subir os containers
```sh
composer up -d
```
Instalar as dependencias do projeto
```sh
docker-compose exec app_wedev composer install
```
Gerar a chave da aplicação
```sh
docker-compose exec app_wedev php artisan key:generate
```
Migrar o DB
```sh
docker-compose exec app_wedev php artisan migrate
```
Gerar as migrations do projetos (dados ficticios)
```sh
docker-compose exec app_wedev php artisan db:seed
```
Rodar os testes da aplicação
```sh
docker-compose exec app_wedev php artisan test
```
