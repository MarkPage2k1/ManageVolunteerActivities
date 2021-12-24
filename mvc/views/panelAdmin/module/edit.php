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
                        <label for="title">Danh muc cha</label>
                        <select name="data_post[parentID]" class="form-control" id="">
                            <option value="0">Chon danh muc cha</option>
                            <?php if (isset($data['parent']) && $data['parent'] != null) {?>
                                    <?php foreach ($data['parent'] as $key => $val) {?>
                                        <option value="<?= $val['id'] ?>" <?= $data['datas']['parentID'] == $val['id'] ? 'selected' : '' ?> > <?= $val['name'] ?></option>
                                    <?php }?>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="content">Ten module</label>
                        <input type="text" id="name" class="form-control" name="data_post[name]" value="<?= $data['datas']['name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="content">Lien ket</label>
                        <input type="text" id="link" class="form-control" name="data_post[link]" value="<?= $data['datas']['link'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="content">Controller</label>
                        <input type="text" id="controller" class="form-control" name="data_post[controller]" value="<?= $data['datas']['controller'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="content">Icon</label>
                        <input type="text" id="icon" class="form-control" name="data_post[icon]" value="<?= $data['datas']['icon'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="category">Hien thi</label>
                        <input type="checkbox" name="data_post[publish]" id="publish" <?= $data['datas']['publish'] == 1 ? 'checked' : '' ?>>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" name="submit">Cap nhat</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>