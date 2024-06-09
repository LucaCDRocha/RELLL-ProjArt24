<script setup>
import { onMounted } from 'vue';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    count: {
        type: Number,
    },
    checked: {
        type: Boolean,
        default: false,
    },
});

const form = defineModel({
    key: "form",
    default: [],
});

const toggleCheckbox = (event) => {
    const checkbox = event.currentTarget.querySelector(
        'input[type="checkbox"]'
    );
    checkbox.checked = !checkbox.checked;

    // Trigger the change event manually to update the v-model
    const changeEvent = new Event("change", { bubbles: true });
    checkbox.dispatchEvent(changeEvent);
};

const preventClickPropagation = (event) => {
    // Prevent the click event from bubbling up to the parent div
    event.stopPropagation();
};

onMounted(() => {
    if (props.checked) {
        form.value.push(props.id);
    }
});
</script>

<template>
    <div class="checkboxGroup" @click="toggleCheckbox">
        <div @click="preventClickPropagation">
            <input
                type="checkbox"
                :name="name"
                :value="id"
                :id="id"
                v-model="form"
            />
            <label :for="id">{{ name }}</label>
        </div>
        <p v-if="count" class="count">{{ count }}</p>
    </div>
</template>

<style scoped>
.checkboxGroup {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom-width: 1px;
    @apply border-b border-customGray dark:border-darkCustomGray;
    padding: 12px 5px;
    width: 100%;
    cursor: pointer;
}

input:focus {
    background-color: #ccc;
}

input {
    margin: 0.4rem;
}

input:target {
    @apply bg-error;
}

input:checked {
    @apply bg-onSurface dark:bg-darkOnSurface;
}

.checkboxGroup label {
    @apply text-base;
    margin-left: 0.5rem;
}

.count {
    @apply text-xs;
}
</style>
