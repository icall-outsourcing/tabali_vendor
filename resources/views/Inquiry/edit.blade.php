<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
@php $branch_id  = \App\Branch::all()->lists('name','id')->toArray(); @endphp
  
@extends('layouts.app')
@section('content')
    @include('layouts.form')
    <div class="well Append col-md-4">
        
    <div class="  status col-md-12">
        <div class="form-group">
            @php $status = array ('opened'=>'opened','processing'=>'processing','closed'=>'closed');@endphp
            <label for="status" class="control-label"> حالة الشكوى </label>
            {!! Form::select('status',$status,$EditData->status,['class' => 'form-control','id' => 'status'])!!}
        </div>
    </div>
    <div class="  close_inquiry_comment col-md-12">
        <div class="form-group">
            <label for="close_inquiry_comment" class="control-label"> حل الشكوى  </label>
            <div class="check_close_inquiry_comment">
                <textarea class="form-control" id="close_inquiry_comment" name="close_inquiry_comment" cols="30" rows="5">{{$EditData->close_inquiry_comment}}</textarea>
                </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $('.NewAppend').append($('.Append'));
    </script>
@endsection
