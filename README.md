# 🏪 StockManager

**Sistema Gerenciador de Estoque de Produtos Alimentícios**

----------

## 📖 Sobre o Projeto

O **StockManager** é uma aplicação **Full Stack** desenvolvida para oferecer aos usuários uma **visão clara, confiável e automatizada do controle de estoque de produtos alimentícios**, simplificando a gestão de entradas, saídas e monitoramento de validade.

O sistema foi construído com foco em **organização, escalabilidade e integridade dos dados**, utilizando **migrations**, **camadas de serviço**, **padrões de repositório** e **transações de banco de dados** para garantir segurança e consistência das informações em ambientes multiusuário.

----------

## 🧱 Arquitetura da Aplicação

A solução é composta por três camadas principais:

### 🔹 **Frontend**

-   **Framework:** [Vue 3](https://vuejs.org/)
    
-   **Linguagem:** TypeScript
    
-   **Gerenciador de Estado:** [Pinia](https://pinia.vuejs.org/)
    
-   **UI Framework:** [Vuetify](https://vuetifyjs.com/)
    
-   **Autenticação:** JWT (armazenado em Pinia / Local Storage)
    
-   **Build Tool:** Vite
    

### 🔹 **Backend**

-   **Framework:** [Laravel 12](https://laravel.com/)
    
-   **Linguagem:** PHP 8+
    
-   **ORM:** Eloquent
    
-   **Autenticação:** JWT + Senhas criptografadas (bcrypt)
    
-   **Padrões:** Repository Pattern, Service Layer
    
-   **Transações de Banco:** Garantia de atomicidade e integridade referencial
    

### 🔹 **Banco de Dados**

-   **SGBD:** PostgreSQL
    
-   **Modelagem:** Normalizada com controle de chaves estrangeiras
    
-   **Migrations:** Utilizadas para versionamento e reprodutibilidade da estrutura
    

----------

## ✅ Funcionalidades Implementadas

### 👥 **Autenticação**

-   Login de usuários administradores via JWT.
    
-   Senhas armazenadas com criptografia segura.
    
-   Controle de acesso baseado em **perfis (Administrador / Padrão)**.
    

### 👤 **CRUD de Usuários**

-   **Cadastro** com os campos obrigatórios:
    
    -   Nome, E-mail, Contato, Endereço (Estado e Cidade integrados ao IBGE).
        
-   **Listagem** completa de usuários.
    
-   **Edição** de dados cadastrais.
    
-   **Inativação** de usuários (soft delete).
    
-   **Permissões:** Apenas administradores podem criar, editar ou inativar usuários.
    

### 🍞 **CRUD de Produtos**

-   Cadastro com:
    
    -   Nome, Preço (máscara de moeda), Data de Validade (obrigatória para perecíveis).
        
-   Edição restrita (integridade de validade).
    
-   Listagem com colunas: **Nome, Preço, Validade, Status**.
    
-   Filtros: **Nome, Status, Intervalo de Preço**.
    
-   Destaques visuais para:
    
    -   Produtos **com validade próxima (≤ 30 dias)**.
        
    -   Produtos **com estoque baixo**.
        

### 🔄 **Transações de Estoque**

-   **Entradas de Produtos:**
    
    -   Seleção de produto, quantidade, tipo e observação.
        
    -   Atualização automática do saldo.
        
-   **Saídas de Produtos:**
    
    -   Bloqueio de saídas maiores que o estoque disponível.
        
-   **Histórico de Transações:**
    
    -   Filtros por produto, tipo, usuário e período.
        
-   **Auditoria Completa:**
    
    -   Registro de usuário, data/hora e tipo de movimento.
        
    -   Nenhuma transação pode ser excluída.
        

### 📊 **Estoque Atual**

-   Exibição em tempo real do saldo de cada produto.
    
-   Cálculo dinâmico após entradas e saídas.
    

----------

## ⚙️ Requisitos Opcionais (implementados)
    
-   🐳 **Dockerização Completa:** Containers individuais para Frontend, Backend e Banco de Dados.
    
----------

## 🧠 Padrões e Boas Práticas

-   **Repository Pattern:** Isolamento da camada de persistência.
    
-   **Service Layer:** Regras de negócio desacopladas dos controladores.
    
-   **Transações de Banco:** Atomicidade garantida nas movimentações.
    
-   **Paginação e Otimização:** Consultas otimizadas e carregamento preguiçoso (Eloquent).
    
-   **Componentização Vue:** Reutilização e clareza de código.
    

----------


# Guia de Execução

Este projeto é composto por **três serviços** rodando em containers Docker:

-   **Frontend (Vue + Vite)** — porta `3000`
    
-   **Backend (Laravel + PHP-FPM)** — porta `8000`
    
-   **Banco de Dados (PostgreSQL)** — porta `5433` (exposta para o host)
    

O ambiente é totalmente automatizado: ao subir, o backend aguarda o banco iniciar, rodará **migrations** e **seeders** automaticamente e iniciará o servidor Laravel.

----------

## 🚀 **Como rodar a aplicação**

### **1. Pré-requisitos**

-   **Docker** instalado
    
-   **Docker Compose** instalado
    
-   Nenhum serviço rodando nas portas **3000**, **8000** e **5433** no seu computador
    

----------

## ▶️ **Subindo tudo**

No diretório raiz do projeto, execute:

`docker-compose up -d --build` 

Isso irá:

1.  Criar a rede Docker
    
2.  Subir o Postgres
    
3.  Subir o backend Laravel
    
4.  Aguardar o banco iniciar
    
5.  Rodar migrations + seeders automaticamente
    
6.  Subir o frontend Vite
    
7.  Servir o frontend em `localhost:3000`
    

----------

## 🌐 **Acessos**

Serviço

URL

Frontend

[http://localhost:3000](http://localhost:3000)

Backend API

http://localhost:8000/api

Banco

`localhost:5433` (Postgres)

----------

## 🗄️ **Conectando ao banco (opcional)**

Você pode acessar o banco via DBeaver ou outro cliente usando:

`Host:  localhost  Port:  5433  User:  postgres  Password:  admin  Database:  stock_manager` 

----------

## 🛑 **Desligando os containers**

`docker-compose down` 

----------

## ♻️ **Resetando o ambiente**

Se quiser apagar o banco e gerar tudo do zero:

`docker-compose down -v
docker-compose up -d --build` 

----------

## 🧩 Estrutura dos containers

`services/
  app-client/ -> Frontend Vue
  api/ -> Backend Laravel
  postgres/ -> Banco de dados PostgreSQL

docker-compose.yml` 

----------

## 📦 **Variáveis de ambiente**

O backend usa os valores de `api/.env`.  
As variáveis principais são:

`DB_HOST=postgres DB_PORT=5432 (porta interna dentro do Docker) DB_USERNAME=postgres DB_PASSWORD=admin` 

Para acessar o banco pelo host, a porta exposta é **5433**, mas dentro do Docker sempre use **5432**.

----------

## 🧾 **Logs**

Backend Laravel:

`docker logs api -f` 

Frontend Vue:

`docker logs app-client -f` 

Banco:

`docker logs postgres -f` 

----------

## 🛠️ Comandos úteis no container do backend

`docker exec -it api bash
php artisan migrate
php artisan db:seed
php artisan tinker`

## 🧾 Licença

Este projeto é distribuído sob a licença **MIT**.  
Sinta-se livre para usar, modificar e contribuir.

----------

## 👨‍💻 Autor

**Vitor Martins Castanheira**  
Desenvolvedor Full Stack  
