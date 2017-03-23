// JavaScript Document
window.onload=function(){
	// var formseri;
	var submitbtn = document.getElementById("submitbtn");
	EventUtil.addHandler(submitbtn, "click", function(eventa){
		EventUtil.preventDefault(eventa);
		submitData();
/*	    var form = document.forms[0];
	     formseri=serialize(form);
	     console.log("序列化后的结果"+formseri);//调试*/
	});

	//绑定事件
	var form=document.forms[0];
	EventUtil.addHandler(form,"keyup",keyupEvent);
	EventUtil.addHandler(form,"paste",keyupEvent);
	for(var i=0,len=form.elements.length;i<len;i++){
		EventUtil.addHandler(form.elements[i],"focus",focusEvent);
	}
	for(var i=0,len=form.elements.length;i<len;i++){
		EventUtil.addHandler(form.elements[i],"blur",blurEvent);
	}	
}

//处理focus事件
function focusEvent(eventa){
		var formeles=document.forms[0].elements;
		var eve=EventUtil.getEvent(eventa);
		var target=EventUtil.getTarget(eve);
		if(target.type=="text"){//==判断请使用“==”，而不要用“=”
			target.select();
		}
		
}
//处理blur事件
function blurEvent(eventa){
	var formeles=document.forms[0].elements;
	var eve=EventUtil.getEvent(eventa);
	var target=EventUtil.getTarget(eve);
	var parent=target.parentNode;
	if(target.name=="checknum"){//==判定用双等号“==”
		var parentCheck=parent.parentNode;
		var parent3=DomUtil.getnextnode(parentCheck.nextSibling);
		var msgeleCheck=DomUtil.getnextnode(parent3.firstChild);	
	}else{
		var parent2=DomUtil.getnextnode(parent.nextSibling);
		var msgele=DomUtil.getnextnode(parent2.firstChild);
	}
	switch(target.name){
	case "phone"://==phone需要加引号，是字符串
		if(/^\d{11}$/.test(target.value)){
			msgele.innerHTML="OK";
			msgele.style.color="green";
			DomUtil.addClass(target,"ok");
		}else{
			msgele.innerHTML="请输入11位手机号码";
			msgele.style.color="red";
			DomUtil.deleteClass(target,"ok");
		}
		break;
	case "checknum":	
		if(/^\d{4}$/.test(target.value)){
			msgeleCheck.innerHTML="OK";
			msgeleCheck.style.color="green";
		}else if(target.value==""){
			msgeleCheck.innerHTML="为必填项，不能为空";	
			msgeleCheck.className="help-block";
			msgeleCheck.style.color="blue";	
		}else{
			msgeleCheck.innerHTML="校验码为4位数字";
			msgeleCheck.style.color="red";
		}
		break;
	case "password":	
// 密码必须由6-16位字母、数字、下划线组成，必须包含字母、数字，不能以下划线开头
		reg =/^(?=.*[a-zA-Z])(?=.*\d)(?![_])\w{6,16}$/;
		if(reg.test(target.value)){
			msgele.innerHTML="OK";
			msgele.style.color="green";
			DomUtil.addClass(target,"ok");
			formeles["password2"].disabled=false;
			formeles["password2"].focus();
		}else if(target.value==""){
			msgele.innerHTML="为必填项，不能为空";	
			msgele.className="help-block";
			msgele.style.color="blue";
			DomUtil.deleteClass(target,"ok");	
			formeles["password2"].disabled=true;
		}else{
			msgele.innerHTML="密码必须由6-16位字母、数字、下划线组成，必须包含字母、数字，不能以下划线开头";
			msgele.style.color="red";
			DomUtil.deleteClass(target,"ok");
			formeles["password2"].disabled=true;
		}
		break;
	case "password2":	
		if(target.value==formeles["password"].value){
			msgele.innerHTML="OK";
			msgele.style.color="green";
			DomUtil.addClass(target,"ok");
		}else if(target.value==""){
			msgele.innerHTML="为必填项，不能为空";	
			msgele.className="help-block";
			msgele.style.color="blue";	
			DomUtil.deleteClass(target,"ok");
		}else{
			msgele.innerHTML="请重新输入";
			msgele.style.color="red";
			DomUtil.deleteClass(target,"ok");
		}
		break;
	case "name":	
	//1,数字、字母、汉子、下划线;2,5-25个字符，推荐使用中文会员名
		var reg=/[\w\u4e00-\u9fa5]+/;
		var nameleg=getLength(target.value);
		if(reg.test(target.value)){
			if(nameleg>=5&&nameleg<=25){
				msgele.innerHTML="ok";
				msgele.style.color="green";
				DomUtil.addClass(target,"ok");
			}else if(target.value==""){
				msgele.innerHTML="为必填项，不能为空";	
				msgele.className="help-block";
				msgele.style.color="red";	
				DomUtil.deleteClass(target,"ok");
			}else{
				msgele.innerHTML="应由数字、字母、汉字、下划线组成，5-25个字符，推荐使用中文会员名";
				msgele.style.color="red";
				DomUtil.deleteClass(target,"ok");
			}
		}
		break;
	case "cardid":	
		reg =/^\d{18}(x)?$/;
		if(reg.test(target.value)){
			msgele.innerHTML="ok";
			msgele.style.color="green";	
			DomUtil.addClass(target,"ok");
		}else{
			msgele.innerHTML="请输入18位身份证号,末位可为x";
			msgele.style.color="red";
			DomUtil.deleteClass(target,"ok");
		}
		break;
	case "email":	
	var rege=/^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g;
	if(reg.test(target.value)){
		msgele.innerHTML="ok";
		msgele.style.color="green";		
		DomUtil.addClass(target,"ok");
	}else{
		msgele.innerHTML="您输入的邮箱不合法";
		msgele.style.color="red";
		DomUtil.deleteClass(target,"ok");
	}
		break;
	case "question":	

		break;
	}
}

//处理keyup事件
function keyupEvent(eventa){
	var formeles=document.forms[0].elements;
	var eve=EventUtil.getEvent(eventa);
	var target=EventUtil.getTarget(eve);
	var parent=target.parentNode;
	if(target.name=="checknum"){
		var parentCheck=parent.parentNode;
		var parent3=DomUtil.getnextnode(parentCheck.nextSibling);
		var msgeleCheck=DomUtil.getnextnode(parent3.firstChild);	
	}else{
		var parent2=DomUtil.getnextnode(parent.nextSibling);
		var msgele=DomUtil.getnextnode(parent2.firstChild);
	}

	switch(target.name){
	case "phone"://==phone需要加引号，是字符串
		if(/^\d{11}$/.test(target.value)){
			msgele.innerHTML="OK";
			msgele.style.color="green";
			formeles["freeget"].focus();
		}else if(target.value==""){
			msgele.innerHTML="为必填项，不能为空";	
			msgele.className="help-block";
			msgele.style.color="red";	
		}else{
			msgele.innerHTML="请输入11位手机号码";
			msgele.style.color="red";
		}
		break;
	case "checknum":
		if(/^\d{4}$/.test(target.value)){
			msgeleCheck.innerHTML="";
			msgeleCheck.style.color="";		
		}else{
			msgeleCheck.innerHTML="校验码为4位数字";
			msgeleCheck.style.color="red";
		}
		break;
	case "password":	
// 密码必须由6-16位字母、数字、下划线组成，必须包含字母、数字，不能以下划线开头
		var reg =/^(?=.*[a-zA-Z])(?=.*\d)(?![_])\w{6,16}$/;
		var passwordlen=target.value.length;
		var passwordcover=document.getElementsByClassName("passwordcover")[0];
		if(reg.test(target.value)){
			msgele.innerHTML="";
			msgele.style.color="#737373";
			formeles["password2"].disabled=false;
			passwordcover.innerText="强度低";
			passwordcover.style.width="30%";
			passwordcover.style.background="red";
			if(passwordlen>12){
				passwordcover.innerText="强度高";
				passwordcover.style.width="100%";
				passwordcover.style.background="green";
			}else if(passwordlen>8){
				passwordcover.innerText="强度中";
				passwordcover.style.width="60%";
				passwordcover.style.background="blue";
			}
		}else{
			msgele.innerHTML="密码必须由6-16位字母、数字、下划线组成，必须包含字母、数字，不能以下划线开头";
			msgele.style.color="red";
			formeles["password2"].disabled=true;
			passwordcover.innerText="";
			passwordcover.style.width="0";
		}
		break;
	case "password2":	
		if(target.value==formeles["password"].value){
			msgele.innerHTML="OK";
			msgele.style.color="green";
			target.blur();
		}else{
			msgele.innerHTML="";
			msgele.style.color="";
		}
		break;
	case "name":	
	//1,数字、字母、汉子、下划线;2,5-25个字符，推荐使用中文会员名
		var reg=/^[\w\u4e00-\u9fa5]*$/;
		var nameleg=getLength(target.value);
		if(reg.test(target.value)){
			if(nameleg>=5&&nameleg<=25){
				msgele.innerHTML="";
				msgele.style.color="";
			}else{
				msgele.innerHTML="字符数应为5-25个";
				msgele.style.color="red";
			}
		}else{
			msgele.innerHTML="姓名由数字、字母、汉子、下划线组成";
			msgele.style.color="red";
		}
		break;
	case "cardid":	

		break;
	case "email":	

		break;
	case "question":	

		break;
	}
}

//取字节数，其中汉字为双字节
function getLength(str){
	return str.replace(/[^\x00-\xff]/g,"xx").length;
}

function submitData(){
    var xhr = createXHR();        
    xhr.onreadystatechange = function(event){
        if (xhr.readyState == 4){
            if ((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
                console.log("回复的内容"+xhr.responseText);
            } else {
                alert("Request was unsuccessful: " + xhr.status);
            }
        }
    };
    
    xhr.open("post","formmanage.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var form = document.getElementById("usersign"); 
    var formseri=serialize(form);
    console.log("序列化后的结果"+formseri);           
    xhr.send(formseri);
    
}
