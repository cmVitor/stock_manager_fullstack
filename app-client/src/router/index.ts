/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory } from 'vue-router'
import { setupLayouts } from 'virtual:generated-layouts'
import path from 'path'
import { components } from 'vuetify/dist/vuetify.js'
import Guard from '@/services/middlewares/Guard'
import CheckAdmin from '@/services/middlewares/CheckAdmin'
import UsuarioNovo from '../pages/Usuarios/novo.vue'
import RelatoriosCriticos from '../pages/Relatorios/criticos.vue'

const routes = [
  {
    name: 'Login',
    path: '/login',
    component: () => import('../pages/login.vue'),
    meta: { layout: 'blank' }
  },
  {
    name: 'Home',
    path: '/home',
    component: () => import('../pages/home.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'Usuarios',
    path: '/usuarios',
    component: () => import('../pages/Usuarios/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    name: 'UsuarioNovo',
    path: '/usuarios/novo',
    component: UsuarioNovo,
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    name: 'RelatoriosCriticos',
    path: '/relatorios/criticos',
    component:RelatoriosCriticos,
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'RelatoriosVencimentos',
    path: '/relatorios/vencimentos',
    component: () => import('../pages/Relatorios/vencimentos.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'Produtos',
    path: '/produtos',
    component: () => import('../pages/Produtos/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'ProdutosNovo',
    path: '/produtos/novo',
    component: () => import('../pages/Produtos/novo.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'Movimentacoes',
    path: '/movimentacoes',
    component: () => import('../pages/Movimentacoes/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'MovimentacoesNova',
    path: '/movimentacoes/nova',
    component: () => import('../pages/Movimentacoes/nova.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'Lotes',
    path: '/lotes',
    component: () => import('../pages/lotes/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    name: 'NovoLote',
    path: '/lotes/novo',
    component: () => import('../pages/lotes/novo.vue'),
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    name: 'Fornecedores',
    path: '/fornecedores',
    component: () => import('../pages/Fornecedores/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    name: 'FornecedoresNovo',
    path: '/fornecedores/novo',
    component: () => import('../pages/Fornecedores/novo.vue'),
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    name: 'Estoque',
    path: '/estoque',
    component: () => import('../pages/Estoque/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'Profile',
    path: '/profile',
    component: () => import('../pages/profile.vue'),
    meta: { layout: 'default' },
    beforeEnter: Guard.auth
  },
  {
    name: 'Categorias',
    path: '/categorias',
    component: () => import('../pages/Categorias/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    name: 'Marcas',
    path: '/marcas',
    component: () => import('../pages/Marcas/index.vue'),
    meta: { layout: 'default' },
    beforeEnter: CheckAdmin.auth
  },
  {
    path: '/',
    redirect: '/login'
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: setupLayouts(routes),
})

// Workaround for https://github.com/vitejs/vite/issues/11804
router.onError((err, to) => {
  if (err?.message?.includes?.('Failed to fetch dynamically imported module')) {
    if (localStorage.getItem('vuetify:dynamic-reload')) {
      console.error('Dynamic import error, reloading page did not fix it', err)
    } else {
      console.log('Reloading page to fix dynamic import error')
      localStorage.setItem('vuetify:dynamic-reload', 'true')
      location.assign(to.fullPath)
    }
  } else {
    console.error(err)
  }
})

router.isReady().then(() => {
  localStorage.removeItem('vuetify:dynamic-reload')
})

export default router
