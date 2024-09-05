<style scoped>
.action-link {
    cursor: pointer;
}

.m-b-none {
    margin-bottom: 0;
}
</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div
                            style="
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                            "
                        >
                            <span> OAuth Clients </span>

                            <a
                                class="action-link"
                                @click="showCreateClientForm"
                            >
                                Create New Client
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Current Clients -->
                        <p class="m-b-none" v-if="clients.length === 0">
                            You have not created any OAuth clients.
                        </p>
                        <table
                            class="table table-borderless m-b-none"
                            v-if="clients.length > 0"
                        >
                            <thead>
                                <tr>
                                    <th>Client ID</th>
                                    <th>Name</th>
                                    <th>Secret</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="client in clients">
                                    <!-- ID -->
                                    <td style="vertical-align: middle">
                                        {{ client.id }}
                                    </td>

                                    <!-- Name -->
                                    <td style="vertical-align: middle">
                                        {{ client.name }}
                                    </td>

                                    <!-- Secret -->
                                    <td style="vertical-align: middle">
                                        <code>{{ client.secret }}</code>
                                    </td>

                                    <!-- Edit Button -->
                                    <td style="vertical-align: middle">
                                        <a
                                            class="action-link"
                                            @click="edit(client)"
                                        >
                                            Edit
                                        </a>
                                    </td>

                                    <!-- Delete Button -->
                                    <td style="vertical-align: middle">
                                        <a
                                            class="action-link text-danger"
                                            @click="destroy(client)"
                                        >
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    /*
     * The component's data.
     */
    data() {
        return {
            clients: [],

            createForm: {
                errors: [],
                name: "",
                redirect: "",
            },

            editForm: {
                errors: [],
                name: "",
                redirect: "",
            },
        };
    },

    /**
     * Prepare the component (Vue 1.x).
     */
    ready() {
        this.prepareComponent();
    },

    /**
     * Prepare the component (Vue 2.x).
     */
    mounted() {
        this.prepareComponent();
    },

    methods: {
        /**
         * Prepare the component.
         */
        prepareComponent() {
            this.getClients();
        },

        /**
         * Get all of the OAuth clients for the user.
         */
        getClients() {
            axios.get("/oauth/clients").then((response) => {
                this.clients = response.data;
            });
        },

        /**
         * Destroy the given client.
         */
        destroy(client) {
            axios.delete("/oauth/clients/" + client.id).then((response) => {
                this.getClients();
            });
        },
    },
};
</script>
