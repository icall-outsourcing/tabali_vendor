<?php $__env->startSection('content'); ?>
    <style type="text/css">
        .background{
            position: absolute;
            top: -20px;
            left: -20px;
            right: -40px;
            bottom: 0px;
            width: auto;
            height: auto;
            background-image: url(https://gaddelivery.com/img/f1be58330025805b9ac92df6ddda33a1.png);
            background-size: cover;
            -webkit-filter: blur(2px);
            z-index: 0;
        }
        .login{
            margin-top: 50%; 
            opacity: 0.9;
            width: 350px;
            padding: 10px;
            z-index: 2;
        }
    </style>
    <div class="background"></div>
    <div style="position: absolute; left: 50%;">
        <div style="position: relative; left: -50%;">
            <form class="login well" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
                <?php echo csrf_field(); ?>

                <center>
                        <img class=" img-responsive" src="<?php echo e(asset('img/logo.png')); ?>" style="border-radius: 10%;opacity: 0.8;">
                </center>
                
                <div class="form-group">
                    <label id="lblUsername" for="email">Username</label>
                    <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>">
                </div>
                 <div class="form-group">
                    <label id="lblPassword" for="email">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="text-right"><button type="submit" class="btn btn-success" >LOGIN TO CRM</button></div>
                <span id="RequiredFieldValidator1" style="color:Red;">
                <?php if($errors->any()): ?>
                  <?php foreach($errors->all() as $error): ?>
                      <?php echo e($error); ?>

                  <?php endforeach; ?>
                <?php endif; ?>
                </span>                                        
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>