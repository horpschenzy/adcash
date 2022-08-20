<template>
  <div class="client">
  <Navbar></Navbar>
    <div class="container-fluid">
        <div class="row">
            <Sidebar :page="name"></Sidebar>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <div class="row">
                    <h1 class="h2">{{ client.username}}'s Stocks</h1>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-12 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">List all client's stocks ({{ client.username}})</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">Company</th>
                                            <th scope="col">Volume</th>
                                            <th scope="col">Purchase Price</th>
                                            <th scope="col">Current Price</th>
                                            <th scope="col">Gain/Loss</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(purchase, index) in computedClientStock" :key="index">
                                            <td>{{purchase.stock}}</td>
                                            <td>{{purchase.volume}}</td>
                                            <td>€{{purchase.purchasePrice}}</td>
                                            <td>€{{purchase.currentPrice}}</td>
                                            <td v-html="purchase.gainOrLoss"></td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-3">
                                        <p class="mb-2" v-html="totalProfit"></p>
                                        <p class="mb-2" v-html="totalInvested"></p>
                                        <p class="mb-2" v-html="performance"></p>
                                        <p class="mb-2" v-html="balance"></p>
                                    </div>
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
          client: [],
          stocks: [],
          totalProfit: '',
          totalInvested:'',
          performance:'',
          balance: ''
        };
    },
    methods: {
        listClientStock () {
            let id = this.$route.params.id;
            this.$api.get('/api/v1/client/'+id+'/stocks').then(response => {
                if (response.status == 200) {
                    this.client = response.data.data;
                    this.stocks = response.data.data.purchases;
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
        }
    },
    computed: {
        computedClientStock () {
            let purchases =  this.stocks;
            let mainArray = [];
            let totalProfit = 0;
            let totalInvested = 0;
            purchases.forEach((value, index) => {
                let stockPrice = value.stock.price * value.volume;
                let purchasePrice = value.price;
                let gainOrLoss = stockPrice - purchasePrice;
                totalProfit += gainOrLoss;
                totalInvested += purchasePrice;

                let result = '';
                if (gainOrLoss > 0) {
                    result = '<span class="text-success">+€' + gainOrLoss.toFixed(2) + '</span>';
                } else if (gainOrLoss < 0) {
                    result =  '<span class="text-danger">-€' + Math.abs(gainOrLoss).toFixed(2) + '</span>';
                } else {
                    result =  '€0.00';
                }

                let purchaseObject = {
                    'stock': value.stock.company_name,
                    'volume': value.volume,
                    'purchasePrice': (value.price / value.volume).toFixed(2),
                    'currentPrice': value.stock.price.toFixed(2),
                    'profit': gainOrLoss,
                    'gainOrLoss': result,
                }
                mainArray.push(purchaseObject);
            });
            if (totalProfit > 0) {
                this.totalProfit = '<span class="text-dark">Total:</span></span><span class="text-success px-5"> +€' + totalProfit.toFixed(2) + '</span>';
            } else if (totalProfit < 0) {
                this.totalProfit =  '<span class="text-dark">Total:</span></span><span class="text-danger px-5"> -€' + Math.abs(totalProfit).toFixed(2) + '</span>';
            } else {
                this.totalProfit =  '<span class="text-dark">Total:</span> <span class="px-5"> €0.00 </span>';
            }
            this.totalInvested =  '<span class="text-dark">Invested:</span> <span class="px-4">€' + totalInvested.toFixed(2) + '</span>';
            this.balance =  '<span class="text-dark">Cash Balance:</span> €' + this.client.balance.toFixed(2);
            let performance = (totalInvested / (this.client.balance + totalInvested)) * 100;
            if (performance > 0) {
                this.performance = '<span class="text-dark">Performance:</span><span class="text-success px-0"> +' + performance.toFixed(2) + '%</span>';
            } else if (performance < 0) {
                this.performance =  '<span class="text-dark">Performance:</span><span class="text-danger px-0"> -' + Math.abs(performance).toFixed(2) + '%</span>';
            } else {
                this.performance =  '<span class="text-dark">Performance:</span> <span class="px-0"> 0.00% </span>';
            }
            mainArray.sort((a,b) => (a.profit > b.profit)  ? -1 : (a.profit < b.profit) ? 1 :0);
            return mainArray;
        }
    },
    mounted() {
        this.listClientStock()
    },
  components: { Sidebar, Navbar }
}
</script>