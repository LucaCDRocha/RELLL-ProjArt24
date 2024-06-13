<script setup>
import { ref, computed } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import BaseTag from '@/Components/BaseTag.vue'
import BaseImgGalery from '@/Components/BaseImgGalery.vue'
import TheCardNav from '@/Components/TheCardNav.vue'
import AppCardList from '@/Components/AppCardList.vue'

const props = defineProps({
    data: {
        type: Object,
        default: () => {},
    },
    full: {
        type: Boolean,
        default: false,
    },
    isAllreadyAdded: {
        type: Boolean,
        default: false,
    },
})

const imgs = ref([])

for (const img of props.data.imgs) {
    if (img.img_path.includes('http')) imgs.value.push(img.img_path)
    else imgs.value.push(`${img.img_path}`)
}

const textButton = computed(() => {
    if (props.isAllreadyAdded) {
        return 'Lieu ajouté'
    } else {
        return 'Ajouter ce lieu'
    }
})

const emit = defineEmits(['handle-close', 'handle-point', 'add-point'])
</script>

<template>
    <div class="interest-point">
        <TheCardNav
            @handle-close="emit('handle-close')"
            :is-full="full"
            :interest-point-id="data.id"
        />
        <h1>{{ data.name }}</h1>
        <div class="ouvertures">
            <p>{{ data.open_seasons }}</p>
        </div>
        <div class="tags" v-if="!full">
            <BaseTag v-for="tag in data.tags" :key="tag.id" :tag="tag.name" />
        </div>

        <div class="button">
            <PrimaryButton
                @click.prevent="emit('add-point', { point: data })"
                >{{ textButton }}</PrimaryButton
            >
        </div>

        <BaseImgGalery :imgs="imgs" />

        <div class="description">
            <h2>Description</h2>
            <div class="tags">
                <BaseTag
                    v-for="tag in data.tags"
                    :key="tag.id"
                    :tag="tag.name"
                />
            </div>
            <p>{{ data.description }}</p>
        </div>
    </div>
</template>

<style scoped>
.interest-point {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
    width: 100%;
    height: fit-content;
}

.tags {
    display: flex;
    gap: 0.5rem;
}

.ouvertures {
    display: flex;
    justify-content: space-between;

    width: 100%;
    padding-right: 1rem;
}

.button {
    align-self: flex-end;
    padding-right: 1rem;
}

.description {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding-right: 1rem;
}
</style>
