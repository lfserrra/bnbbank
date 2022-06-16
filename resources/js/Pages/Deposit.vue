<template>
    <div>
        <div class="header relative header-light">
            <MenuButton class="absolute top-0 left-0"/>

            <span class="header-title">Check Deposit</span>

            <div class="header-info">
                <CurrentBalance />
            </div>
        </div>

        <form @submit.prevent="submit" class="pb-20">
            <div class="px-5">
                <div class="input-group-icon">
                    <label>
                        <div>
                            <Icon :icon="{ name: 'money', size: 6}"/>
                            AMOUNT
                        </div>

                        <input type="text" v-model="form.amount" placeholder="0.00">

                        <small>* The money will be deposited in your account once the check is accepted.</small>
                    </label>

                    <span class="input-group-append">USD</span>
                </div>

                <div class="input-group-icon">
                    <label>
                        <div>
                            <Icon :icon="{ name: 'star'}"/>
                            DESCRIPTION
                        </div>

                        <input type="text" v-model="form.description">
                    </label>
                </div>

                <div class="card-upload" v-if="!fileUpload.showPreview">
                    <Icon :icon="{ name: 'image', size: 12}"/>

                    <span>Upload check picture</span>

                    <input type="file" ref="file" class="file" accept="image/*" @change="handleFileUpload()"/>
                </div>

                <img v-else :src="fileUpload.imagePreview" class="upload-preview">

                <button type="button" v-if="fileUpload.file" class="button-link" @click.prevent="resetImage">
                    <Icon :icon="{ name: 'close', size: 4}"/>
                    Reset image
                </button>
            </div>

            <div class="footer">
                <button class="button">DEPOSIT CHECK</button>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import MenuButton from "../components/MenuButton.vue";
import {formatValue} from "../utils/formarValue";
import Icon from "../components/Icon.vue";
import CurrentBalance from "../components/CurrentBalance.vue";

type DepositType = {
    amount: number | null;
    description: string;
}

type DepositFileType = {
    file: File | null;
    showPreview: boolean;
    imagePreview: string | ArrayBuffer | null;
}

export default defineComponent({
    components: {CurrentBalance, Icon, MenuButton},

    data() {
        return {
            form: <DepositType>{
                amount: null,
                description: ''
            },

            fileUpload: <DepositFileType>{
                file: null,
                showPreview: false,
                imagePreview: null
            }
        }
    },

    methods: {
        submit(): void {
            this.$router.push('/deposit-completed');
        },

        handleFileUpload(): void {
            const ref = (this.$refs['file'] as HTMLInputElement);

            if (ref.files != null) {
                this.fileUpload.file = ref.files[0];

                const reader = new FileReader();

                reader.onload = (event: ProgressEvent<FileReader>) => {
                    if (event.target != null) {
                        this.fileUpload.showPreview = true;
                        this.fileUpload.imagePreview = event.target.result;
                    }
                };

                reader.readAsDataURL(this.fileUpload.file);
            } else {
                this.fileUpload.file = null;
                this.fileUpload.showPreview = false;
                this.fileUpload.imagePreview = null;
            }
        },

        resetImage(): void {
            this.fileUpload.file = null;
            this.fileUpload.showPreview = false;
            this.fileUpload.imagePreview = null;
        },

        formatValue
    }
})
</script>
