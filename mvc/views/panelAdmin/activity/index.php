<?php 
    require_once "./mvc/core/redirect.php";
    $redirect = new redirect();
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $data['title'] ?></h3>
            <a href="<?= $data['template'].'/add' ?>" class="btn btn-primary" ><i class="fa fa-plus"></i></a>
            <a href="javascript:void(0)" onclick="delAll(this)" data-control="<?= $data['template'] ?>" class="btn btn-danger" ><i class="fa fa-trash"></i></a>
            <a href="<?= base_url.$data['template'].'/index' ?>" class="btn btn-success" ><i class="fa fa-history"></i></a>
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
                    <th>
                        <input type="checkbox" id="check-all" onclick="toggle(this)">
                    </th>
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
                        <td class="text-center">
                            <input type="checkbox" name="foo" value="<?= $val['id'] ?>">
                        </td>
                        <td class=""><?= $val['title'] ?></td>
                        <td class=""><?= $val['content'] ?></td>
                        <td class=""><?= $val['owner'] ?></td>
                        <td class=""><?= date('d/m/Y', strtotime($val['post_date'])) ?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="del(<?= $val['id'] ?>)" id="del<?= $val['id'] ?>" data-control="<?= $data['template'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <a href="<?= base_url.$data['template'].'/'.'edit/'.$val['id'] ?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                <?php }?>
            </table>
        </div>
    </div>
</div>
<script>
    function toggle(__this) {
        let isChecked = __this.checked;
        let checkbox = document.querySelectorAll('input[name="foo"]');
        for(let index = 0; index < checkbox.length; index++) {
            checkbox[index].checked = isChecked;
        }
    }
</script>