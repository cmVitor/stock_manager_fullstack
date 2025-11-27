# Frontend - Stock Manager

Este repositório contém o **frontend** do projeto desenvolvido com **Vue 3**, **TypeScript** e **Vuetify**, responsável pela interface do Sistema de Gerenciamento de Estoque.

---

## 🚀 Tecnologias Utilizadas

- [Vue 3](https://vuejs.org/) - Framework principal  
- [TypeScript](https://www.typescriptlang.org/) - Tipagem estática  
- [Vuetify 3](https://vuetifyjs.com/en/) - Biblioteca de componentes UI  
- [Vite](https://vitejs.dev/) - Ferramenta de build e dev server  
- [Vue Router](https://router.vuejs.org/) - Gerenciamento de rotas  
- [Pinia](https://pinia.vuejs.org/) - Gerenciamento de estado  
- [JSON Server](https://github.com/typicode/json-server) - API fake para simular o backend

---

## ⚙️ Instalação e Execução

Clone o repositório e instale as dependências:

```bash
npm install
```
### 🔹 Rodar o Frontend
```
`npm run dev`
```
O projeto será executado em:

> [http://localhost:3000](http://localhost:3000)

### 🔹 Rodar o Backend Fake (JSON Server)
O backend utiliza o **JSON Server** para simular a API REST.  
Execute o comando abaixo para iniciar o servidor:

```
npm run backend
```

A API será iniciada em:

> [http://localhost:3001](http://localhost:3001)

---

## 🧱 Estrutura do Projeto
```
src/
 ├─ assets/           # Imagens e arquivos estáticos
 ├─ components/       # Componentes reutilizáveis
 ├─ layouts/          # Layouts globais (ex: Default, Blank)
 ├─ pages/            # Páginas do sistema
 ├─ stores/           # Armazenamento de estado (Pinia)
 ├─ router/           # Configuração das rotas
 ├─ App.vue           # Componente raiz
 └─ main.ts           # Ponto de entrada da aplicação
```

---

## 📦 API Fake

O **JSON Server** utiliza o arquivo `db.json` localizado na pasta `db/` 

Exemplo de endpoint:
```
GET http://localhost:3001/products
```

---

## 🧑‍💻 Autor

**Vitor Martins**

📧 [LinkedIn](https://www.linkedin.com/in/vitor-martins-castanheira-749b1024a/)  
💻 Projeto desenvolvido como parte do desafio **Full Stack** da Norven.
