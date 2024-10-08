<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
 <div class="row">
     <div class="col-xs-12">
   <h2 class="page-header">
    <i class="fa fa-barcode"></i> Complaint No # <?php echo e($ShowData->id); ?>

    <small class="pull-right">Date: <?php echo e($ShowData->created_at); ?></small>
   </h2>
     </div>
   </div>
 <div class="row">
  <div class="col-sm-12  text-right">
   <style type="text/css">
    table.products td {
      text-align: right;
    }
   </style>
   
    <table class="table table-striped" width="100%">
        <tr>
            <td ><?php echo e($ShowData->branch->name); ?></td>
            <td ><strong> الفرع  </strong></td>
            <td > <?php echo e($ShowData->follow_up_phone); ?></td>
            <td ><strong>ﺭﻗﻢ اﻟﺘﻠﻴﻔﻮﻥ</strong></td>
            <td > <?php echo e($ShowData->contact->contact_name); ?></td>
            <td ><strong>  اسم العميل </strong></td>
        </tr>
        <tr>
            <td ><?php echo e($ShowData->status); ?> </td>
            <td ><strong> الحاله  </strong></td>
            <td > <?php echo e($ShowData->Priority); ?> </td>
            <td ><strong> درجه الاهميه </strong></td>
            <td ><?php echo e($ShowData->complaint_type); ?> </td>
            <td ><strong> نوع الشكوى </strong></td>
            
        </tr>
        <tr>
            <td colspan="2" class="bg-success" ><?php echo e($ShowData->close_complain_comment); ?> </td>
            
            <td class="bg-success" ><strong> حل الشكوى  </strong></td>
            
            
            <td colspan="2"  class="bg-danger"><?php echo e($ShowData->complain_comment); ?> </td>
            <td class="bg-danger" ><strong> وصف الشكوى  </strong></td>
            
        </tr>
    </table>
   
       
    <?php if($ShowData->order_id): ?>
   <div class="page-footer">
        <center>
            <small class="text-center">
             لقد تم انشاء هذه الشكوى على الطلب رقم #<?php echo e($ShowData->order_id); ?>

             <br/>
            <a href="#" id="showorder" data-route="<?php echo e(url(route('Order.show',$ShowData->order_id))); ?>" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
        </small>
        </center>
            
        
   </div>
    <?php endif; ?>   
   
   
   
   
   
  </div>
 </div>
 