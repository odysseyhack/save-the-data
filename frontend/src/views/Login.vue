<template>
    <body class="login-page">
        <!-- End Navbar -->
        <div class="squares square1"></div>
        <div class="squares square2"></div>
        <div class="squares square3"></div>
        <div class="squares square4"></div>
        <div class="squares square5"></div>
        <div class="squares square6"></div>
        <div class="page-header">
            <div class="page-header-image"></div>
            <div class="container">
                <div class="col-lg-5 col-md-8 mx-auto">
                    <div class="card card-login">
                        <form class="form" method="" action="">
                            <div class="card-header">
                                <img class='card-title' src='@/assets/img/firesync.png'>
                            </div>
                            <div class="card-body">
                                <div class="input-group input-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fire-icons icon-single-02"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="email">
                                </div>
                                <div class="input-group input-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fire-icons icon-caps-small"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="password">
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <router-link class="btn btn-primary btn-round btn-lg btn-block" to="/">Login</router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</template>

<script>
export default {
  name: 'login',
};
</script>

<style src='@/assets/style.scss' lang='scss'>

</style>
