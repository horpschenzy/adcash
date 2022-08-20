<template>
  <div class="stock">
  <Navbar></Navbar>
    <div class="container-fluid">
        <div class="row">
            <Sidebar :page="name"></Sidebar>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <div class="row">
                    <h1 class="h2">Stock</h1>
                    <div class="row my-4">
                        <div class="col-12 col-md-4 col-lg-4 mb-4 mb-lg-0">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Stocks</h5>
                                            <h3 class="font-weight-bold mb-0">{{stocks.length}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-4 mb-4 mb-lg-0">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <h5 class="card-header">Add Stock</h5>
                                    <div class="card-body">
                                        <form @submit.prevent="addStock" method="POST">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Company name" aria-label="Company name" v-model="form.company_name" aria-describedby="basic-addon1" required>
                                            </div>
                                            <div class="badge-danger" v-for="(companyNameError, index) in companyNameErrors" :key="index">* {{companyNameError}}</div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text text-white bg-blue input-border" id="basic-addon2">€</span>
                                                <input type="text" class="form-control" placeholder="Unit price" aria-label="Unit price" v-model="form.price" aria-describedby="basic-addon1" required>
                                            </div>
                                            <div class="badge-danger" v-for="(unitPriceError, index) in unitPriceErrors" :key="index">* {{unitPriceError}}</div>
                                            <button type="submit" class="btn btn-primary float-right">Add</button>
                                        </form>                                  
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <h5 class="card-header">Update Stock</h5>
                                    <div class="card-body">
                                        <form @submit.prevent="updateStock">
                                            <div class="input-group mb-3">
                                                <select class="form-select" aria-label="Default select example" v-model="updateForm.stock" required>
                                                    <option value="">Choose stock</option>
                                                    <option  v-for="(stock, index) in stocks" :key="index" :value="stock.id">{{stock.company_name}}</option>
                                                </select>
                                            </div>
                                            <div class="badge-danger" v-for="(updateCompanyNameError, index) in updateCompanyNameErrors" :key="index">* {{updateCompanyNameError}}</div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text text-white bg-blue input-border" id="basic-addon2">€</span>
                                                <input type="text" class="form-control" placeholder="Unit price" aria-label="Unit price" v-model="updateForm.price" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="badge-danger" v-for="(updateUnitPriceError, index) in updateUnitPriceErrors" :key="index">* {{updateUnitPriceError}}</div>
                                            <button type="submit" class="btn btn-primary float-right">Save</button>
                                        </form>                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
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
                                                        <a class="dropdown-item" @click="deleteStock(stock.id)">Delete stock</a>
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
          name: "stock",
          title: "Stock",
          stocks: [],
          form: {
            company_name: '',
            price: 0
          },
          updateForm: {
            stock: '',
            price: 0
          },
          companyNameErrors: [],
          unitPriceErrors: [],
          updateCompanyNameErrors: [],
          updateUnitPriceErrors: [],

        };
    },
    methods: {
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
                            this.listStock();
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
        updateStock () {
            this.$api.put('/api/v1/stock', this.updateForm).then(response => {
                if (response.status == 201) {
                    this.updateForm.stock = '';
                    this.updateForm.price = 0;

                    this.updateCompanyNameErrors = [];
                    this.updateUnitPriceErrors = [];

                    this.listStock()
                    this.$toastr.success(response.data.message);
                    return true;
                } else {
                    let error = response.data.message;
                    if ( typeof error === 'object' && error !== null){
                        if (error.hasOwnProperty('stock')) {
                            this.updateCompanyNameErrors = error.stock;
                        }
                        if (error.hasOwnProperty('price')) {
                            this.updateUnitPriceErrors = error.price;
                        }
                    }
                    else {
                        this.$toastr.error(response.data.message);
                    }
                    return false;
                }
            })
        },
        addStock () {
            this.$api.post('/api/v1/stock', this.form).then(response => {
                if (response.status == 201) {
                    this.form.company_name = '';
                    this.form.price = 0;

                    this.companyNameErrors = [];
                    this.unitPriceErrors = [];

                    this.listStock()
                    this.$toastr.success(response.data.message);
                    return true;
                } else {
                    let error = response.data.message;
                    if ( typeof error === 'object' && error !== null){
                        if (error.hasOwnProperty('company_name')) {
                            this.companyNameErrors = error.company_name;
                        }
                        if (error.hasOwnProperty('price')) {
                            this.unitPriceErrors = error.price;
                        }
                    }
                    else {
                        this.$toastr.error(response.data.message);
                    }
                    return false;
                }
            })
        }
    },
    mounted() {
        this.listStock()
    },
  components: { Sidebar, Navbar }
}
</script>