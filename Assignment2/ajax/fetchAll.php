<?php

include_once ("../common/webinit.php");


$rtn = 0; 
$msg = ''; //for showing message
$data = array(); 
$dtest=array();
$count = 0; 
$empcode = (isset($_POST['emp_code']) ? $_POST['emp_code'] : '');
$empname = (isset($_POST['emp_name']) ? $_POST['emp_name'] : '');
$age     = (isset($_POST['check_age']) ? $_POST['check_age'] :0);
$flag = (isset($_POST['flag']) ? $_POST['flag'] : '');


$data=array();

$con = cmDbCon();
if ($con === false) {
    $rtn = 1;
    $msg = MSG1;
}

if($rtn===0){
	$r=fnGetSQLTBLEMP($con);
	if($r["result"]!==true){
		$rtn=1;
		$msg=$r["result"];
	}else{
		$data=$r["data"];
	}
}

$rtnAry = array(
'data' => $data
);
echo (je($rtnAry));


//get function
function fnGetSQLTBLEMP($con){
	$data=array();
	$rs=true;
	$sql =" SELECT A.* FROM SQLTBLEMP AS A ";
	$param = array();
	$r = cmFetchAll($con, $sql, '', $param);
	if ($r === false) {
		$rs=MSG2;
	}else{
		$data=$r;
	}
	return array("result"=>$rs,"data"=>$data);
}

