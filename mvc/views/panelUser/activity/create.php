<script src="public/ckeditor/ckeditor.js"></script>
<script src="public/ckfinder/ckfinder.js"></script>
<section id="footer-top" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="newslatter">
                    <h2><span>Tạo mới</span>hoạt động</h2>
                </div>
            </div>
            <form method="post">
                <div class="col-md-6">
                    <div class="news-form">
                        <label for="title">Tên hoạt động</label>
                        <input type="text" name="data_post[title]" placeholder="Mùa hè xanh" id="title">

                        <label for="address">Địa điểm</label>
                        <input type="text" name="data_post[address]" placeholder="54 - Nguyễn Lương Bằng" id="address">

                        <label for="category">Chủ đề</label>
                        <input type="text" name="data_post[category]" placeholder="xã hội, giáo dục, ..." id="category">

                        <label for="min_reg">Số lượng thành viên tối thiểu</label>
                        <input type="number" name="data_post[min_reg]" placeholder="30" id="min_reg" min="0">
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="news-form">
                        <label for="open_reg_date">Thời gian mở đăng ký</label>
                        
                        <input type="date" name="data_post[open_reg_date]" value="<?php echo date('Y-m-d') ?>" id="open_reg_date" >
                        <label for="close_reg_date">Thời gian đóng đăng ký</label>
                        <input type="date" name="data_post[close_reg_date]" value="<?php echo date('Y-m-d'); ?>" id="close_reg_date" >                        

                        <label for="activity_end_date">Thời gian kết thúc hoạt động</label>
                        <input type="date" name="data_post[activity_end_date]" value="<?php echo date('Y-m-d'); ?>" id="activity_end_date" >

                        <label for="max_reg">Số lượng thành viên tối đa</label>
                        <input type="number" name="data_post[max_reg]" placeholder="50" id="max_reg" min="0" >                                                
                    </div>                   
                </div>

                <div class="col-md-12">
                    <label for="content" style="margin-top: 50px;">Nội dung chi tiết</label>
                    <textarea style="background-color: #F1F1F1;" name="data_post[content]" id="content" class="form-control" cols="30"></textarea>
                    <script>
                            CKEDITOR.replace( 'data_post[content]', {
                                filebrowserBrowseUrl: 'public/ckfinder/ckfinder.html',
                                filebrowserUploadUrl: 'public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserWindowWidth: '1000',
                                filebrowserWindowHeight: '700'
                            } );
                    </script>                    
                </div>
                <div class="col-md-12">
                    <button type="submit" name="submit" style="width: 200px; height: 50px; border-radius: 30px; margin-top: 20px; background-color:#F2784B"><i class="fa fa-paper-plane" style="font-size: 20px;"></i></button>
                </div>
            </form>

        </div>
    </div>
</section>