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


$con = cmDbCon();
if ($con === false) {
    $rtn = 1;
    $msg = MSG1;
}
if($flag==="ADD"){
	if($rtn===0){
		$fetchall=fnGetSQLTBLEMP_EMPCODE($con,$empcode);
		if($fetchall["result"]!==true){
			$rtn=1;
			$msg=$fetchall["result"];
		}else{
			$d=$fetchall["data"];
			if(count($d)>0){//update data
				error_log("upd functon");
				$r_update=fnUpdSQLTBLEMP($con,$empcode,$empname,$age);
				if($r_update!==true){
					$rtn=1;
					$msg=$r_update;
				}else{
					$msg="更新完了しました。";
				}
			}else{//insert data
				$r_insert=fnInsSQLTBLEMP($con,$empcode,$empname,$age);
				if($r_insert!==true){
					$rtn=1;
					$msg=$r_insert;
				}else{
					$msg="登録完了しました。";
				}
			}
			
		}
	}

}else if($flag==="SHOW"){
	if($rtn===0){
		$r=fnGetSQLTBLEMP($con);
		if($r["result"]!==true){
			$rtn=1;
			$msg=$r["result"];
		}else{
			$data=$r["data"];
		}
	}

}else if($flag==="SEARCH"){
	if($rtn===0){
		$r=fnGetSQLTBLEMP_SEARCH($con,$empcode);
		if($r["result"]!==true){
			$rtn=1;
			$msg=$r["result"];
		}else{
			$data=$r["data"];
		}
	}

}else if($flag==="DELETE"){
	if ($rtn===0) {
		$del_res = fnDeleteSQLTBLEMP($con,$empcode);	
		if($del_res["result"]!==true){
			$rtn=1;
			$msg=$del_res["result"];
		}else{
			$data=$r["data"];
		}
	}
}




$rtnAry = array(
'DATA' => $data,
'dtest'=>$dtest,
'RTN' => $rtn,
'MSG' => $msg,
'empcode'=>$empcode,
'empname'=>$empname,
'age'=>$age
);
echo (je($rtnAry));


//insert function
function fnInsSQLTBLEMP($con,$empcode,$empname,$age){
	$rs=true;
        $sql = " INSERT INTO SQLTBLEMP VALUES( ?, ?, ?)";
        $param = array($empcode, $empname, $age);
        $data = cmDbQuery($con, $sql, 'ssi', $param);
        if ($data === false) {
            $rs=MSG2;
        }
	return $rs; 
}
//delete function
function fnDeleteSQLTBLEMP($con,$empcode)
{

	$rs = true;
	$sql= " DELETE FROM SQLTBLEMP ";
	$sql .= " WHERE TEEMCD = ? ";
    $param = array($empcode);
    $data = cmDbQuery($con, $sql, 's', $param);
    if ($data === false) {
        $rs=MSG2;
    }
	return $rs;
}

//update function
function fnUpdSQLTBLEMP($con,$empcode,$empname,$age){
	$rs=true;
	$sql = " UPDATE SQLTBLEMP SET TEEMNM=?,TEAGE=? ";
	$sql.= " WHERE  TEEMCD=? ";
	$param = array($empname, $age,$empcode);
	$data = cmDbQuery($con, $sql, 'sis', $param);
	if ($data === false) {
		$rs=MSG2;
	}
	return $rs; 
}
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
//get function by empcode
function fnGetSQLTBLEMP_EMPCODE($con,$empcode){
	$data=array();
	$rs=true;
	$sql =" SELECT A.* FROM SQLTBLEMP AS A ";
	$sql .=" WHERE A.TEEMCD=? ";
	$param = array($empcode);
	error_log("select =>fnGetSQLTBLEMP_EMPCODE".$sql.print_r($param,true));
	$r = cmFetchAll($con, $sql, 's', $param);
	if ($r === false) {
		$rs = MSG2;
	}else{
		$data=$r;
	}
	return array("result"=>$rs,"data"=>$data);
}

//search function by empcode
function fnGetSQLTBLEMP_SEARCH($con,$empcode){
	$data=array();
	$param=array();
	$rs=true;
	$sql=" SELECT * FROM SQLTBLEMP WHERE TEEMCD LIKE ? OR TEEMNM LIKE  ?";
	$param[]='%'.$empcode.'%';
	$param[]='%'.$empcode.'%';

	$r = cmFetchAll($con, $sql, 'ss', $param);
	if ($r === false) {
		$rs = MSG2;
	}else{
		$data=$r;
	}
	return array("result"=>$rs,"data"=>$data);
}

