<style>
button#submit {
    margin: -11px 20px 62px 0;
}
</style>
<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  <!-- @php $branch_id  = \App\Branch::all()->lists('name','id')->toArray(); @endphp -->
@extends('layouts.app')
@inject('sections'    , '\App\Product')
@php    
	$sections     = $sections->whereNotNull('sectionid')->withTrashed()->orderBy('sectionid')->groupBy('sectionid')->get(); 
@endphp


@section('content')
    @include('layouts.form')
    <div class="Append col-md-12">
      <div class="panel panel-default clearfix">        



        <table class="table table-hover table-striped table-bordered">                    
          <thead>
            <tr>            
              <th scope="col">Section Name</th>
              <th scope="col">check</th>            
            </tr>
          </thead>
          <tbody>    
            @foreach($sections as $section)
            <tr>
              <th scope="row">{{$section->sectiongroup}}</th>              
              @if(array_search($section->sectionid, array_column($EditData->Dbsections(), 'sectionid')) !== false)
              <td><input type="checkbox" name="sections[]" value="{{$section->sectionid}}" checked></td>
              @else 
              <td><input type="checkbox" name="sections[]" value="{{$section->sectionid}}"></td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>



      </div>
    </div>
	<script type="text/javascript">$('.NewAppend').append($('.Append'));</script>
@endsection
