<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
@extends('layouts.app')
@section('content')
    @include('layouts.form')
@endsection
