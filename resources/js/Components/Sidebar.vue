<template>
    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-black sidebar collapse">
        <div class="position-sticky pt-md-3">
            <ul class="nav flex-column">
                <li class="nav-item pt-1">
                    <router-link :to="{ name: 'dashboard' }" class="nav-link" :class=" page == 'dashboard' ? ' active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="ml-2">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item pt-1">
                    <router-link :to="{ name: 'client' }" class="nav-link" :class=" page == 'client' ? ' active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="ml-2">Client</span>
                    </router-link>
                </li>
                <li class="nav-item pt-1">
                    <router-link :to="{ name: 'stock' }" class="nav-link" :class=" page == 'stock' ? ' active' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span class="ml-2">Stock</span>
                    </router-link>
                </li>
                <li class="nav-item pt-1">
                    <router-link :to="{ name: 'purchase' }" class="nav-link" :class=" page == 'purchase' ? ' active' : ''">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span class="ml-2">Purchase</span>
                    </router-link>
                </li>
                <li class="nav-item pt-1">
                    <a class="nav-link" @click="logout()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span class="ml-2">Sign Out</span>
                    </a>
                </li>
                </ul>
        </div>
    </nav>
</template>

<script>
export default {
  name: 'sidebar',
  props: {
    page: ''
  },
  methods: {
    logout () {
        this.$api.post('/api/logout').then(response => {
            localStorage.removeItem('bearerToken');
            localStorage.removeItem('userData');
            this.$router.push("/login")

        }).catch(error => {
            location.reload();
        });
    }
  },
}
</script>