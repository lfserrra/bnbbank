<template>
    <form @submit.prevent="submit">
        <div class="header-login">BNB Bank</div>

        <div class="flex flex-col p-8 space-y-4">
            <input type="text" class="input-rounded" placeholder="username" v-model="form.username"/>
            <input type="password" class="input-rounded" placeholder="password" v-model="form.password"/>
        </div>

        <div class="my-2 mx-8">
            <button class="button">SIGN UP</button>
        </div>

        <div class="flex justify-center mt-12">
            <span class="w-1/12 h-1 bg-blue-100 rounded-full"></span>
        </div>

        <div class="link-login">
            <router-link to="/auth/register">Back to register an account</router-link>
        </div>
    </form>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import axios from "../services/axios";

type Login = {
    username: string;
    password: string;
}

export default defineComponent({
    data() {
        return {
            form: <Login>{
                username: '',
                password: '',
            }
        }
    },

    methods: {
        submit() {
            this.$router.push('/');

            return;
            axios.post('/auth/login', this.form)
                .then((response) => {
                    console.log(response);
                });
        }
    }
});
</script>
