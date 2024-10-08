<table border="1">
	<thead>
		<tr>
			<td colspan="4"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="4"><h3>Sales Report By Restaurant From {{$from}} To {{$to}} </h3></td>
		</tr>
		<tr>
			<td colspan="4"><h4>Restaurants: </h4></td>
		</tr>
		<tr><td colspan="4">Delivery</td></tr>
		<tr style="color: #fff;background-color: #034d88">
			<td>Restaurant</td>
			<td>TC</td>
			<td>Sales</td>
			<td>Avg. Check</td>
		</tr>
	</thead>
	
	<tbody>
		@foreach($Delivery as $report)
			<tr>
				<td style="background-color: #89bee8">{{$report->Restaurant}}</td>
				<td>{{$report->TC}}</td>
				<td>{{$report->Sales}}</td>
				<td>{{$report->Avg}}</td>			
			</tr>
		@endforeach
		<tr style="background-color: #89bee8">
			<td>Total</td>
			<td>{{$Delivery->sum('TC')}}</td>
			<td>{{$Delivery->sum('Sales')}}</td>
			<td>{{number_format((float)$Delivery->sum('Sales') / $Delivery->sum('TC'), 2, '.', '')}}</td>
		</tr>
	</tbody>
	<tr>
		<td colspan="4">HotSpot</td>
	</tr>
	<tr style="color: #fff;background-color: #034d88">
		<td>Restaurant</td>
		<td>TC</td>
		<td>Sales</td>
		<td>Avg. Check</td>
	</tr>
	<tbody>
		@foreach($HotSpot as $report)
			<tr>
				<td style="background-color: #89bee8">{{$report->Restaurant}}</td>
				<td>{{$report->TC}}</td>
				<td>{{$report->Sales}}</td>
				<td>{{$report->Avg}}</td>			
			</tr>
		@endforeach
		<tr style="background-color: #89bee8">
			<td>Total</td>
			<td>{{$HotSpot->sum('TC')}}</td>
			<td>{{$HotSpot->sum('Sales')}}</td>
			<td>{{number_format((float)$HotSpot->sum('Sales') / $HotSpot->sum('TC'), 2, '.', '')}}</td>
		</tr>
	</tbody>







	
</table>