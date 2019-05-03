<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>演習 検索条件</title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

		<script src="lib/jquery-1.11.3.min.js" type ="text/javascript"></script>
		<script src="lib/jquery-ui.js" type="text/javascript"></script>
		<script type="text/javascript" src="JS/crud.js"></script>
		<style>
			
			.form_div{
				margin-left: 300px;
			}
		</style>
	</head>	
<body> 
	<div class="container">
  		<h2 align="center">検索条件</h2>
		<?php
			 $readonly='';
			 $checked='';
			 $autofocus1='';
			 $autofocus2="autofocus";
			if (isset($_GET['flag'])){
				if ($_GET['flag']=="UPDATE") {
					$readonly = "readonly";
					$autofocus1 = "autofocus";
					$autofocus1 = "";
				}
			}

			if(isset($_GET['age'])){
				if ($_GET['age']=="1") {
					$checked = "checked";
				}
			}

			if(isset($_GET['age'])){
				if ($_GET['age']=="1") {
					$checked = "checked";
				}
			}

		?>  
		<div class="form_div">
			<form name="add_form" method="post" class="form-horizontal" style="width: 500px;">
			  <div class="form-group">
			    <label for="emp_code">社員コード</label>
			    <input type="text" class="form-control" id="emp_code"<?=$autofocus1?> value="<?=isset($_GET['code'])?$_GET['code']:''?>" <?=$readonly?> >
			  </div>
			  <div class="form-group">
			    <label for="emp_name">社員名:</label>
			    <input type="text" class="form-control" id="emp_name" size="5" <?=$autofocus2?>  value="<?=isset($_GET['name'])?$_GET['name']:''?>">
			  </div>
			  <div class="checkbox">
			    <label><input type="checkbox" id="check_age" name="check_age" <?=$checked?> > 誕生年表示</label>
			  </div>
			  <button type="button" class="btn btn-success" onclick="next()" value="">表示</button>
			</form>
		</div>

</body>
</html>
