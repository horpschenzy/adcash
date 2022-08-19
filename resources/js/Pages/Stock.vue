<template>
  <div class="client">
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
                                            <h3 class="font-weight-bold mb-0">350,897</h3>
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
                                        <form>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Company name" aria-label="Company name" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text text-white bg-blue input-border" id="basic-addon2">€</span>
                                                <input type="text" class="form-control" placeholder="Unit price" aria-label="Unit price" aria-describedby="basic-addon1">
                                            </div>
                                            <button type="submit" class="btn btn-primary float-right">Add</button>
                                        </form>                                  
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <h5 class="card-header">Update Stock</h5>
                                    <div class="card-body">
                                        <form>
                                            <div class="input-group mb-3">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option value="">Choose stock</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text text-white bg-blue input-border" id="basic-addon2">€</span>
                                                <input type="text" class="form-control" placeholder="Unit price" aria-label="Unit price" aria-describedby="basic-addon1">
                                            </div>
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
                                          <tr>
                                            <th scope="row">17371705</th>
                                            <td>Volt Premium Bootstrap 5 Dashboard</td>
                                            <td>johndoe@gmail.com</td>
                                            <td>
                                                <div class="dropdown position-static actions d-inline-block">
                                                    <button class="btn btn-primary btn-md px-1 py-0 mt-1 rounded-circle" type="button"
                                                        id="table-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="table-action">
                                                        <a class="dropdown-item" href="#">Update unit price</a>
                                                        <a class="dropdown-item" href="#">Delete stock</a>
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
          title: "Stock"
        };
    },
  components: { Sidebar, Navbar }
}
</script>