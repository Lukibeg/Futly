# Futly - Gerenciador de Times de Futebol

## Sobre o Projeto

Futly é uma aplicação web desenvolvida com o objetivo de aprimorar meus conhecimentos em PHP e no framework Laravel. Além de ser um projeto de aprendizado, a plataforma busca resolver um problema comum entre jogadores de futebol amador: a organização de times antes das partidas.

A ideia é centralizar a criação de equipes, o gerenciamento de jogadores e os pedidos de entrada, facilitando a vida de quem organiza e de quem joga.

## Funcionalidades

-   **Autenticação de Usuários:** Cadastro e login de jogadores.
-   **Criação e Gerenciamento de Times:** Donos de times podem criar e gerenciar suas equipes.
-   **Busca de Times:** Jogadores podem visualizar os times existentes.
-   **Pedidos para Entrar em Times:** Jogadores podem solicitar a entrada em um time.
-   **Aprovação/Rejeição de Pedidos:** Donos de times podem aceitar ou recusar os pedidos de entrada.
-   **Visualização de Jogadores:** Listagem de jogadores cadastrados na plataforma.

## Tecnologias Utilizadas

-   **PHP**
-   **Laravel**
-   **MySQL**
-   **Blade** (template engine)
-   **HTML / CSS / JavaScript**
-   **Vite**

## Instalação e Execução

Siga os passos abaixo para executar o projeto em seu ambiente local.

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/Lukibeg/Futly.git
    cd Futly
    ```

2.  **Instale as dependências do PHP:**
    ```bash
    composer install
    ```

3.  **Instale as dependências do Node.js:**
    ```bash
    npm install
    ```

4.  **Configure o ambiente:**
    -   Copie o arquivo de exemplo `.env.example` para `.env`.
        ```bash
        cp .env.example .env
        ```
    -   Gere a chave da aplicação:
        ```bash
        php artisan key:generate
        ```

5.  **Configure o banco de dados:**
    -   Abra o arquivo `.env` e configure as credenciais do seu banco de dados (MySQL, por exemplo).
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=futly
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Execute as migrations:**
    ```bash
    php artisan migrate
    ```

7.  **Compile os assets (CSS/JS):**
    ```bash
    npm run dev
    ```

8.  **Inicie o servidor local:**
    ```bash
    php artisan serve
    ```

Agora você pode acessar a aplicação em `http://localhost:8000`.

## Contribuições

Este é um projeto de aprendizado pessoal, mas sugestões, dicas e contribuições são sempre bem-vindas. Sinta-se à vontade para abrir uma *issue* ou enviar um *pull request*.

