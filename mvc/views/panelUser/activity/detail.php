<?php $val = $data['data_array'] ?>

<section class="section" style="padding-bottom: 30px">
    <div class="container">
        <h1>Chi tiết hoạt động </h1>
    </div> 
</section>

<section id="about-me" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 fix">
                <div class="tabs-main">
                    <div class="tab-content" style="background: #375">
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
                                            <p><span>Số lượng thành viên: </span> <?= $val['min_reg'] ?> <span> - </span> <?= $val['max_reg'] ?>  </p>
                                            <p><span>Số lượng thành viên còn thiếu: </span> <?= $val['remaining_amount'] ?></p>
                                            <p><?php if (($val['isExpired'] == false) && ($val['remaining_amount'] <= 0) )
                                                    {
                                                        echo 'Đã đủ thành viên tham gia';
                                                    } else { 
                                                        echo $val['time_remaining'];
                                                    }
                                                ?></p>
                                        </div>
                                        <div class="social">
                                            <ul>
                                                <?php if ($data['member_status'] == 'join') { ?>
                                                    <?php if ($val['status'] == 'finish') { ?>
                                                        <li><a href="javascript:void(0)" style="background: yellow;" >Đã hoàn thành!</a><li>
                                                    <?php } else if ($val['isExpired'] == true){ ?>
                                                        <li><a href="javascript:void(0)">Đã đóng!</a><li>
                                                    <?php } else if ($val['remaining_amount'] <= 0){ ?>
                                                        <li><a href="javascript:void(0)">Đã đóng!</a><li>
                                                    <?php } else { ?>
                                                        <li><a href="./activity/join/<?= $val['id']?>">Tham gia ngay</a><li>
                                                    <?php } ?>
                                                <?php } else  if ($data['member_status'] == 'joined') { ?>
                                                    <li><a href="javascript:void(0)">Đã tham gia!</a><li>
                                                    <?php if ($val['status'] == 'finish') { ?>
                                                        <li><a href="javascript:void(0)" style="background: yellow;">Đã hoàn thành!</a><li>
                                                    <?php } ?>
                                                <?php } else if ($data['member_status'] == 'auth') { ?>
                                                    <?php if ($val['status'] == 'finish') { ?>
                                                        <li><a href="javascript:void(0)" style="background: yellow;">Đã hoàn thành!</a><li>
                                                    <?php } else { ?>
                                                        <li><a href="./activity/update/<?= $val['id']?>">Chỉnh sửa!</a><li>
                                                        <li><a href="./activity/add_task/<?= $val['id']?>">Thêm công việc!</a><li>
                                                    <?php } ?>
                                                <?php } ?>
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

<section class="section">
    <div class="container">
            <!-- Tab pen -->
        <div class="tabs">
            <div class="tab-header">
                <?php if (!isset($_SESSION['user'])) { ?>  
                    <div class="active">
                        <i class="fa fa-pencil"></i> Nội dung chi tiết
                    </div>    
                <?php } else if ($data['member_status'] == 'join') { ?>  
                    <div class="active">
                        <i class="fa fa-pencil"></i> Nội dung chi tiết
                    </div>     
                    <div >
                        <i class="fa fa-user"></i> thành viên tham gia
                    </div>
                    <div >
                        <i class="fa fa-heart"></i> nhà tài trợ
                    </div>
                <?php } else { ?>
                    <div class="active">
                        <i class="fa fa-pencil"></i> Nội dung chi tiết
                    </div>                       
                    <div >
                        <i class="fa fa-user"></i> thành viên tham gia
                    </div>
                    <div >
                        <i class="fa fa-heart"></i> nhà tài trợ
                    </div>
                    <div >
                        <i class="fa fa-check-square-o"></i> Tiến độ
                    </div>
                <?php } ?>
            </div>
            <div class="tab-indicator"></div>
            <div class="tab-body">
                <?php if (!isset($_SESSION['user'])) { ?>
                    <div class="active">
                        <h2><?= $val['title'] ?></h2>
                        <p><?= $val['content'] ?></p>  
                        <p>Ngày đăng: <?= $val['post_date'];?></p>                    
                    </div>
                <?php } else if ($data['member_status'] == 'join') { ?>
                    <div class="active">
                        <h2><?= $val['title'] ?></h2>
                        <p><?= $val['content'] ?></p>  
                        <p>Ngày đăng: <?= $val['post_date'];?></p>                    
                    </div>

                    <div>
                        <h2>Thanh vien tham gia</h2>
                        <p>lorem</p>
                    </div>

                    <div>
                        <h2>Thanh vien tai tro</h2>
                        <p>lorem</p>
                    </div>
                    
                <?php } else if ($data['member_status'] == 'joined'){ ?>
                    <?php if ( ($val['status'] == 'finish') && ($val['user_rated'] != true) ) { ?>
                        <script>
                            (async () => {
                                const { value: formValues } = await Swal.fire({
                                title: '<span style="color: #FCD53F">⭐️</span> Đánh giá <span style="color: #FCD53F">⭐️</span>',
                                html:
                                    '<textarea id="swal-input1" class="swal2-textarea" placeholder="Về hoạt động này..."></textarea>' +
                                    '<textarea id="swal-input2" class="swal2-textarea" placeholder="Về người tổ chức ..."></textarea>',
                                focusConfirm: false,
                                preConfirm: () => {
                                    return [
                                    document.getElementById('swal-input1').value,
                                    document.getElementById('swal-input2').value
                                    ]
                                }
                                })
                                if (formValues) {
                                    let control = '<?= $data['template'] ?>';
                                    let data_arr = JSON.stringify(formValues);
                                    let id = <?= $val['id'] ?>;
                                    let user_ratings = '<?= ($data_user['username'])?>';
                                    $.ajax({
                                        url:control + '/rateOfUser',
                                        method: "post",
                                        data: {data_arr: data_arr, id:id, user_ratings: user_ratings},
                                        dataType: "json",
                                        success:function(response){
                                            if (response.type === 'successfully') {
                                                Swal.fire(
                                                    'Thank you! <span style="color: red">❤️❤️❤️</span>',
                                                    response.message,
                                                    'success'
                                                );
                                            } 
                                        }
                                    })
                                }

                            })()
                        </script>
                    <?php }?>

                    <div class="active">
                        <h2><?= $val['title'] ?></h2>
                        <p><?= $val['content'] ?></p>  
                        <p>Ngày đăng: <?= $val['post_date'];?></p>                    
                    </div>

                    <div>
                        <h2>Thanh vien tham gia</h2>
                        <p>lorem</p>
                    </div>

                    <div>
                        <h2>Thanh vien tai tro</h2>
                        <p>lorem</p>
                    </div>

                    <div>
                        <!-- Start Timeline-->
                        <section id="my-timeline" class="section clearfix" style="padding-top: 40px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="section-title">
                                            <h1>Tiến độ công việc<i class="fa fa-history"></i></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="timeline">
                                            <div class="timeline-inner">
                                                <?php 
                                                    $dataTask = $data['data_task']; 
                                                    $numberTask = sizeof($dataTask);
                                                    for ($i = 0; $i < $numberTask; $i++) {
                                                ?>
                                                    <div class="single-main wow fadeInLeft" data-wow-delay="0.4s">
                                                        <div class="single-timeline">
                                                            <div class="single-content">
                                                                <div class="date">
                                                                    <p><?php $date = date_create($dataTask[$i]['create_date']);  echo date_format($date,"d - m Y");?></p>
                                                                </div>
                                                                <h2><?= $dataTask[$i]['name'] ?></i></h2>
                                                                <p><b>Trạng thái:</b>
                                                                    <?php 
                                                                        if ($dataTask[$i]['status'] == 'progress') {
                                                                    ?>
                                                                            <input type="checkbox" disabled> Chưa hoàn thành 
                                                                    <?php
                                                                        } else if ($dataTask[$i]['status'] == 'finish') {
                                                                    ?>
                                                                            <input type="checkbox" checked disabled> Đã hoàn thành
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                     
                                                                </p>
                                                                <p><?= $dataTask[$i]['description'] ?><p>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                <?php } ?>                                                                                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--/ End Timeline -->
                    </div>
                <?php } else { ?>
                    <div class="active">
                        <h2><?= $val['title'] ?></h2>
                        <p><?= $val['content'] ?></p>  
                        <p>Ngày đăng: <?= $val['post_date'];?></p>                    
                    </div>

                    <div>
                        <h2>Thanh vien tham gia</h2>
                        <p>lorem</p>
                    </div>

                    <div>
                        <h2>Thanh vien tai tro</h2>
                        <p>lorem</p>
                    </div>

                    <div>
                        <!-- Start Timeline-->
                        <section id="my-timeline" class="section clearfix" style="padding-top: 40px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="section-title">
                                            <h1>Tiến độ công việc<i class="fa fa-history"></i></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="timeline">
                                            <div class="timeline-inner">
                                                <?php 
                                                    $dataTask = $data['data_task']; 
                                                    $numberTask = sizeof($dataTask);
                                                    for ($i = 0; $i < $numberTask; $i++) {
                                                ?>
                                                    <div class="single-main wow fadeInLeft" data-wow-delay="0.4s">
                                                        <div class="single-timeline">
                                                            <div class="single-content">
                                                                <div class="date">
                                                                    <p><?php $date = date_create($dataTask[$i]['create_date']);  echo date_format($date,"d - m Y");?></p>
                                                                </div>
                                                                <h2><?= $dataTask[$i]['name'] ?></i></h2>
                                                                <p><b>Trạng thái:</b>
                                                                    <?php 
                                                                        if ($dataTask[$i]['status'] == 'progress') {
                                                                    ?>
                                                                            <input type="checkbox" onclick="checkFinish(<?= $dataTask[$i]['task_id'] ?>)" id="checkFinish<?= $dataTask[$i]['task_id'] ?>" data-control="<?= $data['template'] ?>"> Hoàn thành 
                                                                            <a href="./activity/edit_task/<?= $val['id']?>/<?= $dataTask[$i]['task_id'] ?>" name="editTask<?= $dataTask[$i]['task_id'] ?>"> Chỉnh sửa<i class="fa fa-pencil"></i></a>
                                                                    <?php
                                                                        } else if ($dataTask[$i]['status'] == 'finish') {
                                                                    ?>
                                                                            <input type="checkbox" checked disabled> Hoàn thành
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                     
                                                                </p>
                                                                <p><?= $dataTask[$i]['description'] ?><p>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                <?php } ?>                                                                                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--/ End Timeline -->
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>  
</section>  