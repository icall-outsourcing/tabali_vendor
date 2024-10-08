<!-- language -->
<?php if(session()->has('lang')): ?>
    <?php echo e(App::setLocale(session()->get('lang'))); ?>

<?php else: ?>
    <?php echo e(App::setLocale('ar')); ?>

<?php endif; ?>



    <?php if($data->status =='viewed' || $data->status == 'opened' || Auth::user()->is('admin|tabaliadmin|teamleader')): ?>
        <?php  
            $under_change   = \App\Order::find($data->id)->update(['under_change' => 'Y']);
            $branchProduct  = \App\Product::where('branch_id',$branch->id)->where('available','ON');
            $ar_name        = \App\Product::where('branch_id',$branch->id)->where('available','ON')->lists('ar_name','id')->toArray();
            $section_name   = \App\Product::where('branch_id',$branch->id)->where('available','ON')->groupBy('section_name')->lists('section_name','sectionid')->toArray();
            $ExtraItems     = \App\Product::where('branch_id',$branch->id)->where('available','ON')->where('extra','1')->get();
         ?> 
        <?php $__env->startSection('content'); ?>
            <style type="text/css">
                table,thead, tbody { display: block; }
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
                /*width: 35px  !important;*/
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
                    /*height: */
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
                                <h3 class="box-title">Select Items</h3>
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
                                        <div class="form-group">
                                            <label> تصنيف المنتج  </label>
                                            <?php echo Form::select('section_name',[null =>'Please Select'] + $section_name,null,['class' => 'form-control select2','id' => 'sectionid']); ?>

                                        </div>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <!-- /.row -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-right"></div>
                        </div>


                        <?php if(!empty(@$data->Voucher->vouchercode)): ?>
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <!-- <h3 class="box-title"><?php echo e(trans('form.GiftVoucher')); ?></h3> -->
                                    <img src="<?php echo e(asset('img/logo2.png')); ?>" style="display: block;margin-left: auto;margin-right: auto;width: 50%;" >
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group text-center">
                                                <label class="control-label ">Gift Code has been inserted</label>
                                                <div type="text" class="form-control" disabled><?php echo e(@$data->Voucher->gift->name); ?>  -  ( <?php echo e(@$data->Voucher->vouchercode); ?> )</div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        <?php endif; ?>

                    



                    </div>

                    <!-- check value -->
                    <div class="col-md-3">
                        <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Suggestion</h3>
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
                        
                    <div class="col-md-6">
                        <!-- ORDERTable -->
                        <?php echo Form::model($data,['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'PUT','enctype' =>'multipart/form-data','route'=>  array("Order.update",$data->id)]); ?>

                            <input type="hidden" id="contact_id"     name="contact_id"      value="<?php echo e($data->contact_id); ?>">
                            <input type="hidden" id="account_id"     name="account_id"      value="<?php echo e($data->account_id); ?>">
                            <input type="hidden" id="branch_id"      name="branch_id"       value="<?php echo e($data->branch_id); ?>">
                            <input type="hidden" id="address_id"     name="address_id"      value="<?php echo e($data->address_id); ?>">
                            <div class="box box-default">
                                <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <div class="form-group">
                                        <label>المصدر</label>                                        
                                        <?php echo Form::select('source',array('Phone'=>'Phone','Otlob'=>'Otlob','El menus'=>'El menus','Koinz'=>'Koinz','Marsool'=>'Marsool','Botit'=>'Botit'),null,['class' => 'form-control select2','id' => 'source']); ?>

                                    </div>    
                                    
                                    <table class="table table-hovered">
                                        <thead class="label-success">
                                            <tr class="label-default">
                                                <th colspan="2" class="text-center"><?php echo e($contact->contact_name); ?></th>
                                                <th class="text-center" colspan="2"><?php echo e($data->follow_up_phone); ?></th>
                                                <th class="text-center" colspan="2"><?php echo e($branch->name); ?></th>
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
                                        <?php foreach($data->items->where('version',$data->version) as $value): ?>
                                            <?php  $notes = $value->item_comment ;  ?>
                                            <?php if($value->extra_items == null): ?>
                                                <tr id="item_<?php echo e($value->product_id); ?>">
                                                    <td style="width: 23%;"   class="dep-name"><?php echo e($value->product->section_name); ?></td>
                                                    <td style="width: 22.5%;" class="tdname"><?php echo e($value->product->ar_name); ?></td>
                                                    <td style="width: 9%;"    class="tdquantity">
                                                        <?php if($value->voucher == 'Y'): ?>
                                                            <div class="quantity input-table disabled"><?php echo e(number_format($value->quantity ,0,'','')); ?></div>
                                                        <?php else: ?>
                                                            <input class="quantity input-table" id="quantity" name="quantity[]" value="<?php echo e(number_format($value->quantity ,0,'','')); ?>">
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="width: 8.5%;"  class="tduprice"><?php echo e($value->uprice); ?></td>
                                                    <td style="width: 11%;"   class="tdtprice"><span class="stprice"><?php echo e($value->tprice); ?></span></td>
                                                    <?php if($value->voucher == 'N'): ?>
                                                        <td style="width: 16%;"   class="tdaction" onclick="suminvoice();">
                                                            <a class="addextra    btn btn-success btn-xs" data-sectionid="<?php echo e($value->product->sectionid); ?>">  <i title="Extra Titems" class="fa fa-plus"></i></a>                                                        
                                                            <?php if(!empty($value->item_comment)): ?>
                                                                <a class="addnote btn btn-success btn-xs"><i title="Comment" class="fa fa-sticky-note-o"></i></a>
                                                            <?php else: ?> 
                                                                <a class="addnote btn btn-warning btn-xs"><i title="Comment" class="fa fa-sticky-note-o"></i></a>
                                                            <?php endif; ?> 
                                                            <a class="removeitems btn btn-danger  btn-xs" data-id="<?php echo e($value->id); ?>" data-token="<?php echo e(csrf_token()); ?>"> <i title="Remove"        class="fa fa-trash-o"></i></a>
                                                            <input type="hidden" class="orderItemId"  id="orderItemId"  name="orderItemId[]"    value="<?php echo e($value->id); ?>">
                                                            <input type="hidden" class="uprice"       id="uprice"       name="uprice[]"         value="<?php echo e($value->uprice); ?>">
                                                            <input type="hidden" class="tprice"       id="tprice"       name="tprice[]"         value="<?php echo e($value->tprice); ?>">
                                                            <input type="hidden" class="item_comment" id="item_comment" name="item_comment[]"   value="<?php echo e($value->item_comment); ?>">
                                                            <input type="hidden" class="item_i"       id="item_id"      name="item_id[]"        value="<?php echo e($value->product_id); ?>">
                                                            <input type="hidden" class="extraitem_id" id="extraitem_id" name="extraitem_id[]"   value="No">
                                                        </td>
                                                    <?php else: ?>
                                                        <td style="width: 16%;"   class="tdaction">Voucher Gift</td>

                                                    <?php endif; ?>
                                                </tr>
                                                <tr class="extraitem">  
                                                    <td colspan="6" style="width: 100%;" > 
                                                        <?php  $extra_items = $value->id;  ?>
                                                        <?php foreach($data->items->where('version',$data->version) as $value): ?>
                                                            <?php if($value->extra_items == $extra_items): ?>
                                                            <span class="label label-default"><?php echo e($value->product->ar_name); ?>  <?php echo e($value->tprice); ?><b class="extraitemquantity"> x  <?php echo e(number_format($value->quantity ,0,'','')); ?> </b> <a id="removeexItems" class="label label-danger" href="#" > <i  title="Remove" class="fa fa-trash-o"> </i> </a>
                                                                <input type="hidden" name="item_id[]"      value="<?php echo e($value->product_id); ?>"                       class="item_id">
                                                                <input type="hidden" name="quantity[]"     value="<?php echo e(number_format($value->quantity ,0,'','')); ?>" class="input-table quantity">
                                                                <input type="hidden" name="uprice[]"       value="<?php echo e($value->uprice); ?>" class="uprice" id="uprice">
                                                                <input type="hidden" name="tprice[]"       value="<?php echo e($value->tprice); ?>" class="tprice" id="tprice">
                                                                <input type="hidden" name="extraitem_id[]" value="Yes"               class="extraitem_id">
                                                                <input type="hidden" name="item_comment[]" value="extra"             class="input-table" >
                                                                <input type="hidden" name="orderItemId[]"  value="<?php echo e($value->id); ?>">
                                                            </span>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                </tr>
                                                <?php if(!empty($notes)): ?>
                                                    <tr class="itemcomment">
                                                        <td colspan="6" style="width: 100%;" class="text-green"><?php echo e($notes); ?></td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr class="itemcomment" style="display: none">
                                                        <td colspan="6" style="width: 100%;" class="text-green"></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="label-success">
                                            <tr style="width: 100%">
                                                <th style="width: 40%"><?php echo e(trans('form.totalprice')); ?></th> 
                                                <th style="width: 50%"><span class="label label-danger"><strong id="totalinvoice"><?php echo e($data->total); ?></strong></span></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>

                                            <?php if($address->discount_id > 0 ): ?>
                                            <tr style="width: 100%" >
                                                <th style="border:none !important;width: 40%"><?php echo e(trans('form.discount_id')); ?></th>
                                                <th style="border:none !important;"><input type="hidden" name="discount" id="inputdiscount_id" value="<?php echo e($address->discount->dicount); ?>"><strong><span class="label label-danger" id="discount_id"><?php echo e($address->discount->dicount); ?>% </span></strong></th>
                                                <th style="border:none !important;"></th>
                                                <!-- <th style="border:none !important;"></th> -->
                                                <!-- <th style="border:none !important;"></th> -->
                                                <!-- <th style="border:none !important;"></th> -->
                                                <th colspan="4" style="border:none !important;"><?php echo e($address->discount->company_name); ?></th>
                                            </tr>
                                            <?php else: ?>
                                            <input type="hidden" name="discount" id="inputdiscount_id" value="0">
                                            <?php endif; ?>
                                            <tr style="width: 100%" >
                                                <th style="border:none !important;width: 40%"><?php echo e(trans('form.deliveryfees')); ?></th>
                                                <th style="border:none !important;">
                                                <input type="hidden" id="oldfess" value="<?php if(empty($area)): ?> 0 <?php else: ?> <?php echo e($area->dlivery_fees); ?> <?php endif; ?>">                                                
                                                <input type="hidden" name="deliveryfees" id="fess" value="<?php if(empty($area)): ?> 0 <?php else: ?> <?php echo e($area->dlivery_fees); ?> <?php endif; ?>"><span class="label label-danger" id="deliveryfees"><strong><?php echo e($data->deliveryfees); ?></strong></span></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                            </tr>

                                            <tr style="width: 100%" >
                                                <th style="border:none !important;width: 40%"><?php echo e(trans('form.TAX')); ?></th>
                                                <th style="border:none !important;"><input type="hidden" name="taxfees" id="inputTAX" value="<?php echo e($data->taxfees); ?>"><strong><span class="label label-danger" id="TAX"><?php echo e($data->taxfees); ?></span></strong></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                                <th style="border:none !important;"></th>
                                            </tr>
                                            


                                            <tr>  
                                                <th style="width: 10%"><?php echo e(trans('form.total')); ?></th>
                                                <th><input type="hidden" name="total" id="total"><span class="label label-danger" id="dtinvoice"><strong>
                                                <?php  
                                                    $discount = ( 100 - $data->discount) / 100;
                                                    $Afterdiscount =  number_format($data->total *  $discount,2)
                                                 ?>
                                                <?php echo e(number_format((float)$Afterdiscount + $data->deliveryfees + $data->taxfees, 2, '.', '')); ?>

                                                
                                                </strong></span></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th><button type="submit" id="SaveOrder" class="btn btn-danger">Save </button>  </th>
                                                <th><button type="submit" id="CancelSaveOrder" class="btn btn-danger">Cancel </button>  </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->                            
                        <?php echo Form::close(); ?>

                        <!-- ./ORDERTable -->
                    </div>
                </div>
            </div>
            <input type="hidden" id="DataOrderComment" value="<?php echo $data->order_comment; ?>">
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
                                    $.each(data[0], function(index, value) {'<a style="left:5px; cursor:pointer;width:98%" title="'+value.description+'" class="additem list-group-item" id="'+value.id+'">'+value.ar_name +'</a>'});
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
                                                +'<a class="addextra    btn btn-success btn-xs" data-sectionid="'+data["sectionid"]+'"> <i title="Extra Titems" class="fa fa-plus"></i></a> '
                                                +'<a class="addnote     btn btn-warning btn-xs"> <i title="Comment"      class="fa fa-sticky-note-o"></i></a> '
                                                +'<a class="removeitems btn btn-danger  btn-xs"> <i title="Remove"        class="fa fa-trash-o"></i></a> '
                                                +'<input type="hidden" class="uprice"         name="uprice[]"       value="'+data["price"]+'" id="uprice">'
                                                +'<input type="hidden" class="tprice"         name="tprice[]"       value="'+data["price"]+'" id="tprice">'
                                                +'<input type="hidden" class="item_comment"   name="item_comment[]" value=""                    id="item_comment">'
                                                +'<input type="hidden" class="item_id"        name="item_id[]"      value="'+data["id"]+'">'
                                                +'<input type="hidden" class="extraitem_id"   name="extraitem_id[]" value="No">'
                                                +'<input type="hidden" class="orderItemId"  id="orderItemId"  name="orderItemId[]"    value="orderItemId">'
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
                    $(document).on('keyup','.quantity',function(){
                        var qty     = $(this).val();
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
                            var dicount     = $('#inputdiscount_id').val() / 100;
                            var dtinvoice   = (+total + +$('#deliveryfees').text()).toFixed(2);
                            var TAX         = (dtinvoice * 0.14).toFixed(2);
                            var totalDiscou = total * dicount;
                            $('#totalinvoice').text(total);
                            $('#total').val(total);
                            if($('#inputdiscount_id').val() > 0 ){
                                $('#dtinvoice').text(((+TAX + +dtinvoice - +totalDiscou)  ).toFixed(2));
                            }else{
                                $('#dtinvoice').text(((+TAX + +dtinvoice)).toFixed(2));
                            }
                            
                            $('#TAX').text(TAX);
                            $('#inputTAX').val(TAX);
                            $('#fees').val($('#deliveryfees').text());



                            
                            




                    }
                // remove items
                    $(document).on('click','.removeitems',function(e){ 
                        e.preventDefault();
                        var ritems  = $(this);
                        var id      = $(this).data('id');
                        if (id == null) {
                            ritems.parent().parent().next($('.itemcomment')).remove();
                            ritems.parent().parent().next($('.extraitem')).remove();
                            ritems.parent().parent().remove();
                            suminvoice();
                            return false
                        }
                        var route   = "<?php echo e(URL::route('Order.printerUpdate',$data->id)); ?>";
                        var token   = $(this).data('token');
                        $.ajax({
                            type    : "POST",
                            url     : route,
                            data    : {_method: 'post', _token:token,order_item:id,flagtoprint:'P',updateorder:'pending',printeraction:'remove',version:"<?php echo e($data->version); ?>"},
                            success : function(data){
                                if (data.message == "Success") {
                                    ritems.parent().parent().next($('.itemcomment')).remove();
                                    ritems.parent().parent().next($('.extraitem')).remove();
                                    ritems.parent().parent().remove();
                                    suminvoice();
                                }
                            },
                            error : function(data){
                                $.alert({title: 'Massage!',autoClose: 'confirm|1000',content: 'Try again!',});
                            }
                        },"json");
                    });
                // remove extraItems
                    $(document).on('click','#removeexItems',function(e){ 
                        e.preventDefault();
                        $(this).parent().remove();
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
                            confirmButtonClass: 'btn-success',
                            cancelButtonClass: 'btn-danger',
                            keyboardEnabled: true,
                            confirmKeys: [13], // ENTER key
                            cancelKeys: [27], // ESC key
                            confirm: function () {
                                var comparray   = [];
                                var id    = $('#addEI').find('option:selected').attr('id');
                                var model   = 'Product';
                                $(".compositeId:checked").each(function(){comparray.push($(this).val());});
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
                // Order details
                    $(document).on('click','#SaveOrder',function(e){ 
                        e.preventDefault();
                        var DataOrderComment = $('#DataOrderComment').val();
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
                                content             : '<div class="form-group">'+
                                                        '<label for="payment_type" class="control-label">Payment type</label>'+
							'<div class="check_payment_type">'+							
							    '<select class="form-control" id="payment_type" required="required" name="payment_type">'+
							      '<option value="Delivery" <?php if($data->payment_type == "Delivery"): ?> selected  <?php endif; ?> >Delivery</option>'+
							      '<option value="HotSpot" <?php if($data->payment_type == "HotSpot"): ?> selected  <?php endif; ?> >HotSpot</option>'+
							      '<option value="OnHold" <?php if($data->payment_type == "OnHold"): ?> selected  <?php endif; ?> >OnHold</option>'+
							    '</select>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="form-group">'+
                                                        '<label for="payment_method" class="control-label">payment Method</label>'+
                                                        '<div class="check_payment_method">'+
                                                            '<select class="form-control" id="payment_method" required="required" name="payment_method"><option value="Cash" <?php if($data->payment_method == "Cash"): ?> selected  <?php endif; ?>>Cash</option><option value="paid" <?php if($data->payment_method == "paid"): ?> selected  <?php endif; ?>>paid</option> <option value="Visa Card" <?php if($data->payment_method == "Visa Card"): ?> selected  <?php endif; ?> >Visa Card</option></select>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<?php if($data->payment_type == "OnHold"): ?> <div class="form-group">'+'<?php echo e($data->on_hold_time); ?></div><?php endif; ?>'+
                                                    '<div class="form-group">'+
                                                        '<label for="follow_up_phone" class="control-label">Follow up Phone</label><div class="check_follow_up_phone"><select class="form-control" id="follow_up_phone" required="required" name="follow_up_phone"><option selected="selected"><?php echo e($data->follow_up_phone); ?></option></select></div></div><div class="form-group"><label for="order_comment" class="control-label">Note</label><div class="check_order_comment"><textarea class="form-control" name="order_comment" rows="5" id="order_comment">'+DataOrderComment+'</textarea></div></div>',
                                cancelButton        : 'Cancel!',
                                confirmButton       : 'Save Order',
                                confirm: function () {
                                    var payment_type  = $('#payment_type').val();
                                    var order_comment   = $('#order_comment').val();
                                    var follow_up_phone = $('#follow_up_phone').val();
                                    var payment_method = $('#payment_method').val();
                                    
                                    $('#SaveOrder').hide();
                                    $.ajax({
                                        type    : "POST",
                                        url     : formAction,
                                        data    : dataString + '&payment_type=' + payment_type+ '&order_comment=' + order_comment + '&follow_up_phone=' + follow_up_phone + '&payment_method=' + payment_method ,
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
                                            $('#SaveOrder').show();
                                            $.alert({title: 'Massage!',autoClose: 'confirm|1000',content: 'The Order dosn\'t save please try again!',});
                                        }
                                    },"json");
                                },
                            });
                        }else{
                            $.alert({title: 'Massage!',autoClose: 'confirm|2000',content: 'You have to Select Items',});                   
                        }
                    }); 

 // test   
            $(document).on('change','#source',function(e){
                var value      = $('#source :selected').attr( "value" );
                if(value == 'Marsool'){                    
                    $("#deliveryfees").text('0');
                    $("#fess").val('0');                    
                }else{
                    var oldfess = $("#oldfess").val();                    
                    $('#fess').val(oldfess);
                    $("#deliveryfees").text(oldfess);
                    
                }
                suminvoice();
            });


                    $(document).on('click','#CancelSaveOrder',function(e){ 
                        e.preventDefault();
                        var form = jQuery(this).parents("form:first");
                        var dataString = form.serialize();
                        $.ajax({
                            type    : "POST",
                            url     : "<?php echo e(url(route('Order.update',$data->id))); ?>",
                            data    : dataString + '&under_change=N&cancelupdate=Y',
                            success : function(data){
                                $.alert({
                                    type: 'red',
                                    columnClass: 'col-md-4 col-md-push-4',
                                    title: data.message,
                                    content: data.success,
                                    confirm: function(){
                                        window.location.replace("<?php echo e(URL::route('Account.show',['id' => $account->id ,'contact' => $contact->id])); ?><?php echo '&branch='.$address->branch_id.'&address='.$address->id?>");
                                    }
                                });
                            },
                            error : function(data){
                                $('#CancelSaveOrder').show();
                                $.alert({title: 'Massage!',autoClose: 'confirm|1000',content: 'The Order dosn\'t save please try again!',});
                            }
                        })
                    });  
            </script>
        <?php $__env->stopSection(); ?>
    <?php else: ?>
        <?php $__env->startSection('content'); ?>
            <section class="content">
                <div class="error-page">
                    <h2 class="headline text-red"><i class="fa fa-frown-o" aria-hidden="true"></i></h2>
                    <div class="error-content">
                        <br/>
                        <h3><i class="fa fa-warning text-red"></i> Oops! This Order <?php echo e($data->status); ?></h3>
                        <p>We are sorry you can't modified on this Order right now.</p>
                        <p><a href="<?php echo e(url()->previous()); ?>"> Return to Back </a></p>
                    </div>
                </div>
            </section>
        <?php $__env->stopSection(); ?>    
    <?php endif; ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>