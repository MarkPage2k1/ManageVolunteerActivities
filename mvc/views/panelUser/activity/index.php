<section class="section" style="padding-bottom: 30px">
    <div class="container">
        <h1>Danh sách các hoạt động</h1>
    </div> 
</section>

<?php foreach ($data['data_array'] as $key => $val) { ?>
<section id="about-me" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 fix">
                <div class="tabs-main">
                    <div class="tab-content">
                            <div class="about-text">
                                <h2 class="tab-title"><?= $val['title'] ?></h2>
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <!-- About Image -->
                                        <div class="single-image">
                                            <img src="public/user/images/personal/my-image.jpg" alt="">
                                        </div>
                                    </div>
                                    <!-- End About Image -->
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                        <div class="content">
                                            <P>Người tổ chức: <span><?= $val['owner'] ?></span></P>
                                            <p>Địa chỉ: <span><?= $val['address'] ?></span></p>
                                            <p><span>Chủ đề: </span> <?= $val['category'] ?></p>                                        
                                            <p><?= $val['time_remaining']?></p>
                                        </div>
                                        <div class="social">
                                            <ul>
                                                <li><a href="./activity/detail/<?= $val['id']?>">Xem chi tiết</a><li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
