<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <?php if(isset($data['data_menu']['getModule']) && $data['data_menu']['getModule'] != null) {?>
                <?php foreach($data['data_menu']['getModule'] as $key => $val) {?>
                    <li>
                        <a href="<?= $val['children'] != null ? 'javascript:void(0)' : $val['link'] ?>"> 
                            <i class="<?= $val['icon'] ?>"></i> 
                            <?= $val['name'] ?>
                            <?= $val['children'] != null ? '<span class="fa fa-chevron-down"></span>' : '' ?> 
                        </a>
                        <?php if(isset($val['children']) && $val['children'] != null) {?>
                            <ul class="nav child_menu">
                                <?php foreach($val['children'] as $key_child => $val_child) {?>
                                    <li><a href="<?= $val_child['link'] ?>"><?= $val_child['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php }?>
            <?php }?>
        </ul>
    </div>
</div>