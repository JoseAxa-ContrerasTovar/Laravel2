<template>
    <app-layout title="User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <Link class="btn btn-success inline-block" :href="route('user.create')"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 float-left"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4v16m8-8H4"
                                /></svg
                        > Crear usuario</Link>

                        <form method="get" class="flex mt-2" @submit.prevent="submit">
                            <jet-input v-model="form.name" class="w-full" placeholder="Buscar por nombre o email..." type="text" />
                            <button type="submit" class="ml-2 btn btn-primary">Buscar</button>
                        </form>

                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="p-3">Id</th>
                                    <th class="p-3">Nombre</th>
                                    <th class="p-3">Email</th>
                                    <th class="p-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="u in users.data" :key="u.id">
                                    <td class="p-3 border">{{ u.id }}</td>
                                    <td class="p-3 border">{{ u.name }}</td>
                                    <td class="p-3 border">{{ u.email }}</td>
                                    <td class="p-3 border">
                                        <Link
                                            class="btn btn-primary mr-2 inline-block"
                                            :href="
                                                route('user.show', {
                                                    customer: u,
                                                })
                                            "
                                            ><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                /></svg
                                        ></Link>
                                        <Link
                                            class="btn btn-primary mr-2 inline-block"
                                            :href="
                                                route('user.edit', {
                                                    customer: u,
                                                })
                                            "
                                            ><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                /></svg
                                        ></Link>
                                        <!-- <Link :href="route('user.destroy',{customer: u})" method="DELETE">Borrar</Link>    -->

                                        <button
                                            class="btn btn-danger align-top"
                                            @click="
                                                modalOpen = true;
                                                selectedUser = u;
                                            "
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <paginator class="mt-3" :paginator="users" />
                    </div>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="modalOpen">
            <template #title>
                <h1>Eliminar Usuario</h1>
            </template>
            <template v-slot:content>
                <p v-if="selectedUser">
                    ¿Seguro que quieres eliminar el usuario:
                    <strong> {{ selectedUser.email }} </strong> ?
                </p>
            </template>
            <template v-slot:footer>
                <jet-button
                    class="float-left bg-red-500 hover:bg-red-800"
                    @click="deleteUser()"
                >
                    Eliminar
                </jet-button>

                <jet-button @click="modalOpen = false"> Cerrar </jet-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import Paginator from "@/Components/Paginator"

export default defineComponent({
    props: {
        users:Object,
        name: String,
    },
    data() {
        return {
            modalOpen: false,
            selectedUser: Object,
            form: {
                name:this.name
            }
        };
    },
    components: {
        AppLayout,
        Link,
        JetDialogModal,
        JetButton,
        Paginator,
        JetInput,
    },
    methods: {
        submit: function () {
            Inertia.get(route("user.index",this.form))
        },
        deleteUser: function () {
            /*
            if(
                !confirm("¿Seguro que quieres aliminar el usuario: "+data.email+" ?")
            )
                return;
            */
            Inertia.delete(
                route("user.destroy", { customer: this.selectedUser })
            );

            this.modalOpen = false;
        },
    },
});
</script>
