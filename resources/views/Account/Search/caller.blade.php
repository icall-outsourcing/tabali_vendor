@extends('layouts.app')
@section('content')
  <section class="invoice">
    <!-- Contact Details -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header"><i class="fa fa-user"></i> # {{$contactID = $findcaller->contact->id}} {{$findcaller->contact->contact_name}}<small class="pull-right">Member since:  {{date('F, Y',strtotime($findcaller->contact->created_at))}}</small></h2>
        </div>
      </div>
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Phone: </strong>{{$caller}}<br>
            <strong>Email: </strong>{{$findcaller->contact->email}}<br>
          </address>
        </div>
        <div class="col-sm-4 invoice-col">
          <strong>Other Phone: </strong><br>
          @foreach($findcaller->contact->phones as $phone)
            {{$phone->phone}}<br>
          @endforeach
        </div>
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Comment</strong><br>
            {{$findcaller->contact->contact_comment}}
          </address>
        </div>
      </div>
      <hr/>
    <!-- ./Contact Details -->
    <!-- Accounts Details -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Account</th>
                <th>Type</th>
                <th>Phone Number</th>
                <th>District</th>
                <th>Address</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php
                  if($findcaller->contact->accounts->count() == 0){
                    $account_id = DB::table('accounts')->insertGetId(['account_name' => $findcaller->contact->contact_name]);
                    $account_contact = DB::table('account_contact')->insert(['account_id' => $account_id,'contact_id'=>$findcaller->contact->id]);
                    header("Refresh:0");
                  }
                ?>


              @foreach($findcaller->contact->accounts as $account)
              <i>
                <tr style="cursor:pointer" data-id="#" data-href="#">
                  <td class="clickable-row">{{$account->id}}</td>
                  <td class="clickable-row">{{$account->account_name}}</td>
                  <td class="clickable-row"></td>
                  <td class="clickable-row"  colspan="3">{{$account->phone_number}}</td>
                  <td title="Address">
                    @if(count($account->addresses) > 0)
                      <span id="{{$account->id}}" class="togglesubtr label label-success">more Address for this account <i class=" fa fa-chevron-down"></i></span>
                    @endif
                      <span id="add-address" data-account="{{$account->account_name}}" data-route="{{URL::route('Address.create','')}}id={{$account->id}}" class="togglesubtr label label-info">Add Address</span>
                  </td>
                </tr>
                 @php $count= 1 @endphp 
                @foreach($account->addresses as $address)
                  @if(empty($address->area_id))
                    <tr class="{{$account->id}}" style="cursor:pointer;background-color: rgba(221, 57, 57);color: #fff">
                  @else 
                    <tr class="account-address-{{$account->id}}" style="cursor:pointer;background-color: rgba(180, 180, 180, 0.35)" data-id="{{URL::route('Account.show',['id' => $account->id ,'contact' => $contactID] )}}" data-href="{{URL::route('Account.show',['id' => $account->id ,'contact' => $contactID,'branch'=>$address->branch_id,'address'=>$address->id] )}}">
                  @endif
                    <td class="clickable-row" colspan="2"><span class="label label-success">{{$count++}}</span></td>
                    <td class="clickable-row" colspan="2">{{$address->address_type}}</td>
                    <td class="clickable-row">{{$address->district}}</td>
                    <td  class="clickable-row col-md-5">{{$address->address}} Building: {{$address->building_number}} Floor: {{$address->floor}} Apartment: {{$address->apartment}}</td>
                    <td>
                      
                        <span id="edit-address" data-route="{{URL::route('Address.edit',$address->id)}}" class="togglesubtr label label-warning">complete this address </span>
                      
                    </td>
                  </tr>
                @endforeach
              </i>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <hr/>
    <!-- Accounts Details -->
  </section>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".togglesubtr").click(function(){
        var id = $(this)[0].getAttribute('id');
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
        $('.account-address-'+id).toggle();
      });
      $(".clickable-row").click(function() {
          window.document.location = $(this).parent().data("href");
      });
    });
  </script>
  <script type="text/javascript">
     $(document).on('click','#add-address',function(e){ 
        e.preventDefault();
        var route   = $(this).data('route');
        var account   = $(this).data('account');
        $.confirm({
          title           : 'Add Address for : ' + account,
          columnClass     : 'col-md-10 col-md-push-1',
          closeIcon       :  true,
          content         : 'url:'+route,
          animation     : 'top',
          closeAnimation: 'bottom',
          animation       : 'zoom',
          cancelButton: false, // hides the cancel button.
          confirmButton: false, // hides the confirm button.
        });
      });
  </script>
  <script type="text/javascript">
    $(document).on('click','#edit-address',function(e){ 
      e.preventDefault();
      var route   = $(this).data('route');

      // alert(route);
      // return false;
      
      $.confirm({
        title           : 'Edit Address for :',
        columnClass     : 'col-md-10 col-md-push-1',
        closeIcon       :  true,
        content         : 'url:'+route,
        animation     : 'top',
        closeAnimation: 'bottom',
        animation       : 'zoom',
        cancelButton: false, // hides the cancel button.
        confirmButton: false, // hides the confirm button.
      });
    });
  </script>
@endsection