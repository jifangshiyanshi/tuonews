<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li>
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 菜单管理</a>
                </li>
                <li class="active">
                    <a href="javascript:void(0);"><em class="glyphicon glyphicon-plus"></em> 添加菜单</a>
                </li>
            </ul>

            <div class="container placeholders">
                <form class="form-horizontal" autocomplete="off" id="content_add_form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">菜单分组key</label>
                        <div class="col-sm-10">
                            <select name="data[groupkey]" id="menu-group-select" class="form-control select select-default">
                                <?php foreach ( $menuGroups as $value ) { ?>
                                <option value="<?php echo $value[tkey]?>" <?php if ( $value[tkey]==$groupkey ) { ?>selected<?php } ?>><?php echo $value[name]?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">上级菜单</label>
                        <div class="col-sm-10">
                            <select name="data[pid]" data-toggle="select" id="pmenu-select" class="form-control select select-default">
                                <option value="0">顶级菜单</option>
                                <?php foreach ( $menuData as $value ) { ?>
                                <option value="<?php echo $value[id]?>" <?php if ( $value[id]==$pid ) { ?>selected<?php } ?>><?php echo $value[name]?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 菜单名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[name]" class="form-control" max-length="10" placeholder="菜单名称" required autofocus>
                            <p class="help-block">长度在10以内，不区分中英文。</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 菜单URL</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[url]" class="form-control" placeholder="菜单URL" required>
                            <p class="help-block">长度在100以内。</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 排序数字</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[sort_num]" class="form-control" dtype="number" placeholder="排序数字" required>
                            <p class="help-block">数字越小越靠前，三位数以内</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 是否显示</label>
                        <div class="col-sm-10">
                            <input type="checkbox" data-toggle="switch"  checked />
                            <input type="hidden" name="data[ishow]" value="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <a href="<?php echo $insert_url?>"  class="btn btn-inverse ajaxproxy" data-loading-text="正在提交……"
                               proxy='{"formId":"content_add_form", "method":"post", "location":"reset", "callbackDelay":"1000"}'>保存修改</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<?php echo $this->importResource('res', 'js', 'menu.js')?>

<?php include $this->getIncludePath('admin.footer')?>