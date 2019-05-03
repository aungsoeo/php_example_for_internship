function next() {
	if($("#emp_code").val()==""){
		alert("社員コード、社員名の何れかを入力して下さい");
		return false;
	}else{
		var emp_code=$("#emp_code").val();
		var emp_name=$("#emp_name").val();

		if (emp_code.length > 5) {
			alert("empcode can't be greater than 5 character! ");
			return false;
		}

		if (emp_name.length > 20) {
			alert("emp_name can't be greater than 20 character! ");
			return false;
		}
		var check_age=($("#check_age").is(':checked'))?1:0;
		var paramData=new Array();
		paramData.push({name: 'emp_code',value : emp_code});
		paramData.push({name: 'emp_name',value : emp_name});
		paramData.push({name: 'check_age' ,value:  check_age});
		paramData.push({name: 'flag' ,value:  "ADD"});
		console.log(paramData);

        $.ajax({
            type:"POST",
            url:"ajax/ptest_setting.php",
            data: paramData,
            success:function(response){
				location.href="list.php";           
            }
        });
	}
}

function update(code,name,age){
	var flag="UPDATE";
	if(code != '' || name != '' || age !=''){
        location.href = "index.php?code="+code+"&name="+name+"&age="+age+"&flag="+flag;
    }      
}

function Delete(empcode){
	var r = confirm("Are are sure!");
    if (r == false) {
        return false;
    }

	var paramData=new Array();
	paramData.push({name: 'emp_code',value : empcode});
	paramData.push({name: 'flag' ,value:  "DELETE"});
    $.ajax({
        type:"POST",
        url:"ajax/ptest_setting.php",
        data: paramData,
        success:function(res){
            location.href="list.php";
         }
      });
}