<template>
  <div class="dashboard">
  <Navbar></Navbar>
    <div class="container-fluid">
        <div class="row">
            <Sidebar :page="name"></Sidebar>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <div class="row">
                    <h1 class="h2">Dashboard</h1>
                    <div class="row my-4">
                        <div class="col-12 col-md-4 col-lg-4 mb-4 mb-lg-0">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Clients</h5>
                                            <h3 class="font-weight-bold mb-0">{{clientCount}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 mb-4 mb-lg-0">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Stocks</h5>
                                            <h3 class="font-weight-bold mb-0">{{stockCount}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 mb-4 mb-lg-0">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Purchases</h5>
                                            <h3 class="font-weight-bold mb-0">{{purchaseCount}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                      
                </div>

                <div class="row">
                    <div class="col-12 col-xl-6 mb-4 mb-lg-0">
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
                                                        <a class="dropdown-item" href="#">View stocks</a>
                                                    </div>
                                                </div>
                                            </td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <router-link :to="{ name: 'client' }" class="btn btn-block btn-light">View all</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">List all stocks</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">Company</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Updated At</th>
                                            <th scope="col">Actions</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(stock, index) in stocks" :key="index">
                                            <th scope="row">{{stock.company_name}}</th>
                                            <td>€{{stock.price.toFixed(2)}}</td>
                                            <td>{{stock.updated_at}}</td>
                                            <td>
                                                <div class="dropdown position-static actions d-inline-block">
                                                    <button class="btn btn-primary btn-md px-1 py-0 mt-1 rounded-circle" type="button"
                                                        id="table-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="table-action">
                                                        <router-link :to="{ name: 'stock' }" class="btn btn-block btn-light">Update unit price</router-link>
                                                        <a class="dropdown-item" @click="deleteStock(stock.id)">Delete stock</a>
                                                    </div>
                                                </div>
                                            </td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <router-link :to="{ name: 'stock' }" class="btn btn-block btn-light">View all</router-link>
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
          name: "dashboard",
          title: "Dashboard",
          clientCount: 0,
          stockCount: 0,
          purchaseCount: 0,
          clients: [],
          stocks: [],
        };
    },
    methods: {
        getDashboardStats () {
            this.$api.get('/api/v1/dashboard/stats').then(response => {
                if (response.status == 200) {
                    this.clientCount = response.data.data.stats.clients;
                    this.stockCount = response.data.data.stats.stocks;
                    this.purchaseCount = response.data.data.stats.purchases;
                    
                    this.clients = response.data.data.tableData.clients;
                    this.stocks = response.data.data.tableData.stocks;
                    return true;
                } else {
                    this.$toastr.error(response.data.message);
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
        },
        deleteStock (stock) {
            this.$swal({
                title: 'Do you want to delete this stock?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$api.delete('/api/v1/stock', {data: {
                        stock: stock
                    }}).then(response => {
                        if (response.status == 201) {
                            this.getDashboardStats();
                            this.$toastr.success(response.data.message);
                        }
                        else{
                            this.$toastr.error(response.data.message);
                        }
                    });
                } else if (result.isDenied) {
                    this.$swal('Changes are not saved', '', 'info')
                }
            })
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
        this.getDashboardStats()
    },
  components: { Sidebar, Navbar }
}
</script>