<script setup>
    import Layout from "../Shared/Layout.vue";
    import { computed, ref } from "vue";

    const props = defineProps({
        questions: Object
    });
    const currentIndex = ref(0);
    const currentQuestion = computed(()=>{
        return props.questions[currentIndex.value];
    });
    const answers = computed(()=>{
        return props.questions[currentIndex.value].answers;
    });
</script>

<template>
    <Layout>
        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                    <h6 class="mb-0">{{ currentQuestion.question }}</h6>
                    </div>
                </div>
                </a>
                <a  v-for="(answer, index) in answers" href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                    <p class="mb-0 opacity-75">{{ answer.answers }}</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </Layout>
</template>