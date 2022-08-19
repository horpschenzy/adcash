<template>
    <div class="login">
        <section class="vh-100">
        <div class="container py-5 h-50">
          <div class="row d-flex align-items-center justify-content-center h-50">
            <div class="col-md-8 col-lg-7 col-xl-6">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-t-7">
            <h2>Login</h2>
              <form @submit.prevent="submit" method="POST">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form1Example13">Email address</label>
                  <input type="email" id="form1Example13" class="form-control form-control-lg" v-model="form.email" required/>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form1Example23">Password</label>
                  <input type="password" id="form1Example23" class="form-control form-control-lg" v-model="form.password" required/>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
</template>

<script>
import axios from "axios";
export default {
  name: 'Login',
  data() {
    return {
        title: "Login",
        form: {
          'email' : '',
          'password': ''
        }
    }
  },

  methods: {
    submit () {
      // this.$toastr.s("SUCCESS MESSAGE", "Success Toast Title");
      axios.post('/api/v1/auth/login', this.form).then(response => {
        if (response.status == 200) {
          localStorage.removeItem('bearerToken');
          localStorage.removeItem('userData');

          localStorage.setItem('bearerToken', JSON.stringify(response.data.data.access_token));
          localStorage.setItem('userData', JSON.stringify(response.data.data));
          this.$toastr.success(response.data.message);
          window.location = '/dashboard';
        } else {
          this.$toastr.error(response.data.message);
          return false;
        }
      })
    }
  },
}
</script>