<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 模板列表</a>
                </li>

                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon-plus"></em> 添加模板</a>
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
                            <th>模板名称</th>
                            <th>模板类型</th>
                            <th>模板key</th>
                            <th>排序</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
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
                            <td><?php echo $value[name]?></td>
                            <td><?php echo $templateTypes[$value[type]]?></td>
                            <td><?php echo $value[tkey]?></td>
                            <td><?php echo $value[sort_num]?></td>
                            <td><?php echo $this->getDate($value[add_time], "") ?></td>
                            <td><?php echo $this->getDate($value[update_time], "") ?></td>
                            <td>
                                <a href="<?php echo url("/admin_sTemplate_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_sTemplate_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </form>

            <div class="pagination pull-right"><?php echo $pagemenu?></div>

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<?php include $this->getIncludePath('admin.footer')?>