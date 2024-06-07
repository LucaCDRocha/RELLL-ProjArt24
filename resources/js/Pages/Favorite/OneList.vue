<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
import TheNav from "@/Components/TheNav.vue";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import BaseCard from "@/Components/BaseCard.vue";
import BaseBottomSheet from "@/Components/BaseBottomSheet.vue";
import AppTrailInfo from "@/Components/AppTrailInfo.vue";
import TheHeader from "@/Components/TheHeader.vue";

const items = defineProps({
    trailsList: {
        type: Array,
        default: () => [],
    },
    listDetails: {
        type: Object,
        default: () => [],
    }
});
const form = useForm({ 
    id : items.listDetails.id
});
const submit = () => {
    form.get(route('bookmark.edit', { id: items.listDetails.id }), {});
};

const isOpen = ref(false);

const data = ref({});

const BottomSheet = (e) => {
        fetch(route("trails.showJson", e.id))
            .then((response) => response.json())
            .then((datas) => {
                data.value = datas;
                isOpen.value = true;
            });
    };

const closeBottomSheet = () => {
    isOpen.value = false;
};

</script>
<template>
    <Head :title="listDetails.name" />

    <TheHeader/>

    <div class="oneList">
        
      <div class="title">
<h2>{{ listDetails.name }}</h2>
    <!-- <Link :href="route('bookmark.index')"
        class="underline text-sm font-medium text-onSurface dark:text-onSurface hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800">
    Retour
    </Link> -->
    <SecondaryButton @click="submit" class="ms-4" icon="edit">
                    Modifier
    </SecondaryButton>

    
</div>
    <div class="trailsList">
        <BaseCard v-for="trail in trailsList" :key="trail.id" :data="trail" @click="BottomSheet(trail)"></BaseCard>
    </div> 


</div>

        <BaseBottomSheet
        v-if="isOpen"
        :isOpen="isOpen"
        @handle-close="closeBottomSheet()"
    >
        <AppTrailInfo
            :data="data"
            @handle-close="closeBottomSheet()"
            @handle-point="BottomSheet($event)"
        />
    </BaseBottomSheet>
    <TheNav />
</template>

<style scoped>
.oneList {
    padding: 1rem 1rem 0rem 1rem;
}

.title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.25rem;
    margin-bottom: 2.25rem;
}

div.trailsList {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    column-gap: 1.25rem;
}
</style>
