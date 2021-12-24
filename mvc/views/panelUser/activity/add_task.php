<script src="public/ckeditor/ckeditor.js"></script>
<script src="public/ckfinder/ckfinder.js"></script>
<section id="footer-top" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="newslatter">
                    <h2><span>Thêm</span>nhiệm vụ</h2>
                </div>
            </div>
            <form method="post">
                <div class="col-md-12">
                    <div class="news-form">
                        <label for="name">Tên nhiệm vụ</label>
                        <input type="text" name="data_post[name]" placeholder="Chuẩn bị phương tiện, ..." id="name">
                    </div>

                </div>

                <div class="col-md-12">
                    <label for="description" style="margin-top: 50px;">Mô tả chi tiết</label>
                    <textarea style="background-color: #F1F1F1;" name="data_post[description]" id="description" class="form-control" cols="30"></textarea>
                    <script>
                            CKEDITOR.replace( 'data_post[description]', {
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