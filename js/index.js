window.onload=function(){

	var content = document.getElementById('content');
	EventUtil.addHandler(content,'click',clickhandler);
}

function clickhandler(e){

	var eve=EventUtil.getEvent(e);
	var target=EventUtil.getTarget(eve);

	if(target.className.indexOf('subm')>=0){//处理删除事件		
		EventUtil.preventDefault(eve);
		target.value="发送中……";target.disable=true;target.className="havesub";
		var myform=target.form;
		var url=myform.action;
		var content=myform.elements['content'];
		var liform=myform.parentNode;
		var xhr=AjaxUtil.createXHR();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4){
				if((xhr.status>=200&&xhr.status<300)||xhr.status==304){
					if(xhr.responseText==""){
						alert("新增失败");
						target.disable=false;target.className="subm";target.value="回复";
					}else{
						content.value='';
						var lii=document.createElement('li');
						lii.innerHTML=xhr.responseText;
						liform.parentNode.insertBefore(lii,liform);
						target.disable=false;target.className="subm";target.value="回复";
					}
				}
			}
		}
		xhr.open("POST",url,true);
		xhr.setRequestHeader("content-Type","application/x-www-form-urlencoded");
		xhr.send(serialize(myform));

	}
	if(target.className.indexOf('havesub')>=0){EventUtil.preventDefault(eve);}
	
	if(target.className.indexOf('del')>=0){//处理删除事件		
		EventUtil.preventDefault(eve);
		var ulmsgc=target.parentNode.parentNode;
		var ahref=target.href;
		var xhr=AjaxUtil.createXHR();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4){
				if((xhr.status>=200&&xhr.status<300)||xhr.status==304){
					ulmsgc.innerHTML='';
					alert('已删除该信息！');
				}
			}
		}
		xhr.open("get",ahref,true);
		xhr.send(null);

	}

	if(target.className.indexOf('unfold')>=0){//处理展开事件
			EventUtil.preventDefault(eve);
		var ulmsgc=DomUtil.getnextnode(target.parentNode.nextSibling);
		var ahref=target.href;
		var xhr=AjaxUtil.createXHR();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4){
				if((xhr.status>=200&&xhr.status<300)||xhr.status==304){
					ulmsgc.innerHTML+=xhr.responseText;
					target.href=ahref.replace(/(action=)(.*)(&)/,'$1fold$3');
					target.text='收起';
					target.className='fold';
				}else{
					alert("展开失败");
				}
			}
		}
		xhr.open("get",ahref,true);
		xhr.send(null);
	}else{
		if(target.className.indexOf('fold')>=0){//处理展开事件
				EventUtil.preventDefault(eve);
			var ulmsgc=DomUtil.getnextnode(target.parentNode.nextSibling);
			var ahref=target.href;
			var xhr=AjaxUtil.createXHR();
			xhr.onreadystatechange=function(){
				if(xhr.readyState==4){
					if((xhr.status>=200&&xhr.status<300)||xhr.status==304){
						ulmsgc.innerHTML=xhr.responseText;
						target.href=ahref.replace(/(action=)(.*)(&)/,'$1unfold$3');
						target.text='展开';
						target.className='unfold';
					}
				}
			}
			xhr.open("get",ahref,true);
			xhr.send(null);
		}
	}

}

//用 Ajax 进行操作

//定饭店