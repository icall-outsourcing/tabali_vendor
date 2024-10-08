<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>


<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php /*     
    <div class="Append col-md-12">
      <div class="panel panel-default clearfix">
        <div class="panel-heading" style="height:50px !important">
          <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#feature-2"> <i class="glyphicon glyphicon-resize-vertical"></i>Toggle Feature Set</button> -->
          <div class="col-xs-5 panel-title"> Printer Name</div>
          <div class="col-xs-5 text-center"> Branch Name </div>
          <!-- <div class="col-xs-4 text-center"> ID </div> -->
          <div class="col-xs-2 text-center"> check </div>
        </div> 
        
        <div id="feature-2" class="collapse in">
            @foreach($printers as $print)
              <div class="panel-body">
                <div class="row">                  
                  <div class="col-xs-5">{{$print->printer_name}} </div>
                  <div class="col-xs-5 text-center">{{$print->printer_key}}</div>
                  <div class="col-xs-2 text-center"> <input type="checkbox" name="printers[]" value="{{$print->id}}"></div>
                </div>
              </div> 
            @endforeach               
        </div>
      </div>
    </div>
        */?>
    <script type="text/javascript"> $('.NewAppend').append($('.Append')); </script>

    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>