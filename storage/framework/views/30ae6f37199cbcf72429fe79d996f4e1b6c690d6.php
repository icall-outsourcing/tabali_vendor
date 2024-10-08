<?php if($errors->any()): ?>
    <?php foreach($errors->all() as $error): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <ul>
                <li><?php echo e($error); ?></li>
            </ul>
        </div>       
    <?php endforeach; ?>
<?php endif; ?>
<!-- Form -->
<?php if($create == 'create'): ?>
    <?php echo Form::model($form,['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'POST','enctype' =>'multipart/form-data','route'=>$route]); ?>

 <?php elseif(strpos(Request::route()->getName(), '.edit') !== false): ?>
    <?php echo Form::model($EditData,['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'PUT','enctype' =>'multipart/form-data','route'=>  array(str_replace(".edit",".update",Request::route()->getName()),$EditData->id)]); ?>

<?php endif; ?>
    <div class="panel-body" id="formbody">
        <?php foreach($form->getTablColumns() as $key => $value): ?>
            <?php if($value->Comment    == 'disable'): ?>
            <?php elseif($value->Comment    == 'hidden'): ?>
                <!--  -->
                <?php echo Form::hidden($value->Field, null , ['class' => 'form-control','id' => $value->Field,'required' => 'required']); ?>

            <?php elseif($value->Comment    == 'relationship' || $value->Comment    == 'list'): ?>
                <div class="<?php echo e($value->Field); ?> col-md-4">
                    <div class="form-group">
                        <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>                              
                        <div class="check_<?php echo e($value->Field); ?>">
                            <?php if($value->Null == 'YES'): ?>
                                <?php echo Form::select($value->Field,[null =>'Please Select'] + eval('return $'. $value->Field . ';'),null,['class' => 'form-control','id' => $value->Field]); ?>

                            <?php else: ?>
                                <?php echo Form::select($value->Field,[null=>'Please Select'] + eval('return $'. $value->Field . ';'),null,['class' => 'form-control','id' => $value->Field,'required' =>'required']); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>                    
            <?php elseif($value->Comment    == 'lists'): ?>
                <div class="<?php echo e($value->Field); ?> col-md-4">
                    <div class="form-group">
                        <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>                              
                        <div class="check_<?php echo e($value->Field); ?>">
                            <?php if($value->Null == 'YES'): ?>                        
                                <select class="form-control" id="<?php echo e($value->Field); ?>" name="<?php echo e($value->Field); ?>">
                                    <option><?php echo e(old($value->Field) ? old($value->Field) : ''); ?></option>
                                    <?php foreach(eval('return $'. $value->Field . ';')as  $id => $value): ?>
                                        <option id="<?php echo e($id); ?>" value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <select class="form-control" id="<?php echo e($value->Field); ?>" name="<?php echo e($value->Field); ?>" required="required">
                                    <option><?php echo e(old($value->Field) ? old($value->Field) : ''); ?></option>
                                    <?php foreach(eval('return $'. $value->Field . ';')as  $id => $value): ?>
                                        <option id="<?php echo e($id); ?>" value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>                    
            <?php elseif($value->Comment    == 'file'): ?>
                <div class="<?php echo e($value->Field); ?> col-md-4">
                    <div class="form-group">
                        <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>
                        <div class="check_<?php echo e($value->Field); ?>">
                            <?php if($value->Null == 'YES'): ?>
                                <?php echo Form::file($value->Field , ['class' => 'form-control','id' => $value->Field]); ?>

                            <?php else: ?>
                                <?php echo Form::file($value->Field , ['class' => 'form-control','id' => $value->Field,'required' => 'required']); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>  
            <?php elseif($value->Comment    == 'email'): ?>
                <div class="<?php echo e($value->Field); ?> col-md-4">
                    <div class="form-group">
                        <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>
                        <div class="check_<?php echo e($value->Field); ?>">
                            <?php if($value->Null == 'YES'): ?>
                                <?php echo Form::email($value->Field, null , ['class' => 'form-control','id' => $value->Field,'data-error' => 'this email address is invalid']); ?>

                            <?php else: ?>
                                <?php echo Form::email($value->Field, null , ['class' => 'form-control','id' => $value->Field,'required' => 'required','data-error' => 'this email address is invalid']); ?>

                            <?php endif; ?>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div> 
            <?php elseif($value->Comment    =='password'): ?>
                <div class="<?php echo e($value->Field); ?> col-md-4">
                    <div class="form-group">
                        <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>
                        <div class="check_<?php echo e($value->Field); ?>">
                            <?php if($value->Null == 'YES'): ?>
                                <?php echo Form::password($value->Field, ['class' => 'form-control','id' => $value->Field]); ?>

                            <?php else: ?>
                                <?php echo Form::password($value->Field, ['class' => 'form-control','id' => $value->Field,'required' => 'required']); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php elseif($value->Type       == 'date'): ?>
                <div class="<?php echo e($value->Field); ?> col-md-4">
                    <div class="form-group">
                        <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?> </label>
                        <div class='check_<?php echo e($value->Field); ?> input-group' id='<?php echo e($value->Field); ?>'>
                            <?php if($value->Null == 'YES'): ?>
                                <?php echo Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field]); ?>

                            <?php else: ?>
                                <?php echo Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field,'required' => 'required']); ?>

                            <?php endif; ?>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <?php if($value->Comment != 'changejs'): ?>
                        <script type="text/javascript">$(function () {$('#<?php echo e($value->Field); ?>').datetimepicker({format: 'YYYY-MM-DD',viewMode: 'years'});});</script>
                    <?php endif; ?>
                </div>
            <?php elseif($value->Type       == 'time'): ?>
                <div class="<?php echo e($value->Field); ?> col-md-4">
                    <div class="form-group">
                        <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?> </label>
                        <div class='check_<?php echo e($value->Field); ?> input-group' id='<?php echo e($value->Field); ?>'>
                            <?php if($value->Null == 'YES'): ?>
                                <?php echo Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field]); ?>

                            <?php else: ?>
                                <?php echo Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field,'required' => 'required']); ?>

                            <?php endif; ?>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <?php if($value->Comment != 'changejs'): ?>
                        <script type="text/javascript">$(function () {$('#<?php echo e($value->Field); ?>').datetimepicker({format: 'HH:mm'});});</script>                        
                    <?php endif; ?>
                </div>
            <?php elseif($value->Type       == 'text'): ?>
                            <div class="<?php echo e($value->Field); ?> col-md-4">
                                <div class="form-group">
                                    <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>
                                    <div class="check_<?php echo e($value->Field); ?>">
                                        <?php if($value->Null == 'YES'): ?>
                                            <?php echo e(Form::textarea($value->Field, null, ['class' => 'form-control','id' => $value->Field,'size' => '30x5'])); ?>

                                        <?php else: ?>                                    
                                            <?php echo e(Form::textarea($value->Field, null, ['class' => 'form-control','id' => $value->Field,'size' => '30x5','required' =>'required'])); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div> 
            <?php elseif(strpos($value->Type, 'enum') !== false): ?>
                            <?php
                            $remove = str_replace("enum(", "",$value->Type );
                            $remove = str_replace(")", "",$remove );
                            $remove = str_replace("'", "",$remove );
                            //$array  = explode(",",$remove);
                            $array = explode(',', $remove);
                            $array = array_combine($array, $array);
                            ?>
                            <div class="<?php echo e($value->Field); ?> col-md-4">
                                <div class="form-group">
                                    <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>                              
                                    <div class="check_<?php echo e($value->Field); ?>">
                                        <?php if($value->Null == 'YES'): ?>
                                            <?php echo Form::select($value->Field,[null=>'Please Select'] + $array,null,['class' => 'form-control ','id' => $value->Field]); ?>

                                        <?php else: ?>
                                            <?php echo Form::select($value->Field,[null=>'Please Select'] + $array,null,['class' => 'form-control ','id' => $value->Field,'required' =>'required']); ?>

                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                            </div>
            <?php elseif(strpos($value->Type, 'int' ) !== false  || strpos($value->Type, 'decimal' ) !== false || strpos($value->Type, 'bigint' ) !== false): ?>
                           <div class="<?php echo e($value->Field); ?> col-md-4">
                                <div class="form-group">
                                    <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>
                                    <div class="check_<?php echo e($value->Field); ?>">
                                        <?php if($value->Null == 'YES'): ?>
                                           <?php echo Form::text($value->Field, null , ['class' => 'number form-control','id' => $value->Field]); ?>

                                        <?php else: ?>
                                            <?php echo Form::text($value->Field, null , ['class' => 'number form-control','id' => $value->Field,'required' => 'required']); ?>

                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                            </div>                                       
            <?php elseif(1==1): ?>
                            <div class="<?php echo e($value->Field); ?> col-md-4">
                                <div class="form-group">
                                    <label for="<?php echo e($value->Field); ?>" class="control-label"><?php echo e(trans('form.'.$value->Field)); ?></label>
                                    <div class="check_<?php echo e($value->Field); ?>">
                                        <?php if($value->Null == 'YES'): ?>
                                            <?php echo Form::text($value->Field, null , ['class' => 'form-control','id' => $value->Field]); ?>

                                        <?php else: ?>
                                            <?php echo Form::text($value->Field, null , ['class' => 'form-control','id' => $value->Field,'required' => 'required']); ?>

                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                            </div> 
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="NewAppend"></div>
    </div>

    <div class="container-fluid text-right" id="box-footer">
        <?php if(!empty($titel)): ?>
            <button type="submit" id="submit" class="btn btn-success">Save</button>
        <?php else: ?>
            <button type="submit" id="submit" class="btn btn-success"><?php echo e(ucfirst(substr(Request::route()->getName(), strpos(Request::route()->getName(),'.')+strlen('.')))); ?></button>
        <?php endif; ?>
    </div>
<?php echo Form::close(); ?>

