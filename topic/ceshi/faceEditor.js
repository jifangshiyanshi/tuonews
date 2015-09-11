/**
 * options:
 *  facesrc  表情包地址
 *  editthml 编辑页面地址
 *  dom  编辑器对象  
 */
function faceEditor(options){
	var that = this;
	//变量定义 与错误检查
	this.showErrorMessage = function(msg){
		alert(msg);
		return;
	}
	
	if (typeof options !== 'object') {
		 this.showErrorMessage("请传入表情包地址 和 编辑器对象");alert(error);//既然用return 不能返回  干脆用一个错误的语让程序停止
	}

	this.facesrc = typeof options.facesrc !== 'undefined'?options.facesrc:'';
	this.dom = typeof options.dom !== 'undefined'?options.dom:null;
	this.edithtml = typeof options.edithtml !== 'undefined'?options.edithtml:'';
	this.facebox = typeof options.facebox !== 'undefined'?options.facebox:'';
	this.facebtn = typeof options.facebtn !== 'undefined'?options.facebtn:'';


	if(!this.dom){
		this.showErrorMessage("没有编辑器对象 dom");alert(error);
	}
    if( typeof this.dom === 'string' ){
    	this.dom = document.getElementById(this.dom);
    }
	if(!this.facesrc){ 
		this.showErrorMessage("没有表情包地址 facesrc");
		alert(error);
	}
	if(!this.edithtml){
		this.showErrorMessage("没有编辑器地址 edithtml");alert(error);
	}
	if(!this.facebox){
		this.showErrorMessage("没有表情框 facebox");alert(error);
	}
	if( typeof this.facebox === 'string'){
		this.facebox = document.getElementById(this.facebox);
	}
	if(!this.facebtn){
		this.showErrorMessage("没有表情激发按钮 facebox");alert(error);
	}
	if( typeof this.facebtn === 'string'){
		this.facebtn = document.getElementById(this.facebtn);
	}
	this.face = ['1','2','3','4','5','6'];//图片名字 这个可以运行用于更改
	this.facesuffix = '.jpg';//后缀
	that.createFaceList = function(){
		var str = '';
		for(var i = 0;i<that.face.length;i++){
			str += '<span ><img src="'+that.facesrc+that.face[i]+that.facesuffix+'" onclick="choiceface(this);" /></span>';
		}
		return str;
	};


	var innerhtml = '<iframe src="'+this.edithtml+'" id="_faceeditor" style="width:100%;height:100%;border:1px solid black;padding:0px;"></iframe>';

	that.dom.innerHTML = innerhtml;
	//编辑模式
	that.theEditor = document.getElementById("_faceeditor");
	that.theEditor.onload = function(){
		that.theEditorWin = that.theEditor.contentWindow;
		that.theEditorDoc = that.theEditorWin.document;
		that.theEditorDoc.body.contentEditable = true;
		that.theEditorDoc.designMode = 'on';
	}
	//隐藏表情框
	that.facebox.style.display = 'none';
	that.facebox.innerHTML = that.createFaceList();

	//表情触发按钮 客户端打开表情框的 时间

	that.facebtn.onclick = function(){
		that.facebox.style.display = 'block';
		//生成表情  表情的默认名字 只能是12345数字为名字 其他的不行
	}



	//表情框的管理 留给客户端
	
	this.getData = function(){
		
	};
	
	
}
