<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li <?php if ( !$sign ) { ?>class="active"<?php } ?>>
                <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 保留字列表</a>
                </li>
                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon glyphicon-plus"></em> 添加保留字</a>
                </li>
            </ul>
            <!-- 搜索表单 -->
            <form class="search-form" <?php if ( $sign=="check" ) { ?>action="<?php echo url("/admin_user_check/") ?>"<?php } elseif ( $sign=="aborted" ) { ?>action="<?php echo url("/admin_user_aborted/") ?>"<?php } else { ?>action="<?php echo $index_url?>"<?php } ?> method="get">
            <div class="clearfix">

                <div class="pull-right sbtn-addon">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control input-sm" value="<?php echo $params[name]?>" placeholder="请输入域名保留字" />
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
                            <th>保留字</th>
                            <th>类型</th>
                            <th>添加时间</th>
                            <th>添加人</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ( empty($items) ) { ?>
                        <tr>
                            <td class="empty-table-td"><?php echo $emptyRecord?></td>
                        </tr>
                        <?php } ?>

                        <?php foreach ( $items as $key => $value ) { ?>
                        <tr>
                            <td>
                                <label class="checkbox default">
                                    <input type="checkbox" data-toggle="checkbox" name="ids[]" value="<?php echo $value[id]?>">
                                </label>
                            </td>
                            <td><?php echo $value[name]?></td>
                            <td><?php echo $types[$value[type]]?></td>
                            <td><?php echo $this->getDate($value[add_time], "") ?></td>
                            <td><?php echo $admins[$value[userid]][name]?></td>
                            <td>
                                <a href="<?php echo url("/admin_keywords_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_keywords_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
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
<?php echo $this->importResource('res', 'js', 'article.js')?>
<?php include $this->getIncludePath('admin.footer')?>
