<template>
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-6">
        <h3 class="text-center">Iniciar sesión</h3>

        <div v-if="showSuccessMessage" class="m-4 alert alert-danger" role="alert">
          {{ msg }}
        </div>

        <form @submit.prevent="onLogin" class="p-4 border rounded">
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input v-model="email" type="email" class="form-control" id="email" required />
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input v-model="password" type="password" class="form-control" id="password" required />
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>
  
  
<script>
import axios from "axios";

export default {
  data() {
    return {
      msg: "",
      showSuccessMessage: false,
      email: "admin@example.com",
      password: "12345678",
    };
  },
  methods: {
    async onLogin() {
      this.submitted = true;
      try {
        this.processing = true;
        const { data } = await axios.post(
          '/api/login',
          {
            email: this.email,
            password: this.password
          }
        );
        const status = data.status;
        if (status == true) {
          this.$store.commit('setUser', data.user);
          this.$store.commit('setAccessToken', data.access_token);
          this.$router.push({
            path: "/"
          });
        } else {
          this.msg = data.message;
          this.showSuccessMessage = true;
          setTimeout(() => {
            this.showSuccessMessage = false;
          }, 3000);
        }
      } catch (error) {
        console.error("failed at onLogin", { error });
        localStorage.removeItem("user");
      } finally {
        this.processing = false;
      }
    }

  },
};
</script>
  
<style scoped>
</style>
  