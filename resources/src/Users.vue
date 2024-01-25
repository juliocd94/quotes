<template>
    <Menu />
    <div class="container">
        <h2 class="m-3">Usuarios</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Bloqueado</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="index">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.banning === 1 ? 'SI' : 'NO' }}</td>
                    <td>
                        <button v-if="user.banning === 0" class="btn btn-sm btn-danger "
                            @click="blockUser(user.id)">bloquear</button>
                        <button v-if="user.banning === 1" class="btn btn-sm btn-success "
                            @click="unblockUser(user.id)">Desbloquear</button>
                        <button class="btn btn-sm btn-info " @click="openModerationModal(user.id)" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">Moderar
                            favoritos</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="staticBackdropLabel">Favoritos del usuario {{ selectedUserId }}
                        </h5>
                        <button @click="closeModerationModal" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Quote</th>
                                    <th>Author</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(quote, index) in favorites" :key="index">
                                    <td>{{ quote.id }}</td>
                                    <td>{{ quote.quote }}</td>
                                    <td>{{ quote.author }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"
                                            @click="deleteQuote(quote.id)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
  
<script>
import Menu from "./general/Menu.vue"

export default {
    data() {
        return {
            access_token: `Bearer ${this.$store.state.access_token}`,
            selectedUserId: null,
            showModerationModal: false,
            favorites: [],
            msg: "",
            users: null,
            quotesu: null,
        };
    },
    components: {
        Menu,
    },
    computed: {

    },

    mounted() {
        this.getUsers();
        this.user();
    },
    methods: {
        user() {
            const loggedInUser = this.$store.state.user;

            if (loggedInUser && loggedInUser.admin) {
                return loggedInUser;
            } else {
                this.$router.push('/');
                return null;
            }
        },

        async getQuotes() {
            try {
                this.processing = true;
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.get(`/api/quotes-user/${this.selectedUserId}`, config);
                const status = data.status;
                if (status === true) {
                    this.favorites = data.data;
                    console.log(data)
                } else {
                    console.error('Error al actualizar el perfil');
                }
            } catch (error) {
                console.error("failed at onUpdateProfile", { error });
            } finally {
                this.processing = false;
            }
        },

        async deleteQuote(id) {
            try {
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.delete(`/api/delete-quote/${id}`, config);
                const status = data.status;

                if (status === true) {
                    this.getQuotes();
                    this.msg = data.message;
                } else {
                    console.error('Error al eliminar la cita.');
                }
            } catch (error) {
                console.error('Error en la solicitud de eliminación', error);
            }
        },

        openModerationModal(userId) {
            this.selectedUserId = userId;
            this.getQuotes();
            this.showModerationModal = true;
        },

        closeModerationModal() {
            this.selectedUserId = null;
            this.favorites = [];
            this.showModerationModal = false;
        },

        async blockUser(userId) {
            try {
                this.processing = true;
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.get(`/api/block-user/${userId}`, config);
                const status = data.status;
                console.log(data);

                if (status === true) {
                    this.getUsers();
                } else {
                    console.error('Error al bloquear al usuario');
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.processing = false;
            }
        },

        async unblockUser(userId) {
            try {
                this.processing = true;
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.get(`/api/unblock-user/${userId}`, config);
                const status = data.status;
                console.log(data);

                if (status === true) {
                    this.getUsers();
                } else {
                    console.error('Error al bloquear al usuario');
                }
            } catch (error) {
                console.error(error);
            } finally {
                this.processing = false;
            }
        },

        async getUsers() {
            try {
                this.processing = true;
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.get(`/api/users`, config);
                const status = data.status;
                if (status === true) {
                    this.users = data.data;
                    console.log(this.users);
                } else {
                    console.error('Error al obtener los usuarios');
                }
            } catch (error) {
                console.error(error);
            } finally {
                this.processing = false;
            }
        },
    }
};
</script>
  