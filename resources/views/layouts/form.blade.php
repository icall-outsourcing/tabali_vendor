@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <ul>
                <li>{{ $error }}</li>
            </ul>
        </div>       
    @endforeach
@endif
<!-- Form -->
@if ($create == 'create')
    {!! Form::model($form,['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'POST','enctype' =>'multipart/form-data','route'=>$route])!!}
 @elseif(strpos(Request::route()->getName(), '.edit') !== false)
    {!! Form::model($EditData,['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'PUT','enctype' =>'multipart/form-data','route'=>  array(str_replace(".edit",".update",Request::route()->getName()),$EditData->id)])!!}
@endif
    <div class="panel-body" id="formbody">
        @foreach($form->getTablColumns() as $key => $value)
            @if     ($value->Comment    == 'disable')
            @elseif ($value->Comment    == 'hidden')
                <!--  -->
                {!! Form::hidden($value->Field, null , ['class' => 'form-control','id' => $value->Field,'required' => 'required']) !!}
            @elseif ($value->Comment    == 'relationship' || $value->Comment    == 'list')
                <div class="{{$value->Field}} col-md-4">
                    <div class="form-group">
                        <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>                              
                        <div class="check_{{$value->Field}}">
                            @if($value->Null == 'YES')
                                {!! Form::select($value->Field,[null =>'Please Select'] + eval('return $'. $value->Field . ';'),null,['class' => 'form-control','id' => $value->Field])!!}
                            @else
                                {!! Form::select($value->Field,[null=>'Please Select'] + eval('return $'. $value->Field . ';'),null,['class' => 'form-control','id' => $value->Field,'required' =>'required'])!!}
                            @endif
                        </div>
                    </div>
                </div>                    
            @elseif ($value->Comment    == 'lists')
                <div class="{{$value->Field}} col-md-4">
                    <div class="form-group">
                        <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>                              
                        <div class="check_{{$value->Field}}">
                            @if($value->Null == 'YES')                        
                                <select class="form-control" id="{{$value->Field}}" name="{{$value->Field}}">
                                    <option>{{old($value->Field) ? old($value->Field) : '' }}</option>
                                    @foreach (eval('return $'. $value->Field . ';')as  $id => $value)
                                        <option id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control" id="{{$value->Field}}" name="{{$value->Field}}" required="required">
                                    <option>{{old($value->Field) ? old($value->Field) : '' }}</option>
                                    @foreach (eval('return $'. $value->Field . ';')as  $id => $value)
                                        <option id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>                    
            @elseif ($value->Comment    == 'file')
                <div class="{{$value->Field}} col-md-4">
                    <div class="form-group">
                        <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>
                        <div class="check_{{$value->Field}}">
                            @if($value->Null == 'YES')
                                {!! Form::file($value->Field , ['class' => 'form-control','id' => $value->Field]) !!}
                            @else
                                {!! Form::file($value->Field , ['class' => 'form-control','id' => $value->Field,'required' => 'required']) !!}
                            @endif
                        </div>
                    </div>
                </div>  
            @elseif ($value->Comment    == 'email')
                <div class="{{$value->Field}} col-md-4">
                    <div class="form-group">
                        <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>
                        <div class="check_{{$value->Field}}">
                            @if($value->Null == 'YES')
                                {!! Form::email($value->Field, null , ['class' => 'form-control','id' => $value->Field,'data-error' => 'this email address is invalid']) !!}
                            @else
                                {!! Form::email($value->Field, null , ['class' => 'form-control','id' => $value->Field,'required' => 'required','data-error' => 'this email address is invalid']) !!}
                            @endif
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div> 
            @elseif ($value->Comment    =='password')
                <div class="{{$value->Field}} col-md-4">
                    <div class="form-group">
                        <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>
                        <div class="check_{{$value->Field}}">
                            @if($value->Null == 'YES')
                                {!! Form::password($value->Field, ['class' => 'form-control','id' => $value->Field]) !!}
                            @else
                                {!! Form::password($value->Field, ['class' => 'form-control','id' => $value->Field,'required' => 'required']) !!}
                            @endif
                        </div>
                    </div>
                </div>
            @elseif ($value->Type       == 'date')
                <div class="{{$value->Field}} col-md-4">
                    <div class="form-group">
                        <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }} </label>
                        <div class='check_{{$value->Field}} input-group' id='{{$value->Field}}'>
                            @if($value->Null == 'YES')
                                {!! Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field]) !!}
                            @else
                                {!! Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field,'required' => 'required']) !!}
                            @endif
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    @if($value->Comment != 'changejs')
                        <script type="text/javascript">$(function () {$('#{{$value->Field}}').datetimepicker({format: 'YYYY-MM-DD',viewMode: 'years'});});</script>
                    @endif
                </div>
            @elseif ($value->Type       == 'time')
                <div class="{{$value->Field}} col-md-4">
                    <div class="form-group">
                        <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }} </label>
                        <div class='check_{{$value->Field}} input-group' id='{{$value->Field}}'>
                            @if($value->Null == 'YES')
                                {!! Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field]) !!}
                            @else
                                {!! Form::text($value->Field, null , ['class' => 'form-control','id' => 'date-'.$value->Field,'required' => 'required']) !!}
                            @endif
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    @if($value->Comment != 'changejs')
                        <script type="text/javascript">$(function () {$('#{{$value->Field}}').datetimepicker({format: 'HH:mm'});});</script>                        
                    @endif
                </div>
            @elseif ($value->Type       == 'text')
                            <div class="{{$value->Field}} col-md-4">
                                <div class="form-group">
                                    <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>
                                    <div class="check_{{$value->Field}}">
                                        @if($value->Null == 'YES')
                                            {{ Form::textarea($value->Field, null, ['class' => 'form-control','id' => $value->Field,'size' => '30x5']) }}
                                        @else                                    
                                            {{ Form::textarea($value->Field, null, ['class' => 'form-control','id' => $value->Field,'size' => '30x5','required' =>'required']) }}
                                        @endif
                                    </div>
                                </div>
                            </div> 
            @elseif (strpos($value->Type, 'enum') !== false)
                            <?php
                            $remove = str_replace("enum(", "",$value->Type );
                            $remove = str_replace(")", "",$remove );
                            $remove = str_replace("'", "",$remove );
                            //$array  = explode(",",$remove);
                            $array = explode(',', $remove);
                            $array = array_combine($array, $array);
                            ?>
                            <div class="{{$value->Field}} col-md-4">
                                <div class="form-group">
                                    <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>                              
                                    <div class="check_{{$value->Field}}">
                                        @if($value->Null == 'YES')
                                            {!! Form::select($value->Field,[null=>'Please Select'] + $array,null,['class' => 'form-control ','id' => $value->Field])!!}
                                        @else
                                            {!! Form::select($value->Field,[null=>'Please Select'] + $array,null,['class' => 'form-control ','id' => $value->Field,'required' =>'required'])!!}
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
            @elseif (strpos($value->Type, 'int' ) !== false  || strpos($value->Type, 'decimal' ) !== false || strpos($value->Type, 'bigint' ) !== false)
                           <div class="{{$value->Field}} col-md-4">
                                <div class="form-group">
                                    <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>
                                    <div class="check_{{$value->Field}}">
                                        @if($value->Null == 'YES')
                                           {!! Form::text($value->Field, null , ['class' => 'number form-control','id' => $value->Field]) !!}
                                        @else
                                            {!! Form::text($value->Field, null , ['class' => 'number form-control','id' => $value->Field,'required' => 'required']) !!}
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>                                       
            @elseif (1==1)
                            <div class="{{$value->Field}} col-md-4">
                                <div class="form-group">
                                    <label for="{{$value->Field}}" class="control-label">{{ trans('form.'.$value->Field) }}</label>
                                    <div class="check_{{$value->Field}}">
                                        @if($value->Null == 'YES')
                                            {!! Form::text($value->Field, null , ['class' => 'form-control','id' => $value->Field]) !!}
                                        @else
                                            {!! Form::text($value->Field, null , ['class' => 'form-control','id' => $value->Field,'required' => 'required']) !!}
                                        @endif
                                        
                                    </div>
                                </div>
                            </div> 
            @endif
        @endforeach
        <div class="NewAppend"></div>
    </div>

    <div class="container-fluid text-right" id="box-footer">
        @if(!empty($titel))
            <button type="submit" id="submit" class="btn btn-success">Save</button>
        @else
            <button type="submit" id="submit" class="btn btn-success">{{ucfirst(substr(Request::route()->getName(), strpos(Request::route()->getName(),'.')+strlen('.')))}}</button>
        @endif
    </div>
{!! Form::close()!!}
