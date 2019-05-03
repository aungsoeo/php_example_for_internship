<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>演習 検索条件</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="lib/jquery-1.11.3.min.js" type ="text/javascript"></script>
    <script src="lib/jquery-ui.js" type="text/javascript"></script>
    <script type="text/javascript" src="JS/crud.js"></script>
    <!-- //for print excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.9.2/xlsx.core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alasql/0.3.7/alasql.min.js"></script>
</head>
<body>
  <div class="container">
      <div class="row">
            <div class="container-fluid">
              <h1 ><center>検索結果</center></h1>
              <br>
               <div align="right">
                  <button type="button" name="button" class="btn btn-default" onclick="rtn()">戻る</button>
                  <button type="button" class="btn" name="download_csv" onclick="exportTableToCSV('employee_list.csv')" style="background: #128445">CSV</button>
                  <button type="button"  class="btn" name="download_excel" style="background: #9FE31C" onclick="exportTableToExcel()">Excel</button>
              </div>
              <div>
                  <form class="search_form">
                    <label for="">検索</label>
                     <input type='text' name='search' id='search' autofocus/>
                  </form>
              </div>
                <table class="table table-bordered" id="tblData">
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
               
              </div>
            </div>
      </div>
  </div>
</body>
<script>
  function rtn(){
    location.href="index.php";
  }
  function showTable(data){
        var html="";

        for(var i=0;i<data.length;i++){
        var code=data[i]["TEEMCD"];
        var name=data[i]["TEEMNM"];
        var age=data[i]["TEAGE"];

          html +="<tr>";
          html +="<td>"+data[i]["TEEMCD"]+"</td>";
          html +="<td>"+data[i]["TEEMNM"]+"</td>";
          html +="<td class='tdd'>"+data[i]["TEAGE"]+"</td>";
          html +="<td class='tdd'><button class='btn btn-primary'  onclick='update(\"" + code +"\",\"" + name +"\",\"" + age +"\")'>更新</button></td>";
          html +="<td class='tdd'><button class='btn btn-danger' onclick='Delete(\"" + code +"\")'>削除</button></td>";
          html +="</tr>";
        }

        return html;
      }

    $(function(){
          fetchAll();
    });


    function fetchAll(){
      var paramData=new Array();
        paramData.push({name: 'flag',value : "SHOW"});  
        $.ajax({
          type:"POST",
          url:"ajax/ptest_setting.php",
          data: paramData,
          success:function(res){
            var data=JSON.parse(res);
            if(data.RTN == 0){
              var employees=data.DATA;
              $("div table tbody tr").remove();
              $("div table tbody").append(showTable(employees));
              
              //search by keyword
               $('#search').keyup(function(){
                    var param=new Array();
                    param.push({name: 'emp_code',value :$('#search').val() });
                    param.push({name: 'flag' ,value:  "SEARCH"});
                      $.ajax({
                          type:"POST",
                          url:"ajax/ptest_setting.php",
                          data: param,
                          success:function(res){
                              var data=JSON.parse(res);
                              if(data.RTN == 0){
                                var search_data=data.DATA;
                                $("div table tbody tr").remove();
                                $("div table tbody").append(showTable(search_data));
                              }
                            }
                    });
              });

            }else{
              alert(data.MSG);
            }
          } 
        });
    }


//Ref:: https://www.codexworld.com/export-html-table-data-to-csv-using-javascript/
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function downloadCSV(csv, filename) {
      var csvFile;
      var downloadLink;

      // CSV file
      csvFile = new Blob([csv], {type: "text/csv"});

      // Download link
      downloadLink = document.createElement("a");

      // File name
      downloadLink.download = filename;

      // Create a link to the file
      downloadLink.href = window.URL.createObjectURL(csvFile);

      // Hide download link
      downloadLink.style.display = "none";

      // Add the link to DOM
      document.body.appendChild(downloadLink);

      // Click download link
      downloadLink.click();
}


function exportTableToExcel(){
      var excel = [];
      var tr=$("#tblData tbody tr");
      var thead=$("#tblData thead tr:eq(0)")[0];
      var td0=thead.children[0].textContent;
      var td1=thead.children[1].textContent;
      var td2=thead.children[2].textContent;
      excel.push(new Array(td0,td1,td2));
      for(var i=0;i<tr.length;i++){
          var td0=tr[i].children[0].textContent;
          var td1=tr[i].children[1].textContent;
          var td2=tr[i].children[2].textContent;
          var arr=new Array(td0,td1,td2);
          excel.push(arr);
      }
      alasql("SELECT * INTO XLSX('emp_list.xlsx',{headers:false}) FROM ? ",[excel]);
}
</script>
</html>

