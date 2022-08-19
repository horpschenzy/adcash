import http from '../Libs/axios-config'

const routes = [
    {
      path: '/login',
      component: () => import('../Pages/Login.vue'),
      name: 'login'
    },
    {
      path: '/dashboard',
      component: () => import('../Pages/Dashboard.vue'),
      name: 'dashboard',
      beforeEnter(to, from, next) {
        let token = JSON.parse(localStorage.getItem('bearerToken'));
        http.get('/api/v1/me').then(response => {
          if(response.status >= 400 && response.status <= 499){
            next('/login')
          } else {
            next();
          }
        });
      }
    },
    {
      path: '/client',
      component: () => import('../Pages/Client.vue'),
      name: 'client',
      beforeEnter(to, from, next) {
        let token = JSON.parse(localStorage.getItem('bearerToken'));
        http.get('/api/v1/me').then(response => {
          if(response.status >= 400 && response.status <= 499){
            next('/login')
          } else {
            next();
          }
        });
      }
    },
    {
      path: '/stock',
      component: () => import('../Pages/Stock.vue'),
      name: 'stock',
      beforeEnter(to, from, next) {
        let token = JSON.parse(localStorage.getItem('bearerToken'));
        http.get('/api/v1/me').then(response => {
          if(response.status >= 400 && response.status <= 499){
            next('/login')
          } else {
            next();
          }
        });
      }
    },
    {
      path: '/purchase',
      component: () => import('../Pages/Purchase.vue'),
      name: 'purchase',
      beforeEnter(to, from, next) {
        let token = JSON.parse(localStorage.getItem('bearerToken'));
        http.get('/api/v1/me').then(response => {
          if(response.status >= 400 && response.status <= 499){
            next('/login')
          } else {
            next();
          }
        });
      }
    },
    {
      path: '*',
      redirect: '/login'
    },
  ];

export default routes;