import type { NavigationGuardNext, RouteLocationNormalized } from "vue-router";

export default {
  auth(
    to: RouteLocationNormalized,
    from: RouteLocationNormalized,
    next: NavigationGuardNext
  ) {
    const userJson = localStorage.getItem("usuario");

    if (!userJson) {
      next("/login");
      return;
    }

    const user = JSON.parse(userJson);

    if (user.role !== "admin") {
      next("/login");
      alert("Não é adm pra entrar nessa page");
      return;
    }

    next();
  },
};
