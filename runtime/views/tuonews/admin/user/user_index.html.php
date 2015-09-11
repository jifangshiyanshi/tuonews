<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li <?php if ( $ischeck==1 ) { ?>class="active"<?php } ?>>
                    <a href="<?php echo url("/admin_user_index") ?>"><em class="glyphicon glyphicon glyphicon-check"></em> 用户列表</a>
                </li>
                <li <?php if ( $ischeck==2 ) { ?>class="active"<?php } ?>>
                    <a href="<?php echo url("/admin_user_aborted") ?>"><em class="glyphicon glyphicon-ban-circle"></em> 封号用户</a>
                </li>
                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon glyphicon-plus"></em> 添加会员</a>
                </li>
            </ul>
            <!-- 搜索表单 -->
            <form class="search-form" <?php if ( $sign=="check" ) { ?>action="<?php echo url("/admin_user_check/") ?>"<?php } elseif ( $sign=="aborted" ) { ?>action="<?php echo url("/admin_user_aborted/") ?>"<?php } else { ?>action="<?php echo $index_url?>"<?php } ?> method="get">
                <div class="clearfix">
                    <div class="pull-left calendar-addon">

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon fui-calendar input-sm"></span>
                                <input type="text" name="start_time" value="<?php echo $params[start_time]?>" class="form-control input-sm date" placeholder="开始时间" id="start-time" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon fui-calendar input-sm"></span>
                                <input type="text" name="end_time" value="<?php echo $params[end_time]?>" class="form-control input-sm date" placeholder="结束时间" id="end-time" />
                            </div>
                        </div>

                    </div>
                    <div class="pull-right sbtn-addon">
                        <div class="input-group">
                            <input type="text" name="username" class="form-control input-sm" value="<?php echo $params[username]?>" placeholder="请输入用户名" />
                            <span class="input-group-addon fui-search input-sm">
                                <button class="submit" type="submit"></button>
                            </span>
                        </div>
                    </div>
                </div>
            </form><!-- 搜索表单 -->
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
                            <th>用户名</th>
                            <th>手机号码</th>
                            <th>邮箱</th>
                            <th>注册时间</th>
                            <th>最后登录</th>
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
                            <td><?php echo $value[username]?></td>
                            <td><?php echo $value[mobile]?></td>
                            <td><?php echo $value[email]?></td>
                            <td><?php echo $this->getDate($value[add_time], "") ?></td>
                            <td><?php echo $this->getDate($value[last_login_time], "") ?></td>
                            <td>
                                <a href="<?php echo url("/admin_user_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_user_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="container row">
                    <a href="<?php echo url("/admin_user_deletes") ?>" class="btn btn-sm btn-danger ajaxproxy" data-loading-text="正在删除"
                       proxy='{"formId":"J_ListForm", "method":"post", "location":"reload", "callBefore":"multiCallbefore(data);"}'>
                        <i class="glyphicon glyphicon-remove"></i> 删除选中</a>

                    <?php if ( $ischeck==2 ) { ?>
                    <a href="<?php echo url("/admin_user_unaborted") ?>" class="ajaxproxy btn btn-sm btn-warning" data-loading-text="正在解除封号……"
                       proxy='{"method":"post", "formId":"J_ListForm","location":"<?php echo $index_url?>"}'>
                        <em class="glyphicon glyphicon-check"></em> 解除封号</a>
                    <?php } else { ?>
                    <a href="<?php echo url("/admin_user_abort") ?>" class="ajaxproxy btn btn-sm btn-warning" data-loading-text="正在封号……"
                       proxy='{"method":"post", "formId":"J_ListForm","location":"<?php echo $index_url?>"}'>
                        <em class="glyphicon glyphicon-check"></em> 批量封号</a>
                    <?php } ?>
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
<script>
    createDatePicker('start-time',null);
    createDatePicker('end-time',null);
</script>
<?php include $this->getIncludePath('admin.footer')?>
