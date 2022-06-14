<template>
    <form @submit.prevent="submit">
        <div class="w-full">
            <div class="header-login">BNB Bank</div>
        </div>

        <div class="flex flex-col p-8 space-y-4">
            <input type="text" class="input-rounded" placeholder="name" v-model="form.name"/>
            <input type="email" class="input-rounded" placeholder="email" v-model="form.email"/>
            <input type="text" class="input-rounded" placeholder="username" v-model="form.username"/>
            <input type="password" class="input-rounded" placeholder="password" v-model="form.password"/>
            <input type="password" class="input-rounded" placeholder="password confirmation" v-model="form.password_confirmation"/>
        </div>

        <div class="my-2 mx-8">
            <button class="button">SIGN UP</button>
        </div>

        <div class="flex justify-center mt-12">
            <span class="w-1/12 h-1 bg-blue-100 rounded-full"></span>
        </div>

        <div class="link-login">
            <router-link to="/auth/login">Already have an account?</router-link>
        </div>
    </form>
</template>

<script lang="ts">
import axios from "../services/axios";

import {defineComponent} from 'vue'

type CustomerRegister = {
    name: string;
    email: string;
    username: string;
    password: string;
    password_confirmation: string;
}

export default defineComponent({
    data() {
        return {
            form: <CustomerRegister>{
                name: '',
                email: '',
                username: '',
                password: '',
                password_confirmation: '',
            }
        }
    },

    methods: {
        submit() {
            axios.post('/auth/register', this.form)
                .then((response) => {
                    console.log(response);
                });
        }
    }
});
</script>
