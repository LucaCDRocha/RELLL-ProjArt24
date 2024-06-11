<script setup>
import { onMounted, ref } from "vue";
import { getTimeDifference } from "@/Helpers/timeHelper.js";
import AppStarRanking from "@/Components/AppStarRanking.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    data: {
        type: Object,
        default: () => {},
    },
});

console.log(props.data);
const likes = ref(props.data.comment ? props.data.comment.likes.length : 0);
const user = usePage().props.auth.user;
const hasUserLiked = ref(
    props.data.comment
        ? props.data.comment.likes.find((like) => like.user_id === user?.id)
        : false
);

const like = (commentId) => {
    if (!user) return;

    fetch(`/api/likecomment/${commentId}/${user.id}`)
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            likes.value = data.likes;
            hasUserLiked.value = !hasUserLiked.value;
        });
};
</script>

<template>
    <div class="container">
        <div class="action">
            <div class="header">
                <p>{{ data.user.name }}</p>
                <div class="stars">
                    <AppStarRanking :rating="`${data.ranking.note}`" />
                    <small>
                        Il y a
                        {{ getTimeDifference(data.ranking.created_at) }}
                    </small>
                </div>
            </div>
            <SecondaryButton
                v-if="data.comment !== null"
                @click="like(data.comment.id)"
                class="like"
                :class="{ active: hasUserLiked }"
                icon="thumb_up"
                >{{ likes }}</SecondaryButton
            >
        </div>
        <p v-if="data.comment !== null">{{ data.comment.text }}</p>
    </div>
</template>

<style scoped>
.stars {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.action {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
}

.header p {
    @apply text-xl;
}

.container {
    @apply bg-surfaceVariant dark:bg-darkSurfaceVariant;

    display: flex;
    flex-direction: column;
    padding: 1rem;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 0.5rem;

    border-radius: 0.75rem;
}

.like.active :deep(.material-symbols-rounded) {
    font-variation-settings: "FILL" 1;
}
</style>
