<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tag List <small class="text-muted">Server Side pagination with search and progress bar</small></h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm pt-1 mr-2">
                            <button type="button" class="btn btn-sm btn-info" @click="createModal"><i class="fa fa-plus"></i> Add New</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <!-- table start -->
                        <table class="table table-hover mt-2">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(tag, index) in tags" :key="tag.id">
                                <td>1</td>
                                <td>{{tag.name}}</td>
                                <td>
                                    <span v-if="tag.status" class="badge bg-success">Approved</span>
                                    <span v-else class="badge bg-danger">Pending</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info" title="Edit" @click="editModal(tag)"><i class="fa fa-edit"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Delete"  @click="deleteTag(tag.id)"><i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                            <tr v-if="tags.length == 0"><td colspan="6"><p class="mb-0 text-center">No Data Found</p></td></tr>
                            </tbody>
                        </table>
                        <!-- table end -->
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
                        <h5 class="modal-title" v-show="!editMode && !detailMode">Create Category</h5>
                        <h5 class="modal-title" v-show="editMode && !detailMode">Edit Category</h5>
                        <h5 class="modal-title" v-show="detailMode">View Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form v-if="!detailMode" @submit.prevent="editMode ? updateTag() : saveTag()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="tagName" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="tagName" class="form-control" name="name" v-model="form.name" placeholder="Enter Tag Name">
                                    <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
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
                                <li class="list-group-item">Name: {{tag.name}}</li>
                                <li class="list-group-item">Status: {{tag.status == 1 ? 'Approved' : 'Pending'}}</li>
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
    name: "Tags",

    data(){
        return{
            editMode: true,
            detailMode: false,
            form: new Form({
                id: '',
                name: '',
                status: 1,
            }),
            tags: [],
        }
    },
    methods:{
        // get data
        getData(){
            this.$Progress.start()
            axios.get('api/tag')
                .then(response => {
                    this.tags = response.data.data;
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
            this.editMode = false;
            this.detailMode = false;
            this.form.reset();
            $('#createModal').modal('show');
        },

        //edit modal
        editModal(tag){
            this.form.reset();
            this.form.clear();
            this.detailMode = false;
            this.editMode = true;
            //fill form with old data
            this.form.fill(tag);
            $('#createModal').modal('show');
        },


        //  save record
        async saveTag(){
            //const response = await this.form.post('api/category')
            this.form.post('api/tag')
                .then((response)=>{
                    if (response.data.status){
                        toast.fire({
                            icon: 'success',
                            title: 'Tag Created successfully'
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
        updateTag(){
            this.form.put('api/tag/'+this.form.id).then((response)=>{
                if (response.data.status){
                    toast.fire({
                        icon: 'success',
                        title: 'Tag Updated successfully'
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
        deleteTag(id){
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
                    this.form.delete('api/tag/'+id).then(()=>{
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
        reloadData(){
            this.getData();
        }

    },
    // load data when mount component
    mounted() {
        this.getData()
    }
}
</script>

<style scoped>

</style>
