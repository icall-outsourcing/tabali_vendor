<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>


<?php  
    $branchProduct  = \App\Product::where('branch_id',$branch->id)->where('available','ON');
    $ar_name        = \App\Product::where('branch_id',$branch->id)->where('available','ON')->lists('ar_name','id')->toArray();
    $section_name   = \App\Product::where('branch_id',$branch->id)->where('available','ON')->whereNull('extragroup')->groupBy('section_name')->lists('section_name','sectionid')->toArray();
    $ExtraItems     = \App\Product::where('branch_id',$branch->id)->where('available','ON')->where('extra','1')->get();
    
    
    
    

 ?> 

<?php $__env->startSection('content'); ?>
    <style type="text/css">
        
        #ordertabel table,#ordertabel thead,#ordertabel  tbody { display: block; }
        
        tbody {height: 330px;overflow-y:scroll;overflow-x: auto;}
        .input-table
        {
            text-align: center;  
            border:1; 
            width: 40px;
            padding: 0px;
            box-sizing: border-box;
        }
        #Typeahead-button{
          
          height: 34px !important;
          margin-top: -5px;
          z-index: 2;
        }
        .Typeahead-hint,
        .Typeahead-input {
          width: 100% !important;
          padding: 5px 8px;
          font-size: 24px;
          line-height: 30px;
        }
        .tt-dataset{
            overflow:auto;
            overflow: scroll; 
            overflow-x:hidden;
            border: 1px solid #024e6a !important;
            width: 120% !important;
         
            min-height: 45px !important; 
            max-height:200px !important;        
        }
        .items{
            overflow:auto;
            overflow: scroll; 
            overflow-x:hidden;
            width: 98%;
            min-height: 45px !important; 
            max-height:377px !important;
        }
        #arraydiv .additem{
            left:5px; 
            cursor:pointer;
            width:98%

        }
        .dep-name, .tdweight, .tdquantity, .tdtprice, .tduprice, .tdaction{            
            text-align:center;

         
        }
        .tdname{
            width: 30%;
            text-align:center;
        }
        .itemcomment{
            background-color: #ddd;
            height: 5px !important;
            font-style: italic;

        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo e(trans('form.selectitems')); ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>اسم الفرع </label>
                                <?php echo Form::select('branch_id',array($branch->id=>$branch->name),null,['class' => 'form-control select2','id' => 'branch']); ?>

                            </div>                            
                            <div class="form-group">
                                <label><?php echo e(trans('form.searchall')); ?></label>
                                <div id="remote" class="input-group">
                                    <input class="form-control Typeahead-input"  id="Typeahead-input" type="text" name="q" placeholder="Search" autocomplete="off" spellcheck="false" dir="rtl">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" id="Typeahead-button" type="button">
                                        <i id="Typeahead-hidden" class="fa fa-refresh fa-spin"  aria-hidden="true" style="display: none;"></i>
                                        <i id="Typeahead-show"   class="fa fa-search"          aria-hidden="true"></i> 
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label> تصنيف المنتج  </label>
                                <?php echo Form::select('section_name',[null =>'Please Select'] + $section_name,null,['class' => 'form-control select2','id' => 'sectionid']); ?>

                            </div>
                        <?php /*
                            <div class="form-group">
                                <label>Sub Class Name</label>                                
                                {!! Form::select('ar_name',[null =>'Please Select'] + $ar_name,null,['class' => 'form-control select2','id' => 'ar_name'])!!}
                            </div>
                        */?>
                      <!-- /.form-group -->
                    </div>

                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-right">
                </div>
              </div>
            </div>
            
            <!-- check value -->
            <div class="col-md-3">
                <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo e(trans('form.suggestion')); ?></h3>
                    <div class="box-tools input-group" style="width: 150px;">
                        <input type="search" name="search" class="live-search-box form-control input-sm" placeholder="Search">
                        <div class="input-group-btn"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i></button></div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row" >
                        <ul class="list-group items live-search-list" id="arraydiv" >
                        </ul>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
            <!-- ORDERTable -->
            <?php echo Form::model('Order',['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'POST','enctype' =>'multipart/form-data','route'=>"Order.store"]); ?>

                <input type="hidden" id="contact_id"     name="contact_id"      value="<?php echo e($contact->id); ?>">
                <input type="hidden" id="account_id"     name="account_id"      value="<?php echo e($account->id); ?>">
                <input type="hidden" id="branch_id"      name="branch_id"       value="<?php echo e($branch->id); ?>">
                <input type="hidden" id="address_id"     name="address_id"      value="<?php echo e($address->id); ?>">
                <input type="hidden" id="requested_from" name="requested_from"  value="<?php echo e($contact->phones->first()->phone); ?>">
                

                <div class="col-md-6">
                      <div class="box box-default" id="ordertabel">
                          
                            <div class="form-group">
                                <label>المصدر</label>
                                <?php echo Form::select('source',array('Phone'=>'Phone','Otlob'=>'Otlob','El menus'=>'El menus'),null,['class' => 'form-control select2','id' => 'source']); ?>

                            </div>
                        
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                          <table class="table table-hovered">
                            <thead class="label-success">
                                <tr class="label-default">
                                  <th  class="text-center"><?php echo e($contact->contact_name); ?></th>  
                                  <th class="text-center" colspan="3"><?php echo e($contact->phones->first()->phone); ?></th>
                                  <th class="text-center" colspan="3"><?php echo e($branch->name); ?></th>
                                </tr>
                                <tr>
                                  <th style="width: 30%" class="text-center">Dep.Name</th>
                                  <th style="width: 30%" class="text-center"><?php echo e(trans('form.item_name')); ?></th>
                                  <th style="width: 10%" class="text-center"><?php echo e(trans('form.quantity')); ?></th>
                                  <th style="width: 10%" class="text-center"><?php echo e(trans('form.uprice')); ?></th>
                                  <th style="width: 10%" class="text-center"><?php echo e(trans('form.total')); ?></th>
                                  <th colspan="2" style="width: 10%" class="text-center">Ac</th>
                                </tr>
                            </thead>
                            <tbody class="insertData" id="insertData">
                                    

                            </tbody>
                            <tfoot class="label-success">
                                <tr style="width: 100%">
                                    <th style="width: 40%"><?php echo e(trans('form.totalprice')); ?></th> 
                                    <th style="width: 50%"><span class="label label-danger"><strong id="totalinvoice">0</strong></span></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr style="width: 100%" >
                                    <th style="border:none !important;width: 40%"><?php echo e(trans('form.deliveryfees')); ?></th>
                                    <th style="border:none !important;"><input type="hidden" name="deliveryfees" id="fess" value=" <?php if(empty($area)): ?> 0 <?php else: ?> <?php echo e($area->dlivery_fees); ?> <?php endif; ?> "><span class="label label-danger" id="deliveryfees"><strong><?php if(!empty($area)): ?> <?php echo e($area->dlivery_fees); ?> <?php else: ?> 0 <?php endif; ?></strong></span></th>                                    
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                </tr>
                                <tr style="width: 100%" >
                                    <th style="border:none !important;width: 40%"><?php echo e(trans('form.TAX')); ?></th>
                                    <th style="border:none !important;"><input type="hidden" name="taxfees" id="inputTAX"><strong><span class="label label-danger" id="TAX">0</span></strong></th>
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                    <th style="border:none !important;"></th>
                                </tr>
                                <tr>  
                                    <th style="width: 10%"><?php echo e(trans('form.total')); ?></th>
                                    <th><input type="hidden" name="total" id="total"><span class="label label-danger" id="dtinvoice"><strong></strong></span></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><button type="submit" id="SaveOrder" class="btn btn-danger">Save </button>  </th>
                                </tr>
                            </tfoot>
                          </table>
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                </div>
            <?php echo Form::close(); ?>

            <!-- ./ORDERTable -->
        </div>
    </div>
    
    <script>
        // Search For All
            jQuery(document).ready(function($) {     
                // Set the Options for "Bloodhound" suggestion engine
                 var engine = new Bloodhound({
                    remote: {
                        url     :"<?php echo e(url('find?q=%QUERY%')); ?>"+"&"+"<?php echo 'branch='.$branch->id; ?>",
                        wildcard: '%QUERY%'
                    },
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                $(".Typeahead-input").typeahead('open');
                $(".Typeahead-input").typeahead('destroy');
                $('.Typeahead-input').typeahead(null, {
                    hint: false,highlight: true,minLength: 3,name:'Items',limit: 100,display: 'ar_name',source: engine,
                    templates: {
                        empty: function(data){
                            return '<a href="#" class="list-group-item">Nothing found.</a>';
                        },
                        suggestion: function (data) {
                            if (data.extra > 0 ) {
                                return '<a href="#"  id="'+data.id+'" title="'+data.description+'" class="list-group-item addtypeahead">'+ data.ar_name +' <span class="label label-success">اضافة</span></a>';
                            }else{
                                return '<a href="#"  id="'+data.id+'" title="'+data.description+'" class="list-group-item addtypeahead">'+ data.ar_name +'</a>';
                            }
                        }
                    }
                })
                .on('typeahead:asyncrequest', function() {
                    $('#Typeahead-show').hide();
                    $('#Typeahead-hidden').show();
                })
                .on('typeahead:asynccancel typeahead:asyncreceive', function() {
                    $('#Typeahead-hidden').hide();
                    $('#Typeahead-show').show();
                });
            });
        // DropDowm List
            $("#sectionid").attr('onchange'   ,'Ajaxdropdown("sectionid","Section","ar_name","ar_name")');
            function Ajaxdropdown(thislist,model,method,appendtolist) {
                $('#Typeahead-input').val('');
                var id      = $('#'+thislist+' :selected').attr( "value" );
                var text    = $('#'+thislist+' :selected').text();
                $("#arraydiv").html("<center><img src='<?php echo e(asset('img/icon.png')); ?>'></center>");
                $.ajax({
                    url     :"<?php echo e(url('Ajaxdropdown?')); ?>",
                    data    :{id:id,text:text,model:model,method:method},
                    dataType:'json',
                    type    :'get',
                    success : function(data){
                        var $items     = $('#'+appendtolist);
                        $items.empty();
                        $items.append('<option value="" selected>Select</option>');
                        if (appendtolist == 'ar_name') {
                            $.each(data[0], function(index, value) {                        
                                $items.append('<option value="'+value["id"]+'"id="'+value.id+'">'+value.ar_name+'</option>');
                            });
                        };
                        var $div = $('#arraydiv');

                        $div.empty(data);
                        $.each(data[0], function(index, value) {
                            if(value.branch_id == "<?php echo e($branch->id); ?>"){
                                $div.append('<a style="left:5px; cursor:pointer;width:98%" title="'+value.description+'" class="additem list-group-item" id="'+value.id+'">'+value.ar_name +'</a>');
                            }                 
                            
                        });
                        
                    }
                });
                return false;
            };
        // Add to Suggestion Div
            $(document).on('click','.addtypeahead',function(e){ 
                e.preventDefault();
                var name = $(this).text();
                var id   = $(this).attr('id');
                var title= $(this).attr('title');
                $('#arraydiv').html('<a class="additem list-group-item" title="'+title+'" id="'+id+'">'+ name +'</a>');
            });                 
        // live search
            $('.live-search-box').on('keyup', function(){
                $('.live-search-list a').each(function(){
                   $(this).attr('data-search-term', $(this).text().toLowerCase());
                });

                var searchTerm = $(this).val().toLowerCase();

                $('.live-search-list a').each(function(){

                    if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }

                });
            });
        // Add addZeroes
            function addZeroes( num ) {
                var value = Number(num);
                var res = num.split(".");
                if(num.indexOf('.') === -1) {
                    value = value.toFixed(2);
                    num = value.toString();
                } else if (res[1].length < 3) {
                    value = value.toFixed(2);
                    num = value.toString();
                }
            return num
            }
        // Add to selected Items
            $(document).on('click','.additem',function(){
                $('#Typeahead-input').val('');
                var id    = $(this).attr('id');
                var model   = 'Product';
                if (id == null || id == 0) {alert('you have to select Items');
                }else{  
                    $.ajax({
                        url     :"<?php echo e(url('Ajaxrow?')); ?>",
                        data    :{id:id,model:model},
                        dataType:'json',
                        type    :'get',
                        success : function(data){
                            $('.insertData').append(
                                '<tr id="item_'+data["id"]+'" style="font-size:13px" border="1">'
                                    +'<td style="width: 23%;" class="dep-name">'+data["section_name"]+'</td>'
                                    +'<td style="width: 22.5%;" class="tdname">'+data["ar_name"]+'</td>'
                                    +'<td style="width: 9%;" class="tdquantity"><input class="quantity input-table" id="quantity" name="quantity[]" value="1"></td>'
                                    +'<td style="width: 8.5%;" class="tduprice">'+addZeroes(data["price"])+'</td>'
                                    +'<td style="width: 11%;" class="tdtprice">'+'<span class="stprice">'+addZeroes(data["price"])+'</span>'+'</td>'
                                    +'<td style="width: 16%;" class="tdaction" onclick="suminvoice();">'
                                        +'<a class="addextra   btn btn-success btn-xs" data-sectionid="'+data["sectionid"]+'"> <i title="Extra Titems" class="fa fa-plus"></i></a> '
                                        +'<a class="addnote     btn btn-warning btn-xs"> <i title="Comment"      class="fa fa-sticky-note-o"></i></a> '
                                        +'<a class="removeitems btn btn-danger  btn-xs"> <i title="Remove"        class="fa fa-trash-o"></i></a> '
                                        +'<input type="hidden" class="uprice"         name="uprice[]"       value="'+data["price"]+'" id="uprice">'
                                        +'<input type="hidden" class="tprice"         name="tprice[]"       value="'+data["price"]+'" id="tprice">'
                                        +'<input type="hidden" class="item_comment"   name="item_comment[]" value=""                    id="item_comment">'
                                        +'<input type="hidden" class="item_id"        name="item_id[]"      value="'+data["id"]+'">'
                                        +'<input type="hidden" class="extraitem_id"   name="extraitem_id[]" value="No">'
                                    +'</td>'
                                +'</tr>'
                                +'<tr class="extraitem">  <td colspan="6" style="width: 100%;" ></td></tr>'
                                +'<tr class="itemcomment"></tr>'
                            );
                            suminvoice();
                        },
                    },"json");  
                }
            });
        // check the quantity
            $(document).on('keyup','.quantity',function(e){
                var qty     = Math.floor($(this).val());
                $(this).val(qty);
                var uprice  = addZeroes($(this).parent().parent().find($('.uprice')).val());
                var tprice  = (uprice * qty).toFixed(2);
                $(this).parent().parent().find($('.tprice')).val(tprice);
                $(this).parent().parent().find($('.stprice')).text(tprice);
                $(this).parent().parent().next($('.extraitem')).find('.quantity').each(function() {
                        $(this).val(qty);
                        var uprice = $(this).parent().find('.extraitemquantity').text(' x '+qty);
                        var uprice = $(this).next('.uprice').val();
                        $(this).next().next('.tprice').val((uprice * qty).toFixed(2));
                });
                var sum = 0;
                suminvoice();
            });
        // count the total 
            function suminvoice(){
                var sum = 0;
                    $('.tprice').each(function() {
                        sum += Number($(this).val());
                    });
                    var total       = sum.toFixed(2);
                    var dtinvoice   = (+total + +$('#deliveryfees').text()).toFixed(2);
                    var TAX         = (dtinvoice * 0.14).toFixed(2);
                    $('#totalinvoice').text(total);
                    $('#total').val(total);
                    $('#dtinvoice').text((+TAX + +dtinvoice).toFixed(2));
                    $('#TAX').text(TAX);
                    $('#inputTAX').val(TAX);
                    $('#fees').val($('#deliveryfees').text());
            }
        // remove items
            $(document).on('click','.removeitems',function(e){ 
                e.preventDefault();
                $(this).parent().parent().next($('.itemcomment')).remove();
                $(this).parent().parent().next($('.extraitem')).remove();
                $(this).parent().parent().remove();
                suminvoice();
            });
        // remove extraItems
            $(document).on('click','#removeexItems',function(e){ 
                e.preventDefault();
                $(this).parent().remove();
                suminvoice();
            });
        // remove extraItems
            $(document).on('click','#removeexcomposite',function(e){ 
                e.preventDefault();
                $(this).next('div').remove();
                $(this).remove();
                suminvoice();
            });
        // Add note
            $(document).on('click','.addnote',function(e){ 
                e.preventDefault();
                var thiscomment = $(this);
                $.confirm({
                    title: 'Add your comment',
                    content: 'Comment. <input id="comments" type="text" class="form-control" value=""/>',
                    confirmButtonClass: 'btn-success',
                    cancelButtonClass: 'btn-danger',
                    keyboardEnabled: true,
                    confirmKeys: [13], // ENTER key
                    cancelKeys: [27], // ESC key
                    confirm: function () {
                        var comment      = $('#comments').val();
                        thiscomment.parent().find($('.item_comment')).val(comment);
                        thiscomment.parent().parent().next().next($('.itemcomment')).html('<td colspan="6" style="width: 100%;" class="text-green">'+comment+'</td>');
                        thiscomment.attr('class','addnote btn btn-success btn-xs');
                    }
                });
            });
        // Add Extra Items
            $(document).on('click','.addextra',function(e){
                e.preventDefault();
                var quantity = $(this).parent().parent().find('.quantity').val();
                var addextra = $(this);
                var sectionid = $(this).data('sectionid');
                var route    = "<?php echo e(URL::route('Order.extraItems')); ?>?branch_id=<?php echo e($branch->id); ?>&sectionid="+sectionid;
                $.confirm({
                    title: 'Add Extra Items',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: 'url:'+route,
                    closeIcon:  true,
                    confirmButtonClass: 'btn-success',
                    cancelButtonClass: 'btn-danger',
                    keyboardEnabled: true,
                    confirmKeys: [13], // ENTER key
                    cancelKeys: [27], // ESC key
                    confirm: function () {
                        var comparray   = [];
                        // console.log(comparray)
                        $(".compositeId:checked").each(function(){comparray.push($(this).val());});
                        var id    = $('#addEI').find('option:selected').attr('id');
                        var model   = 'Product';
                            // console.log(comparray)
                            // return false;
                        if (id == null && Object.keys(comparray).length === 0) {   
                            alert('you have to select Items');
                        }else{  
                            $.ajax({
                                url     :"<?php echo e(url('Ajaxrow?insert=extra&')); ?>",
                                data    :{id:id,model:model,comparray:comparray,quantity:quantity},
                                dataType:'json',
                                type    :'get',
                                success : function(data){
                                    addextra.parent().parent().next($('.extraitem')).find('td').prepend(data);
                                    suminvoice();
                                },
                            },"json");
                        }  
                    }
                });
            });
                function checkOnHold(){
                    if($('#payment_type').val() != 'Delivery'){
                        $('#onHolddiv').show();
                    }else{
                        $('#onHolddiv').hide();
                    }

                }
        // Order details
            $(document).on('click','#SaveOrder',function(e){ 
                e.preventDefault();
                var form = jQuery(this).parents("form:first");
                var dataString = form.serialize();
                var formAction = form.attr('action');
                var rowCount = $('#insertData tr').length;
                if(rowCount > 0){
                    $.confirm({
                        icon                : 'fa fa-barcode',
                        title               : 'Order Details',
                        columnClass         : 'col-md-4 col-md-offset-4',
                        confirmButtonClass  : 'btn-success',
                        cancelButtonClass   : 'btn-danger',
                        content             :   '<div class="form-group">'+
                                                    '<label for="payment_type" class="control-label">Payment Type</label><div class="check_payment_type"><select class="form-control" id="payment_type" required="required" onchange="checkOnHold()" name="payment_type">'+
                                                    '<?php if(!empty($area)): ?> <option value="Delivery">Delivery</option> <?php endif; ?> <option value="HotSpot">HotSpot</option><option value="OnHold">OnHold</option></select>'+
                                                '</div>'+
                                                '<div class="form-group" id="onHolddiv" style="display: none;">'+
                                                    '<label for="on_hold_time" class="control-label">On Hold Time</label><div class="check_on_hold_time input-group" id="on_hold_time">'+
                                                    '<input type="text" name="on_hold_time" class="form-control" id="date-on_hold_time"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>'+
                                                '</div></div>'+
                                                '<div class="form-group">'+
                                                    '<label for="follow_up_phone" class="control-label">Follow up Phone</label>'+
                                                    '<input type="text" class="form-control" id="follow_up_phone" required="required" name="follow_up_phone">'+
                                                '</div>'+
                                                '<div class="form-group">'+
                                                    '<label for="order_comment" class="control-label">Note</label>'+
                                                    '<textarea class="form-control" name="order_comment" rows="5" id="order_comment"></textarea>'+
                                                '</div>',
                        cancelButton        : 'Cancel!',
                        confirmButton       : 'Save Order',
                        confirm: function () {
                            var payment_type  = $('#payment_type').val();
                            var order_comment   = $('#order_comment').val();
                            var follow_up_phone = $('#follow_up_phone').val();
                            var on_hold_time    = $('#date-on_hold_time').val();
                            $('#SaveOrder').hide();
                            $.ajax({
                                type    : "POST",
                                url     : formAction,
                                data    : dataString + '&OnHold=' + on_hold_time+ '&payment_type=' + payment_type+ '&order_comment=' + order_comment + '&follow_up_phone=' + follow_up_phone ,
                                success : function(data){
                                    if (data.message=='Error') {
                                        var JSONError = '';
                                        $.each(data.errors, function(index, value) {
                                          index =  index.replace("_", " ");JSONError += index.toUpperCase()  +' : '+ value +'<br/>';
                                        });
                                        $.alert({
                                            type: 'red',
                                            columnClass: 'col-md-6 col-md-push-3 col-sm-6',
                                            title: data.message,
                                            content: '<div class="alert alert-danger">'+JSONError+'</div>',
                                        });
                                        $('#SaveOrder').show();
                                        return false;
                                    }else if(data.message=='Success'){
                                        $.alert({
                                            type: 'red',
                                            columnClass: 'col-md-4 col-md-push-4',
                                            title: data.message,
                                            content: data.success,
                                            confirm: function(){
                                                window.location.replace("<?php echo e(URL::route('Account.show',['id' => $account->id ,'contact' => $contact->id])); ?><?php echo '&branch='.$address->branch_id.'&address='.$address->id?>");
                                            }
                                        });

                                    }
                                    
                                },
                                error : function(data){
                                     console.log(data);
                                    $('#SaveOrder').show();
                                    $.alert({title: 'Massage!',autoClose: 'confirm|1000',content: 'The Order dosn\'t save please try again!',});
                                }
                            },"json");
                        },
                    });
                    $(function () {$('#on_hold_time').datetimepicker({format: 'YYYY-MM-DD HH:m:ss',toolbarPlacement: 'top',defaultDate: ' <?php echo e(date("Y-m-d h:t:s")); ?>'});});
                }else{
                    $.alert({title: 'Massage!',autoClose: 'confirm|2000',content: 'You have to Select Items',});                   
                }
            });  
    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>