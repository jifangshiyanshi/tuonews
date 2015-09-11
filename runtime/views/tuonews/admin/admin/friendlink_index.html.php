<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 友链列表</a>
                </li>
                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon glyphicon-plus"></em> 添加友链</a>
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
                            <th>友链名称</th>
                            <th>所属频道</th>
                            <th>是否显示</th>
                            <th>排序</th>
                            <th>是否允许引擎抓取</th>
                            <!--<th>友链样式(文字|图片)</th>-->
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
                                    <input type="hidden" name="hids[<?php echo $value[id]?>]" value="<?php echo $value[id]?>" />
                                </label>
                            </td>
                            <td><?php echo $value[name]?></td>
                            <td><?php echo $chanels[$value[chanel_id]][name]?></td>
                            <td>
                                <input type="checkbox" data-toggle="switch"  <?php if ( $value['ishow']==1 ) { ?>checked<?php } ?> />
                                <input type="hidden" name="data[<?php echo $value[id]?>][ishow]" value="<?php echo $value[ishow]?>">
                            </td>
                            <td>
                                <input type="text" name="data[<?php echo $value[id]?>][sort_num]" value="<?php echo $value[sort_num]?>" class="form-control input-sm" />
                            </td>
                            <td>
                                <input type="checkbox" data-toggle="switch"  <?php if ( $value[nofollow]==1 ) { ?>checked<?php } ?> />
                                <input type="hidden" name="data[<?php echo $value[id]?>][nofollow]" value="<?php echo $value[nofollow]?>">
                            </td>
                            <td>
                                <a href="<?php echo url("/admin_friendLink_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_friendLink_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                    <i class="glyphicon glyphicon-remove"></i> 删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="container row">
                    <a href="<?php echo url("/admin_friendLink_deletes") ?>" class="btn btn-sm  btn-danger ajaxproxy" data-loading-text="正在删除"
                       proxy='{"formId":"J_ListForm", "method":"post", "location":"reload", "callBefore":"multiCallbefore(data);"}'>
                        <i class="glyphicon glyphicon-remove"></i> 删除</a>
                    <a href="<?php echo url("/admin_friendLink_quicksave") ?>" class="ajaxproxy btn btn-sm btn-inverse" data-loading-text="正在保存……"
                       proxy='{"method":"post", "formId":"J_ListForm","location":"reload"}'>
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
