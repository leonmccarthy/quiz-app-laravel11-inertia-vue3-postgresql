<script setup>
    import Layout from '@/Shared/Layout.vue';
    import NewQuestionModel from '@/Shared/NewQuestionModel.vue';
    import { ref } from 'vue';


    let showNewQuestionModal = ref(false);

    const createQuestion = ()=>{
        showNewQuestionModal.value=true;
    };

    const destroyModal = ()=>{
        showNewQuestionModal.value=false;
    };

    const createdQuestion = ref(null);

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
                <template #body>
                    <form>
                        <div class="mb-3">
                            <label for="question" class="form-label">Email address</label>
                            <input type="text" v-model="createdQuestion"class="form-control" id="question" aria-describedby="questionHelp">
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td><input type="text" class="form-control" id="question" aria-describedby="questionHelp"></td>
                                    <td><input type="radio" class="form-check-input"  id="correct"></td>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                </template>
                <template #footer>
                    <span class="mx-1"><h3>+</h3></span>
                    <button class="btn btn-danger mx-1" @click="destroyModal">Close</button>
                    <button class="btn btn-success mx-1">Submit</button>
                </template>
            </NewQuestionModel>
        </Teleport>
    </Layout>
</template>