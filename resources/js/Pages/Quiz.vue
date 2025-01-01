<script setup>
    import Layout from "../Shared/Layout.vue";
    import { computed, ref } from "vue";
    import { router } from "@inertiajs/vue3";

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

    const totalQuestions = computed(()=>props.questions.length);
    const lastQuestion = computed(()=>currentIndex.value+1==totalQuestions.value);

    const selectedAnswer = ref(null);
    const result = ref(null);
    const selectedOption = (index)=>{
        selectedAnswer.value = index;
    }

    const nextQuestion = ()=>{
        if(selectedAnswer.value==null){
            alert('Please select an answer');
        }else{
            if(props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer==true){
                result.value++;
            }
            currentIndex.value++;
            selectedAnswer.value=null;            
        }
    }

    const calculateAnswer = ()=>{
        if(props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer==true){
                result.value++;
        }
        router.post('/results',[
            {
                results: {
                    'score': result.value,
                    'totalQuestions': totalQuestions.value
                }
            }
        ])
    }

</script>

<template>
    <Layout>
        <div class="d-flex justify-content-center">Question {{ currentIndex +1 }} out of {{ totalQuestions  }}</div>
        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
            <div class="list-group">
                <a  class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                    <h6 class="mb-0">{{ currentQuestion.question }}</h6>
                    </div>
                </div>
                </a>
                <a @click="selectedOption(index)"  v-for="(answer, index) in answers" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                    <p class="mb-0 opacity-75">{{ answer.answers }}</p>
                    </div>
                </div>
                </a>
                <div class="d-flex justify-content-around p-2">
                    <button @click="nextQuestion" v-if="!lastQuestion" class="btn btn-primary mx-1">Next</button>
                    <button @click="calculateAnswer" v-if="lastQuestion" class="btn btn-success mx-1">Submit</button>
                </div>
            </div>
        </div>
    </Layout>
</template>