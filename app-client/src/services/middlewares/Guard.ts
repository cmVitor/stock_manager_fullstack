import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

export default {
  auth(
    to: RouteLocationNormalized,
    from: RouteLocationNormalized,
    next: NavigationGuardNext
  ) {
    const token = localStorage.getItem('token')

    if (!token) {
      next('/login')
      alert("É necessário estar autenticado pra entrar nessa page!")
      return   
    }

    next()
  }
}
