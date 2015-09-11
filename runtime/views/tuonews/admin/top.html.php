<!DOCTYPE html>
<html lang="cn-zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FiiDee blog admin manager">
    <meta name="author" content="yangjian102621@163.com">
    <link rel="icon" href="/res/global/images/favicon.ico">

    <title><?php echo $appConfigs[admin_title]?></title>

    <!-- Bootstrap core CSS -->
    <?php echo $this->importResource('gres', 'css', 'bootstrap.min.css')?>

    <!-- Custom styles for this template -->
    <?php echo $this->importResource('gres', 'css', 'JDialog.css')?>
    <?php echo $this->importResource('gres', 'css', 'flat-ui.css')?>
    <?php echo $this->importResource('res', 'css', 'admin.css')?>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <?php echo $this->importResource('gres', 'js', 'html5shiv.js')?>
    <?php echo $this->importResource('gres', 'js', 'respond.min.js')?>
    <![endif]-->

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo url("/admin_index_index") ?>"><?php echo $appConfigs[admin_title]?></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav" id="system-menu-tab">
                <?php $i=0 ?>
                <?php foreach ( $__menuGroups as $key => $val ) { ?>
                <?php if ( empty($systemMenu[$val[tkey]]) ) { ?>
                    <?php continue ?>
                <?php } ?>
                <li <?php if ( $val[tkey] == $mgroup || ($i == 0 && $mgroup=='') ) { ?>class="active"<?php } ?>>
                    <a href="#menu_<?php echo $val[tkey]?>" data-toggle="tab" id="menu-tab-<?php echo $val[tkey]?>">
                        <em class="glyphicon glyphicon-<?php echo $val[icon]?>"></em> <?php echo $val[name]?></a>
                </li>
                <?php $i++ ?>
                <?php } ?>
            </ul>

            <!-- dropdown menu -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown" role="menu">
                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $loginUser[username]?> <span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#user-info"><i class="glyphicon glyphicon-envelope"></i> 用户信息</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#modify-password"><i class="glyphicon glyphicon-lock"></i> 修改密码</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="<?php echo url("/admin_login_logout/?op=logout") ?>"><i class="glyphicon glyphicon-share"></i> 安全退出</a></li>
                        <li role="presentation" class="divider"></li>
                    </ul>
                </li>
            </ul><!-- /dropdown menu END -->

        </div>
    </div>
</nav>

<div aria-hidden="false" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="0" class="modal fade" id="user-info">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-user"></i> 当前登陆用户信息</h4>
            </div>
            <div class="modal-body">
                <p>用户名：<?php echo $loginUser[username]?></p>
                <p>创建时间：<?php echo $this->getDate($loginUser[add_time], "") ?></p>
                <p>最后登陆时间：<?php echo $this->getDate($loginUser[last_login_time], "") ?></p>
                <p>最后登陆IP：<?php echo $loginUser[last_login_ip]?></p>
                <p>简介：<?php echo $loginUser[summary]?></p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div aria-hidden="false" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="0" class="modal fade" id="modify-password">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-lock"></i> 修改密码</h4>
            </div>
            <div class="modal-body">
                <div role="alert" id="password-alert" class="alert alert-danger alert-dismissible fade in" style="display: none;">
                    <strong id="password-error-message"></strong>
                </div>

                <form id="pass-modify-form" autocomplete="off">
                    <div class="form-group">
                        <label>原密码</label>
                        <input type="password" class="form-control" name="oldpass" placeholder="原密码">
                    </div>
                    <div class="form-group">
                        <label>新密码</label>
                        <input type="password" class="form-control" name="password" placeholder="新密码">
                    </div>
                    <div class="form-group">
                        <label>确认密码</label>
                        <input type="password" class="form-control" name="repass" placeholder="确认密码">
                    </div>
                    <a href="<?php echo url("/admin_admin_password") ?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……"
                       proxy='{"formId":"pass-modify-form", "method":"post", "callBefore":"editpassCallbefore(data);", "callBack":"editpassCallback(data);", "validate":"1"}'>保存修改</a>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>

    //修改密码提交前回调函数
    function editpassCallbefore(data) {
        var oldpass = $.trim($('input[name="oldpass"]').val());
        var password = $.trim($('input[name="password"]').val());
        var repass = $.trim($('input[name="repass"]').val());
        if ( oldpass == '' ) {
            editPassMessage('原密码不能为空！');
            return false;
        }
        if ( password == '' ) {
            editPassMessage('新密码不能为空！');
            return false;
        }
        if ( repass == '' ) {
            editPassMessage('确认密码不能为空！');
            return false;
        }

        if ( password != repass ) {
            editPassMessage('两次输入密码不一致！');
            return false;
        }
        return true;
    }

    //修改密码回调函数
    function editpassCallback(data) {

        if ( data.state == 'ok' ) {
            setTimeout(function() {
                $('#modify-password').modal('hide');
                $('#password-alert').hide();
            }, 1500);

            editPassMessage(data.message);
            $('#password-alert').removeClass('alert-danger').addClass('alert-success');
        } else {
            editPassMessage(data.message);
        }

        return false;
    }

    //显示错误信息
    function editPassMessage(message) {

        $('#password-alert').show().removeClass('alert-success').addClass('alert-danger');
        $('#password-error-message').html(message);

    }
</script>

