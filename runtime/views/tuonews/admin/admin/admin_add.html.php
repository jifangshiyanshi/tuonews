<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li>
                    <a href="<?php echo url("/admin_admin_index") ?>"><em class="glyphicon glyphicon-th-list"></em> 管理员列表</a>
                </li>
                <li class="active">
                    <a href="javascript:void(0);"><em class="glyphicon glyphicon-plus"></em> 添加管理员</a>
                </li>
            </ul>

            <div class="container placeholders">
                <form class="form-horizontal" autocomplete="off" id="content_add_form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 所属角色</label>
                        <div class="col-sm-10">
                            <select name="data[role_id]" data-toggle="select" class="form-control select select-default" required autofocus>
                                <?php foreach ( $roles as $value ) { ?>
                                <option value="<?php echo $value[id]?>"><?php echo $value[name]?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 用户名</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[username]" class="form-control" dtype="uname" max-length="20" placeholder="用户名" required autofocus>
                            <p class="help-block">由字母，数字，下划线组成，长度不超过20</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 姓名</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[name]" class="form-control" max-length="10" placeholder="姓名" required autofocus>
                            <p class="help-block">填写管理员的真实姓名或者笔名,长度不超过20</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 登陆密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="data[password]" class="form-control" id="password" placeholder="登陆密码" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 重复密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="repass" dtype="repass" for-password="password" class="form-control" placeholder="重复密码" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">是否激活</label>
                        <div class="col-sm-10">
                            <input type="checkbox" data-toggle="switch"  checked />
                            <input type="hidden" name="data[status]" value="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">管理员类别</label>
                        <div class="col-sm-10">
                            <label class="radio">
                                <input type="radio" data-toggle="radio" name="data[isystem]" value="0" />
                                系统管理员
                            </label>
                            <label class="radio">
                                <input type="radio" data-toggle="radio" name="data[isystem]" value="0" checked />
                                普通管理员
                            </label>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">备注</label>
                        <div class="col-sm-10">
                            <textarea name="data[summary]" class="form-control"></textarea>
                            <p class="help-block">长度不超过100</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <a href="<?php echo $insert_url?>"  class="btn btn-inverse ajaxproxy" data-loading-text="正在提交……"
                               proxy='{"formId":"content_add_form", "method":"post", "location":"<?php echo $index_url?>", "callbackDelay":"1000"}'>保存修改</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<?php include $this->getIncludePath('admin.footer')?>