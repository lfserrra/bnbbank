<template>
    <div>
        <div class="header relative header-light">
            <MenuButton class="absolute top-0 left-0"/>

            <span class="header-title">Check Deposited</span>

            <div class="header-info">
                <CurrentBalance />
            </div>
        </div>

        <div class="pb-20 info-list px-5">
            <DetailListItem title="Amount" value="0,00 USD" observation="* The money will be deposited in your account once the check is accepted.">
                <Icon :icon="{ name: 'money', size: 6}"/>
            </DetailListItem>

            <DetailListItem title="DESCRIPTION" value="Gits's">
                <Icon :icon="{ name: 'star', size: 6}"/>
            </DetailListItem>

            <img src="https://spaces.arenavirtual.net/0001/noticias/preco-do-campeao1655132046.jpg" class="upload-preview">
        </div>

        <div class="footer">
            <button class="button">GO HOME</button>
        </div>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import MenuButton from "../components/MenuButton.vue";
import {formatValue} from "../utils/formarValue";
import DetailListItem from "../components/DetailListItem.vue";
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
    components: {CurrentBalance, Icon, DetailListItem, MenuButton},

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
