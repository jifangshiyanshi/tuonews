
        <div class="col-sm-3 col-md-2 sidebar">

            <div class="tab-content">
                <?php $i = 0 ?>
                <?php foreach ( $systemMenu as $key => $group ) { ?>
                <?php if ( empty($systemMenu[$key]) ) { ?>
                    <?php continue ?>
                <?php } ?>
                <!-- ul -->
                <ul class="nav nav-sidebar tab-pane <?php if ( $key == $mgroup || ($mgroup == '' && $i==0) ) { ?>active<?php } ?>" id="menu_<?php echo $key?>">
                    <?php foreach ( $group as $fmenu ) { ?>
                    <li <?php if ( $mpid==$fmenu[id] ) { ?>class="active"<?php } ?>>

                        <!-- 一级菜单 -->
                        <a data-toggle="collapse" href="#collapse_<?php echo $fmenu[id]?>" aria-expanded="false" aria-controls="collapseExample">
                            <span class="glyphicon glyphicon-th-large"></span> <?php echo $fmenu[name]?></a>

                        <ul class="nav nav-sidebar-2 collapse in" id="collapse_<?php echo $fmenu[id]?>">
                            <!-- 二级菜单 -->
                            <?php foreach ( $fmenu[sub] as $value ) { ?>
                            <li <?php if ( $value[url]==$currentOpt || $mid==$value[id] ) { ?>class="active"<?php } ?>>
                                <a href="<?php echo url("$value[url]/m-$value[id]") ?>">
                                    <i class="glyphicon glyphicon-record"></i> <?php echo $value[name]?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul><!-- 二级菜单 -->
                    </li>
                    <?php } ?>
                </ul><!-- end ul -->
                <?php $i++ ?>
                <?php } ?>
            </div>
        </div>
