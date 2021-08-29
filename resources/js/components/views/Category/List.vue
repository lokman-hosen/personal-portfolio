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
                    <form>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Category Name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
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
export default {
    name: "List",
    data(){
        return {
            categories: [],
        }
    },
    methods: {
        loadPostCategory(){
            axios.get('http://localhost:3003/api/category')
            .then(response => {
                this.categories = response.data.data;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },
    },

    created() {
        this.loadPostCategory()
    },

}


</script>

<style scoped>

</style>
