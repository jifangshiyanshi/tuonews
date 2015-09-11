<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 报名表</a>
                </li>
            </ul>

            <form id="J_ListForm" role="form" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="20">

                            </th>
                            <th>姓名</th>
                            <th>电话</th>
                            <th>时间</th>

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
                            </td>
                            <td><?php echo $value['name']?></td>
                            <td><?php echo $value['mobile']?></td>
                            <td><?php echo $this->getDate($value['addtime'], "") ?></td>

                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </form>
            <style type="text/css">
                .page .current {
                    background: #4c4c4c;
                    border-color: #4c4c4c;
                    color: #fff;
                }
                .page>li {
                    width: 46px;
                    height: 46px;
                    border: 1px solid #ddd;
                    margin: 0 3px;
                    vertical-align: top;
                    line-height: 46px;
                    text-align: center;
                    font-size: 14px;
                    display: inline-block;
                }
                .page>li a {
                    display: block;
                    width: 46px;
                    height: 46px;
                    color: #8b8b8b;
                }


            </style>
            <nav>
                <?php echo $pagemenu?>
            </nav>

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<?php include $this->getIncludePath('admin.footer')?>