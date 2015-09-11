<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <ul role="tablist" class="nav nav-pills">
                <li>
                    <a href="<?php echo $index_url?>"><em class="glyphicon glyphicon-th-list"></em> 模板列表</a>
                </li>

                <li>
                    <a href="<?php echo $add_url?>"><em class="glyphicon glyphicon-plus"></em> 添加模板</a>
                </li>

            </ul>

            <div class="container placeholders">
                <form class="form-horizontal" autocomplete="off" id="content_add_form">

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 模板名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[name]" class="form-control" max-length="20" value="<?php echo $item[name]?>" placeholder="模板名称" autofocus required>
                            <p class="help-block">长度不超过20个字符,不区分中英文</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">模板类型</label>
                        <div class="col-sm-10">
                            <select name="data[type]" data-toggle="select" class="form-control select select-default">
                                <?php foreach ( $templateTypes as $key => $value ) { ?>
                                <option value="<?php echo $key?>" <?php if ( $item[type] == $key ) { ?>selected<?php } ?>><?php echo $value?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">模板标识key</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[tkey]" class="form-control" value="<?php echo $item[tkey]?>" max-length="30" placeholder="模板标识key" required>
                            <input type="hidden" name="tkey_bak" value="<?php echo $item[tkey]?>" />
                            <p class="help-block">模板标识key，必须保持唯一性，不可重复，长度为30个英文字符以内</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序数字</label>
                        <div class="col-sm-10">
                            <input type="text" name="data[sort_num]" class="form-control" value="<?php echo $item[sort_num]?>" dtype="number" placeholder="排序数字" required>
                            <p class="help-block">排序数字，越小排序越靠前，不解释！</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            模板内容 <br/>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#template-tag-model">
                                查看模板标签
                            </button>
                        </label>
                        <div class="col-sm-10">
                            <textarea id="editor" name="data[content]" style="max-width:900px;height:500px;"><?php echo $item[content]?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" name="id" value="<?php echo $item[id]?>">
                            <a href="<?php echo $update_url?>"  class="btn btn-inverse ajaxproxy" data-loading-text="正在提交……"
                               proxy='{"formId":"content_add_form", "method":"post", "location":"<?php echo $index_url?>"}'>保存修改</a>
                            <a href="javascript:window.history.go(-1);" class="btn btn-primary"><i class="glyphicon glyphicon-fast-backward"></i> 返回列表</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal -->
            <div style="z-index: 10000" class="modal fade" id="template-tag-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">模板标签</h4>
                        </div>
                        <div class="modal-body">
                            <div class="well well-sm">调用模板时，标签可以被替换成指定的内容。</div>
                            <ul class="list-group">
                                <?php foreach ( $messageTags as $key => $value ) { ?>
                                <li class="list-group-item"><?php echo $key?>：<?php echo $value?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>
<!-- 引入编辑器 -->
<?php echo $this->importResource('cres', 'js', 'ueditor/tuonews.config.min.js')?>
<?php echo $this->importResource('cres', 'js', 'ueditor/ueditor.all.min.js')?>

<!-- 注册全局变量 -->
<script lang="javascript">

    //实例化编辑器
    var __UE = UE.getEditor('editor');
</script>

<?php include $this->getIncludePath('admin.footer')?>