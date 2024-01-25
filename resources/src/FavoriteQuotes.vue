<template>
    <Menu />
    <div class="container">
        <h2 class="m-3">Mis citas favoritas</h2>
        <div v-if="showSuccessMessage" class="m-4 alert alert-success" role="alert">
            {{ msg }}
        </div>
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
                <tr v-for="(quote, index) in displayedQuotes" :key="index">
                    <td>{{ quote.id }}</td>
                    <td>{{ quote.quote }}</td>
                    <td>{{ quote.author }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" @click="deleteQuote(quote.id)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
  
<script>
import Menu from "./general/Menu.vue"

export default {
    data() {
        return {
            access_token: `Bearer ${this.$store.state.access_token}`,
            msg: "",
            displayedQuotes: null,
            showSuccessMessage: null,
            quotesu: null,
        };
    },
    components: {
        Menu,
    },

    created() {
        this.getQuotes();
    },
    
    methods: {
        async getQuotes() {
            this.submitted = true;
            try {
                this.processing = true;
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.get('/api/quotes', config);
                const status = data.status;
                if (status === true) {
                    this.displayedQuotes = data.data;
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
                    this.showSuccessMessage = true;
                    setTimeout(() => {
                        this.showSuccessMessage = false;
                    }, 5000);
                } else {
                    console.error('Error al eliminar la cita.');
                }
            } catch (error) {
                console.error('Error en la solicitud de eliminación', error);
            }
        },
    }
};
</script>
  