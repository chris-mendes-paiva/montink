Projeto Montink
Este é o guia de instalação e configuração para o projeto Montink, desenvolvido com o framework Laravel.

📋 Pré-requisitos
Antes de começar, certifique-se de que você tem o seguinte software instalado em sua máquina:

PHP (versão ^7.4 ou superior)
Composer
Git
Um servidor de banco de dados (MySQL, MariaDB, ou PostgreSQL)

Node.js e NPM (opcional, mas recomendado para dependências de frontend)

⚙️ Guia de Instalação e Configuração
Siga os passos abaixo para configurar o ambiente de desenvolvimento local.

1. Clonar o Repositório
Primeiro, clone este repositório para a sua máquina local usando o Git.

Bash

# Clone o projeto
git clone (https://github.com/chris-mendes-paiva/montink.git)

# Acesse a pasta do projeto
cd montink

2. Instalar Dependências com Composer
O Composer é usado para gerenciar as dependências do PHP. Execute o comando abaixo para instalar todos os pacotes necessários definidos no arquivo composer.json.

Bash

composer install

3. Configurar o Ambiente
O Laravel utiliza um arquivo .env para armazenar variáveis de ambiente, como as credenciais do banco de dados.

Bash

# Copie o arquivo de exemplo para criar o seu próprio arquivo de configuração
cp .env_christian .env

# Gere uma chave de aplicação única para o projeto
php artisan key:generate

4. Configurar e Popular o Banco de Dados
Agora, vamos configurar e alimentar o banco de dados.

a) Crie um banco de dados local usando seu gerenciador de banco de dados preferido (MySQL Workbench, DBeaver, etc.).

b) Edite o arquivo .env com as credenciais do seu banco de dados local:

Fragmento do código

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=montink
DB_USERNAME=
DB_PASSWORD=

c) Execute o script SQL inicial
Este projeto requer a importação de um arquivo SQL para configurar a estrutura inicial ou popular dados essenciais. Utilize uma ferramenta de sua preferência (linha de comando, DBeaver, etc.) para executar o arquivo Montink.sql no banco de dados que você acabou de criar.

Exemplo via linha de comando do MySQL:

Bash

mysql -u <SEU_USUARIO_DO_BANCO> -p <NOME_DO_SEU_BANCO_DE_DADOS> < caminho/para/o/NOME_DO_ARQUIVO.sql

5. Executar as Migrations
Após a configuração inicial, é importante rodar as migrations do Laravel para garantir que o banco de dados esteja atualizado com todos os modelos e tabelas mais recentes do projeto.

Bash

# Executa as migrations para criar/atualizar as tabelas do banco de dados
php artisan migrate


▶️ Executando a Aplicação
Com tudo configurado, inicie o servidor de desenvolvimento local do Laravel:

Bash

php artisan serve
