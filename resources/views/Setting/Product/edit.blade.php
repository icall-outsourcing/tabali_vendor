<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
 


@extends('layouts.app')
@section('content')
   



<form action="{{ url('/Product/'.$Product->id.'/updateall') }}" data-toggle="validator"  id='myForm' role="form" method="POST" enctype="multipart/form-data">
{{method_field('PUT')}}
    {!! csrf_field() !!}
  <div class="form-row">


  @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
  @endif



    <div class="form-group col-md-3">
      <label for="ar_name">الأسم العربي </label>
      <input type="text" class="form-control" id="ar_name" value="{{$Product->ar_name}}" name="ar_name" required placeholder="فضلا أدخل أسم المنتج">
    </div>

	<div class="form-group col-md-3">
      <label for="en_name">الأسم الأنجليزي</label>
      <input type="text" class="form-control" id="en_name" value="{{$Product->en_name}}" name="en_name" required placeholder="فضلا أدخل أسم المنتج">
    </div>


  <div class="form-group col-md-3">
      <label for="price">السعر</label>
      <input type="text" class="form-control" id="price" value="{{$Product->price}}" name="price" required placeholder="أدخل السعر">
    </div>
  </div>

  <div class="form-group col-md-3">
      <label for="description">الوصف</label>
      <input type="text" class="form-control" id="description" value="{{$Product->description}}" name="description" required placeholder="فضلا أدخل وصف المنتج">
    </div>
  </div>

    <div class="form-group col-md-3">
	   <label for="available">التفعيل</label>
     {!! Form::select('available',[null=>'من فضلك أختر'] + $available,null,['class' => 'form-control select2','value'=>'$Product->available','id' => 'available','required' =>'required'])!!}

    </div>


	<div class="form-group col-md-3">
	   <label for="item_group_name"> نوع المنتج </label>
	                <select name="item_group_name" value="{{$Product->item_group_name}}" required id="item_group_name" class="chosen-select form-control" required="required">
                                        <option selected>{{$Product->item_group_name}}</option>
                                        @foreach($item_group_name as $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach

                    </select>
    </div>



  </div>
  <div class="form-group col-md-12">
  <button type="submit" class="btn btn-success">تحديث</button>
  </div>
</form>



<script>
$('#sectionid').on('change',function(e){
  var selectedText = $("#sectionid option:selected").text();
  $('#section_name').val(selectedText);
  $('#sectiongroup').val(selectedText);
});
</script>

@endsection
