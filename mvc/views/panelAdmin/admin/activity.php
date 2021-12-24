<?php 
    require_once "./mvc/core/redirect.php";
    $redirect = new redirect();
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $data['title'] ?></h3>
            <a href="<?= base_url.$data['template'].'/activity'.'/' ?>" class="btn btn-success" ><i class="fa fa-history"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-12" id="MessageFlash">
            <?php if(isset($_SESSION['flash'])) {?>
                <h3 class="text-success"> <?= $redirect->setFlash('flash'); ?> </h3>
            <?php } ?>
        </div>
    </div>
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                    <th class="column-title">Tên hoạt động</th>
                    <th class="column-title">Nội dung</th>
                    <th class="column-title">Người tổ chức </th>
                    <th class="column-title">Ngày đăng</th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                    <th class="bulk-actions" colspan="7">
                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th>
                    </tr>
                </thead>
                <?php if (isset($data['data_array']) && $data['data_array'] != null) {?>
                <tbody>
                    <?php foreach ($data['data_array'] as $key => $val) { ?>
                    <tr class="even<?= $val['id'] ?> pointer">
                        <td class=""><?= $val['title'] ?></td>
                        <td class=""><?= $val['content'] ?></td>
                        <td class=""><?= $val['owner'] ?></td>
                        <td class=""><?= date('d/m/Y', strtotime($val['post_date'])) ?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="accept(<?= $val['id'] ?>)" id="accept<?= $val['id'] ?>" data-control="<?= $data['template'] ?>" class="btn btn-success"><i class="fa fa-check-circle"></i></a>
                            <a href="javascript:void(0)" onclick="refuse(<?= $val['id'] ?>)" id="refuse<?= $val['id'] ?>" data-control="<?= $data['template'] ?>" class="btn btn-danger"><i class="fa fa-times-circle"></i></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                <?php }?>
            </table>
        </div>
    </div>
</div>