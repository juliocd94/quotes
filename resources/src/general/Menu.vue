<template>
    <div v-if="user" class="">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">Citas</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/favorite-quotes" class="nav-link">Favoritas</router-link>
                        </li>
                        <li v-if="user.admin" class="nav-item">
                            <router-link to="/users" class="nav-link">Usuarios</router-link>
                        </li>
                        <li class="nav-item dropdown">
                            <a v-if="user" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link to="/profile" class="dropdown-item">Editar perfil</router-link>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" @click="logout">Salir</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
    
<script>
export default {
    data() {
        return {
        }
    },
    computed: {
        user() {
            if (this.$store.state.user) {
                return this.$store.state.user;
            } else {
                this.$router.push('/login');
            }
        },
    },

    methods: {
        logout() {
            this.$store.commit('clearUser');
            this.$store.commit('clearAccessToken');
            this.$router.push({
                path: "/login"
            });
        },
    },
};
</script>
    