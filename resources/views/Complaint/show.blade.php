<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
 <div class="row">
     <div class="col-xs-12">
   <h2 class="page-header">
    <i class="fa fa-barcode"></i> Complaint No # {{$ShowData->id}}
    <small class="pull-right">Date: {{$ShowData->created_at}}</small>
   </h2>
     </div>
   </div>
 <div class="row">
  <div class="col-sm-12  text-right">
   <style type="text/css">
    table.products td {
      text-align: right;
    }
   </style>
   
    <table class="table table-striped" width="100%">
        <tr>
            <td >{{$ShowData->branch->name}}</td>
            <td ><strong> الفرع  </strong></td>
            <td > {{$ShowData->follow_up_phone}}</td>
            <td ><strong>ﺭﻗﻢ اﻟﺘﻠﻴﻔﻮﻥ</strong></td>
            <td > {{$ShowData->contact->contact_name}}</td>
            <td ><strong>  اسم العميل </strong></td>
        </tr>
        <tr>
            <td >{{$ShowData->status}} </td>
            <td ><strong> الحاله  </strong></td>
            <td > {{$ShowData->Priority}} </td>
            <td ><strong> درجه الاهميه </strong></td>
            <td >{{$ShowData->complaint_type}} </td>
            <td ><strong> نوع الشكوى </strong></td>
            
        </tr>
        <tr>
            <td colspan="2" class="bg-success" >{{$ShowData->close_complain_comment}} </td>
            
            <td class="bg-success" ><strong> حل الشكوى  </strong></td>
            
            
            <td colspan="2"  class="bg-danger">{{$ShowData->complain_comment}} </td>
            <td class="bg-danger" ><strong> وصف الشكوى  </strong></td>
            
        </tr>
    </table>
   
       
    @if($ShowData->order_id)
   <div class="page-footer">
        <center>
            <small class="text-center">
             لقد تم انشاء هذه الشكوى على الطلب رقم #{{$ShowData->order_id}}
             <br/>
            <a href="#" id="showorder" data-route="{{url(route('Order.show',$ShowData->order_id))}}" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
        </small>
        </center>
            
        
   </div>
    @endif   
   
   
   
   
   
  </div>
 </div>
 