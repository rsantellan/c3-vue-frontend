import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import { token, user } from '@/auth'

import Home from '../pages/Home.vue'
import Infraestructura from '../pages/Infraestructura.vue'
import Contabilidad from '../pages/Contabilidad.vue'
import Seguridad from '../pages/Seguridad.vue'
import Asesoramientos from '../pages/Asesoramientos.vue'
import Auditoria from '../pages/Auditoria.vue'
import ServicioNotarial from '../pages/ServicioNotarial.vue'
import Contacto from '../pages/Contacto.vue'

import Dashboard from '../pages/Dashboard.vue'
import News from '../pages/admin/News.vue'
import Accounts from '../pages/admin/Accounts.vue'
import MonthAmount from '../pages/admin/MonthAmount.vue'
import YearExpiration from '../pages/admin/YearExpiration.vue'
import CreateTask from '@/pages/admin/CreateTask.vue'
import ViewTasks from '@/pages/admin/ViewTasks.vue'
import View from '@/pages/admin/profile/View.vue'
import Edit from '@/pages/admin/profile/Edit.vue'
import ChangePassword from '@/pages/admin/profile/ChangePassword.vue'

import Users from '@/pages/admin/manage/Users.vue'
import ShowProfile from '@/pages/admin/manage/ShowProfile.vue'
import EditProfile from '@/pages/admin/manage/EditProfile.vue'
import CreateUser from '@/pages/admin/manage/CreateUser.vue'

const routes: RouteRecordRaw[] = [
  // Public
  { path: '/', component: Home },
  { path: '/infraestructura', component: Infraestructura },
  { path: '/contabilidad', component: Contabilidad },
  { path: '/seguridad', component: Seguridad },
  { path: '/asesoramientos', component: Asesoramientos },
  { path: '/auditoria', component: Auditoria },
  { path: '/servicio-notarial', component: ServicioNotarial },
  { path: '/contacto', component: Contacto },

  // Logged
  { path: '/admin', component: Dashboard, meta: { requiresAuth: true } },
  { path: '/admin/news', component: News, meta: { requiresAuth: true } },
  { path: '/admin/accounts', component: Accounts, meta: { requiresAuth: true } },
  { path: '/admin/monthAmount', component: MonthAmount, meta: { requiresAuth: true } },
  { path: '/admin/yearExpiration', component: YearExpiration, meta: { requiresAuth: true } },
  { path: '/admin/createTask', component: CreateTask, meta: { requiresAuth: true } },
  { path: '/admin/viewTasks', component: ViewTasks, meta: { requiresAuth: true } },

  { path: '/admin/user/profile', component: View, meta: { requiresAuth: true } },
  { path: '/admin/user/profile/edit', component: Edit, meta: { requiresAuth: true } },
  { path: '/admin/user/profile', component: YearExpiration, meta: { requiresAuth: true } },

  // Admin
  { path: '/admin/users', component: Users, meta: { requiresAuth: true, requiresAdmin: true } },
  { path: '/admin/user/create', component: CreateUser, meta: { requiresAuth: true, requiresAdmin: true } },
  {
    path: '/admin/user/profile/changepassword',
    component: ChangePassword,
    meta: { requiresAuth: true },
  },
  {
    path: '/admin/user/:id',
    name: 'admin-user-show',
    component: ShowProfile,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/user/edit/:id',
    name: 'admin-user-edit',
    component: EditProfile,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  // Admin and Boss
  {
    path: '/admin/permissions',
    component: Dashboard,
    meta: { requiresAuth: true, requiresAdmin: true, requiresBoss: true },
  },

  // Boss
  { path: '/admin/boss', component: Dashboard, meta: { requiresAuth: true, requiresBoss: true } },
  { path: '/admin/boss/create', component: Dashboard, meta: { requiresAuth: true, requiresBoss: true } },
]
const base = import.meta.env.VITE_BASE_URL || '/'

const router = createRouter({
  history: createWebHistory(base),
  routes,
})

// 🔐 Auth guard (clean version)
router.beforeEach((to) => {
  const isLogged = !!token.value
  const currentUser = user.value

  if (to.meta.requiresAuth && !isLogged) {
    return '/'
  }

  // 2. Requires admin
  if (to.meta.requiresAdmin && !currentUser?.isAdmin) {
    return '/admin'
  }

  // 3. Requires boss
  if (to.meta.requiresBoss && !currentUser?.isBoss) {
    return '/admin'
  }

  return true
})

export default router
