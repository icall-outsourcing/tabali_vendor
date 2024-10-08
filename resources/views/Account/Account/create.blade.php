<!-- language -->
    @if(session()->has('lang'))
        {{App::setLocale(session()->get('lang'))}}
    @else
        {{App::setLocale('ar')}}
    @endif
@extends('layouts.app')
    @php
        $branch_id  = \App\Branch::all()->lists('name','id')->toArray();
        $governorate= \App\Governorate::all()->lists('name','id')->toArray();
        $district   = array();
        $subdistrict= array();
        $area       = array();
        if (Input::get('ani') > 0){
            $caller = 'ani';
            $phone_number = Input::get('ani');
            $required = 'true';
        }elseif (Input::get('add') > 0){
            $caller = 'addaccount';
            $phone_number = '';
            $required = 'false';
        }elseif (Input::get('search') > 0)
        {
            $caller = 'search';
            $phone_number = Input::get('search');
            $required = 'true';
        }else{
            $caller = 0;
            $phone_number = '';
            $required = 'true';
        }
    @endphp
@section('content')
<style type="text/css">
  .twitter-typeahead{
    width: 100% !important;
  }
  .tt-menu{
    width: 100% !important;
  }
  .remotearea .tt-menu {
   max-height: 150px;
   overflow-y: auto;
   border-left: 1px solid;
   border-right: 1px solid;
   border-bottom: 1px solid;
 }
</style>
    <div class="container-fluid">
    	<div class="row">
			<div class="col-md-8 col-md-push-2">
				<div class="box box-Success">
			        <div class="box-header with-border"><h3 class="box-title text-green">{{trans('form.account')}}</h3></div>
			        <div class="box-body" style="display: block;">
			          	@include('layouts.form')
                        <div class="remotearea form-group col-md-4">
                            <label>{{trans('form.area')}}</label>
                            <div id="remote" class="input-group">
                                <input class="form-control Typeahead-input"  id="Typeahead-input" type="text" name="area" placeholder="Search" autocomplete="off" spellcheck="false" dir="rtl" required="required">
                                <span class="input-group-btn" style="    top: -2px;">
                                    <button class="btn btn-success" id="Typeahead-button" type="button">
                                    <i id="Typeahead-hidden" class="fa fa-refresh fa-spin"  aria-hidden="true" style="display: none;"></i>
                                    <i id="Typeahead-show"   class="fa fa-search"          aria-hidden="true"></i> 
                                    </button>
                                </span>
                            </div>
                          </div>
			          	<input class="Append" type="hidden" id="caller"  name="caller" value="">
                        <input class="Append" type="hidden" id="area_id" name="area_id" value="">
			        </div>
			  	</div>
			</div>
      	</div>      
    </div>
    <script type="text/javascript">
        document.getElementById("phone_number").required="{{$required}}";
        $('.NewAppend').append($('.Append'));
        $('.remotearea').insertAfter($('.account_type'));
        $(".governorate").remove();
        $(".district").remove();
        $(".area").remove();
        $(".subdistrict").remove();
        
            /*
        $("#governorate").attr('onchange','relationlist("governorate","Governorate","districts","district")');
        $("#district").attr('onchange','relationlist("district","District","subdistricts","subdistrict")');
        $("#subdistrict").attr('onchange','relationlist("subdistrict","Subdistrict","areas","area")');
        $("#area").attr('onchange','Ajaxrow("area","Area","branch_id","branch_id")');
*/


        $('#caller').val('{{old("caller") ? old("caller") : $caller }}');
        $('#phone_number').val('{{old("phone_number") ? old("phone_number") : $phone_number }}');
    </script>
<script type="text/javascript">
    // Search For All
    jQuery(document).ready(function($) {     
        // Set the Options for "Bloodhound" suggestion engine
         var engine = new Bloodhound({
            remote: {
                url     :"{{url('Address/find/%QUERY%')}}",
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('area'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        $(".Typeahead-input").typeahead('open');
        $(".Typeahead-input").typeahead('destroy');
        $('.Typeahead-input').typeahead(null, {
            hint: false,highlight: true,minLength: 3,name:'Items',limit: 100,display: 'name',source: engine,
            templates: {
                empty: function(data){
                    return '<a href="#" class="list-group-item">Nothing found.</a>';
                },
                suggestion: function (data) {
                  return '<a href="#"  id="'+data.id+'"  data-branch="'+data.branch_id+'"  title="'+data.fees+'" class="list-group-item addArea">'+ data.name +'</a>';                    
                }
            }
        })
        .on('typeahead:asyncrequest', function() {
            $('#Typeahead-show').hide();
            $('#Typeahead-hidden').show();
        })
        .on('typeahead:asynccancel typeahead:asyncreceive', function() {
            $('#Typeahead-hidden').hide();
            $('#Typeahead-show').show();
        });
    });
    //Select brnach and area_id
    $(document).on('click','.addArea',function(e){ 
        e.preventDefault();
        var name      = $(this).text();
        var id        = $(this).attr('id');
        var fees      = $(this).attr('title');
        var branch_id = $(this).data('branch');
        $('#area_id').val(id);
        $('#branch_id option[value='+branch_id+']').attr('selected','selected');
        
    }); 
</script>
@endsection