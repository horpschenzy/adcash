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
                                            <h3 class="font-weight-bold mb-0">350,897</h3>
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
                                            <h3 class="font-weight-bold mb-0">350,897</h3>
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
                                            <h3 class="font-weight-bold mb-0">350,897</h3>
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
                                                        <a class="dropdown-item" href="#">View stocks</a>
                                                    </div>
                                                </div>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                                <a href="#" class="btn btn-block btn-light">View all</a>
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
                                <a href="#" class="btn btn-block btn-light">View all</a>
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
          title: "Dashboard"
        };
    },
  components: { Sidebar, Navbar }
}
</script>