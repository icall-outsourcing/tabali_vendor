<!-- language -->
    @if(session()->has('lang'))
        {{App::setLocale(session()->get('lang'))}}
    @else
        {{App::setLocale('ar')}}
    @endif

@extends('layouts.blank')
@php 
  $contactbranch_id = \App\Branch::all()->lists('name','id')->toArray(); 
  if (Input::get('phone') > 0){
    $phone_number = Input::get('phone');
  }else{
    $phone_number = 0;
  }
@endphp
@section('content')
  <style type="text/css">.insertcontactphone, .insertaddress{overflow  : auto;overflow-y: auto;overflow-x: hidden;max-height: 100px !important;}</style>
  {!! Form::model($form,['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'POST','enctype' =>'multipart/form-data','route'=> $route ])!!}
      <div class="container-fluid">
        <div class="row">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Contact</h3>
              <div class="box-tools"><a title="Add Phone" id="AddcontactPhone" class="btn btn-success btn-sm"><i class="fa fa-phone"></i></a></div>
            </div>
              <div class="box-body">
                 @include('layouts.form')
            <div id="contactphone" class="col-md-4">
              <div class="form-group">
                <label for="Phone" class="control-label">Phones</label>
                <input name="contactphone[]" id="contactphone-0" value="{{ old('contactphone.0') }}" type="text" class="number form-control" required="required">
                @if($errors->has('contactphone.0'))
                    <span class="help-block">{{$errors->first('contactphone.0')}}</span>
                  @endif
              </div>
              <div class="insertcontactphone">
                @for ($x = 1; $x < count(old('contactphone')); $x++)
                  <div class="form-group">
                    <div class="input-group">
                      <input name="contactphone[]" id="contactphone-{{$x}}" value="{{ old('contactphone.'.$x) }}" type="text" class="number input-sm form-control" required="required">
                        <a class="btn btn-danger input-group-addon" onclick="$(this).parent().parent().remove();"><i class="fa fa-bitbucket"></i></a>
                    </div>
                      @if($errors->has('contactphone.'.$x))
                        <span class="help-block text-info">{{$errors->first('contactphone.'.$x)}}</span>
                      @endif
                  </div>
                @endfor
              </div>
            </div>
              </div>
          </div>
        </div>
      </div>      
      <input class="Append" type="hidden" name="account_id" value="{{Input::get('account')}}">
  {!! Form::close()!!}
    <script type="text/javascript">
      $('.NewAppend').append($('.Append')); 
      $('#contactphone-0').val('{{old("contactphone.0") ? old("contactphone.0") : $phone_number }}');

      $('#contactphone').insertAfter('.contact_comment');
      var contactphone    = $('.insertcontactphone input').size() + {{count(old('contactphone'))}} + 1;
      $('#AddcontactPhone').on('click', function() {$('.insertcontactphone').prepend('<div class="form-group"><div class="input-group"><input name="contactphone[]" id="contactphone-'+ contactphone +'" type="text" class="number form-control" required="required"><a class="btn btn-danger input-group-addon" onclick="$(this).parent().parent().remove();"><i class="fa fa-bitbucket"></i></a></div></div>');
          contactphone++;
          return false;
      });
        
      $('#myForm button[type=submit]').click(function(e){
        e.preventDefault();
        var form = jQuery(this).parents("form:first");
        var dataString = form.serialize();
        var formAction = form.attr('action');
        $.ajax({
            type: "POST",
            url : formAction,
            data : dataString,
            success : function(data){
              var result = data['0'].map(function(a) {return a.phone;});
              $('.ContactsDiv').prepend('<li id="contact_'+data['1']['id']+'" class="list-group-item"><strong><i class="fa fa-user margin-r-5"></i>'+data['1']['contact_name']+'</strong><a class="pull-right">'+result+'<br/> </a> <br/></li>');
              $("#alarm").attr("id", "alarmdone");
              $("#alarmdone").attr("class","AddContact btn btn-success");
              $("#chnagetext").attr("class","box-title");
              $("#chnagetext").html("#"+data['1']['id']+" Contact Name: "+data['1']['contact_name']);
              var reda =  data['1']['id'];
              var  contact_id= "{{Session::put('contact_id','"+reda+"')}}";
              $("#changedangerdiv").attr("class","box-body");
              $('.jconfirm').remove();
              
            },
            error : function(data){
              alert('error');
            }
          },"json");
      });
    </script>

@endsection



