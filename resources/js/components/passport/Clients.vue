<template>
    <div>
        <div class="card p-3">
            <div class="card-heading">
                <div class="d-flex justify-content-between align-items-center">
                    <span> OAuth Clients </span>

                    <a class="btn btn-primary" @click="showCreateClientForm">
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
                    class="table table-striped table-bordered"
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
                                    class="btn btn-primary"
                                    @click="edit(client)"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td style="vertical-align: middle">
                                <a
                                    class="btn btn-danger"
                                    @click="destroy(client)"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Client Modal -->
        <div
            class="modal fade"
            id="modal-create-client"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create Client</h4>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div
                            class="alert alert-danger"
                            v-if="createForm.errors.length > 0"
                        >
                            <p>
                                <strong>Whoops!</strong> Something went wrong!
                            </p>
                            <br />
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label"
                                    >Name</label
                                >

                                <div class="col-md-12">
                                    <input
                                        id="create-client-name"
                                        type="text"
                                        class="form-control"
                                        @keyup.enter="store"
                                        v-model="createForm.name"
                                    />

                                    <span class="help-block">
                                        Something your users will recognize and
                                        trust.
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group">
                                <label class="col-md-3 control-label"
                                    >Redirect URL</label
                                >

                                <div class="col-md-12">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="redirect"
                                        @keyup.enter="store"
                                        v-model="createForm.redirect"
                                    />

                                    <span class="help-block">
                                        Your application's authorization
                                        callback URL.
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>

                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="store"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Client Modal -->
        <div
            class="modal fade"
            id="modal-edit-client"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Client</h4>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div
                            class="alert alert-danger"
                            v-if="editForm.errors.length > 0"
                        >
                            <p>
                                <strong>Whoops!</strong> Something went wrong!
                            </p>
                            <br />
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label"
                                    >Name</label
                                >

                                <div class="col-md-12">
                                    <input
                                        id="edit-client-name"
                                        type="text"
                                        class="form-control"
                                        @keyup.enter="update"
                                        v-model="editForm.name"
                                    />

                                    <span class="help-block">
                                        Something your users will recognize and
                                        trust.
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group">
                                <label class="col-md-3 control-label"
                                    >Redirect URL</label
                                >

                                <div class="col-md-12">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="redirect"
                                        @keyup.enter="update"
                                        v-model="editForm.redirect"
                                    />

                                    <span class="help-block">
                                        Your application's authorization
                                        callback URL.
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cerrar
                        </button>

                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="update"
                        >
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from "bootstrap";
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
        this.modalCreate = new Modal(
            document.getElementById("modal-create-client")
        );
        this.modalEdit = new Modal(
            document.getElementById("modal-edit-client")
        );
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
         * Show the form for creating new clients.
         */
        showCreateClientForm() {
            this.modalCreate.show();
        },

        /**
         * Create a new OAuth client for the user.
         */
        store() {
            this.persistClient(
                "post",
                "/oauth/clients",
                this.createForm,
                "#modal-create-client"
            );
        },

        /**
         * Edit the given client.
         */
        edit(client) {
            this.editForm.id = client.id;
            this.editForm.name = client.name;
            this.editForm.redirect = client.redirect;
            this.modalEdit.show();
        },

        /**
         * Update the client being edited.
         */
        update() {
            this.persistClient(
                "put",
                "/oauth/clients/" + this.editForm.id,
                this.editForm,
                "#modal-edit-client"
            );
        },

        /**
         * Persist the client to storage using the given form.
         */
        persistClient(method, uri, form, modal) {
            form.errors = [];

            axios[method](uri, form)
                .then((response) => {
                    this.getClients();

                    form.name = "";
                    form.redirect = "";
                    form.errors = [];

                    if (modal == "#modal-edit-client") {
                        this.modalEdit.hide();
                    } else {
                        this.modalCreate.hide();
                    }
                })
                .catch((error) => {
                    console.log(error.response.data);
                    if (typeof error.response.data === "object") {
                        // form.errors = _.flatten(_.toArray(error.response.data));
                        form.errors = [
                            "Something went wrong. Please try again",
                        ];
                    } else {
                        form.errors = [
                            "Something went wrong. Please try again.",
                        ];
                    }
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
