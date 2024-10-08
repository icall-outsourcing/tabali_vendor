<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  @php
        $branch_id  = \App\Branch::all()->lists('name','id')->toArray();
        $discount_id  = \App\Discount::all()->lists('company_name','id')->toArray();
        $governorate= array();
        $district   = array();
        $subdistrict= array();
        $area       = array();
        $getArea    = \App\Area::getArea($EditData->area_id)->first();
  @endphp
  

  <script src="{{asset('packages/jquery/jquery.min.js')}}" crossorigin="anonymous"></script>
  <script src="{{asset('packages/validate/jquery.validate.js')}}"></script>
  <script src="{{asset('packages/confirm/jquery-confirm.min.js')}}"></script>
  <script src="{{asset('packages/typeahead/typeahead.bundle.min.js')}}"></script>
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
  <div id="validateerror"></div>
  <div class="box-body" style="display: block;">
    @include('layouts.form')
    <div class="remotearea form-group col-md-8">
      <label>{{trans('form.area')}}</label>
      <div id="remote" class="input-group">
          <input class="form-control Typeahead-input"  id="Typeahead-input" type="text" name="area" placeholder="@if(!empty($getArea->name))  {{$getArea->name}} @endif" autocomplete="off" spellcheck="false" dir="rtl" >
          <span class="input-group-btn" style="    top: -2px;">
              <button class="btn btn-success" id="Typeahead-button" type="button">
              <i id="Typeahead-hidden" class="fa fa-refresh fa-spin"  aria-hidden="true" style="display: none;"></i>
              <i id="Typeahead-show"   class="fa fa-search"          aria-hidden="true"></i> 
              </button>
          </span>
      </div>
    </div>
    <input class="Append" type="hidden" id="area_id" name="area_id" value="">
  </div>

<script type="text/javascript">
    $('.NewAppend').append($('.Append'));
    $('.remotearea').insertAfter($('.address_type'));
    $(".governorate").remove();
    $(".district").remove();
    $(".area").remove();
    $(".subdistrict").remove();
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
            hint: false,highlight: true,minLength: 3,name:'Items',limit: 70,display: 'name',source: engine,
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
              if(data == 'success'){
               $('.jconfirm').remove();
               location.reload();
              }else{
                for (var key in data) {
                      // skip loop if the property is from prototype
                      if (!data.hasOwnProperty(key)) continue;

                      var obj = data[key];
                      $( "#validateerror" ).html("");
                      for (var prop in obj) {
                          // skip loop if the property is from prototype
                          if(!obj.hasOwnProperty(prop)) continue;

                          // your code
                          $("#validateerror" ).addClass( "alert alert-danger" );
                          $('#validateerror').append('<center>'+obj[prop]+'</center><br/>');                          
                      }
                }
              }
            },
            error : function(data){
              $( "#validateerror" ).html("");
               var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, val) {
                       $("#validateerror" ).addClass( "alert alert-danger" );
                        $('#validateerror').append('<center>'+val[0]+'</center><br/>');
                    });
            }
      	},"json");
  	});
    
</script>
