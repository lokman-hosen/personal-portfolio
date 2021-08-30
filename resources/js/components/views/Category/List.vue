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
                        <tr v-for="(category, index) in categories" :key="category.id">
                            <td>{{index+1}}</td>
                            <td>{{category.name}}</td>
                            <td>
                                <span v-if="category.status" class="badge bg-success">Approved</span>
                                <span v-else class="badge bg-danger">Pending</span>
                            </td>
                            <td>
                                <a href="#" title="Delete" @click="deleteCategory(category.id)"><i class="fa fa-trash"></i> </a>
                            </td>
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
                  // $(':input').val('');
                   $('.modal').on('hidden.bs.modal', function(){
                       $(this).find('form')[0].reset();
                   });
                    // hide the modal
                   $('#createModal').modal('hide');
                   //load new data
                   this.loadPostCategory()
               }
            })
            .catch((error)=>{
                console.log(error)
            })
        },

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
                        this.loadPostCategory();
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
        }
    },

    created() {
        this.loadPostCategory()
    },

}


</script>

<style scoped>

</style>
