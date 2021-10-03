<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Project Images List <small class="text-muted">Server Side pagination with search and progress bar</small></h3>
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
                                    <input type="text" class="form-control" v-model="filter.title" id="name" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label class="form-label">Project</label>
                                <select class="form-select" v-model="filter.project_id" aria-label="Default select example">
                                    <option value="">--Select--</option>
                                    <option v-for="project in projects" :key="project.id" :value="project.id" >{{project.name}}</option>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Project</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(projectImage, index) in projectImages" :key="projectImage.id">
                                <td>{{pagination.from+index}}</td>
                                <td><img :src="`uploads/project/${projectImage.file}`" style="width: 50px;"/></td>
                                <td>{{projectImage.title}}</td>
                                <td>{{projectImage.project.name}}</td>
                                <td>{{projectImage.description}}</td>
                                <td>
                                    <span v-if="projectImage.status" class="badge bg-success">Approved</span>
                                    <span v-else class="badge bg-danger">Pending</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info" title="Edit" @click="editModal(projectImage)"><i class="fa fa-edit"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Delete"  @click="deleteProject(projectImage.id)"><i class="fa fa-trash"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-success" title="View" @click="detailProject(projectImage)"><i class="fa fa-eye"></i> </a>
                                </td>
                            </tr>
                            <tr v-if="projectImages.length == 0"><td colspan="7"><p class="mb-0 text-center">No Data Found</p></td></tr>
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
        <!-- set progressbar -->
        <vue-progress-bar></vue-progress-bar>

        <!-- Button trigger modal -->

        <!-- Create and edit Modal start-->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode && !detailMode">Add Project Image</h5>
                        <h5 class="modal-title" v-show="editMode && !detailMode">Edit Project</h5>
                        <h5 class="modal-title" v-show="detailMode">View Project Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form v-if="!detailMode" @submit.prevent="editMode ? updateProjectImage() : saveProjectImage()" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="projectName" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" id="projectName" class="form-control" name="title" v-model="form.title" placeholder="Enter Title">
                                        <div class="text-danger" v-if="form.errors.has('title')" v-html="form.errors.get('title')" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Project <span class="text-danger">*</span></label>
                                        <select class="form-select" name="project_id" v-model="form.project_id" aria-label="Default select example">
                                            <option value="">--Select--</option>
                                            <option v-for="project in projects" :key="project.id" :value="project.id" >{{project.name}}</option>
                                        </select>
                                        <div class="text-danger" v-if="form.errors.has('project_id')" v-html="form.errors.get('project_id')" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea type="text" class="form-control" name="description" v-model="form.description" placeholder="Enter Project Features" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="file" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="file" id="file" class="form-control" name="file" @change="uploadFile">
                                        <div class="text-danger" v-if="form.errors.has('file')" v-html="form.errors.get('file')" />
                                    </div>
                                </div>


                                <div v-if="editMode" class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status" v-model="form.status" aria-label="Default select example">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        <div class="text-danger" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                                    </div>
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
                                <li class="list-group-item">Project: {{project.project.name}}</li>
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
    name: "ProjectImage",

    data(){
        return{
            editMode: true,
            detailMode: false,
            form: new Form({
                id: '',
                title: '',
                file: '',
                project_id: '',
                description: '',
                status: 1,
            }),
            projectImages: [],
            projects: [],
            pagination: {
                current_page: 1,
            },
            filter:{
                name: '',
                project_id: '',
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
                    title: this.filter.title,
                    project_id: this.filter.project_id,
                    status: this.filter.status,
                }
            }
            this.$Progress.start()
            axios.get('api/project-image?page='+this.pagination.current_page, filterData)
                .then(response => {
                    this.projectImages = response.data.data;
                    this.pagination = response.data.meta;
                    this.$Progress.finish()
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    this.$Progress.fail()
                });
        },

        //create modal
        createModal(){
            this.getProjectList();
            this.editMode = false;
            this.detailMode = false;
            this.form.reset();
            $('#createModal').modal('show');
        },

        //edit modal
        editModal(projectImage){
            this.form.reset();
            this.form.clear();
            this.getProjectList();
            this.detailMode = false;
            this.editMode = true;
            //fill form with old data
            this.form.fill(projectImage);
            $('#createModal').modal('show');
        },

        // project detail
        detailProject(project){
            this.project = project;
            this.detailMode = true;
            $('#createModal').modal('show');
        },

        uploadFile(e){
            this.form.file = e.target.files[0];
        },



        //  save record
        async saveProjectImage(){
            //const response = await this.form.post('api/project')
            this.form.post('api/project-image')
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
        updateProjectImage(){
            this.form.put('api/project-image/'+this.form.id).then((response)=>{
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
                        title: 'Error To Updated Project'
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
                    this.form.delete('api/project-image/'+id).then(()=>{
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

        getProjectList(){
            axios.get('api/project')
                .then(response => {
                    this.projects = response.data.data;
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
            this.filter.project_id = '';
            this.filter.status = '';
            this.getData();
        }

    },
    // load data when mount component
    mounted() {
        this.getProjectList()
        this.getData()
    }
}
</script>

<style scoped>

</style>
