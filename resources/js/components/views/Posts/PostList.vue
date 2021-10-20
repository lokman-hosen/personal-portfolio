<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Project List <small class="text-muted">Server Side pagination with search and progress bar</small></h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm pt-1 mr-2">
                            <button type="button" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add New</button>
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
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- set progressbar -->
        <vue-progress-bar></vue-progress-bar>

        <!-- Button trigger modal -->

    </div>
</template>

<script>
export default {
    name: "PostList",
    computed:{
      posts(){
          return this.$store.state.posts;
      }
    },
    mounted() {
        this.$store.dispatch("getPosts")
    }
}
</script>

<style scoped>

</style>
