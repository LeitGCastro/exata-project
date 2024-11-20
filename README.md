<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# Gerenciamento de Tarefas

Este é um sistema de gerenciamento de tarefas construído com Laravel integrado com o framework Vue.js. O Sistema suporta autenticação de usuários, criação, visualização, edição e exclusão de tarefas e ainda conta com diferentes níveis de permissão.

Durante o desenvolvimento foram utilzados algumas ferramentas para auxiliar e otimizar o desenvolvimento, dentre elas:
* Laravel 11
* Vue.js 3 (integrado ao laravel a partir do Inertia)
* Laravel Breeze (pacote de funcionalidades para facilitar a autencticação de usuário)
* Tailwind CSS
* FontAwesome icons


---

## Requisitos do Sistema

Antes de começar, certifique-se que seu ambiente possua os seguintes requisitos:

- PHP 8.1 ou superior
- Composer 2.x
- MySQL 8.x ou MariaDB (ou SQLite para desenvolvimento)
- Node.js 18.x (para assets front-end)
- NPM ou Yarn

---

## Instalação e Configuração

Siga estas etapas para configurar o projeto em sua máquina local:

### 1. Clone o Repositório

```
    git clone https://github.com/LeitGCastro/exata-project
    cd exata-project
```

### 2. Instale as dependencias

```
    composer install
    npm install
```

### 3. Configure o ambiente
Crie uma cópia dos arquivos de configuração 

```
    cp .env.example .env
    cp .env.testing.example .env.testing # Nescessário para rodas os testes
```

### 4. Gere a chave de aplicação
Gere uma chave criptografada para o laravel e adicione aos arquivos de configuração na variavel `APP_KEY`

```
    php artisan key:generate
```

### 5. Configure o banco de dados
Por padrão o banco de dados está configurado para rodar localmente em um arquivo SQLite, caso queira rodar em um banco de dados externo altere as configurações no arquivo `.env` 

```
    php artisan migrate --seed #roda as migrations já populando as tabelas
```
Obs.: Caso tenha problemas com o arquivo SQLite confira se o arquivo `database.sqlite` existe dentro da pasta database.
```
    touch database/database.sqlite
```

### 6. Rode a aplicação
Inicialize o servidor e o front-end
Credenciais de adminstrador:
- adm@teste.com.br
- randomPassword123

```
    npm run dev 
    php artisan serve
```

### Rodar testes
O sistema possui teste de integração e de funcionalidade mesclados baseados em PHPUnit.  
Para rodar os testes é nescessário configurar o arquivo `.env.testing`.

```
    php artisan migrate --env=testing 
    php artisan test
```