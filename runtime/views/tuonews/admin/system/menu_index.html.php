<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <!-- content form start -->
            <form  id="J_ListForm" name="contentListForm">
                <ul role="tabpanel" class="nav nav-tabs" id="menu-group-tab">
                    <?php foreach ( $menuGroups as $key => $val ) { ?>
                    <li><a href="#<?php echo $key?>" data-toggle="tab"><?php echo $val['name']?></a></li>
                    <?php } ?>
                </ul>

                <div class="tab-content" style="padding-top: 10px;">
                    <?php foreach ( $menuGroups as $key => $gval ) { ?>
                    <div role="tabpanel" class="table-responsive tab-pane fade" id="<?php echo $key?>">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>菜单名称</th>
                                <th>URL</th>
                                <th>排序数字</th>
                                <th>是否显示</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if ( empty($items[$key])  ) { ?>
                            <tr>
                                <td class="empty-table-td"><?php echo $emptyRecord?></td>
                            </tr>
                            <?php } ?>

                            <?php foreach ( $items[$key] as $value ) { ?>

                            <tr id="items_<?php echo $value['id']?>">
                                <td>
                                    <?php echo $value[id]?>
                                    <input type="hidden" name="hids[<?php echo $value[id]?>]" value="<?php echo $value[id]?>" />
                                </td>
                                <td>
                                    <input type="text" name="data[<?php echo $value[id]?>][name]" value="<?php echo $value[name]?>" class="form-control input-sm" />
                                </td>

                                <td>
                                    <input type="text" name="data[<?php echo $value[id]?>][url]" value="<?php echo $value[url]?>" class="form-control input-sm" />
                                </td>
                                <td class="has-warning">
                                    <input type="text" name="data[<?php echo $value[id]?>][sort_num]" value="<?php echo $value[sort_num]?>" class="form-control input-sm" />
                                </td>
                                <td>
                                    <input type="checkbox" data-toggle="switch"  <?php if ( $value['ishow']==1 ) { ?>checked<?php } ?> />
                                    <input type="hidden" name="data[<?php echo $value[id]?>][ishow]" value="<?php echo $value[ishow]?>">
                                </td>
                                <td><?php echo $this->getDate($value['add_time'], "") ?></td>

                                <td>
                                    <a href="<?php echo url("/admin_menu_add/?pid=$value[id]") ?>" data-toggle="tooltip" title="添加子菜单" class="btn btn-xs btn-inverse">添加</a>
                                    <a href="<?php echo url("/admin_menu_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                    <a href="<?php echo url("/admin_menu_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
                                        <i class="glyphicon glyphicon-remove"></i> 删除</a>
                                </td>
                            </tr>

                            <!-- 二级菜单 -->
                            <?php foreach ( $subitems[$value['id']] as $val ) { ?>
                            <tr id="items_<?php echo $val['id']?>" class="items_<?php echo $value['id']?>">
                                <td>
                                    <?php echo $val[id]?>
                                    <input type="hidden" name="hids[<?php echo $val[id]?>]" value="<?php echo $val[id]?>" />
                                </td>

                                <td style="padding-left: 30px;">
                                    <input type="hidden" name="hids[<?php echo $val[id]?>]" value="<?php echo $val['id']?>" />

                                    <input type="text" name="data[<?php echo $val[id]?>][name]" value="<?php echo $val[name]?>" class="form-control input-sm" />
                                </td>

                                <td>
                                    <input type="text" name="data[<?php echo $val[id]?>][url]" value="<?php echo $val[url]?>" class="form-control input-sm" />
                                </td>
                                <td>
                                    <input type="text" name="data[<?php echo $val[id]?>][sort_num]" value="<?php echo $val[sort_num]?>" class="form-control input-sm" />
                                </td>
                                <td>
                                    <input type="checkbox" data-toggle="switch"  <?php if ( $val['ishow']==1 ) { ?>checked<?php } ?> />
                                    <input type="hidden" name="data[<?php echo $val[id]?>][ishow]" value="1">
                                </td>
                                <td><?php echo $this->getDate($val['add_time'], "") ?></td>

                                <td>
                                    <a href="<?php echo url("/admin_menu_edit/?id=$val[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                    <a href="<?php echo url("/admin_menu_delete/?id=$val[id]") ?>" class="btn btn-xs btn-danger delone">
                                        <i class="glyphicon glyphicon-remove"></i> 删除</a>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>

                <div class="opt_box">
                    <a href="<?php echo $add_url?>" class="btn btn-sm btn-primary"><em class="glyphicon glyphicon-plus"></em> 添加菜单</a>
                    <a href="<?php echo $quicksave_url?>" class="ajaxproxy btn btn-sm btn-inverse" data-loading-text="正在保存……"
                       proxy='{"method":"post", "formId":"J_ListForm", "location":"reload"}'>
                        <em class="glyphicon glyphicon-saved"></em> 快速保存</a>
                </div>

            </form><!-- form END -->

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<script language="javascript">
    $(document).ready(function() {
        $('#menu-group-tab a:first').tab('show');
    });

</script>

<?php include $this->getIncludePath('admin.footer')?>