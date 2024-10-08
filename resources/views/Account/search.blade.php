<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
@extends('layouts.app')
@section('content')
  <style type="text/css">
      .ttt{
        display: none;
      }
      #Typeahead-button{
        /*width: 35px  !important;*/
        height: 34px !important;
        margin-top: -5px;
        z-index: 2;
      }
      .Typeahead-hint,
      .Typeahead-input {
        width: 137% !important;
        padding: 5px 8px;
        line-height: 30px;
      }
      .tt-dataset{
          overflow:auto;
          overflow: scroll; 
          overflow-x:hidden;
          border: 1px solid #024e6a !important;
          width: 302% !important;          
          /*height: */
          min-height: 45px !important; 
          max-height:200px !important;
         /*
           width:100px; 
           height:45px; 
           max-height:200px; 

          */
      }
      .tt-dataset a{ 
        color: black !important
      }
      .items{
          overflow:auto;
          overflow: scroll; 
          overflow-x:hidden;
          width: 98%;
          min-height: 45px !important; 
          max-height:350px !important;
      }
  </style>
  @php 
  $Accountss = \App\Account::where('phone_number',$phone_number)->first();
  @endphp
    @if(session()->has('CallerID'))
    {{session()->get('CallerID')}}
    @endif
  @if (count($find) > 0)
    <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header"><i class="fa fa-user"></i> {{ucwords(strtolower($find->contact->contact_name))}}<small class="pull-right">Member since:  {{date('F, Y',strtotime($find->contact->created_at))}}</small></h2>
        </div>
      </div>
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>#: </strong>{{$find->contact->id}}<br>
            <strong>Phone: </strong>{{$phone_number}}<br>
            <strong>Email: </strong>{{$find->contact->email}}<br>
          </address>
        </div>
        <div class="col-sm-4 invoice-col">
          <strong>Other Phone: </strong><br>
          @foreach($find->contact->phones as $phone)
            {{$phone->phone}}<br>
          @endforeach
        </div>
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Comment</strong><br>
            {{$find->contact->contact_comment}}
          </address>
        </div>
      </div>
      <hr/>
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Account</th>
                <th>Type</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($find->contact->accounts as $account)
                <tr style="cursor:pointer">
                  <div class="tr clickable-row" data-id="{{URL::route('Account.show',   $account->id)}}" data-href="{{URL::route('Account.show',   $account->id)}}"">
                    <td>{{$account->id}}</td>
                    <td>{{$account->account_name}}</td>
                    <td>{{$account->account_type}}</td>
                    <td>{{$account->phone_number}}</td>
                    <td class="col-md-5">
                      <i class="ttt">
                      {{$account->governorate}}, 
                      {{$account->district}}, 
                      {{$account->area}}, 
                      {{$account->address}}
                      </i>
                    </td>
                    <td title="Address">
                      <span class="togglesubtr label label-success">
                        <i class=" fa fa-chevron-up"></i>
                      </span> 
                    </td>
                  </div>
                  <td>

                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <hr/>
    </section>
  @else
    <div class="row">
      <div class="col-md-8 col-md-push-2">
        <section class="wow bounceInDown" data-wow-duration="2s" data-wow-delay="0">
          <div class="callout callout-success">
          <div class="row">
            <div class="col-md-4 ">There's no Contact For <b>{{$phone_number}}</div>
            <div class="col-md-6">
              <div id="remote" class="input-group">
                <input class="form-control Typeahead-input" id="Typeahead-input" type="text" name="q" placeholder="Search" autocomplete="off" spellcheck="false" dir="tlr">
                <span class="input-group-btn">
                    <button class="btn btn-default" id="Typeahead-button" type="button">
                    Add To Account
                    </button>
                </span>
              </div>
            </div>
            <div class="col-md-2"><a href="{{route('Account.create',['phone' => $phone_number])}}" class="btn btn-info">Create Account</a></div>
          </div>

          </div>
        </section>
      </div>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function($) {     
          // Set the Options for "Bloodhound" suggestion engine
           var engine = new Bloodhound({
              remote: {
                  url     :"{{url('Account?q=%QUERY%')}}",
                  wildcard: '%QUERY%'
              },
              datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
              queryTokenizer: Bloodhound.tokenizers.whitespace
          });
          $(".Typeahead-input").typeahead('open');
          $(".Typeahead-input").typeahead('destroy');
          $('.Typeahead-input').typeahead(null, {
              highlight: true,
              minLength: 3,
              name: 'account_name',
              limit: 100,
              display: 'account_name',
              source: engine,
              templates: {
                  empty: function(data){
                      return '<a href="#" class="list-group-item">Nothing found.</a>';
                  },
                  suggestion: function (data) {
                      return '<a href="#" id="'+data.id+'" class="list-group-item addtypeahead">' +data.account_name+'</a>';
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
    </script>
  @endif
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".togglesubtr").click(function(){
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
        $(this).parent().parent().find('.ttt').toggle();
      });
      $(".clickable-row").click(function() {
          window.document.location = $(this).data("href");
      });
    });
  </script>






































































@endsection