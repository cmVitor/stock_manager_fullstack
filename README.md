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

## 🧾 Licença

Este projeto é distribuído sob a licença **MIT**.  
Sinta-se livre para usar, modificar e contribuir.

----------

## 👨‍💻 Autor

**Vitor Martins Castanheira**  
Desenvolvedor Full Stack  
