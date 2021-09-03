<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Category List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm pt-1" style="width: 150px;">
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
                                <label class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example" v-model="filter.status">
                                    <option value="">-- Select --</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!--filter form end -->

                    <!-- table start -->
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
                        <tr v-for="(category, index) in categories" :key="category.id">
                            <td>{{index+1}}</td>
                            <td>{{category.name}}</td>
                            <td>
                                <span v-if="category.status" class="badge bg-success">Approved</span>
                                <span v-else class="badge bg-danger">Pending</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-info" title="Edit" @click="editModal(category)"><i class="fa fa-edit"></i> </a>
                                <a href="#" class="btn btn-sm btn-outline-danger" title="Delete" @click="deleteCategory(category.id)"><i class="fa fa-trash"></i> </a>
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
                <!-- /.card-body -->
            </div>

        <!-- Button trigger modal -->

        <!-- Create and edit Modal start-->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode">Create Category</h5>
                        <h5 class="modal-title" v-show="editMode">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="editMode ? updateCategory() : saveCategory()">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="categoryname" class="form-label">Name</label>
                                <input type="text" id="categoryname" class="form-control" name="name" v-model="form.name" placeholder="Enter Category Name">
                                <div class="text-danger" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </div>
                            <div v-if="editMode" class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" v-model="form.status" aria-label="Default select example">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="text-danger" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
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
        <!-- Create and edit modal end -->
        </div>
</template>

<script>
import axios from "axios"
import Form from 'vform'

export default {
    name: "List",
    data(){
        return {
            editMode: true,
            form: new Form({
                id: '',
                name: '',
                status: 1,
            }),
            categories: [],
            pagination: {
                current_page: 1,
            },
            filter:{
                name: '',
                status: '',
            }
        }
    },
    methods: {
        // get data
        getData(){
            const filterData = {
                params:{
                    name: this.filter.name,
                    status: this.filter.status,
                }
            }
            axios.get('api/category?page='+this.pagination.current_page, filterData)
            .then(response => {
                this.categories = response.data.data;
                this.pagination = response.data.meta;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },

        //create modal
        createModal(){
            this.editMode = false,
            this.form.reset();
            $('#createModal').modal('show');
        },
        //edit modal
        editModal(category){
            this.editMode = true,
                //fill form with old data
            this.form.fill(category);
            $('#createModal').modal('show');
        },

        //  save record
        async saveCategory(){
            //const response = await this.form.post('api/category')
           this.form.post('api/category')
            .then((response)=>{
               if (response.data.status){
                   toast.fire({
                       icon: 'success',
                       title: 'Category Created successfully'
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
        updateCategory(){
            this.form.put('api/category/'+this.form.id).then((response)=>{
                if (response.data.status){
                    toast.fire({
                        icon: 'success',
                        title: 'Category Updated successfully'
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
        deleteCategory(id){
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
                    this.form.delete('api/category/'+id).then(()=>{
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
        filterData(){
            this.getData()
        }
    },

    /*created() {
        this.getData()
    },*/
    // load data when mount component
    mounted() {
        this.getData()
    }
}


</script>

<style>
.btn-group-sm>.btn, .btn-sm {
    padding: .15rem .5rem;
    font-size: .875rem;
    border-radius: .2rem;
}
</style>
