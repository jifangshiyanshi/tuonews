<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!-- 申请列表-->
            <div class="user_right_layout">
                <ul class="user_right_menu">
                    <li><a href="<?php echo url("/user_ucenter_mediaApply/?id=1") ?>">媒体</a></li>
                    <li><a href="<?php echo url("/user_ucenter_mediaApply/?id=2") ?>">自媒体</a></li>
                    <li><a href="<?php echo url("/user_ucenter_mediaApply/?id=3") ?>">企业</a></li>
                    <li class="current"><a href="#">申请列表</a></li>
                </ul>
                <div class="user_right_content user_right_content_form">
                    <!-- 申请列表 start-->
                    <table class="table_list">
                        <thead>
                            <tr>
                                <th>申请名称</th>
                                <th width="70px">申请类型</th>
                                <th width="140px">申请时间</th>
                                <th width="70px">审核状态</th>
                                <th width="70px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ( $items as $value ) { ?>
                        <tr>
                            <td><?php echo $value['name']?></td>
                            <td><?php echo $value['mediaType']?></td>
                            <td><?php echo date("Y-m-d H:i",$value[add_time]) ?></td>
                            <td><?php echo $value['ischeck']?></td>
                            <td><a href="<?php echo url("/user_ucenter_mediaApplyDetail/?id=$value[id]") ?>">查看详情</a></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <!-- 申请列表 end-->
                    <?php include $this->getIncludePath('common.module_page')?>
                </div>
            </div>
        </div>
        <div class="layout-left">
            <?php include $this->getIncludePath('user.module_aside')?>
        </div>
    </div>
</section>
<!--content end-->
<?php include $this->getIncludePath('user.footer')?>
