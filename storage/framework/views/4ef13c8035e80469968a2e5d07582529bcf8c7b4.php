<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- meta -->
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>ICALL Delivery System</title>
        <!-- icon -->

        <!-- Fonts -->
            <link rel="stylesheet" href="<?php echo e(asset('packages/font-awesome/css/font-awesome.min.css')); ?>"  crossorigin="anonymous">
            <link rel="stylesheet" href="<?php echo e(asset('font/googleapis.css')); ?>"  crossorigin="anonymous">
        <!-- Styles -->
            <link rel="stylesheet" href="<?php echo e(asset('packages/bootstrap/css/bootstrap.min.css')); ?>" crossorigin="anonymous">
            <link rel="stylesheet" href="<?php echo e(asset('packages/select2/select2.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('packages/confirm/jquery-confirm.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('packages/datetimepicker/bootstrap-datetimepicker.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('packages/ionicons/ionicons.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('packages/datatables/dataTables.bootstrap.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('packages/admintl/admin.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('packages/wow/animate.css')); ?>">
        <!-- js -->
            <script src="<?php echo e(asset('packages/jquery/jquery.min.js')); ?>" crossorigin="anonymous"></script>
            <script src="<?php echo e(asset('packages/select2/select2.full.min.js')); ?>"></script>
            <script src="<?php echo e(asset('packages/validate/jquery.validate.js')); ?>"></script>
            <script src="<?php echo e(asset('packages/wow/wow.min.js')); ?>"></script>
            <script src="<?php echo e(asset('packages/chartjs/Chart.js')); ?>"></script>
            <script src="<?php echo e(asset('packages/confirm/jquery-confirm.min.js')); ?>"></script>
            <script src="<?php echo e(asset('packages/typeahead/typeahead.bundle.min.js')); ?>"></script>
        <!-- language -->
            <?php if(session()->has('lang')): ?>
                <?php echo e(App::setLocale(session()->get('lang'))); ?>

            <?php else: ?>
                <?php echo e(App::setLocale('ar')); ?>

            <?php endif; ?>
    </head>
    <body id="app-layout">
        <?php if(Auth::guest()): ?>
        <?php else: ?>
            <?php echo $__env->make('layouts.navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
        <footer class="main-footer no-print">
            <div class="pull-right hidden-xs">
              <b><?php echo e(trans('form.version')); ?></b> 1.0.0
            </div>
            <strong><?php echo e(trans('form.copyright')); ?>  &copy; 2016-2017 <a href="http://www.icall.com.eg"><?php echo e(trans('form.icall')); ?></a>.</strong> <?php echo e(trans('form.reserved')); ?>.
        </footer>
        
        
    <div class="modal fade" id="ChangePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <?php echo Form::model('User',['data-toggle'=>'validator','id'=>'chnagemypassword','role'=>'form','method'=>'POST','enctype' =>'multipart/form-data','route'=>  'postpassword'  ]); ?>

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="exampleModalLabel">Change Password</h4>
            </div>
            <div  id="chnagemypasswordmessage">
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="recipient-name" class="control-label">password:</label>
                  <input id="password" type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                  <label for="message-text" class="control-label">Password Confirmation:</label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="sendmychangepassword">Change</button>
            </div>
          </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
  
  
  
    </body>
    <!-- JavaScripts -->
        <script type="text/javascript">
            
            
            
            $(document).on('click','.restpassword',function(){
                var route   = $(this).data('route');
                $.confirm({
                    title           : 'Reset Password',
                    closeIcon       : true,
                    content         : 'url:'+route,
                    //columnClass     : 'col-md-6',
                    //animation       : 'top',
                    closeAnimation  : 'bottom',
                    animation       : 'zoom',
                    cancelButton: false,
                    confirmButton: false,
                });
            });

            $(document).on('click','.Withdraw',function(){
                var route   = $(this).data('route');
                var id      = $(this).attr('id');
                $.confirm({
                    title           : 'Request Folder',
                    closeIcon       : true,
                    content         : 'url:'+route,
                    columnClass     : 'col-md-4 col-md-offset-4',
                    animation       : 'top',
                    closeAnimation  : 'bottom',
                    animation       : 'zoom',
                    cancelButton: false,
                    confirmButton: false,
                });
            });

            function saveAsExcel(id, fileName){
                var table_text="<table border='2px'><tr>"; //Table Intialization, CSS included
                var textRange; 
                var index=0; 
                var table = document.getElementById(id); // Read table using id
                /*
                    Read Table Data and append to table_text
                */
                
                for(index = 0 ; index < table.rows.length ; index++) 
                  {     
                        table_text=table_text+table.rows[index].innerHTML+"</tr>";
                        
                  }

                  table_text=table_text+"</table>"; // table close
                  table_text= table_text.replace(/<a[^>]*>|<\/a>/g, ""); //removes links embedded in <td>
                  table_text= table_text.replace(/<img[^>]*>/gi,"");  //removes images embeded in <td>
                  table_text= table_text.replace(/<input[^>]*>|<\/input>/gi, ""); //removes input tag elements

                  var userAgent = window.navigator.userAgent; //check client user agent to determine browser
                  var msie = userAgent.indexOf("MSIE "); // If it is Internet Explorer user Aget will have string MSIE
                  
                 if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
                  {
                      //Since IE > 10 supports blob, check for blob support and use if we can
                  if (typeof Blob !== "undefined") {
                        //Bolb Data is ArrayStorage, convert to array
                        table_text = [table_text];
                        var blob = new Blob(table_text);
                        window.navigator.msSaveBlob(blob, ''+fileName);
                    }
                    else{
                        //If Blob is unsupported, create an iframe in HTML Page, and call that blank iframe
                        
                        textArea.document.open("text/html", "replace");
                        textArea.document.write(table_text);
                        textArea.document.close();
                        textArea.focus();
                        textArea.document.execCommand("SaveAs", true, fileName); 

                    }
                  }
                  
                    //Other Browsers         
                   else  
                       //Can use below statement if client machine has Excel Application installed
                       //window.open('data:application/vnd.ms-excel,' + encodeURIComponent(table_text));  
                       var a = document.createElement('a');
                        //getting data from our div that contains the HTML table
                        var data_type = 'data:application/vnd.ms-excel';
                        var table_div = document.getElementById(id);
                        var table_html = table_div.outerHTML.replace(/ /g, '%20');
                        table_html = table_html.replace(/<a[^>]*>|<\/a>/g, "");
                        table_html= table_html.replace(/<img[^>]*>/gi,"");  //removes images embeded in <td>
                        table_html= table_html.replace(/<input[^>]*>|<\/input>/gi, ""); //removes input tag elements

                        a.href = data_type + ', ' + table_html;

                //setting the file name
                a.download = ''+fileName;
                //triggering the function
                a.click();
            }

            function relationlist(thislist,model,method,appendtolist) {
                var id = $('#'+thislist+' :selected').attr( "id" );
                
                $.ajax({
                    url     :"<?php echo e(url('Ajaxrelationlist?')); ?>",
                    data    :{id:id,model:model,method:method},
                    dataType:'json',
                    type    :'get',
                    success : function(data){
                        var $option = $('#'+appendtolist);
                        $option.empty();
                        $option.append('<option value="" selected>Select</option>');
                        $.each(data, function(index, value) {                        
                            $option.append('<option value="'+value["name"]+'"id="'+value.id+'">'+value.name+'</option>');
                        });
                        $('#'+appendtolist).trigger('chosen:updated');
                    }
                });
                return false;
            };


            function Ajaxrow(id,model,inputid,inputvalue) {
                var id = $('#'+id+' :selected').attr( "id" );
                $('#area_id').val(id);
                $.ajax({
                    url     :"<?php echo e(url('Ajaxrow?')); ?>",
                    data    :{id:id,model:model},
                    dataType:'json',
                    type    :'get',
                    success : function(data){
                        var $input = $('#'+inputid);
                        $('#'+inputid+' option[value='+data[inputvalue]+']').attr('selected','selected');
                    }
                });
                return false;
            };





            function pageid(){
                //Get Table information
                var rows        = $('#rows :selected').text();
                var model       = $('#model').val();
                var search      = $('#search').val();
                var orderby     = $('#orderby').val();
                var ordertype   = $('#ordertype').val();
                var groupby     = $('#groupby').val();
                var key         = $('#key').val();
                var path        = $('#path').val();

                if ($('.pagination > .active span').text() != null){var page= $('.pagination > .active span').text();}else {var page = null;}
                if ($('#conditions') != null){var conditions= JSON.parse($('#conditions').val());}else {var conditions = null;}
                //filtratoin
                var columns = new Object();
                var div     = document.getElementById("tfooter");
               
                var selects = div.getElementsByTagName("select");
                for ( var i = 0; i < selects.length; i++ ) {
                    var name    = $(selects[i]).attr("id");
                    var value   = $("#"+name).find(":selected").val();
                    if (value.length > 0) {columns[name] = value;}
                }
                
                var inputs  = div.getElementsByTagName("input");
                for ( var i = 0; i < inputs.length; i++ ) {
                    var name    = $(inputs[i]).attr("id");
                    var value   = $(inputs[i]).val();
                    if (value.length > 0) {columns[name] = value;}
                }
                // Page loading Icon
                $colspan = +inputs.length + +selects.length + 3;
                //$(".insertData").html("<tr><td colspan='"+$colspan+"'><img src='<?php echo e(asset('img/ajax-loader.gif')); ?>'></td></tr>");
                //Go to Ajax Controller
                $.ajax({
                    url     :"<?php echo e(url('Ajaxtable?')); ?>",
                    data    :{path:path,key:key,columns:columns,groupby:groupby,conditions:conditions,model:model,page:page,search:search,ordertype:ordertype,orderby:orderby,rows:rows},
                    dataType:'json',
                    type    :'get',
                    success : function(data){
                        $('#loadpaginate').html($(data).find('#loadpaginate'));
                        $('#loadingcount').html($(data).find('#loadingcount'));
                        $('.insertData').html($(data).find('.loadingrow'));
                    }
                });
                return false;
            };

            $(document).on('click','.pagination a',function(e){
                e.preventDefault();
                var page        = $(this).attr('href').split('page=')[1];
                //Get Table information
                var rows        = $('#rows :selected').text();
                var model       = $('#model').val();
                var search      = $('#search').val();
                var orderby     = $('#orderby').val();
                var ordertype   = $('#ordertype').val();
                var groupby     = $('#groupby').val();
                var key         = $('#key').val();
                var path         = $('#path').val();

                if ($('#conditions') != null){var conditions= JSON.parse($('#conditions').val());}else {var conditions = null;}
                 //filtratoin
                var columns = new Object();
                var div     = document.getElementById("tfooter");
               
                var selects = div.getElementsByTagName("select");
                for ( var i = 0; i < selects.length; i++ ) {
                    var name    = $(selects[i]).attr("id");
                    var value   = $("#"+name).find(":selected").val();
                    if (value.length > 0) {columns[name] = value;}
                }
              
                var inputs  = div.getElementsByTagName("input");
                for ( var i = 0; i < inputs.length; i++ ) {
                    var name    = $(inputs[i]).attr("id");
                    var value   = $(inputs[i]).val();
                    if (value.length > 0) {columns[name] = value;}
                }
                // Page loading Icon
                $colspan = +inputs.length + +selects.length + 3;
                $(".insertData").html("<tr><td colspan='"+$colspan+"'><img src='<?php echo e(asset('img/ajax-loader.gif')); ?>'></td></tr>");
                //Go to Ajax Controller
                $.ajax({
                    url     :"<?php echo e(url('Ajaxtable?')); ?>",
                    data    :{path:path,key:key,columns:columns,groupby:groupby,conditions:conditions,model:model,page:page,search:search,ordertype:ordertype,orderby:orderby,rows:rows},
                    dataType:'json',
                    type    :'get',
                    success : function(data){
                        $('#loadpaginate').html($(data).find('#loadpaginate'));
                        $('#loadingcount').html($(data).find('#loadingcount'));
                        $('.insertData').html($(data).find('.loadingrow'));
                    }
                });
                return false;
            });

            $(document).on('click','.sort',function(e){                
                var sort = $('#ordertype').val();
                if (sort == 'desc') {
                    $('#ordertype').val('asc');
                }else{
                    $('#ordertype').val('desc');
                }
                $('#orderby').val($(this).attr('name'));
                pageid();
            });

            $(".select2").select2();
            $(document).on('click','.destroy',function(){ 
                var route   = $(this).data('route');
                var token   = $(this).data('token');
                $.confirm({
                    icon                : 'glyphicon glyphicon-floppy-remove',
                    animation           : 'rotateX',
                    closeAnimation      : 'rotateXR',
                    title               : 'OOps Delete Action',
                    //autoClose           : 'cancel|6000',
                    content             : 'Are you sure you want to delete!',
                    confirmButtonClass  : 'btn-danger',
                    cancelButtonClass   : 'btn-primary',
                    confirmButton       : 'Yes i agree',
                    cancelButton        : 'NO never !',
                    confirm: function () {
                        $.ajax({
                            url     : route,
                            type    : 'post',
                            data    : {_method: 'delete', _token :token},
                            dataType:'json',           
                            success : function(data){
                                if(data == "لن يسمح لك بالحذف"){
                                    alert(data);
                                }else{
                                    $("#"+data).parents("tr").remove();
                                    $("#"+data).remove();
                                    
                                }
                            },
                        });
                    },
                });
            });

            $(function () {
                $('#example1').DataTable({
                  "paging": false,
                  "lengthChange": false,
                  "searching": true,
                  "ordering": false,
                  "info": false,
                  "autoWidth": false
                });
              });
        </script>
        <?php if(Request::route()->getName() == 'Order.index'): ?>

        <script type="text/javascript">

            function autoprint(){
                //GO TO Controller and Print
                $.ajax({
                    url     :"<?php echo e(url('Order/autoPrint')); ?>",
                    data    :{},
                    dataType:'html',
                    type    :'get',
                    success : function(data){
                        $("#autoPrint").html("");
                        if(data == 'empty'){
                            $("#autoPrint").html("");
                        }else{
                            $("#autoPrint").html("printed");
                            <?php /*//   WebBrowser1.ExecWB(6, 2) //use 6, 1 to prompt the print dialog or 6, 6 to omit it;*/?>
                            <?php /* //   WebBrowser1.outerHTML = "";*/?>
                        }
                    }
                });
                // return false;
            };












            (function () {
                function startTime() {
                pageid();
                autoprint();
                    t = setTimeout(function () {
                        startTime()
                    // }, 1000);
                    }, 50000);
                }
                startTime();
            })();
        </script>
        <?php endif; ?>
    <!-- JS -->
        <script src="<?php echo e(asset('packages/jquery/jquery.min.js')); ?>" crossorigin="anonymous"></script>
        <script src="<?php echo e(asset('packages/bootstrap/js/bootstrap.min.js')); ?>" crossorigin="anonymous"></script>
        <script src="<?php echo e(asset('packages/confirm/jquery-confirm.min.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/datetimepicker/moment-with-locales.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/datetimepicker/bootstrap-datetimepicker.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/datatables/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/datatables/dataTables.bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/admintl/admin.js')); ?>"></script>
</html>
