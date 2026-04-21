<?php 
 // phpinfo();exit;
session_start();
error_reporting(0);
include "config_chart.php";  
//echo $_SESSION['timeout'];


if(!isset($_SESSION['email']))
{
  header('Location: logout.php');
  exit();
}
//print_r($_SESSION);
?>

 <?php
    for ($i = 1; $i <= 13; $i++) 
    {
      $months[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
    }
      /* batch selection query*/
       if($_SESSION['userType'] == 1 && $_SESSION['newuserType'] == ''){
        $starbatch=$months[10];
        $endbatch= date('Y-m');
        $batchstartwhere='';
       }else if($_SESSION['userType'] == 1 && $_SESSION['newuserType'] == 1){
         $starbatch=$months[10];
        $endbatch= date('Y-m');
        $batchstartwhere='';
       }else{
       if(($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4) ){
        
             $batchstartwhere="WHERE ATTY_CDE = '".$_SESSION['firmCode']."'";
       }
        if($_SESSION['userType'] == 3){
          $batchstartwhere="WHERE CLIENT_CDE = '".$_SESSION['clientCode']."'";
        }
         if($_SESSION['newuserType'] == 2  || $_SESSION['newuserType'] == 4 && $_SESSION['userType'] == 1){
          $batchstartwhere="WHERE ATTY_CDE = '".$_SESSION['newattycode']."'";
         }
          if($_SESSION['newuserType'] == 3 && $_SESSION['userType'] == 1){
          $batchstartwhere="WHERE CLIENT_CDE = '".$_SESSION['newclientcode']."'";
          }
             $stbatchquery="SELECT LEFT(DATE_ADD((SELECT AACA_RCVD_DT AS END_BATCH FROM MASTER_DATA_INV  ". $batchstartwhere." GROUP BY AACA_RCVD_BATCH HAVING COUNT(RMSFILENUM) > 1 ORDER BY AACA_RCVD_BATCH DESC LIMIT 1), INTERVAL -12 MONTH),7) AS START_BATCH";
         $stresbatchquery=mysqli_query($dbhandle,$stbatchquery);

         $stfetchbatchquery=mysqli_fetch_array($stresbatchquery);
         $starbatch     =$stfetchbatchquery['START_BATCH'];

         $endbatchquery="SELECT AACA_RCVD_BATCH AS END_BATCH FROM MASTER_DATA_INV  ".$batchstartwhere." GROUP BY AACA_RCVD_BATCH HAVING COUNT(RMSFILENUM) > 1 ORDER BY AACA_RCVD_BATCH DESC LIMIT 1";
         $endresbatchquery=mysqli_query($dbhandle,$endbatchquery);
         $endfetchbatchquery=mysqli_fetch_assoc($endresbatchquery);
         $endbatch     =$endfetchbatchquery['END_BATCH'];
        
        }
        // echo $starbatch.'====='. $endbatch;exit;
        /* batch selection query ends here*/
        ?>

      <!DOCTYPE html>

      <html>
      <head>
       
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Pipeway | BI Dashboard</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=11"/>
        <meta http-equiv="X-UA-Compatible" content="IE=10"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <meta http-equiv="X-UA-Compatible" content="IE=8"/>
        <link rel="stylesheet" href="css/PSnnect.min.css">
        <link rel="stylesheet" href="css/PSdataTables.min.css">
        <link rel="stylesheet" href="css/PSPanel.css">
        <link rel="stylesheet" href="css/PSdaterangepicker.css">
        <link rel="stylesheet" href="css/Multiselect.css">
        <link rel="stylesheet" href="css/sweetalert.css">

        <link rel="stylesheet" href="INV/graph.css">
        <link rel="stylesheet" href="css/dashboard_topfilters.css">


        
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/fevicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/fevicon.ico">
<link rel="apple-touch-icon-precomposed" href="img/fevicon.ico">
<link rel="shortcut icon" href="img/fevicon.ico">
<!--[if IE]---->
<link rel="stylesheet" type="text/css" href="only-ie.css" />
<!---[endif]-->
<script src="js/PSjquery.min.js"></script>
<script src="js/PSnnect.min.js"></script>
<script src="js/PSslimscroll.js"></script>
<script src="js/PSnnectPanel.js"></script>
<script src="js/MultiSelectJs.js"></script>
<script src="js/sweetalert.min.js"></script>

<!-- <script src="js/autologout.js"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" />

 <script src="https://code.highcharts.com/highcharts.js"></script>
  <!-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
 <script src="https://code.highcharts.com/modules/exporting.js"></script>
 <script src="https://code.highcharts.com/modules/drilldown.js"></script>
 <script src="https://code.highcharts.com/modules/export-data.js"></script>
 <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script> 
</head>
<!--  <body onload="bonload();" class="hold-transition skin-yellow sidebar-mini fixed Loader" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()">  -->
<body  onload="bonload();" class="hold-transition skin-yellow sidebar-mini fixed ">
  
  <div id="loader"></div>

  <div class="wrapper" >

    <?php include('topnav.php');?>
   
    <aside class="main-sidebar">
      <?php include('leftpane.php');?> 
    </aside>
     
    <div class="content-wrapper">

 <?php include('topfilter.php');?>

      <section class="bor_none fixme_filter">
        
        <div class="col-md-12 text-center">    
        <div class="col-md-1 p0" style="width: 10%;display: inline-block;float: left;">
          <span class="m_f10">Track Type:</span>
          <label id="agency_flag">ALL</label>
        </div> 

        <div class="col-md-1 p0 res_widt" style="width: 11%;display: inline-block;float: left;">
          <span class="m_f10">Start Batch:</span>        
          <label id="rcvd_batch_from"><?php echo $starbatch; ?></label>
        </div>
        <div class="col-md-1 p0 res_widt" style="width: 10.5%;display: inline-block;float: left;">
          <span class="m_f10">End Batch:</span>
          <label id="rcvd_batch_end"><?php echo $endbatch;?></label>
        </div>
         <?php if(($_SESSION['userType']!=2) && ($_SESSION['newuserType']!=2) && ($_SESSION['newuserType']!=4) && ($_SESSION['userType']!=4)){?>
        <div class="col-md-1 p0 res_widt" style="width: 10.5%;display: inline-block;float: left;">
          <span class="m_f10">Attorney Code:</span>
          <label id="atty_cde" class="show-oneline">ALL</label>
        </div>
      <?php } ?>
       <?php if(($_SESSION['userType']!=3) && ($_SESSION['newuserType']!=3)){ ?>
        <div class="col-md-1 p0" style="width: 10.5%;display: inline-block;float: left;">
          <span class="m_f10">Client Code:</span>
          <label id="client_cde" class="show-oneline">ALL</label>
        </div>
      <?php } ?>
        <div class="col-md-2 p0 res_widt" style="width: 10.5%;display: inline-block;float: left;">
          <span class="m_f10">Portfolio Code:</span>
          <label id="portfolio_cde" class="show-oneline">ALL</label>
        </div>
        <div class="col-md-1 p0 res_widt" style="width: 10.5%;display: inline-block;float: left;">
          <span class="m_f10">Product Code:</span>
          <label id="product_cde" class="show-oneline">ALL</label>
        </div>
        <div class="col-md-1 p0" style="width: 10.5%;display: inline-block;float: left;">
          <span class="m_f10">State Code:</span>
          <label id="debtr_state_ad" class="show-oneline">ALL</label>
        </div>
        <div class="col-md-1 p0 res_widt" style="width: 10.5%;display: inline-block;float: left;">
          <span class="m_f10">Account Type:</span>
          <label id="account_type">ALL</label>
        </div>
        </div>
          </section>
      
      <?php include('graph_inventory.php');?>
    </div>
   

<!-- Button trigger modal -->
    <button type="button" data-toggle="modal" data-target="#exampleModal" id="download_report" style="visibility: hidden; height: 0px;">
      Launch demo modal
    </button>

<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalLabel">Export Result</h3>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
          </div>
          <div class="modal-body">
            <div class="form-group text-center clearfix">
              <label class="pop-msg" style="font-size: 15px; padding-top: 18px; color: #002e5b;">
                Are you sure you want to download ?
              </label>              
            </div>
          </div>
        
          <div class="modal-footer">
            <div class="btn-group btn-group-justified" role="group" aria-label="group button" style="box-shadow:2px 2px 2px rgb(0 0 0 / 0%)!important;">
                <div class="btn-group" role="group" style="box-shadow:2px 2px 2px rgb(0 0 0 / 0%)!important;">
                  <a href="#" id="download_link">
                    <button type="button" id="download" name="UpdateBtn" class="btn btn-default btm-right-radius" role="button" style="padding: 12px; border: none; border-right: 1px solid #ccc; height: 40px; border-bottom-right-radius: 0px;">
                    Download</button>
                  </a>
                </div>
                <div class="btn-group" role="group" style="box-shadow:2px 2px 2px rgb(0 0 0 / 0%)!important;"><button type="button" class="btn btn-default btm-left-radius" data-dismiss="modal" role="button" style="box-shadow:2px 2px 2px rgb(0 0 0 / 0%)!important;">Close</button>
                </div>
            </div>
          </div>

        </div>
      </div>
    </div>

<!-- Modal End-->




    <?php include('footer.php');?>
   
    <div class="control-sidebar-bg"></div>
  </div>


</body>

<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  



<!-- Filter JS -->

<script type="text/javascript">

  $(document).on('click', '#search_data', function(){

    start_batch();
    end_batch();
    get_attycde();
    get_clientcde();
    get_portcde();
    get_prodcde();
    get_statecde();
    get_flagcode(); 

  });
  
</script>

<script type="text/javascript">
  
function get_flagcode(){

  var filter_data = document.getElementById('AGENCY_FLAG').value; 
  var filter_data8 = document.getElementById('ACCOUNT_TYPE').value;  
   if(filter_data8==''){
  var filter_data8='ALL';
 }else{
   var filter_data8 = document.getElementById('ACCOUNT_TYPE').value;
 }    
  document.getElementById('agency_flag').innerHTML = filter_data;
  document.getElementById('account_type').innerHTML = filter_data8;
  
}
  
function start_batch(){

  var dateThis = $('#AACA_RCVD_BATCH_FROM').val();
  $('#rcvd_batch_from').text(dateThis);
  
}

function end_batch(){
  
  var dateThis = $('#AACA_RCVD_BATCH_END').val();
  $('#rcvd_batch_end').text(dateThis);

}

function get_attycde(){
  var str='ALL';
  var strname='';
  var splitName =[];
  for (i=0;i<ATTY_CDE.length;i++) { 

    if(ATTY_CDE[i].selected){
      str +=ATTY_CDE[i].value + ", "; 
      strname +=ATTY_CDE[i].value + ", "; 
      var newstrname= strname.replace(/,\s*$/, "");
      splitName.push(str.split(","));
      var length =splitName.length;
      if(length >0){
        var str =length;
      } 
    }
  } 
  document.getElementById("atty_cde").innerHTML=str;
  document.getElementById('atty_cde').setAttribute('data-title', newstrname);
  return true;
  document.getElementById('atty_cde').setAttribute('title', newstrname);
  return false;
}

function get_clientcde(){
  var str='ALL';
  var strname='';
  var splitName =[];
  for (i=0;i<CLIENT_CDE.length;i++) { 
    if(CLIENT_CDE[i].selected){
      str +=CLIENT_CDE[i].value + ", "; 
      strname +=CLIENT_CDE[i].value + ", "; 
      var newstrname= strname.replace(/,\s*$/, "");
      splitName.push(str.split(","));
      var length =splitName.length;
      if(length >0){
        var str =length;
      }
    }
  } 
  document.getElementById("client_cde").innerHTML=str;
  document.getElementById('client_cde').setAttribute('data-title', newstrname);
  return true;
}

function get_portcde(){
  var str='ALL';
  var strname='';
  var splitName =[];
  for (i=0;i<PORTFOLIO_CDE.length;i++) { 
    if(PORTFOLIO_CDE[i].selected){
      str +=PORTFOLIO_CDE[i].value + ", "; 
      strname +=PORTFOLIO_CDE[i].value + ", "; 
      var newstrname= strname.replace(/,\s*$/, "");
      splitName.push(str.split(","));
      var length =splitName.length;
      if(length >0){
        var str =length;
      }
    }
  } 
  document.getElementById("portfolio_cde").innerHTML=str;
  document.getElementById('portfolio_cde').setAttribute('data-title', newstrname);
  return true;
}



function get_prodcde(){
  var str='ALL';
  var strname='';
  var splitName =[];
  for (i=0;i<PRODUCT_CDE.length;i++) { 
    if(PRODUCT_CDE[i].selected){
      str +=PRODUCT_CDE[i].value + ", "; 
      strname +=PRODUCT_CDE[i].value + ", "; 
      var newstrname= strname.replace(/,\s*$/, "");
      splitName.push(str.split(","));
      var length =splitName.length;
      if(length >0){
        var str =length;
      }
    }
  } 
  document.getElementById("product_cde").innerHTML=str;
  document.getElementById('product_cde').setAttribute('data-title', newstrname);
  return true;
}

function get_statecde(){
  var str='ALL';
  var strname='';
  var splitName =[];
  for (i=0;i<DEBTR_STATE_AD.length;i++) { 
    if(DEBTR_STATE_AD[i].selected){
      str +=DEBTR_STATE_AD[i].value + ", "; 
      strname +=DEBTR_STATE_AD[i].value + ", "; 
      var newstrname= strname.replace(/,\s*$/, "");
      splitName.push(str.split(","));
      var length =splitName.length;
      if(length >0){
        var str =length;
      }
    }
  } 
  document.getElementById("debtr_state_ad").innerHTML=str;
  document.getElementById('debtr_state_ad').setAttribute('data-title', newstrname);
  return true;
}


</script>

<!-- Filter JS END -->


  <!-- Modal -->
  <script type="text/javascript">
      var body = document.getElementsByTagName('body')[0];
     //var body = document.createElement("BODY");
      var removeLoading = function() {
        setTimeout(function() {
          body.className = body.className.replace(/Loader/, '');
        }, 300);
      };
      removeLoading();
  </script>    

  <script type="text/javascript">
    $(function () {
      $("#download").click(function () {
        $("#exampleModal").modal("hide");
      });
    });
  </script>
  
  <script>
    $("#first_function_stack").hide();
  //  $("#first_function_line").hide();
  
  $("#second_function_stack").hide();
  //  $("#second_function_line").hide();
</script>

  <script type="text/javascript">
    $('#container_line').hide();
   
    $('#first_function_line, #first_function_stack').on('click',
      function() 
      {
        $('#container_line, #container_chart').toggle();
        $('#first_function_stack, #first_function_line').toggle();
      }
    );
  </script>

  <script>
    $('#first_function_stack').click(function() {
      $('#myDIV').show();
      $('#myDIV1').hide();
   
    });
      
    $('#first_function_line').click(function() {
      $('#myDIV').hide();
      $('#myDIV1').show();
   
    });
  </script>


  <script type="text/javascript">
    $('#container_line1').hide();
    $('#second_function_line, #second_function_stack').on('click',
      function() 
      {
        $('#container_line1, #container_chart1').toggle();
        $('#second_function_stack, #second_function_line').toggle();
      }
    );
  </script>

  <script>
    $('#second_function_stack').click(function() {
      $('#myDIV2').show();
      $('#myDIV3').hide();
   
    });
      
    $('#second_function_line').click(function() {
      $('#myDIV2').hide();
      $('#myDIV3').show();
   
    });
  </script>



<script src="INV/graph.js"> </script>

<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown1] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "Inventory_Stack";
                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown2] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "Inventory_Line";
                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown3] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "Suit_Status_Stack";
                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown4] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "Suit_Status_Line";
                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown5] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "Inv_Conv";
                
                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown6] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "Suit_Conv";

                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown7] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "Payment_Status";

                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>


<script type="text/javascript">
        $(document).ready(function () {
            $("ul[id*=dropdown8] li").click(function () {
                var legend_name = $(this).attr("value");
                var graph =  "File_Closure";

                window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
            });
        });
</script>

<script type="text/javascript">
      $(document).ready(function () {
          $("ul[id*=dropdown9] li").click(function () {
              var legend_name = $(this).attr("value");
              var graph =  "Status_Batch";

              window.open('export/report-modules.php?legend_name=' + encodeURIComponent(legend_name) + '&graph=' + encodeURIComponent(graph), '_blank');
          });
      });
</script>


<script>

 /* $(document).ready(function() { 
  var form_data = $('#role_chart_access').serialize();

    $.ajax({
          type: "get",
          url: "INV/accounts.php",
          dataType: "json",
          async: true,
            data: form_data,
            success: function (data) {
              //Success = true;
            designChart(data);
            spinner.hide();
          },
          error:function(jqXHR, textStatus, errorThrown){
            alert("Error type" + textStatus + "occured, with value " + errorThrown);
          }
        });

})*/


  var spinner = $('#loader');

  $("#role_chart_access").submit(function(event){
    event.preventDefault();
    spinner.show();

      var form_data = $(this).serialize(); //Encode form elements for submission
        $.ajax({
          type: "POST",
          url: "INV/accounts.php",
          dataType: "json",
          async: true,
            data: form_data,
            success: function (data) {
              //Success = true;
            designChart(data);
            spinner.hide();
          },
          error:function(jqXHR, textStatus, errorThrown){
            alert("Error type" + textStatus + "occured, with value " + errorThrown);
          }
        });
      });

</script>




<script type="text/javascript">
  $(function () {
    $('#ATTY_CDE').multiselect({
      nonSelectedText: 'Attorney Code',
      enableFiltering: false,
      enableCaseInsensitiveFiltering: true,
      includeSelectAllOption: true,
      buttonTitle: function() {},
      //buttonWidth:'170px'

    });
    $('#CLIENT_CDE').multiselect({
      nonSelectedText: 'Client Code',
      enableFiltering: false,
      enableCaseInsensitiveFiltering: true,
      includeSelectAllOption: true,
      buttonTitle: function() {},
      //buttonWidth:'150px'

    });
    $('#PORTFOLIO_CDE').multiselect({
      nonSelectedText: 'Portfolio Code',
      enableFiltering: false,
      enableCaseInsensitiveFiltering: true,
      includeSelectAllOption: true,
      buttonTitle: function() {},
      //buttonWidth:'170px'
    });
    $('#PRODUCT_CDE').multiselect({
     nonSelectedText: 'Product Code',
     enableFiltering: false,
     enableCaseInsensitiveFiltering: true,
     includeSelectAllOption: true,
     buttonTitle: function() {},
     //buttonWidth:'170px'
   });
    $('#DEBTR_STATE_AD').multiselect({
      nonSelectedText: 'State Code',
      enableFiltering: false,
      enableCaseInsensitiveFiltering: true,
      includeSelectAllOption: true,
      buttonTitle: function() {},
      //buttonWidth:'150px'
    });
//   $('.ui-datepicker').click(function(){
//   getattstartbatch();
//   getclistartbatch();
//   getportstartbatch();
//   getprostartbatch();
//   getstatestartbatch();
//   getattendbatch();
//   getcliendbatch();
//   getportendbatch();
//   getproendbatch();
//   getstateendbatch();
// })
 $('input[name=AACA_RCVD_BATCH_FROM]').click(function() { 

  getattstartbatch();
  getclistartbatch();
  getportstartbatch();
  getprostartbatch();
  getstatestartbatch()
});
  $('input[name=AACA_RCVD_BATCH_END]').click(function() {

  getattendbatch();
  getcliendbatch();
  getportendbatch();
  getproendbatch();
  getstateendbatch()
});
});
   function getattstartbatch(val){ 
      var frombatchatt=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchatt  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchatt==''){
        var frombatchatt='2002-01';
      }if(tobatchatt==''){
       var tobatchatt='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchatt:frombatchatt,tobatchatt:tobatchatt} ,
      success: function (data) {
       $("#ATTY_CDE").html(data);
       $('#ATTY_CDE').multiselect('rebuild');
       $('#ATTY_CDE button').removeAttr('title');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }


   function getclistartbatch(val){
      var frombatchcli=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchcli  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchcli==''){
        var frombatchcli='2002-01';
      }if(tobatchcli==''){
       var tobatchcli='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchcli:frombatchcli,tobatchcli:tobatchcli} ,
      success: function (data) {
       $("#CLIENT_CDE").html(data);
       $('#CLIENT_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }

      function getportstartbatch(val){
      var frombatchport=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchcport  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchport==''){
        var frombatchport='2002-01';
      }if(tobatchcport==''){
       var tobatchcport='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchport:frombatchport,tobatchcport:tobatchcport} ,
      success: function (data) {
       $("#PORTFOLIO_CDE").html(data);
       $('#PORTFOLIO_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }
      function getprostartbatch(val){
      var frombatchpro=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchchpro  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchpro==''){
        var frombatchpro='2002-01';
      }if(tobatchchpro==''){
       var tobatchchpro='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchpro:frombatchpro,tobatchchpro:tobatchchpro} ,
      success: function (data) {
       $("#PRODUCT_CDE").html(data);
       $('#PRODUCT_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }
    function getstatestartbatch(val){
      var frombatchstate=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchchstate  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchstate==''){
        var frombatchstate='2002-01';
      }if(tobatchchstate==''){
       var tobatchchstate='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchstate:frombatchstate,tobatchchstate:tobatchchstate} ,
      success: function (data) {
       $("#DEBTR_STATE_AD").html(data);
       $('#DEBTR_STATE_AD').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }
   //    $('input[name=AACA_RCVD_BATCH_END]').change(function() { 
   //    var frombatch1=$('#AACA_RCVD_BATCH_FROM').val();
   //    var tobatch1  =$('#AACA_RCVD_BATCH_END').val();
   //    $.ajax({
   //    type: 'POST',
   //    url: 'filterAjax.php',
      
   //    data: { frombatch1:frombatch1,tobatch1:tobatch1} ,
   //    success: function (data) {
   //     $("#ATTY_CDE").html(data);
   //     $('#ATTY_CDE').multiselect('rebuild');
   //   },
   //   error: function ()
   //   { alert('there is some error to get Rate'); }
   // });
   //  });
   function getattendbatch(val){
      var frombatchatt1=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchatt1  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchatt1==''){
        var frombatchatt1='2002-01';
      }if(tobatchatt1==''){
       var tobatchatt1='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchatt1:frombatchatt1,tobatchatt1:tobatchatt1} ,
      success: function (data) {
       $("#ATTY_CDE").html(data);
       $('#ATTY_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }


   function getcliendbatch(val){
      var frombatchcli1=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchcli1  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchcli1==''){
        var frombatchcli1='2002-01';
      }if(tobatchcli1==''){
       var tobatchcli1='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchcli1:frombatchcli1,tobatchcli1:tobatchcli1} ,
      success: function (data) {
       $("#CLIENT_CDE").html(data);
       $('#CLIENT_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }

      function getportendbatch(val){
      var frombatchport1=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchcport1  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchport1==''){
        var frombatchport1='2002-01';
      }if(tobatchcport1==''){
       var tobatchcport1='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchport1:frombatchport1,tobatchcport1:tobatchcport1} ,
      success: function (data) {
       $("#PORTFOLIO_CDE").html(data);
       $('#PORTFOLIO_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }
      function getproendbatch(val){
      var frombatchpro1=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchchpro1  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchpro1==''){
        var frombatchpro1='2002-01';
      }if(tobatchchpro1==''){
       var tobatchchpro1='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchpro1:frombatchpro1,tobatchchpro1:tobatchchpro1} ,
      success: function (data) {
       $("#PRODUCT_CDE").html(data);
       $('#PRODUCT_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }
    function getstateendbatch(val){
      var frombatchstate1=$('#AACA_RCVD_BATCH_FROM').val();
      var tobatchchstate1  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatchstate1==''){
        var frombatchstate1='2002-01';
      }if(tobatchchstate1==''){
       var tobatchchstate1='<?php echo date('Y-m');?>';
      }
      $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { frombatchstate1:frombatchstate1,tobatchchstate1:tobatchchstate1} ,
      success: function (data) {
       $("#DEBTR_STATE_AD").html(data);
       $('#DEBTR_STATE_AD').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });
    }
  

  /* For attorney------------------------------------*/
  function getClient(val) {
    var attycode = $('#ATTY_CDE').val();
    var firmcodeval = '<?php echo ($_SESSION['firmCode']);?>';
    var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { attycode:attycode,firmcodeval:firmcodeval,frombatch:frombatch,tobatch:tobatch} ,
      success: function (data) {
       $("#CLIENT_CDE").html(data);
       $('#CLIENT_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });

  }
  
  function getPortfolio(val) {
    var attycode1 = $('#ATTY_CDE').val();
    var firmcodeval1 = '<?php echo ($_SESSION['firmCode']);?>';
    var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { attycode1:attycode1,firmcodeval1:firmcodeval1,frombatch:frombatch,tobatch:tobatch} ,
      success: function (data) {
       $("#PORTFOLIO_CDE").html(data);
       $('#PORTFOLIO_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });

  }
  
  function getProduct(val) {
    var attycode2 = $('#ATTY_CDE').val();
    var firmcodeval2 = '<?php echo ($_SESSION['firmCode']);?>'
    var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { attycode2:attycode2,firmcodeval2:firmcodeval2,frombatch:frombatch,tobatch:tobatch} ,
      success: function (data) {
       $("#PRODUCT_CDE").html(data);
       $('#PRODUCT_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });

  }

  function getstate(val) {
    var attycode3 = $('#ATTY_CDE').val();
    var firmcodeval3 = '<?php echo ($_SESSION['firmCode']);?>';
    var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { attycode3:attycode3,firmcodeval3:firmcodeval3,frombatch:frombatch,tobatch:tobatch} ,
      success: function (data) {
       $("#DEBTR_STATE_AD").html(data);
       $('#DEBTR_STATE_AD').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });

  }
  /* For attorney end------------------------------------*/
  /* For client start------------------------------------*/
  function getPortfolio1(val) {
    var clientcode = $('#CLIENT_CDE').val();
    var clientcodeval = '<?php echo ($_SESSION['clientCode']);?>';
     var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    var SelAttyCode =$('#ATTY_CDE').val();
    $.ajax({
      type: 'POST',
      url: 'filterAjax.php',
      
      data: { clientcode:clientcode,clientcodeval:clientcodeval,SelAttyCode:SelAttyCode,frombatch:frombatch,tobatch:tobatch} ,
      success: function (data) {
       $("#PORTFOLIO_CDE").html(data);
       $('#PORTFOLIO_CDE').multiselect('rebuild');
     },
     error: function ()
     { alert('there is some error to get Rate'); }
   });

  }
  
  function getProduct1(val) {
   var clientcode1 = $('#CLIENT_CDE').val();
   var clientcodeval1 = '<?php echo ($_SESSION['clientCode']);?>';
     var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    var SelAttyCode =$('#ATTY_CDE').val();
   $.ajax({
    type: 'POST',
    url: 'filterAjax.php',
    
    data: { clientcode1:clientcode1,clientcodeval1:clientcodeval1,SelAttyCode:SelAttyCode,frombatch:frombatch,tobatch:tobatch} ,
    success: function (data) {
     $("#PRODUCT_CDE").html(data);
     $('#PRODUCT_CDE').multiselect('rebuild');
   },
   error: function ()
   { alert('there is some error to get Rate'); }
 });

 }

 function getstate1(val) {
   var clientcode2 = $('#CLIENT_CDE').val();
   var clientcodeval2 = '<?php echo ($_SESSION['clientCode']);?>';
   var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    var SelAttyCode =$('#ATTY_CDE').val();
   $.ajax({
    type: 'POST',
    url: 'filterAjax.php',
    
    data: { clientcode2:clientcode2,clientcodeval2:clientcodeval2,SelAttyCode:SelAttyCode,frombatch:frombatch,tobatch:tobatch} ,
    success: function (data) {
     $("#DEBTR_STATE_AD").html(data);
     $('#DEBTR_STATE_AD').multiselect('rebuild');
   },
   error: function ()
   { alert('there is some error to get Rate'); }
 });

 }
 /* For client end------------------------------------*/
 /* For portfolio code start------------------------------------*/
 function getProduct2(val) {
   var portfoliocode    = $('#PORTFOLIO_CDE').val();
   var portfoliocodeval = '<?php echo ($_SESSION['portfolioCode']);?>';
   var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
   var SelAttyCode      =$('#ATTY_CDE').val();
   var SelClientCode    =$('#CLIENT_CDE').val();
   $.ajax({
    type: 'POST',
    url: 'filterAjax.php',
    
    data: { portfoliocode:portfoliocode,portfoliocodeval:portfoliocodeval,SelAttyCode:SelAttyCode,SelClientCode:SelClientCode,frombatch:frombatch,tobatch:tobatch},
    success: function (data) {
     $("#PRODUCT_CDE").html(data);
     $('#PRODUCT_CDE').multiselect('rebuild');
   },
   error: function ()
   { alert('there is some error to get Rate'); }
 });

 }

 function getstate2(val) {
   var portfoliocode1 = $('#PORTFOLIO_CDE').val();
   var portfoliocodeval1 = '<?php echo ($_SESSION['portfolioCode']);?>';
   var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
    var SelAttyCode      =$('#ATTY_CDE').val();
   var SelClientCode    =$('#CLIENT_CDE').val();
   $.ajax({
    type: 'POST',
    url: 'filterAjax.php',
    
    data: { portfoliocode1:portfoliocode1,portfoliocodeval1:portfoliocodeval1,SelAttyCode:SelAttyCode,SelClientCode:SelClientCode,frombatch:frombatch,tobatch:tobatch} ,
    success: function (data) {
     $("#DEBTR_STATE_AD").html(data);
     $('#DEBTR_STATE_AD').multiselect('rebuild');
   },
   error: function ()
   { alert('there is some error to get Rate'); }
 });

 }
 
 /* For portfolio code end------------------------------------*/
 /* For product code start------------------------------------*/
 function getstate3(val) {
   var productcode      = $('#PRODUCT_CDE').val();
   var productcodeval   = '<?php echo ($_SESSION['productCode']);?>';
   var frombatch=$('#AACA_RCVD_BATCH_FROM').val();
    var tobatch  =$('#AACA_RCVD_BATCH_END').val();
      if(frombatch==''){
        var frombatch='2002-01';
      }if(tobatch==''){
       var tobatch='<?php echo date('Y-m');?>';
      }
   var SelAttyCode      =$('#ATTY_CDE').val();
   var SelClientCode    =$('#CLIENT_CDE').val();
   var SelPortfolioCode  = $('#PORTFOLIO_CDE').val();

   $.ajax({
    type: 'POST',
    url: 'filterAjax.php',
    
    data: { productcode:productcode,productcodeval:productcodeval,SelAttyCode:SelAttyCode,SelClientCode:SelClientCode,SelPortfolioCode:SelPortfolioCode,frombatch:frombatch,tobatch:tobatch} ,
    success: function (data) {
     $("#DEBTR_STATE_AD").html(data);
     $('#DEBTR_STATE_AD').multiselect('rebuild');
   },
   error: function ()
   { alert('there is some error to get Rate'); }
 });

 }
 /* For product code end------------------------------------*/

</script> 

</html>


