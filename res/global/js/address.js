/*
*三联省市选择
*@version beat 0.1
*@author zhao
*@date 2015-03-03 
*@email moki0084@gmail.com
*@update 2015-03-03
*/
/*
  原生js
*/
function setAddress(fn){
  var province=document.getElementById('province');
  var city=document.getElementById('city');
  var district=document.getElementById('district');
  var html='<option>请选择</option>';
  var defaultHtml=html;
  var callback=fn;
  //获取地址字符串
  function getAdd(arr){
    for(var i=0;i<arr.length;i++){
      html+= '<option value="'+jsonp210[arr[i]].n+'" data-code="'+jsonp210[arr[i]].c+'">'+jsonp210[arr[i]].n+'</option>';
    }
    return html;
  }
  //设置地点
  function setAdd(name,arr,dom){
    for(var i=0;i<arr.length;i++){
      if(arr[i].innerHTML.indexOf(name)!=-1){
        arr[i].selected=true;
        if(dom){
          dom.onchange();
        }
        return;
      }
    }
  }
  //获取地点
  function getCode(element,value){
    var len = element.length;
    for(var i=0;i<len;i++){
      if(element[i].innerHTML==value){
        return element[i].getAttribute('data-code');
      }
    }
  }
  //初始化
  function init(){
    //三联 要可以添加默认ID 初始化
    var shengArr=jsonp210[1].ch;
    province.innerHTML=getAdd(shengArr);
    //省
    province.onchange=function(){
      html=defaultHtml;
      if(city){
        city.innerHTML=html;
      }
      if(district){
        district.innerHTML=html;
      }
      var options=this.getElementsByTagName('option');
      var code=getCode(options,this.value);
      if(code){
        var cityArr=jsonp210[code].ch;
        city.innerHTML=getAdd(cityArr);
      }
    };
    //市
    if(city){
      city.onchange=function(flag){
        html=defaultHtml;
        if(district){
          district.innerHTML=html;
          var options=this.getElementsByTagName('option');
          var code=getCode(options,this.value);
          if(code){
            var districtArr=jsonp210[code].ch;
            if(districtArr){
              district.innerHTML=getAdd(districtArr);
              district.style.display='inline';
            }else{
              district.style.display='none';
              if(callback&&flag){
                callback();
              }
            }
          }
        }
      }
    }
    //区
    if(district){
      district.onchange=function(flag){
        if(callback&&flag){
          callback();
        }
      }
    }
    //ip 自动获取地址
    try {
      var provinceOption=province.getElementsByTagName('option');
      setAdd(remote_ip_info.province,provinceOption,province);
      var cityOption=city.getElementsByTagName('option');
      setAdd(remote_ip_info.city,cityOption,city);
      var districtOption=district.getElementsByTagName('option');
      setAdd(remote_ip_info.district,districtOption);
    } catch (ex){
     console.log('不支持新浪ip查询')
    }
  }
  init();
}