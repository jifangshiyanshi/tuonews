<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 菜单分组管理</a>
                </li>
                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon glyphicon-plus"></em> 添加菜单分组</a>
                </li>
            </ul>

            <div class="alert alert-warning" role="alert">
                <strong>操作说明：</strong> 菜单分组图标填写的是图标的css样式，具体样式参照bootstrap中的组件去填写。
                <a href="http://v3.bootcss.com/components/" target="_blank">http://v3.bootcss.com/components/</a>
                样式只要写后面的组合样式即可，通用样式不用填写！
            </div>
            
            <!-- 列表表单 -->
            <form id="J_ListForm" role="form" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>分组名称</th>
                            <th>分组key</th>
                            <th>图标icon</th>
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
                                <input type="hidden" name="hids[<?php echo $value[id]?>]" value="<?php echo $value['id']?>">
                            </td>
                            <td><input type="input" name="data[<?php echo $value[id]?>][name]" value="<?php echo $value['name']?>" class="form-control input-sm"></td>
                            <td><input type="input" name="data[<?php echo $value[id]?>][tkey]" value="<?php echo $value['tkey']?>" class="form-control input-sm"></td>
                            <td><input type="input" name="data[<?php echo $value[id]?>][icon]" value="<?php echo $value['icon']?>" class="form-control input-sm"></td>
                            <td><input type="input" name="data[<?php echo $value[id]?>][sort_num]" value="<?php echo $value['sort_num']?>" class="form-control input-sm"></td>
                            <td><?php echo $this->getDate($value[add_time], "") ?></td>
                            <td>
                                <a href="<?php echo url("/admin_menuGroup_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                <a href="<?php echo url("/admin_menuGroup_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">
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
                    <?php if ( $params[pid] > 0 ) { ?>
                    <a href="<?php echo $index_url?>" class="btn btn-sm btn-primary"><em class="glyphicon glyphicon-step-backward"></em> 返回上级</a>
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

<?php include $this->getIncludePath('admin.footer')?>