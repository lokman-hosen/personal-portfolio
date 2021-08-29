<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table 55</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
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
