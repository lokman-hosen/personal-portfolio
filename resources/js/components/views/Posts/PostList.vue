<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Project List <small class="text-muted">Server Side pagination with search and progress bar</small></h3>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(post, index) in posts" :key="post.id">
                                <td>{{index}}</td>
                                <td>image</td>
                                <td>{{post.title}}</td>
                                <td>{{post.description}}</td>
                                <td>
                                    <span v-if="post.status" class="badge bg-success">Approved</span>
                                    <span v-else class="badge bg-danger">Pending</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info" title="Edit" ><i class="fa fa-edit"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa fa-trash"></i> </a>
                                    <a href="#" class="btn btn-sm btn-outline-success" title="View"><i class="fa fa-eye"></i> </a>
                                </td>
                            </tr>
                            <tr v-if="posts.length == 0"><td colspan="6"><p class="mb-0 text-center">No Data Found</p></td></tr>
                            </tbody>
                        </table>
                        <!-- table end -->

                        <!-- pagination -->
                        <pagination
                            v-if="this.$store.state.pagination.last_page > 1"
                            :pagination="this.$store.state.pagination"
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
                        <h5 class="modal-title" v-show="!editMode && !detailMode">Create Category</h5>
                        <h5 class="modal-title" v-show="editMode && !detailMode">Edit Category</h5>
                        <h5 class="modal-title" v-show="detailMode">View Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form v-if="!detailMode" @submit.prevent="editMode ? updateBlog() : saveBlog()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="blogName" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="blogName" class="form-control" name="title" v-model="form.title" placeholder="Enter Blog Name">
                                    <div class="text-danger" v-if="form.errors.has('title')" v-html="form.errors.get('title')" />
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description" v-model="form.description" placeholder="Enter Blog Description">
                                    <div class="text-danger" v-if="form.errors.has('description')" v-html="form.errors.get('description')" />
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

                </div>
            </div>
        </div>
        <!-- Create and edit modal end -->

    </div>
</template>

<script>
import Form from "vform";

export default {
    name: "PostList",
    data(){
        return{
            editMode: true,
            detailMode: false,
            form: new Form({
                id: '',
                title: '',
                description: '',
                status: 1,
            }),
            pagination: {
                current_page: 1,
            },
            filter:{
                title: '',
                status: '',
            },
            //detail
            //project: {}
        }
    },
    computed:{
      posts(){
          return this.$store.state.posts;
      }
    },

    methods:{
        //create modal
        createModal(){
            this.editMode = false;
            this.detailMode = false;
            this.form.reset();
            $('#createModal').modal('show');
        },

        getData(){
            //step 1: dispatch an action to get post
            this.$store.dispatch("getPosts")
        },

        saveBlog(){
            this.$store.dispatch("savePost", this.form)
                .then(() => {
                    toast.fire({
                        icon: 'success',
                        title: 'Post Created successfully'
                    })
                    // reset form value
                    $('.modal').on('hidden.bs.modal', function(){
                        $(this).find('form')[0].reset();
                    });
                    // hide the modal
                    $('#createModal').modal('hide');
                })
                .catch(err => {
                    console.error(err)
                })
        }
    },
    mounted() {
        //this.$store.dispatch("getPosts")
        this.getData()
    }
}
</script>

<style scoped>

</style>
