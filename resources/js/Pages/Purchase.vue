<template>
  <div class="client">
  <Navbar></Navbar>
    <div class="container-fluid">
        <div class="row">
            <Sidebar :page="name"></Sidebar>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <div class="row">
                    <h1 class="h2">Purchase</h1>
                    <div class="row my-4">
                        <div class="col-12 col-md-4 col-lg-4 mb-4 mb-lg-0">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Purchases</h5>
                                            <h3 class="font-weight-bold mb-0">{{computedPurchases.length}}</h3>
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
                            <h5 class="card-header">Add Purchase</h5>
                            <div class="card-body">
                                <form @submit.prevent="addPurchase">
                                    <div class="input-group mb-3">
                                        <select class="form-select" aria-label="Default select example" v-model="form.stock" required>
                                            <option value="">Choose stock</option>
                                            <option  v-for="(stock, index) in stocks" :key="index" :value="stock.id">{{stock.company_name}}</option>
                                        </select>
                                    </div>
                                    <div class="badge-danger" v-for="(stockError, index) in stockErrors" :key="index">* {{stockError}}</div>
                                    <div class="input-group mb-3">
                                        <select class="form-select" aria-label="Default select example" v-model="form.client" required>
                                            <option value="">Choose client</option>
                                            <option  v-for="(client, index) in clients" :key="index" :value="client.id">{{client.username}}</option>
                                        </select>
                                    </div>
                                    <div class="badge-danger" v-for="(clientError, index) in clientErrors" :key="index">* {{clientError}}</div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Volume" aria-label="Volume" aria-describedby="basic-addon1" v-model="form.volume" required>
                                    </div>
                                    <div class="badge-danger" v-for="(volumeError, index) in volumeErrors" :key="index">* {{volumeError}}</div>
                                    <button type="submit" class="btn btn-primary float-right">Add</button>
                                </form>                                  
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">List all Purchases</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">Client</th>
                                            <th scope="col">Company</th>
                                            <th scope="col">Volume</th>
                                            <th scope="col">Purchase Price</th>
                                            <th scope="col">Current Price</th>
                                            <th scope="col">Gain/Loss</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(purchase, index) in computedPurchases" :key="index">
                                            <th scope="row">{{purchase.client}}</th>
                                            <td>{{purchase.stock}}</td>
                                            <td>{{purchase.volume}}</td>
                                            <td>€{{purchase.purchasePrice}}</td>
                                            <td>€{{purchase.currentPrice}}</td>
                                            <td v-html="purchase.gainOrLoss"></td>
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
          name: "purchase",
          title: "Purchase",
          stocks: [],
          clients: [],
          purchases: [],
          form: {
            stock: '',
            client: '',
            volume: 0
          },
          stockErrors: [],
          clientErrors: [],
          volumeErrors: [],
        };
    },
    methods: {
        listPurchase () {
            this.$api.get('/api/v1/purchase').then(response => {
                if (response.status == 200) {
                    this.purchases = response.data.data;
                    return true;
                } else {
                    this.$toastr.error(response.data.message);
                    return false;
                }
            })
        },
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
        listStock () {
            this.$api.get('/api/v1/stock').then(response => {
                if (response.status == 200) {
                    this.stocks = response.data.data;
                    return true;
                } else {
                    this.$toastr.error(response.data.message);
                    return false;
                }
            })
        },
        addPurchase () {
            this.$api.post('/api/v1/purchase', this.form).then(response => {
                if (response.status == 201) {
                    this.form.stock = '';
                    this.form.client = '';
                    this.form.volume = 0;

                    this.stockErrors = [];
                    this.clientErrors = [];
                    this.volumeErrors = [];

                    this.listPurchase()
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
    },
    computed: {
        computedPurchases () {
            let purchases =  this.purchases;
            let mainArray = [];
            purchases.forEach((value, index) => {
                let stockPrice = value.stock.price * value.volume;
                let purchasePrice = value.price;
                let gainOrLoss = stockPrice - purchasePrice;

                let result = '';
                if (gainOrLoss > 0) {
                    result = '<span class="text-success">+€' + gainOrLoss.toFixed(2) + '</span>';
                } else if (gainOrLoss < 0) {
                    result =  '<span class="text-danger">-€' + Math.abs(gainOrLoss).toFixed(2) + '</span>';
                } else {
                    result =  '€0.00';
                }

                let purchaseObject = {
                    'client': value.client.username,
                    'stock': value.stock.company_name,
                    'volume': value.volume,
                    'purchasePrice': (value.price / value.volume).toFixed(2),
                    'currentPrice': value.stock.price.toFixed(2),
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
        this.listStock()
        this.listPurchase()
    },
  components: { Sidebar, Navbar }
}
</script>