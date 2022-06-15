<template>
    <div>
        <div class="header relative header-light">
            <MenuButton class="absolute top-0 left-0"/>

            <span class="header-title">Check Deposited</span>

            <div class="header-info">
                <div>
                    <span class="header-info-title">Current balance</span>
                    <span class="header-info-value">{{ formatValue(6320) }}</span>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit" class="pt-5 pb-20">
            <div class="input-group-icon px-5">
                <label>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        AMOUNT
                    </div>

                    <input type="text" v-model="form.amount" placeholder="0.00" readonly>

                    <small>* The money will be deposited in your account once the check is accepted.</small>
                </label>

                <span class="input-group-append">USD</span>
            </div>

            <div class="input-group-icon px-5">
                <label>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        DESCRIPTION
                    </div>

                    <input type="text" v-model="form.description" readonly>
                </label>
            </div>

            <div class="p-5">
                <img src="fileUpload.imagePreview" class="upload-preview">
            </div>

            <div class="absolute bottom-0 p-5 w-full">
                <button class="button">GO HOME</button>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import MenuButton from "../components/MenuButton.vue";
import {formatValue} from "../utils/formarValue";

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
    components: {MenuButton},

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
            this.$router.push('/');
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
