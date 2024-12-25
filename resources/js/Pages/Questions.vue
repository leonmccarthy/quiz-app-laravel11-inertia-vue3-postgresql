<script setup>
    import Layout from '@/Shared/Layout.vue';
    import NewQuestionModel from '@/Shared/NewQuestionModel.vue';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import { usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    let showNewQuestionModal = ref(false);
    const createdQuestion = ref(null);
    const newAnswers = ref([]);
    const selectedAnswer = ref(null);
    let answerId  = 1;
    const page = usePage();
    const success = computed(()=>page.props.flash.success);

    const createQuestion = ()=>{
        showNewQuestionModal.value=true;
    };

    const destroyModal = ()=>{
        showNewQuestionModal.value=false;
    };

    const addNewAnswer = ()=>{
        const newAnswer = {
            id: answerId++,
            answer: '',
            correct_answer: 0
        }
        newAnswers.value.push(newAnswer);
    };

    // HANDLING SELECTING CORRECT ANSWER
    const handleRadioToggle = (id)=>{
        selectedAnswer.value = id;
        newAnswers.value.forEach(answer=>{
            if(answer.id === id){
                answer.correct_answer = 1;
            }else{
                answer.correct_answer = 0;
            }
        })
    }
    // VALIDATE ANSWERS
    const validateAnswer = ()=>{
        for(const answer of newAnswers.value){
            if(answer.answer.trim()===''){
                return false;
            }
        }
        return true;
    }

    // COUNT ANSWERS
    const answerCount = ()=>{
        if(newAnswers.length<4){
            alert('Four answers are required to submit!')
        }else if(newAnswers.length===4){
            return true;
        }
        return false;
    }

    // SUBMIT QUESTION
    const submitQuestion = ()=>{
        if(!createdQuestion.value || createdQuestion.value==" "){
            alert("Question cannot be empty");
            return false;
        }

        if (!validateAnswer() && !answerCount()){
            alert("Fill all the inputs")
            return false;
        }

        console.log("Question ", createdQuestion.value);
        console.log("Answers ", newAnswers.value);

        router.post('/questions', {
            question: createdQuestion.value,
            answers: newAnswers.value
        })
    }

    

</script>
<template>
    <Layout>
        <button @click="createQuestion" class="btn btn-success">Create</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
            </tbody>
        </table>

        <Teleport to="body">
            <NewQuestionModel :show="showNewQuestionModal" @close="destroyModal">
                <template #header>
                    <h5>Add New Question</h5>
                </template>
                <template #success>
                    <div v-if="success" class="alert alert-success">
                        {{ success }}
                    </div>
                </template>
                <template #body>
                    <form>
                        <div class="mb-3">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" v-model="createdQuestion"class="form-control" id="question" aria-describedby="questionHelp" required>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Answers</th>
                                    <th scope="col">Correct ?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(answer, index) in newAnswers">
                                    <th scope="row">{{ answer.id }}</th>
                                    <td><input v-model="answer.answer" type="text" class="form-control" id="answer" aria-describedby="questionHelp" required></td>
                                    <td><input :checked="answer.correct_answer===1" :value="answer.id" @change="handleRadioToggle(answer.id)" type="radio" class="form-check-input"  id="correct"></td>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                </template>
                <template #footer>
                    <span v-if="newAnswers.length<4" class="btn btn-light mx-1" @click="addNewAnswer"><b>+</b></span>
                    <button class="btn btn-danger mx-1" @click="destroyModal">Close</button>
                    <button v-if="newAnswers.length>3" class="btn btn-success mx-1" @click="submitQuestion">Submit</button>
                </template>
            </NewQuestionModel>
        </Teleport>
    </Layout>
</template>