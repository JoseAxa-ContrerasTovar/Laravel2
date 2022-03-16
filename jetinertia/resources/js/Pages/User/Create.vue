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
                        <form @submit.prevent="submit">
                            
                            <div class="mt-4">                        
                                <jet-label value="Nombre:"/>
                                <jet-input-error :message="errors.name"/>
                                <jet-input class="mt-1 block w-full" type="text" v-model="form.name" />
                            </div>

                            <div class="mt-4">
                                <jet-label value="Email:"/>
                                <jet-input-error :message="errors.email"/>
                                <jet-input class="mt-1 block w-full" type="text" v-model="form.email" />
                            </div>

                            <div class="mt-4">
                                <jet-label value="Contraseña:"/>
                                <jet-input-error :message="errors.password"/>
                                <jet-input class="mt-1 block w-full" type="password" v-model="form.password" />
                            </div>

                            <jet-button class="mt-4" >Enviar</jet-button>
                            <Link class="mt-4 float-right cursor-pointer" href="#" @click="cleanForm" preserve-scroll>Limpiar</Link>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import JetInputError from "@/Jetstream/InputError";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: ["errors"],
    data() {
        return{
            form: {
                name: '',
                email: '',
                password: '',
            }
        }
    },
    components: {
    AppLayout,
    JetInputError,
    JetInput,
    JetLabel,
    JetButton,
    Link,
},
    methods: {
        submit(){
            Inertia.post(route('user.store'), this.form);
        },
        cleanForm: function(){
            this.form.name = "";
            this.form.email= "";
            this.form.password="";
        }
    }
});
</script>
