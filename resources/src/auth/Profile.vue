<!-- Profile.vue -->
<template>
    <Menu />
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6">

                <h3 class="text-center">Perfil de usuario</h3>
                <div v-if="showSuccessMessage" class="alert alert-success" role="alert">
                    ¡Perfil actualizado con éxito!
                </div>
                <form @submit.prevent="onUpdateProfile" class="p-4 border rounded">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input v-model="name" type="name" class="form-control" id="name" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input v-model="email" type="email" class="form-control" id="email" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input v-model="password" type="password" class="form-control" id="password" />
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
  
<script>
import Menu from '../general/Menu.vue';
import axios from 'axios';

export default {
    data() {
        return {
            access_token: `Bearer ${this.$store.state.access_token}`,
            email: '',
            password: '',
            name: '',
            submitted: false,
            processing: false,
            errorMsg: '',
            showSuccessMessage: false,
        };
    },
    components: {
        Menu,
    },
    methods: {
        async onUpdateProfile() {
            this.submitted = true;

            try {
                const requestData = {
                    id: this.$store.state.user.id,
                    email: this.email,
                    password: this.password,
                    name: this.name,
                };
                console.log(requestData)
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const response = await axios.post('/api/update-profile', requestData, config);

                if (response.data.status === true) {
                    console.log(response.data);
                    this.$store.commit('setUser', response.data.user);
                    this.$router.push({ path: '/profile' });
                    this.showSuccessMessage = true;

                    setTimeout(() => {
                        this.showSuccessMessage = false;
                    }, 3000);
                } else {
                    this.errorMsg = response.data.message || 'Error al actualizar el perfil';
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.processing = false;
            }
        },
    },

    mounted() {
        const user = this.$store.state.user;
        if (user) {
            this.name = user.name || '';
            this.email = user.email || '';
        }
    },
};
</script>
  