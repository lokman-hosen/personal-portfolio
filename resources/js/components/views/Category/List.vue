<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table 55</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa fa-plus"></i> Add New</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>
                                <span v-if="category.status" class="badge bg-success">Approved</span>
                                <span v-else class="badge bg-danger">Pending</span>
                            </td>
                            <td>Action</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form @submit.prevent="saveCategory">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="categoryname" class="form-label">Name</label>
                                <input type="text" id="categoryname" class="form-control" name="name" v-model="form.name" placeholder="Enter Category Name">
                                <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" :disabled="form.busy">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <!-- /.card -->
        </div>
</template>

<script>
import axios from "axios"
import Form from 'vform'

export default {
    name: "List",
    data(){
        return {
            form: new Form({
                name: '',
            }),

            categories: [],
        }
    },
    methods: {
        loadPostCategory(){
            axios.get('api/category')
            .then(response => {
                this.categories = response.data.data;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },
       /* saveCategory () {
            // Submit the form via a POST request
            this.form.post('api/category')
                .then(({ data }) => { console.log(data) })
        },*/

        async saveCategory(){
            //const response = await this.form.post('api/category')
            const response = this.form.post('api/category')
            if (this.form.successful){
                this.form.reset();
                //$('#createModal').mo
                //$('#createModal').modal().hide();

            }
            console.log('My Message'+ this.form.successful)
            console.log(response)

        }
    },

    created() {
        this.loadPostCategory()
    },

}


</script>

<style scoped>

</style>
