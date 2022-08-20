<template>
  <div class="client">
  <Navbar></Navbar>
    <div class="container-fluid">
        <div class="row">
            <Sidebar :page="name"></Sidebar>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <div class="row">
                    <h1 class="h2">Client</h1>
                    <div class="row my-4">
                        <div class="col-12 col-md-4 col-lg-4 mb-4 mb-lg-0">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Clients</h5>
                                            <h3 class="font-weight-bold mb-0">{{clients.length}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-4 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">Add Client</h5>
                            <div class="card-body">
                                <form @submit.prevent="addClient">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text text-white bg-blue input-border" id="basic-addon1">@</span>
                                        <input type="text" class="form-control" placeholder="Username" v-model="form.username" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="badge-danger" v-for="(usernameError, index) in usernameErrors" :key="index">* {{usernameError}}</div>
                                    <button type="submit" class="btn btn-primary float-right">Add</button>
                                </form>                                  
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">List all clients</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">Client</th>
                                            <th scope="col">Cash Balance</th>
                                            <th scope="col">Gain/Loss</th>
                                            <th scope="col">Actions</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(client, index) in computedClients" :key="index">
                                            <th scope="row">{{client.username}}</th>
                                            <td>€{{client.balance}}</td>
                                            <td v-html="client.gainOrLoss"></td>
                                            <td>
                                                <div class="dropdown position-static actions d-inline-block">
                                                    <button class="btn btn-primary btn-md px-1 py-0 mt-1 rounded-circle" type="button"
                                                        id="table-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="table-action">
                                                        <router-link :to="'/client/'+ client.id + '/stocks'" class="dropdown-item">View stocks</router-link>

                                                    </div>
                                                </div>
                                            </td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
  </div>
</template>

<script>
import Navbar from '../Components/Navbar.vue';
import Sidebar from '../Components/Sidebar.vue';
export default {
    data() {
        return {
          name: "client",
          title: "Client",
          clients: [],
          form: {
            username: '',
          },
          usernameErrors: []
        };
    },
    methods: {
        listClient () {
            this.$api.get('/api/v1/client').then(response => {
                if (response.status == 200) {
                    this.clients = response.data.data;
                    return true;
                } else {
                    this.$toastr.error(response.data.message);
                    return false;
                }
            })
        },
        addClient () {
            this.$api.post('/api/v1/client', this.form).then(response => {
                if (response.status == 201) {
                    this.form.username = '';

                    this.usernameErrors = [];

                    this.listClient()
                    this.$toastr.success(response.data.message);
                    return true;
                } else {
                    let error = response.data.message;
                    if ( typeof error === 'object' && error !== null){
                        if (error.hasOwnProperty('username')) {
                            this.usernameErrors = error.username;
                        }
                    }
                    else {
                        this.$toastr.error(response.data.message);
                    }
                    return false;
                }
            })
        },
        getGainOrLossValue (purchases) {
            if (purchases.length <= 0) {
                return 0;
            }
            let profit = 0;
            purchases.forEach((value, index) => {
                let stockPrice = value.stock.price * value.volume;
                let purchasePrice = value.price;
                let gainOrLoss = stockPrice - purchasePrice;
                profit += gainOrLoss;
            })
            return profit;
        }
    },
    computed: {
        computedClients () {
            let clients =  this.clients;
            let mainArray = [];
            clients.forEach((value, index) => {
                let gainOrLoss = this.getGainOrLossValue(value.purchases);

                let result = '';
                if (gainOrLoss > 0) {
                    result = '<span class="text-success">+€' + gainOrLoss.toFixed(2) + '</span>';
                } else if (gainOrLoss < 0) {
                    result =  '<span class="text-danger">-€' + Math.abs(gainOrLoss).toFixed(2) + '</span>';
                } else {
                    result =  '€0.00';
                }

                let purchaseObject = {
                    'id': value.id,
                    'username': value.username,
                    'balance': value.balance.toFixed(2),
                    'profit': gainOrLoss,
                    'gainOrLoss': result,
                }
                mainArray.push(purchaseObject);
            });
            mainArray.sort((a,b) => (a.profit > b.profit)  ? -1 : (a.profit < b.profit) ? 1 :0);
            return mainArray;
        }
    },
    mounted() {
        this.listClient()
    },
  components: { Sidebar, Navbar }
}
</script>