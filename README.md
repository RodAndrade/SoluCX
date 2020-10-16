<h2 align="center">
  <img src="https://solucx.com.br/wp-content/uploads/2020/04/SoluCX-Logotipo-OK-1-Original-azul.png" alt="SoluCX" height="120">
  <br>
  Desafio técnico SoluCX | Back end (PHP)
</h2>

<p align="center">Teste para desenvolvedor back end PHP, com objetivo de criar uma API REST .</p>

O objetivo do teste era criar uma API REST com PHP, utilizando [Slim](http://www.slimframework.com/) ou [Lumen](https://lumen.laravel.com/) para fornecer dados de entregas por drones.

<img align="center" width="100%" height="400" src="https://github.com/RodAndrade/SoluCX/blob/master/www/demonstracao.gif?raw=true">

<p align="center">
  <a href="#Conteúdo">Conteúdo</a> •
  <a href="#Instalação">Instalação</a> •
  <a href="#art-about-me">About Me</a>
</p>

## **Conteúdo**

## **Instalação**

### 1) Clone & Install Dependencies

Para clonar e rodar essa aplicação, você irá precisar de [Docker](https://docs.docker.com/get-docker/), [Git](https://git-scm.com) e [Composer](https://getcomposer.org/download/)

- `git clone https://github.com/RodAndrade/SoluCX/`
- `cd SoluCX` - cd into project directory.
- `php composer.phar update` - Install composer dependencies
- `docker build . -t solucx:latest` - Compile te latest solocx image
- `docker-compose up -d` - Compose the containers
- `docker exec -it solucxapi-database /bin/bash ./database/seeds.sh` - Import DB schema and seeds

### 2) Extras

- `docker rm -f solucxapi-web` - Stop web container
- `docker rm -f solucxapi-database` - Stop database container
- `docker exec -it containerName /bin/bash` - Access a container shell

---

> [rcandrade.com](https://rcandrade.com) &nbsp;&middot;&nbsp;
> GitHub [@RodAndrade](https://github.com/RodAndrade) &nbsp;&middot;&nbsp;
> LinkedIn [Rodrigo Andrade](https://www.linkedin.com/in/rodrigo-andrade-27969bb3/) &nbsp;&middot;&nbsp;
> WhatsApp [+55 (12) 98229-5679](https://wa.me/5512982295679)
