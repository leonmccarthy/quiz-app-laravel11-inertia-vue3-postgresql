<script setup>
    import Layout from '@/Shared/Layout.vue';
    import QuestionModal from '@/Shared/QuestionModal.vue';
    import { ref , computed } from 'vue';
    import { router , usePage } from '@inertiajs/vue3';
        
    let showNewQuestionModal = ref(false);
    const createdQuestion = ref(null);
    const newAnswers = ref([]);
    const selectedAnswer = ref(null);
    let answerId  = 1;
    const page = usePage();
    const success = computed(()=>page.props.flash.success);
    let showViewQuestionModal = ref(false);
    const selectedQuestion = ref(null);
    const answers = ref([]);
    const selectedEditAnswer = ref(null);
    let showEditQuestionModal = ref(false);
    const questionForEdit = ref(null);

    const createQuestion = ()=>{
        showNewQuestionModal.value=true;
    };

    const destroyModal = ()=>{
        showNewQuestionModal.value=false;
        showViewQuestionModal.value=false;
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

        // SEND CREATE QUESTION DATA TO BACKEND 
        router.post('/questions', {
            question: createdQuestion.value,
            answers: newAnswers.value
        })

        // IF EVERYTHING IS SUCCESSFUL
        router.on('success',()=>{
            createdQuestion.value = null;
            newAnswers.value = []
        })
    }

    // ASSIGN PROPS TO FRONTEND FROM BACKEND
    const props = defineProps({
        questions: Object,
        errors: Object
    });

    const viewQuestion = (index)=>{
        showViewQuestionModal.value = true;
        selectedQuestion.value = props.questions[index].question;
        answers.value = props.questions[index].answers;
    };

    // HANDLE RADIO CHANGE
    const handleRadioChange = (id)=>{
        selectedEditAnswer.value = id;

        answers.value.forEach((answer)=>{
            if(answer.id===id){
                answer.correct_answer = true;
            }else{
                answer.correct_answer = false;
            }
        })
    }

    // SAVE UPDATED ANSWERS TO DATABASE
    const updateAnswers = ()=>{
        router.put('/answers', answers.value);
    };

    // EDIT QUESTION
    const editQuestion = (index)=>{
        questionForEdit.value = props.questions[index];
        // alert(index)
    };

    // UPDATE QUESTION TO DATABASE
    const updateQuestion = ()=>{
        router.put('/question', questionForEdit.value);
    };

    // DELETE QUESTION
    const deleteQuestion = (id) =>{
        router.on('before', ()=>{
            return confirm('Are you sure you want to delete?');
        });

        router.delete('/questions/'+id);
    };

</script>
<template>
    <Layout>
        <button @click="createQuestion" class="btn btn-success">Create</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Question</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(question, index) in questions">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ question.question }}</td>
                    <td>
                        <button class="btn btn-outline-success mx-1" @click="viewQuestion(index)">View</button>
                        <button class="btn btn-outline-primary mx-1" @click="showEditQuestionModal=true, editQuestion(index)">Edit</button>
                        <button class="btn btn-outline-danger mx-1" @click="deleteQuestion(question.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <Teleport to="body">

            <!-- CREATE QUESTION AND ANSWERS MODAL -->

            <QuestionModal :show="showNewQuestionModal" @close="destroyModal">
                <template #header>
                    <h5>Add New Question</h5>
                </template>
                <template #success>
                    <div v-if="success" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            </QuestionModal>

            <!-- VIEW QUESTIONS AND EDIT ANSWERS -->

            <QuestionModal :show="showViewQuestionModal" @close="destroyModal">
                <template #header>
                    <h5>View Question/Answers</h5>
                </template>
                <template #success>
                    <div v-if="success" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </template>
                <template #body>
                    <p><strong>Q. {{ selectedQuestion }}</strong></p>
                    <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Answers</th>
                                    <th scope="col">Correct ?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(answer, index) in answers">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td><input v-model="answer.answers" type="text" class="form-control" id="answer" aria-describedby="answerHelp"  required></td>
                                    <td><input :checked="answer.correct_answer===true" :value="answer.id" @change="handleRadioChange(answer.id)" type="radio" class="form-check-input"  id="correct"></td>
                                </tr>
                            </tbody>
                        </table>
                </template>
                <template #footer>
                    <button class="btn btn-danger mx-1" @click="destroyModal">Close</button>
                    <button v-if="answers.length>3" class="btn btn-success mx-1" @click="updateAnswers">Update</button>
                </template>
            </QuestionModal>

            <!-- FOR VIEWING AND EDITING QUESTION -->
             <QuestionModal :show="showEditQuestionModal">

                <template #header>
                    <h5>Edit Question</h5>
                </template>

                <template #success>
                    <div v-if="success" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </template>

                <template #body>
                    <div class="mb-3">
                        <label for="editQuestion" class="form-label">Question</label>
                        <input v-model="questionForEdit.question" type="text" class="form-control" id="editQuestion" placeholder="Edit Question">
                    </div>
                </template>

                <template #footer>
                    <button class="btn btn-danger mx-1" @click="showEditQuestionModal=false">Close</button>
                    <button class="btn btn-success mx-1" @click="updateQuestion">Update</button>
                </template>

             </QuestionModal>
        </Teleport>
    </Layout>
</template>