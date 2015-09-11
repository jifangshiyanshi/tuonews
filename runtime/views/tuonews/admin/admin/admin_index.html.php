<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 管理员列表</a>
                </li>
                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon glyphicon-plus"></em> 添加管理员</a>
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
                            <th>用户名</th>
                            <th>所属角色</th>
                            <th>最后登陆时间</th>
                            <th>最后登陆ip</th>
                            <th>注册时间</th>
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
                            <td>
                                <label class="checkbox default">
                                    <input type="checkbox" data-toggle="checkbox" name="ids[]" value="<?php echo $value[id]?>">
                                </label>
                            </td>
                            <td><?php echo $value[id]?></td>
                            <td><?php echo $value[username]?></td>
                            <td><?php echo $roles[$value[role_id]][name]?></td>
                            <td><?php echo $this->getDate($value[last_login_time], "") ?></td>
                            <td><?php echo $value[last_login_ip]?></td>
                            <td><?php echo $this->getDate($value[add_time], "") ?></td>
                            <td>
                                <a href="<?php echo url("/admin_admin_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_admin_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="container row">
                    <a href="<?php echo url("/admin_admin_deletes") ?>" class="btn btn-sm btn-danger ajaxproxy" data-loading-text="正在删除"
                       proxy='{"formId":"J_ListForm", "method":"post", "location":"reload", "callBefore":"multiCallbefore(data);"}'>
                        <i class="glyphicon glyphicon-remove"></i> 删除</a>
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