window.onload=function(){
	var userreg=document.forms['userreg'];
	var username=userreg['username'];
	var password=userreg['password'];
	EventUtil.addHandler(userreg,'submit',checksubmit);
	EventUtil.addHandler(username,'blur',usernameexist);
	EventUtil.addHandler(password,'keyup',checkpassword);
}

function checkpassword(e){
	var password= document.forms['userreg']['password'];
	var passtip=DomUtil.getnextnode(password.nextSibling);

	var passvalue=password.value;
	if(/^[_\ ]/.test(passvalue)){
		passtip.innerText="密码不能以下划线或空格开头";
		passtip.style.color='red';
	}else if(!/^\w*$/.test(passvalue)){
		passtip.innerText="密码只能由大小写字母、数字或下划线组成";
		passtip.style.color='red';
	}else if(!/.*[a-zA-Z]/.test(passvalue)||!/.*\d/.test(passvalue)){
		passtip.innerText="密码必须包含字母、数字";
		passtip.style.color='red';
	}else if(!/^\w{6,16}$/.test(passvalue)){
		passtip.innerText="密码长度应为6-16位";
		passtip.style.color='red';
	}else if(/^(?![_])(?=.*[a-z])(?=.*[A-Z])(?=.*\d)\w{8,16}$/.test(passvalue)){
		passtip.innerHTML='<div class="strong">强</div>';
		var passstrong=passtip.firstChild;
		passstrong.style.width='100%';
		passstrong.style.background='green';
		passstrong.style.color='black';
	}else if(/^(?![_])(?=.*[a-z])(?=.*\d)\w{8,16}$/.test(passvalue)
	         ||/^(?![_])(?=.*[A-Z])(?=.*\d)\w{8,16}$/.test(passvalue)
	         ||/^(?![_])(?=.*[_])(?=.*\d)\w{8,16}$/.test(passvalue)){
		passtip.innerHTML='<div class="strong">中</div>';
		var passstrong=passtip.firstChild;
		passstrong.style.width='60%';
		passstrong.style.background='green';
		passstrong.style.color='black';
	}else{
		passtip.innerHTML='<div class="strong">弱</div>';
		var passstrong=passtip.firstChild;
		passstrong.style.width='30%';
		passstrong.style.background='red';
		passstrong.style.color='black';
	}

	
}

function checksubmit(e){
	var eve=EventUtil.getEvent(e);
	EventUtil.preventDefault(eve);

	var userreg=document.forms['userreg'];
	var username=userreg.elements['username'];
	var password=userreg.elements['password'];
	var password2=userreg.elements['password2'];
	var email=userreg.elements['email'];
	var msgtip=document.getElementById('msgtip');
	var usernameflag=true;

	if(!/^[\u4e00-\u9fa5A-Za-z0-9]{1,10}$/.test(username.value)){
		msgtip.innerText="用户名不符合规范！";
	}else if(!/^(?![_])(?=.*[a-zA-Z])(?=.*\d)\w{6,16}/.test(password.value)){
		msgtip.innerText="密码不符合规范！";
	}else if(password.value!=password2.value){
		msgtip.innerText="两次密码不相同！";
	}else if(email.value==''&/^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/.test(email.value)){
		msgtip.innerText="Email不符合规范！";
	}else{
		userreg.submit();
	}
}

function usernameexist(e){
	var eve=EventUtil.getEvent(e);
	var target=EventUtil.getTarget(eve);
	var usertip=document.getElementById('usernameexist');
	var username=target.value;
	usertip.innerText='';
	//alert(username);
	if(target.value!=''){
		var xhr=AjaxUtil.createXHR();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4){
				if(xhr.status>=200&&xhr.status<300||xhr.status==304){
					console.log("Ajax验证用户名："+xhr.responseText);
					if(xhr.responseText==true){//可以注册
						//alert("已注册，请换一个用户名");
						usertip.innerText="该用户名已注册！";
						usertip.style.color="red";
					}else{
						usertip.innerText="该用户名未注册,可以使用！";
						usertip.style.color="green";
					}
				}else{
					alert("网络连接或服务器出错！");
				}
			}
		}
		xhr.open("post","register2.php?action=query",true);
		xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xhr.send("username="+username);
	}else{
		usertip.innerText="用户名不能为空！";
		usertip.style.color="red";
	}
}