<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Project List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm pt-1 mr-2">
                            <button type="button" class="btn btn-sm btn-info" @click="createModal"><i class="fa fa-plus"></i> Add New</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--filter form start -->
                    <form @submit.prevent="filterData">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" v-model="filter.name" id="name" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">Category</label>
                                <select class="form-select" v-model="filter.category_id" aria-label="Default select example">
                                    <option value="">--Select--</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id" >{{category.name}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example" v-model="filter.status">
                                    <option value="">-- Select --</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary p-1"><i class="fas fa-search"></i> Search</button>
                            <button type="button" class="btn btn-sm btn-info p-1 ml-2" @click="reloadData"><i class="fas fa-sync"></i> Refresh</button>
                        </div>
                    </form>
                    <!-- filter form end -->

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
                                    <a href="#" class="btn btn-sm btn-outline-info" title="Edit" @click="editModal(project)"><i class="fa fa-edit"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Delete"  @click="deleteProject(project.id)"><i class="fa fa-trash"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-success" title="View" @click="detailProject(project)"><i class="fa fa-eye"></i> </a>
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
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode && !detailMode">Create Category</h5>
                        <h5 class="modal-title" v-show="editMode && !detailMode">Edit Category</h5>
                        <h5 class="modal-title" v-show="detailMode">View Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form v-if="!detailMode" @submit.prevent="editMode ? updateProject() : saveProject()">
                        <input type="hidden" name="user_id" v-model="user_id">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="projectName" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="projectName" class="form-control" name="name" v-model="form.name" placeholder="Enter Project Name">
                                    <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category_id" v-model="form.category_id" aria-label="Default select example">
                                        <option value="">--Select--</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id" >{{category.name}}</option>
                                    </select>
                                    <div class="text-danger" v-if="form.errors.has('category_id')" v-html="form.errors.get('category_id')" />
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Features</label>
                                    <input type="text"  class="form-control" name="features" v-model="form.features" placeholder="Enter Project Features">
                                    <div class="form-text">User comma(,) separator for multiple feature</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Technologies</label>
                                    <input type="text" class="form-control" name="technologies" v-model="form.technologies" placeholder="Enter Project Technologies">
                                    <div class="form-text">User comma(,) separator for multiple technology</div>
                                </div>

                                <div class="col-6">
                                    <label for="company" class="form-label">Company</label>
                                    <input type="text" id="company" class="form-control" name="company" v-model="form.company" placeholder="Enter Company Name">
                                </div>

                                <div v-if="editMode" class="col-6">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status" v-model="form.status" aria-label="Default select example">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="text-danger" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" :disabled="form.busy">Save</button>
                        </div>
                    </form>

                    <div v-if="detailMode" class="modal-body">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Name: {{project.name}}</li>
                                <li class="list-group-item">Category: {{project.category.name}}</li>
                                <li class="list-group-item">Features: {{project.features}}</li>
                                <li class="list-group-item">Technologies: {{project.technologies}}</li>
                                <li class="list-group-item">Company: {{project.company}}</li>
                                <li class="list-group-item">Status: {{project.status == 1 ? 'Approved' : 'Pending'}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Create and edit modal end -->
    </div>
</template>

<script>
import axios from "axios";
import Form from "vform";

export default {
    name: "List",

    data(){
        return{
            editMode: true,
            detailMode: false,
            form: new Form({
                id: '',
                name: '',
                features: '',
                category_id: '',
                technologies: '',
                company: '',
                //get login user id taken in app.js file
                user_id: this.$userId,
                status: 1,
            }),
            projects: [],
            categories: [],
            pagination: {
                current_page: 1,
            },
            filter:{
                name: '',
                category_id: '',
                status: '',
            },
            //detail
            project: {}
        }
    },
    methods:{
        // get data
        getData(){
            const filterData = {
                params:{
                    name: this.filter.name,
                    category_id: this.filter.category_id,
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

        //create modal
        createModal(){
            this.getCategoryList();
            this.editMode = false;
            this.detailMode = false;
            this.form.reset();
            $('#createModal').modal('show');
        },

        //edit modal
        editModal(project){
            this.form.reset();
            this.form.clear();
            this.getCategoryList();
            this.detailMode = false;
            this.editMode = true;
            //fill form with old data
            this.form.fill(project);
            $('#createModal').modal('show');
        },

        // project detail
        detailProject(project){
            console.log(JSON.stringify(project))
            this.project = project;
            this.detailMode = true;
            $('#createModal').modal('show');
        },

        //  save record
        async saveProject(){
            //const response = await this.form.post('api/category')
            this.form.post('api/project')
                .then((response)=>{
                    if (response.data.status){
                        toast.fire({
                            icon: 'success',
                            title: 'Project Created successfully'
                        })
                        // reset form value
                        $('.modal').on('hidden.bs.modal', function(){
                            $(this).find('form')[0].reset();
                        });
                        // hide the modal
                        $('#createModal').modal('hide');
                        //load new data
                        this.getData()
                    }
                })
                .catch((error)=>{
                    console.log(error)
                })
        },

        // update record
        updateProject(){
            this.form.put('api/project/'+this.form.id).then((response)=>{
                if (response.data.status){
                    toast.fire({
                        icon: 'success',
                        title: 'Project Updated successfully'
                    })
                    // reset form value
                    // $(':input').val('');
                    $('.modal').on('hidden.bs.modal', function(){
                        $(this).find('form')[0].reset();
                    });
                    // hide the modal
                    $('#createModal').modal('hide');
                    //load new data
                    this.getData()
                }
            })
                .catch((error)=>{
                    console.log(error)
                    /*toast.fire({
                        icon: 'error',
                        title: 'Error To Updated Category'
                    })*/
                })
        },

        // delete record
        deleteProject(id){
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //delete item
                    this.form.delete('api/project/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        this.getData();
                    })
                        .catch(()=>{
                            swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })
                        })
                }
            })
        },

        getCategoryList(){
            axios.get('api/category')
                .then(response => {
                    this.categories = response.data.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
        filterData(){
            this.getData()
        },
        reloadData(){
            this.filter.name = '';
            this.filter.category_id = '';
            this.filter.status = '';
            this.getData();
        }

    },
    // load data when mount component
    mounted() {
        this.getCategoryList()
        this.getData()
    }
}
</script>

<style scoped>

</style>
