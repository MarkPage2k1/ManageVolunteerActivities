<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $data['title'] ?></h3>
            <a href="<?= $data['template'].'/index' ?>" class="btn btn-primary" ><i class="fa fa-backward"></i></a>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="">
        <form action="" class="" method="post" novalidate>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="fullname">Ho va ten</label>
                        <input type="text" id="fullname" class="form-control" name="data_post[fullname]">
                    </div>
                    <div class="form-group">
                        <label for="username">Tai khoan</label>
                        <input type="text" id="username" class="form-control" name="data_post[username]">
                    </div>
                    <div class="form-group">
                        <label for="password">Mat Khau</label>
                        <input type="password" id="password" class="form-control" name="data_post[password]">
                    </div>
                    <div class="form-group">
                        <label for="role">Admin</label>
                        <input type="checkbox" name="data_post[role]" id="role" checked>
                    </div>
                    <div class="form-group">
                        <label for="publish">Lock</label>
                        <input type="checkbox" name="data_post[publish]" id="role" checked>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Thêm mới</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>