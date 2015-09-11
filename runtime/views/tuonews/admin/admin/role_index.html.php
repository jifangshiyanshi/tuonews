<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 角色列表</a>
                </li>
                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon glyphicon-plus"></em> 添加角色</a>
                </li>
            </ul>

            <form id="J_ListForm" role="form" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20">
                                <label class="checkbox primary">
                                    <input type="checkbox" data-toggle="checkbox" id="check-all">
                                </label>
                            </th>
                            <th>ID</th>
                            <th>角色名称</th>
                            <th>排序</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ( empty($items) ) { ?>
                        <tr>
                            <td class="empty-table-td"><?php echo $emptyRecord?></td>
                        </tr>
                        <?php } ?>

                        <?php foreach ( $items as $value ) { ?>
                        <tr>
                            <input type="hidden" name="hids[<?php echo $value[id]?>]" value="<?php echo $value['id']?>">
                            <td>
                                <label class="checkbox default">
                                    <input type="checkbox" data-toggle="checkbox" name="ids[]" value="<?php echo $value[id]?>">
                                </label>
                            </td>
                            <td><?php echo $value[id]?></td>
                            <td><input type="input" name="data[<?php echo $value[id]?>][name]" value="<?php echo $value[name]?>" class="form-control input-sm"></td>
                            <td><input type="input" name="data[<?php echo $value[id]?>][sort_num]" value="<?php echo $value['sort_num']?>" class="form-control input-sm"></td>
                            <td><?php echo $this->getDate($value[add_time], "") ?></td>
                            <td>
                                <a href="<?php echo url("/admin_role_permission/?id=$value[id]") ?>" class="btn btn-xs btn-primary">修改权限</a>
                                <a href="<?php echo url("/admin_role_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_role_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="container row">
                    <a href="<?php echo $quicksave_url?>" class="ajaxproxy btn btn-sm btn-inverse" data-loading-text="正在保存……"
                       proxy='{"method":"post", "formId":"J_ListForm", "location":"reload"}'>
                        <em class="glyphicon glyphicon-saved"></em> 快速保存</a>
                </div>
            </form>

            <nav>
                <ul class="pagination pull-right">
                    <?php echo $pagemenu?>
                </ul>
            </nav>

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<?php include $this->getIncludePath('admin.footer')?>