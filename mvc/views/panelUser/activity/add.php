<script src="public/ckeditor/ckeditor.js"></script>
<script src="public/ckfinder/ckfinder.js"></script>
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
                        <label for="title">Tên hoạt động</label>
                        <input type="text" name="data_post[title]" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa điểm (Chưa xử  lý)</label>
                        <input type="text" id="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="category">Chủ đề</label>
                        <input type="text" name="data_post[category]" id="category" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="min_reg">Số lượng thành viên tối thiểu</label>
                        <input type="number" name="data_post[min_reg]" id="min_reg" min="0" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="open_reg_date">Thời gian mở đăng ký</label>
                        <input type="date" name="data_post[open_reg_date]" id="open_reg_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="close_reg_date">Thời gian đóng đăng ký</label>
                        <input type="date" name="data_post[close_reg_date]" id="close_reg_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="activity_end_date">Thời gian kết thúc hoạt động</label>
                        <input type="date" name="data_post[activity_end_date]" id="activity_end_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="max_reg">Số lượng thành viên tối đa</label>
                        <input type="number" name="data_post[max_reg]" id="max_reg" min="0" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="content">Nội dung chi tiết</label>
                        <textarea name="data_post[content]" id="content" class="form-control" cols="30"></textarea>
                        <script>
                            CKEDITOR.replace( 'data_post[content]', {
                                filebrowserBrowseUrl: 'public/ckfinder/ckfinder.html',
                                filebrowserUploadUrl: 'public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserWindowWidth: '1000',
                                filebrowserWindowHeight: '700'
                            } );
                        </script>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" name="submit">Thêm mới</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>