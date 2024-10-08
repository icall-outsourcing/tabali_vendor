<!-- language -->
    @if(session()->has('lang'))
        {{App::setLocale(session()->get('lang'))}}
    @else
        {{App::setLocale('ar')}}
    @endif
@extends('layouts.app')
@php 
	use Carbon\Carbon;
	$checkcontact = array();
        $transferTo   = Auth::User()->getPermissions()->lists('name','id')->toArray();  
@endphp
@if($account)
	@section('content')
	    <section class="content">
			<div class="row">
				<div class="col-md-12">
		          	<!-- Accounts -->
		          	<div class="col-md-6">
		          		<div class="box box-success">
		          		 	<div class="box-header with-border">
          		 				<div class="col-md-3">#{{$account->id}}</div>
	          		 			<div class="col-md-9 text-right">
          		 				<div class="row">
          		 					<div class="col-md-10">{{ucwords(strtolower($account->account_name))}}</div>
          		 					<div class="col-md-2"><strong>: {{trans('form.account_name')}}</strong> </div>
          		 					</div>
	          		 			</div>
				            </div>
			            	<div class="box-body">
		          		 		<div class="col-md-7">
			            			<div class="col-md-9 text-right">{{$account->building_number}} ,{{$account->address}}</div>
			            			<div class="col-md-3 text-left"><strong> : {{trans('form.address')}}</strong></div>
			            		
								    <div class="col-md-9 text-right">{{$account->apartment}}</div>
			            			<div class="col-md-3 text-left"><strong> : {{trans('form.apartment')}}</strong></div>

			            			<div class="col-md-9 text-right">{{$account->landmark}}</div>
			            			<div class="col-md-3 text-left"><strong> : {{trans('form.landmark')}}</strong></div>

			            			<div class="col-md-9 text-right">{{$account->floor}}</div>
			            			<div class="col-md-3 text-left"><strong> : {{trans('form.floor')}}</strong></div>
				            	</div>
				            	<div class="col-md-5">
			            			<div class="col-md-6	 text-right">{{$account->account_type}}</div>
			            			<div class="col-md-6 text-left"><strong> : {{trans('form.account_type')}}</strong></div>
			            		
								    <div class="col-md-6 text-right">{{$account->phone_number}}</div>
			            			<div class="col-md-6 text-left"><strong> : {{trans('form.phone_number')}}</strong></div>

			            			<div class="col-md-6 text-right">{{$account->account_comment}}</div>
			            			<div class="col-md-6 text-left"><strong> : {{trans('form.comment')}}</strong></div>
				            	</div>
			            		<div class="col-md-2 col-md-push-2">
			            				<a href="{{URL::route('Account.edit',array($account->id,'contact' => $contact->id))}}" type="button" class="btn btn-block btn-success btn-sm">Edit</a>
				            	</div>
			            	</div>
		          		</div>
		          	</div>
		          	<!-- Accounts -->
			        <div class="col-md-6">
						<div class="box box-success">
			            	<div class="box-header with-border">
          		 				<div class="col-md-3">#{{$contact->id}}</div>
          		 				<div class="col-md-9 text-right">
          		 					<div class="row">
	          		 					<div class="col-md-10">{{ucwords(strtolower($contact->contact_name))}}</div>
	          		 					<div class="col-md-2"><strong>: {{trans('form.contact_name')}}</strong> </div>
          		 					</div>
          		 				</div>
			            	</div>
			            	<div class="box-body">
			            		<div class="col-md-12" style="min-height: 110px;">
			            			<div class="col-md-9 text-right">{{$contact->phones()->first()->phone}}</div>
			            			<div class="col-md-2 text-left"><strong> : {{trans('form.phone_number')}}</strong></div>
			            		
								    <div class="col-md-9 text-right">{{$contact->email}}</div>
			            			<div class="col-md-3 text-left"><strong> : {{trans('form.email')}}</strong></div>

			            			<div class="col-md-9 text-right">{{$contact->contact_comment}}</div>
			            			<div class="col-md-3 text-left"><strong> : {{trans('form.comment')}}</strong></div>
			            			<div class="col-md-2 col-md-push-2">
			            				<a href="{{URL::route('Contact.edit',array($contact->id,'phone_number' => $account->phone_number))}}" type="button" class="btn btn-block btn-success btn-sm">Edit</a>
				            		</div>
			            		</div>
				            </div>
		          		</div>
			        </div>
		          	<!-- /.Contacts -->
	        	</div>
	      	</div>
		</section>


		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<!-- Related Contacts -->
					<div class="col-md-3">
			          	<!-- Related Contacts -->
		          		<div class="box box-success">
		          		 	<div class="box-header with-border">
								<h3 class="box-title">Link with Contacts</h3>
								<div class="box-tools input-group" style="width: 150px;">
	                    			<input type="search" id="ContactPhone" name="search" class="form-control input" placeholder="">
	                    			<div class="input-group-btn">
	                        			<button type="submit" class="AddContact btn btn-success" data-account="{{$account->id}}" data-token="{{ csrf_token() }}" data-route="{{url(route('Contact.link'))}}" data-route2="{{url(route('Contact.create'))}}">
	                        				<i class="fa fa-search"></i>
	                        			</button>
	                    			</div>
	                			</div>
				            </div>
			            	<div class="box-body">
				              	<ul class="list-group list-group-unbordered ContactsDiv">
				              		@foreach($account->contacts as $linkcontact)
			                			<li id="{{'contact_'.$linkcontact->id}}" class="list-group-item"><strong><i class="fa fa-user margin-r-5"></i>{{ucwords(strtolower($linkcontact->contact_name))}}</strong>
			                			    @if(Auth::user()->is('admin'))
			                				    <span style="cursor: pointer;margin: 0 10px;" data-contact="{{$linkcontact->id}}" data-link="unlink" data-account="{{$account->id}}" data-token="{{ csrf_token() }}"  data-route="{{url(route('Contact.link'))}}" class="AddContact label label-danger pull-right"><i class="fa fa-chain-broken"></i></span>
                                            @endif			                				   
			                				@foreach($linkcontact->phones as $phone)
			                					<a class="pull-right">  {{$phone->phone}} <br/> </a>
			                				@endforeach	
			                			</li>
			                		@endforeach
			                	</ul>
			            	</div>
		          		</div>
			          	<!-- /.Related Contacts -->
		        	</div>
					<!-- /.Account Details -->
	    			<!-- Account Dashboard -->
		    		<div class="col-md-9">
		      			<div class="nav-tabs-custom">
		        			<ul class="nav nav-tabs">
				              <li class="active"><a href="#Orders" data-toggle="tab">Orders</a></li>
				              <li><a href="#Complaint" data-toggle="tab">Complaint</a></li>
				              <li><a href="#Inquiry" data-toggle="tab">Inquiry</a></li>
		        			</ul>
		        			<div class="tab-content">
		          				<div class=" active tab-pane" id="Orders">
						            <!-- /.box-header -->
						            <div class="box-body">
							            <div class="row">
							            	<div class="col-md-4 ">
							            		<a href="{{URL::route('Order.create',array('account'=> $account->id,'contact' => $contact->id,'branch' => $branch->id,'address'=>$address->id))}}" type="button" class="btn btn-block btn-success btn-sm">Create a new Order</a>
							            	</div>
							            </div>
							            <hr/>
						              	<div class="table-responsive">
							                <table class="table no-margin" class="text-center">
							                  <thead>
								                  <tr>
								                    <th class="text-center">{{trans('form.id')}}</th>
								                    <th class="text-center">{{trans('form.status')}}</th>
								                    <th class="text-center" class="Time in current status">{{trans('form.time')}}</th>
								                    <th class="text-center">{{trans('form.total')}}</th>
								                    <th class="text-center">{{trans('form.created_at')}}</th>
								                    <th class="text-center">{{trans('form.updated_at')}}</th>
								                    <th class="text-center">{{trans('form.created_by')}}</th>
								                    <th class="text-center">{{trans('form.updated_by')}}</th>
								                    <th class="text-center"></th>
								                  </tr>
							                  </thead>
							                  <tbody>
                                                
    							                  	@foreach($account->orderslimit as $order)
    							                  	
    								                  <tr>
    								                    <td class="text-center">{!! @$order->id !!}</td>
    								                    
    								                    <td class="orderstatus text-center">
    								                    	@if(@$order->status == 'opened')
    								                    		<span class="label label-default">
    								                    	@elseif(@$order->status == 'viewed')
    								                    		<span class="label label-primary">
    								                    	@elseif(@$order->status == 'processing')
    									                    	<span class="label label-primary">
    								                    	@elseif(@$order->status == 'ondelivery')
    								                    		<span class="label label-warning">
    								                    	@elseif(@$order->status == 'canceled')
    									                    	<span class="label label-danger">
    								                    	@elseif(@$order->status == 'closed')
    									                    	<span class="label label-success">
    								                    	@endif
    								                    	{{@$order->status}}</span>
    								                    </td>
    								                    
    								                    <td class="text-center">
    								                    	@php
    									                    	$StartTime 	= Carbon::parse($order->updated_at);
                											  	$EndTime 	= Carbon::now();
                												$Hours 		= $StartTime->diffInHours($EndTime);
                												$Minutes 	= $StartTime->diffInMinutes($EndTime);
                												$Seconds 	= $StartTime->diffInSeconds($EndTime);
                												$Seconds =  $Seconds - $Minutes * 60;
                												$Minutes =  $Minutes - $Hours * 60;
                											@endphp
                											{{$Hours.':'.$Minutes.':'.$Seconds}}
    										            </td>
    										            
    								                    <td class="text-center">
														@php 
															$discount = ( 100 - $order->discount) / 100;
															$Afterdiscount =  number_format(($order->total *  $discount) - $order->voucher_amount,2)
														@endphp
														{{number_format((float)$Afterdiscount + $order->deliveryfees + $order->taxfees, 2, '.', '')}}														
														</td>
    								                    <td class="text-center">{{@$order->created_at}}</td>
    								                    <td class="text-center">{{@$order->updated_at}}</td>
    								                    <td class="text-center">{{@$order->created_name->name}}</td>
    								                    <td class="text-center">@if(!empty(@$order->updated_name->name)) {{@$order->updated_name->name}} @endif</td>
    								                    
    								                    <td class="text-center"><a href="#" id="showorder" data-route="{{url(route('Order.show',$order->id))}}" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
    								                    	@if(@$order->status == 'canceled')
                											@if (@Auth::user()->is('agent') == false)
    								                    			<button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
    								                    		@endif
    								                    		<button type="button" class="btn btn-xs"><i class="fa fa-pencil"></i></button>
    								                    	@elseif(@$order->status =='closed')
    								                    		<button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
    								                    		<button type="button" class="btn btn-xs"><i class="fa fa-pencil"></i></button>
																@if (@Auth::user()->is('tabaliadmin'))
																	<button data-route="{{URL::route('Order.destroy',@$order->id)}}" id="{{@$order->id}}" data-token="{{ csrf_token() }}" type="button" class="cancelorder btn btn-primary btn-xs"><i class="fa fa-ban"></i></button>
																@endif
    								                    	@elseif(@$order->status =='ondelivery')
    								                    		<button type="button" class="btn btn-xs"><i class="fa fa fa-motorcycle"></i></button>
																@if (@Auth::user()->is('agent') == false)
																	<a href="{{URL::route('Order.edit',@$order->id)}}" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-pencil"></i></a>
                						   					   	@else
    								                    			<button type="button" class="btn btn-xs"><i class="fa fa-pencil"></i></button>
																@endif

																

    								                    	@else
                												@if (@Auth::user()->is('agent') == false)
    						   										<button data-route="{{URL::route('Order.destroy',@$order->id)}}" id="{{@$order->id}}" data-token="{{ csrf_token() }}" type="button" class="cancelorder btn btn-primary btn-xs"><i class="fa fa-ban"></i></button>
    																<button data-route="{{URL::route('Order.transfer',@$order->id)}}" id="{{@$order->id}}" data-token="{{ csrf_token() }}" type="button" class="transfer btn btn-warning btn-xs"><i class="fa  fa-refresh"></i></button>
                						   					   @endif
                						   					   <a href="{{URL::route('Order.edit',@$order->id)}}" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-pencil"></i></a>
                								            @endif
    								                    	<a href="{{URL::route('Complaint.create',array('account'=>@$order->account_id,'contact'=> @$order->contact_id,'branch'=>@$order->branch_id,'order'=> @$order->id))}}" class="Create btn btn-danger btn-xs" ><i class=" fa fa-bell-o"></i> Complaint</a>
    												    </td>
    								                    <?php /**/?>
    								                  </tr>
    								                
    								                @endforeach
								                
							                  </tbody>
							                </table>
							            </div>
							              <!-- /.table-responsive -->
						            </div>
		          				</div>
		          				<div class="tab-pane" id="Complaint">
					                <!-- /.box-header -->
					                <div class="box-body">
							            <div class="row">
							            	<div class="col-md-1 col-md-push-5">

							            		<a href="{{URL::route('Complaint.create',array('account'=> $account->id,'contact' => $contact->id,'branch' => $branch->id,'address'=>$address->id))}}" type="button" class="btn btn-danger btn-xs"><i class=" fa fa-bell-o"></i> create Complaint</a> 

							            	</div>
							            </div>
							            <hr/>

						              	<div class="table-responsive">
							                <table class="table no-margin" class="text-center">
							                  <thead>
								                  <tr>
								                    <th class="text-center">{{trans('form.id')}}</th>
								                    <th class="text-center">{{trans('form.status')}}</th>
								                    <th class="text-center">{{trans('form.complaint_type')}}</th>
								                    <th class="text-center">{{trans('form.created_at')}}</th>
								                    <th class="text-center">{{trans('form.updated_at')}}</th>
								                    <th class="text-center">{{trans('form.created_by')}}</th>
								                    <th class="text-center"></th>
								                  </tr>
							                  </thead>
							                  <tbody>
                                        
							                  	@foreach($contact->complaintslimit as $compaint)
								                  <tr>
								                    <td class="text-center">{{@$compaint->id}}</td>
								                    <td class="text-center">{{@$compaint->status}}</td>
								                    <td class="text-center">{{@$compaint->complaint_type}}</td>
								                    <td class="text-center">{{@$compaint->created_at}}</td>
								                    <td class="text-center">{{@$compaint->updated_at}}</td>
								                    <td class="text-center">{{@$compaint->created_name->name}}</td>
								                    <td><a href="#" id="showorder" data-route="{{url(route('Complaint.show',$compaint->id))}}" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-folder"></i></a></td>
								                  </tr>
								                @endforeach
								                
							                  </tbody>
							                </table>
							            </div>
						              	<!-- /.table-responsive -->
					            	</div>
		        				</div>

					            <div class="tab-pane" id="Inquiry">
					                <!-- /.box-header -->
					                <div class="box-body">
							            <div class="row">
							            	<div class="col-md-4">
							            		<a href="{{URL::route('Inquiry.create',array('account'=> $account->id,'contact' => $contact->id,'branch' => $branch->id,'address'=>$address->id))}}" type="button" class="btn btn-block btn-warning btn-sm">Create a new Inquiry</a>
							            	</div>
							            </div>
							            <hr/>
						              	<div class="table-responsive">
							                <table class="table no-margin" class="text-center">
							                  <thead>
								                  <tr>
								                    <th class="text-center">{{trans('form.id')}}</th>
								                    <th class="text-center">{{trans('form.status')}}</th>
								                    <th class="text-center">{{trans('form.inquiry_type')}}</th>
								                    <th class="text-center">{{trans('form.inquiry_comment')}}</th>
								                    <th class="text-center">{{trans('form.created_at')}}</th>
								                    <th class="text-center">{{trans('form.updated_at')}}</th>
								                    <th class="text-center">{{trans('form.created_by')}}</th>
								                    <th class="text-center"></th>
								                  </tr>
							                  </thead>
							                  <tbody>
							                      
							                  	@foreach($contact->inquirieslimit as $inquiry)
							                  	
								                  <tr>
								                    <td class="text-center">{!! @$inquiry->id !!}</td>
								                    <td class="text-center">{!! $inquiry->status !!}</td>
								                    <td class="text-center">{!! @$inquiry->inquiry_type !!}</td>
								                    <td class="text-center">{!! @$inquiry->inquiry_comment !!}</td>
								                    <td class="text-center">{!! @$inquiry->created_at !!}</td>
								                    <td class="text-center">{!! @$inquiry->updated_at !!}</td>
								                    <td class="text-center">{!! @$inquiry->created_name->name !!}</td>
								                  </tr>
								                
								                @endforeach
								                
								                
							                  </tbody>
							                </table>
							            </div>
							            
						              	<!-- /.table-responsive -->
					            	</div>
					            </div>

		      				</div>
		    			</div>
	    				<!-- /.Account Dashboard -->
	    			</div>
	      		</div>
	      	</div>
		</section>





		<script type="text/javascript">
			$(document).on('click','#showorder',function(e){ 
				e.preventDefault();
	            var route   = $(this).data('route');
				$.confirm({
		            title           : 'Show Order',
		            columnClass     : 'col-md-12',
		            closeIcon       :  true,
		            content         : 'url:'+route,
		            //animation     : 'top',
		            //closeAnimation: 'bottom',
		            animation       : 'zoom',
		            cancelButton: false, // hides the cancel button.
					confirmButton: false, // hides the confirm button.
	        	});
	        });
	        
			$(document).on('click','.AddContact',function(){ 
	            
                var link    = $(this).data('link');
	            var route   = $(this).data('route');
	            var route2  = $(this).data('route2');
	          	var account = $(this).data('account');
	          	var phone 	= $('#ContactPhone').val();
	          	var token 	= $(this).data('token');
	            var contact = $(this).data('contact');
	          	$.ajax({
	                url     : route,
	                type    : 'post',
	                data    : {_method: 'post', _token:token,account:account,phone:phone,link:link,remove:contact},
	                dataType:'json',           
	                success : function(data){
	                    if(data[2] == "success"){
	                    	if ( $("#contact_"+data['0']['id']).length) {
								alert('this contacts already exists')
							}else{
	          					$('.ContactsDiv').prepend('<li id="contact_'+data['0']['id']+'" class="list-group-item"><strong><i class="fa fa-user margin-r-5"></i>'+data['0']['contact_name']+'</strong><a class="pull-right">'+data['1']['phone']+'<br/> </a> <br/></li>');
	          					$("#alarm").attr("id", "alarmdone");
	              				$("#alarmdone").attr("class","AddContact btn btn-success");
							}
						 }else if(data[2] == "remove"){
							    $('#contact_'+data[0]).remove();
	                    }else if(data == "fail"){
	       					$.confirm({
				                title           : 'Add Contact',
				                columnClass     : 'col-md-10 col-md-push-1',
				                closeIcon       :  true,
				                content         : 'url:'+route2+'?account='+account+'&phone='+phone,
				                //animation     : 'top',
				                //closeAnimation: 'bottom',
				                animation       : 'zoom',
				                cancelButton: false, // hides the cancel button.
				    			confirmButton: false, // hides the confirm button.
				            });                 
	                        
	                    }
	                },
	            });
	        });




            $(document).on('click','.transfer',function(){ 
	            var route   = $(this).data('route');
	            var token   = $(this).data('token');
	            var icon 	= $(this);
	            $.confirm({
		            icon                : 'fa fa-refresh',
		            title               : 'Transfer Order',
                    content     : 'Are you sure you want to Transfer! <br/><br/> <select name="brnachKey" class="transferTo form-control" required> @foreach($transferTo as $branchKey => $brnachValue) @if($branch->id != $branchKey ) <option value="{{$branchKey}}"> {{$brnachValue}} </option> @endif @endforeach </select>',
		            confirmButtonClass  : 'btn-danger',
		            cancelButtonClass   : 'btn-primary',
		            confirmButton       : 'OK',
		            cancelButton        : 'NO never !',
		           	confirm: function () {
                            var transferTo = this.$content.find('.transferTo').val();
		                    if(!transferTo){
	                                 $.alert('please provide a Brnach');
		                         return false;
	                     	}
		            	$.ajax({
				    		url     : route,
		                    type    : 'post',
		                    data    : {_method: 'POST', _token :token,transferTo:transferTo},
		                    dataType:'json',           
		                    success : function(data){
		                        if(data.message=='Success'){
									location.reload();
		                        }else{
		                        	$.alert({
									    icon: 'fa fa-spinner fa-spin',
									    title: 'Opps',
									    content: 'sorry you can\'t transfer right now'
									});
		                        }
		                    },
		                });
		           	},
	        	});
	    	});



	        $(document).on('click','.cancelorder',function(){ 
	            var route   = $(this).data('route');
	            var token   = $(this).data('token');
	            var icon 	= $(this);
	            $.confirm({
		            icon                : 'glyphicon glyphicon-remove',
		            title               : 'Cancel Order',
                            content             : 'Are you sure you want to Cancel! <br/><br/> <textarea placeholder="insert your comment" class="comment form-control"  cols="30" rows="5" required></textarea>',
		            confirmButtonClass  : 'btn-danger',
		            cancelButtonClass   : 'btn-primary',
		            confirmButton       : 'OK',
		            cancelButton        : 'NO never !',
		           	confirm: function () {
                                    var comment = this.$content.find('.comment').val();
		                    if(!comment){
  	                                 $.alert('please provide a Comment');
		                         return false;
		                     }
		            	$.ajax({
				    url     : route,
		                    type    : 'post',
		                    data    : {_method: 'delete', _token :token,comment:comment},
		                    dataType:'json',           
		                    success : function(data){
		                        if(data == "fail"){
		                            $.alert({
									    icon: 'fa fa-spinner fa-spin',
									    title: 'Opps',
									    content: 'sorry you can\'t update this recoed right now'
									});
		                        }else{
		                        	icon.parent().parent().find('.orderstatus').html('<span class="label label-danger">canceled</span>');
		                        	icon.children().attr('class','fa fa-times');
		                        	icon.attr('class','btn btn-danger btn-xs');
		                        }
		                    },
		                });
		           	},
	        	});
	    	});
		</script>
	
	@endsection
@else
  @section('content')
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-red"><i class="fa fa-frown-o" aria-hidden="true"></i></h2>
                <div class="error-content">
                    <br/>
                    <h3><i class="fa fa-warning text-red"></i>Check this link again</h3>
                    <p>There's no data for this ID.</p>
                    <p><a href="{{url()->previous()}}"> Return to Back </a></p>
                </div>
            </div>
        </section>
    @endsection
@endif


