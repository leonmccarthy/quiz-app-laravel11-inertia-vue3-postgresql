<script setup>
    import Layout from '@/Shared/Layout.vue';
    import NewQuestionModel from '@/Shared/NewQuestionModel.vue';
    import { ref } from 'vue';


    let showNewQuestionModal = ref(false);
    const createQuestion = ()=>{
        showNewQuestionModal.value=true;
    }
    const destroyModal = ()=>{
        showNewQuestionModal.value=false;
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

            </NewQuestionModel>
        </Teleport>
    </Layout>
</template>