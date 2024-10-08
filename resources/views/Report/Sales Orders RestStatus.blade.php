<table border="1">
	<thead>
		<tr>
			<td colspan="4"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="4"><h3>Orders per Restaurant per Status From {{$from}} To {{$to}} </h3></td>
		</tr>
		<tr>
			<td colspan="4"><h4>Restaurants: </h4></td>
		</tr>
		<tr><td colspan="4">Delivery</td></tr>
		<tr style="color: #fff;background-color: #034d88">
			<td>Restaurant</td>
			<td>Status</td>
			<td>TC</td>
			<td>Sales</td>
			<td>Avg. Check</td>
		</tr>
	</thead>
	
	<tbody>
		@foreach($branch_Delivery as $branch_id)
			@php $Delivery  = \App\Order::whereBetween('orders.created_at', array($from, $to))->where('payment_type','Delivery')->where('branch_id',$branch_id)->getSalesOrdersRestStatusExport()->get(); @endphp
			@foreach($Delivery as $report)
			<tr>
				<td style="background-color: #89bee8">{{$report->Restaurant}}</td>
				<td>{{$report->Status}}</td>
				<td>{{$report->TC}}</td>
				<td>{{$report->Sales}}</td>
				<td>{{$report->Avg}}</td>			
			</tr>
			@endforeach
			<tr style="background-color: #89bee8">
				<td></td>
				<td>Total</td>
				<td>{{$Delivery->sum('TC')}}</td>
				<td>{{$Delivery->sum('Sales')}}</td>
				@if($Delivery->sum('Sales') != 0)
				<td>{{number_format((float)$Delivery->sum('Sales') / $Delivery->sum('TC'), 2, '.', '')}}</td>
				@else
				<td>0</td>
				@endif
			</tr>
		@endforeach
	</tbody>

	<tr>
		<td colspan="5">HotSpot</td>
	</tr>
	<tr style="color: #fff;background-color: #034d88">
			<td>Restaurant</td>
			<td>Status</td>
			<td>TC</td>
			<td>Sales</td>
			<td>Avg. Check</td>
		</tr>

	@foreach($branch_HotSpot as $branch_id)
		@php $Delivery  = \App\Order::whereBetween('orders.created_at', array($from, $to))->where('payment_type','HotSpot')->where('branch_id',$branch_id)->getSalesOrdersRestStatusExport()->get(); @endphp
		<tr>
			<td rowspan="{{$Delivery->count()}}" style="background-color: #89bee8">
		@foreach($Delivery as $report)
				{{$report->Restaurant}}</td>
			<td>{{$report->Status}}</td>
			<td>{{$report->TC}}</td>
			<td>{{$report->Sales}}</td>
			<td>{{$report->Avg}}</td>			
		</tr>
		@endforeach
		<tr style="background-color: #89bee8">
			<td></td>
			<td>Total</td>
			<td>{{$Delivery->sum('TC')}}</td>
			<td>{{$Delivery->sum('Sales')}}</td>
			@if($Delivery->sum('Sales') != 0)
			<td>{{number_format((float)$Delivery->sum('Sales') / $Delivery->sum('TC'), 2, '.', '')}}</td>
			@else
			<td>0</td>
			@endif
		</tr>
	@endforeach
	
</table>