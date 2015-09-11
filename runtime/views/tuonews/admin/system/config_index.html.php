<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ( $groups as $key => $value ) { ?>
                    <li role="presentation" class="<?php if ( $key == 'basic' ) { ?>active<?php } ?>">
                        <a href="#tab-pane-<?php echo $key?>" aria-controls="home" role="tab" data-toggle="tab"><?php echo $value?></a></li>
                    <?php } ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="padding-top:10px;">
                    <form id="J_ListForm" role="form" method="post">
                        <?php foreach ( $groups as $key => $value ) { ?>
                        <div role="tabpanel" class="table-responsive tab-pane fade <?php if ( $key=='basic' ) { ?>active in<?php } ?>" id="tab-pane-<?php echo $key?>">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>所属分组</th>
                                    <th>变量名</th>
                                    <th>变量值</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ( empty($items[$key]) ) { ?>
                                <tr>
                                    <td class="empty-table-td"><?php echo $emptyRecord?></td>
                                </tr>
                                <?php } ?>

                                <?php foreach ( $items[$key] as $value ) { ?>
                                <tr>
                                    <td><?php echo $groups[$value[groupkey]]?></td>
                                    <td><?php echo $value[varname]?></td>
                                    <td><span data-toggle="popover" data-content="<?php echo $value[varval]?>"><?php echo $this->cutString($value[varval], " 20") ?></span></td>
                                    <td><span data-toggle="popover" data-content="<?php echo $value[bak]?>"><?php echo $this->cutString($value[bak], " 20") ?></span></td>
                                    <td>
                                        <a href="<?php echo url("/admin_config_edit/?id=$value[id]") ?>" class="btn btn-xs btn-primary">编辑</a>
                                        <a href="<?php echo url("/admin_config_delete/?id=$value[id]") ?>" class="btn btn-xs btn-danger delone">删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                    </form>
                </div>

            </div>

            <div class="container row">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-config">
                    <i class="glyphicon glyphicon-plus-sign"></i> 添加配置信息
                </button>

                <div aria-hidden="false" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="-1" class="modal fade add-config">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                                <h4 id="myLargeModalLabel" class="modal-title">添加配置信息</h4>
                            </div>
                            <div class="modal-body">
                                <form id="config-add-form">
                                    <div class="form-group">
                                        <label>所属分组</label>
                                        <select name="data[groupkey]" data-toggle="select" class="form-control select select-default">
                                            <?php foreach ( $groups as $key => $value ) { ?>
                                            <option value="<?php echo $key?>"><?php echo $value?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>变量名</label>
                                        <input type="text" class="form-control" name="data[varname]" max-length="30" placeholder="变量名" required>
                                        <p class="help-block">同一个组的变量名必须保持唯一性,长度在30以内。</p>
                                    </div>
                                    <div class="form-group">
                                        <label>变量值</label>
                                        <textarea class="form-control" name="data[varval]" max-length="500" placeholder="变量值" required></textarea>
                                        <p class="help-block">长度在500以内,不区分中英文。</p>
                                    </div>
                                    <div class="form-group">
                                        <label>变量说明</label>
                                        <textarea class="form-control" name="data[bak]" max-length="100" placeholder="变量备注"></textarea>
                                        <p class="help-block">长度在100以内，不区分中英文。</p>
                                    </div>
                                    <a href="<?php echo $insert_url?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……"
                                       proxy='{"formId":"config-add-form", "method":"post", "location":"reload"}'>保存修改</a>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>


        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<script>
    //初始化弹出框
    $('[data-toggle="popover"]').popover({trigger:'hover', placement:'top', html:true});
</script>
<?php include $this->getIncludePath('admin.footer')?>