<!DOCTYPE html>
<html lang="cn-zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FiiDee blog admin manager">
    <meta name="author" content="yangjian102621@163.com">
    <link rel="icon" href="/res/global/images/favicon.png">

    <title><?php echo $appConfigs[admin_title]?></title>

    <!-- Bootstrap core CSS -->
    <?php echo $this->importResource('gres', 'css', 'bootstrap.min.css')?>

    <?php echo $this->importResource('gres', 'css', 'flat-ui.css')?>

    <!-- Custom styles for this template -->
    <?php echo $this->importResource('res', 'css', 'login.css')?>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <?php echo $this->importResource('gres', 'js', 'html5shiv.js')?>
    <?php echo $this->importResource('gres', 'js', 'respond.min.js')?>
    <![endif]-->

</head>

<body>
    <div class="container">

        <form class="form-signin" autocomplete="off" action="#login">

            <div class="login">
                <div class="login-screen">
                    <div class="login-icon">
                        <img alt="<?php echo $appConfigs[admin_login_title]?>" src="<?php echo $appConfigs['res_url']?>/res/global/images/login/icon.png">
                        <h4><?php echo $appConfigs[admin_login_title]?></h4>
                    </div>

                    <div role="alert" class="alert alert-danger alert-dismissible fade in">
                        <strong></strong>
                    </div>

                    <div class="login-form">

                        <div class="form-group">
                            <input type="text" id="username" placeholder="用户名" name="username" class="form-control login-field">
                            <label for="username" class="login-field-icon fui-user"></label>
                        </div>

                        <div class="form-group" id="password-label">
                            <input type="password" id="password" placeholder="密码" class="form-control login-field">
                            <label for="password" class="login-field-icon fui-lock"></label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="return login();">登录系统</button>
                    </div>
                </div>
            </div>
        </form>

        <script type="text/html">

            <!--<div class="form-group">-->
                <!--<input type="text" id="safe-code" placeholder="验证码"  class="form-control login-field">-->
                <!--<img src="<?php echo url("/common_vcode_show/?size=big&charnum=5") ?>" class="scode-img"-->
                     <!--onclick="this.src='<?php echo url("/common_vcode_show/?size=big&charnum=5") ?>?run='+Math.random();">-->
                <!--<label for="safe-code" class="login-field-icon fui-image"></label>-->
            <!--</div>-->

        </script>
    </div> <!-- /con  </script>
<!-- Placed at the end of the document so the pages load faster -->
<?php echo $this->importResource('gres', 'js', 'jquery-1.11.2.min.js')?>
<script>
    /**
     * 登录操作
     */
    function login() {

        //字段验证
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        if ( username == '' ) {
            showErrorMessage('请填写用户名！');
            return false;
        }
        if ( password == '' ) {
            showErrorMessage('请填写密码！');
            return false;
        }

        //发送登录请求
        $.post('<?php echo url("/admin_login_signin") ?>', {
            username : username,
            password : password
        }, function ( res ) {

            if ( res.state == '0' ) {
                location.replace('<?php echo url("/admin_index_index") ?>');
            } else {
                showErrorMessage(res.message);
            }

        }, 'json');

        return false;
    }

    /**
     * 显示错误信息
     */
    function showErrorMessage( message ) {
        $('.alert').show().find('strong').html(message);
    }
</script>
</body>
</html>