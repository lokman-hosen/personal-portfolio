<template>
    <div class="wrapper">
        <!-- Navbar -->
        <Navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <Sidebar />
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">{{ $route.name | capitalize }}</h4>
                        </div><!-- /.col -->
<!--                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">{{ $route.name | capitalize }}</li>
                            </ol>
                        </div>&lt;!&ndash; /.col &ndash;&gt;-->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- render routes component here -->
                    <router-view></router-view>

                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <Footer />
    </div>
</template>

<script>
import Navbar from "./components/Navbar";
import Footer from "./components/Footer";
import Sidebar from "./components/Sidebar";
export default {
    name: "App",
    components:{
        Navbar,
        Footer,
        Sidebar,
    }
}
</script>

<style scoped>

</style>
