<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <div class="alert alert-info">
                当前角色为 <span class="badge"><?php echo $item[name]?></span> 请为其分配权限
            </div>

            <div class="container">
                <form class="form-horizontal" autocomplete="off" id="content_add_form">
                    <table class="table table-bordered">
                        <tbody>
                            <?php foreach ( $permissionOptions as $key => $value ) { ?>
                            <tr>
                                <td class="col-md-2 text-right"><span class="text-info"><?php echo $value[name]?>：</span></td>
                                <td class="col-md-10 text-left">
                                    <label class="checkbox default" style="margin-right: 10px;">
                                        <input type="checkbox" data-toggle="checkbox" value="1" class="check-all" />&nbsp;全部
                                    </label>
                                    <?php foreach ( $value[methods] as $opt => $name ) { ?>
                                    <?php $opt_key = $key.'@'.$opt ?>
                                    <label class="checkbox default" style="margin-right: 10px;">
                                        <input type="checkbox" data-toggle="checkbox" name="data[<?php echo $opt_key?>]" <?php if ( $permissions[$opt_key]==1 ) { ?>checked<?php } ?> value="1" />&nbsp;<?php echo $name?>
                                    </label>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                     </table>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" name="id" value="<?php echo $item[id]?>" />
                            <a href="<?php echo url("/admin_role_updatePermission") ?>"  class="btn btn-inverse ajaxproxy" data-loading-text="正在提交……"
                               proxy='{"formId":"content_add_form", "method":"post", "location":"reload", "callbackDelay":"1000"}'>保存权限</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>
<script type="text/javascript">
    //绑定全选事件
    $('.check-all').on('change.radiocheck', function(e) {
        var target = e.target;
        var checkboxs = $(target).parents('td').find('input[type="checkbox"]');
        for ( var i = 0; i < checkboxs.length; i++ ) {
            checkboxs[i].checked = target.checked;
        }
    });
</script>
<?php include $this->getIncludePath('admin.footer')?>