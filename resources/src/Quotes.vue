<template>
    <Menu />
    <div class="container">
        <h2>Citas</h2>

        <div class="m-4">
            <button class="btn btn-sm btn-secondary" @click="refreshQuotes()">Refrescar listado de citas</button>
        </div>

        <div v-if="showSuccessMessage" class="m-4 alert alert-success" role="alert">
            {{ msg }}
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th col="1">ID</th>
                    <th col="4">Quote</th>
                    <th col="3">Author</th>
                    <th col="4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(quote, index) in displayedQuotes" :key="index">
                    <td>{{ quote.id }}</td>
                    <td>{{ quote.quote }}</td>
                    <td>{{ quote.author }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" @click="setFavorite(quote)">Marcar como favorita</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
  
<script>
import Menu from './general/Menu.vue'

export default {
    data() {
        return {
            access_token: `Bearer ${this.$store.state.access_token}`,
            showSuccessMessage: false,
            msg: "",
            displayedQuotes: null,
            quotesu: null,
            test: null,
            userId: null,
        };
    },
    components: {
        Menu,
    },

    created() {
        this.getQuotes();
        const user = this.$store.state.user;
        if (user) {
            this.userId = user.id
        }
    },

    methods: {
        async getQuotes() {
            try {
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.get( '/api/get-external-quotes', config );
                const status = data.status;
                if (status === true) {
                    this.displayedQuotes = data.data.quotes;
                } else {
                    this.errorMsg = data.message || 'Error al obtener las citas';
                }
            } catch (error) {
                console.error("failed at onUpdateProfile", { error });
            } finally {
                this.processing = false;
            }
        },


        async setFavorite(quote) {
            try {
                this.processing = true;
                const config = {
                    headers: { Authorization: this.access_token },
                };
                const { data } = await axios.post(
                    '/api/set-favorite',
                    {
                        quote: quote.quote,
                        author: quote.author,
                        userId: this.userId
                    },
                    config
                );
                const status = data.status;
                console.log(data)
                if (status === true) {
                    this.msg = data.message;
                    this.showSuccessMessage = true;
                    setTimeout(() => {
                        this.showSuccessMessage = false;
                    }, 5000);

                } else {
                    this.errorMsg = data.message || 'Error al actualizar el perfil';
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.processing = false;
            }
        },

        refreshQuotes() {
            this.getQuotes();
        },
    }
};
</script>
  