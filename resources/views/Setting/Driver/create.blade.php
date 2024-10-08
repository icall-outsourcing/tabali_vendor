<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif

  @php $branch_id  = \App\Branch::whereIn('id',array_values(Auth::user()->PermissionsList))->lists('name','id')->toArray(); @endphp
@extends('layouts.app')
@section('content')
    @include('layouts.form')
@endsection
