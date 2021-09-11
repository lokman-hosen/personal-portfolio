<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Project List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm pt-1 mr-2">
                            <button type="button" class="btn btn-sm btn-info" ><i class="fa fa-plus"></i> Add New</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--filter form start -->
<!--                    <form @submit.prevent="filterData">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" v-model="filter.name" id="name" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example" v-model="filter.status">
                                    <option value="">&#45;&#45; Select &#45;&#45;</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary p-1"><i class="fas fa-search"></i> Search</button>
                            <button type="button" class="btn btn-sm btn-info p-1 ml-2" @click="reloadData"><i class="fas fa-sync"></i> Refresh</button>
                        </div>
                    </form>-->
                    <!--filter form end -->

                    <div class="table-responsive">
                        <!-- table start -->
                        <table class="table table-hover mt-2">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(project, index) in projects" :key="project.id">
                                <td>{{pagination.from+index}}</td>
                                <td>{{project.name}}</td>
                                <td>{{project.category.name}}</td>
                                <td>{{project.company}}</td>
                                <td>
                                    <span v-if="project.status" class="badge bg-success">Approved</span>
                                    <span v-else class="badge bg-danger">Pending</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info" title="Edit"><i class="fa fa-edit"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Delete" ><i class="fa fa-trash"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-success" title="View" ><i class="fa fa-eye"></i> </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- table end -->

                        <!-- pagination -->
                        <pagination
                            v-if="pagination.last_page > 1"
                            :pagination="pagination"
                            :offset="5"
                            @paginate="getData()"
                        ></pagination>
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
        </div>

        <!-- Button trigger modal -->

        <!-- Create and edit Modal start-->
        <!-- Create and edit modal end -->
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "List",

    data(){
        return{
            projects: [],
            pagination: {
                current_page: 1,
            },
            filter:{
                name: '',
                status: '',
            }
        }
    },
    methods:{
        // get data
        getData(){
            const filterData = {
                params:{
                    name: this.filter.name,
                    status: this.filter.status,
                }
            }
            axios.get('api/project?page='+this.pagination.current_page, filterData)
                .then(response => {
                    this.projects = response.data.data;
                    this.pagination = response.data.meta;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },

    },
    // load data when mount component
    mounted() {
        this.getData()
    }
}
</script>

<style scoped>

</style>
