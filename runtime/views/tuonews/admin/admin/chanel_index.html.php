<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 频道列表</a>
                </li>
                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon glyphicon-plus"></em> 添加频道</a>
                </li>
            </ul>

            <form id="J_ListForm" role="form" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>频道名称</th>
                            <th>排序数字</th>
                            <th>添加时间</th>
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
                                <?php echo $value[id]?>
                                <input type="hidden" name="hids[<?php echo $value[id]?>]" value="<?php echo $value[id]?>" />
                            </td>
                            <td>
                                <input type="text" name="data[<?php echo $value[id]?>][name]" value="<?php echo $value[name]?>" class="form-control input-sm" />
                            </td>
                            <td>
                                <input type="text" name="data[<?php echo $value[id]?>][sort_num]" value="<?php echo $value[sort_num]?>" class="form-control input-sm" />
                            </td>
                            <td><?php echo $this->getDate($value[add_time], "") ?></td>
                            <td>
                                <a href="<?php echo url("/admin_chanel_add/?pid=$value[id]") ?>" data-toggle="tooltip" title="添加子频道" class="btn btn-xs btn-inverse">添加</a>
                                <a href="<?php echo url("/admin_chanel_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_chanel_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <!-- 二级菜单 -->
                        <?php foreach ( $value[sub] as $key => $val ) { ?>
                        <tr id="items_<?php echo $val['id']?>" class="items_<?php echo $value['id']?>">
                            <td>
                                <?php echo $val[id]?>
                                <input type="hidden" name="hids[<?php echo $val[id]?>]" value="<?php echo $val[id]?>" />
                            </td>

                            <td style="padding-left: 30px;">
                                <input type="text" name="data[<?php echo $val[id]?>][name]" value="<?php echo $val[name]?>" class="form-control input-sm" />
                            </td>
                            <td>
                                <input type="text" name="data[<?php echo $val[id]?>][sort_num]" value="<?php echo $val[sort_num]?>" class="form-control input-sm" />
                            </td>
                            <td><?php echo $this->getDate($val['add_time'], "") ?></td>
                            <td>
                                <a href="<?php echo url("/admin_chanel_edit/?id=$val[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_chanel_delete/?id=$val[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="opt_box">
                    <a href="<?php echo $add_url?>" class="btn btn-sm btn-primary"><em class="glyphicon glyphicon-plus"></em> 添加频道</a>
                    <a href="<?php echo url("/admin_chanel_quicksave") ?>" class="ajaxproxy btn btn-sm btn-inverse" data-loading-text="正在保存……"
                       proxy='{"method":"post", "formId":"J_ListForm","location":"<?php echo $index_url?>"}'>
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