<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>演習 検索条件</title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<script src="lib/jquery-1.11.3.min.js" type ="text/javascript"></script>
    <script src="lib/jquery-ui.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src=" https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>  
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet">
		
    <script type="text/javascript" src="JS/crud.js"></script>
</head>
<body>
	<div class="container">
      <div class="row">
            <div class="container-fluid">
              <h1 ><center>検索結果</center></h1>
              <br>
                <table id="data-table" class="display" style="width:100%" border="1">
                  <thead >
                    <tr>
                      <th >社員コード</th>
                      <th>社員名</th>
                      <th>年</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>

                </table>
                <div >
                  <button type="button" name="button" class="btn btn-default" onclick="rtn()">戻る</button>
                </div><br>
              </div>
            </div>
      </div>
  </div>
</body>
<script>
  function rtn(){
    location.href="index.php";
  }


    $(function(){
        $('#data-table').DataTable({
          dom:'Bfrtip',
                buttons:['csv', 'excel'],
          "ajax":"ajax/fetchAll.php",
          "columns":[
                    {"data" : "TEEMCD"},
                    {"data" : "TEEMNM"},
                    {"data" : "TEAGE"},
                    {"data" : null,
                        "mRender" : function(e){
                                var update_btn = '';
                                update_btn = '<button class="btn btn-primary" onclick="update(\'' + e.TEEMCD +'\',\'' + e.TEEMNM +'\',\'' + e.TEAGE +'\')">更新</button>';
                                return update_btn;
                           }
                    },
                    {"data" : null,
                        "mRender" : function(e){
                                var delete_btn = '';
                                delete_btn = '<button class="btn btn-danger" onclick="Delete(\'' + e.TEEMCD + '\')">削除</button>';
                                return delete_btn;
                           }
                      }                                 
              ]
          });
    });
</script>
</html>

