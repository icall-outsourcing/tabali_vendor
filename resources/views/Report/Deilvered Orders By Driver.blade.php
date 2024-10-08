<table border="1">
	<thead>
		<tr>
			<td colspan="12"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="12"><h3>Sales Report By Driver From {{$from}} To {{$to}} </h3></td>
		</tr>
		<tr>
			<td colspan="12"><h4>Restaurants: </h4></td>
		</tr>
		<tr style="color: #fff;background-color: #034d88">
			@php $dlivery_fees = \App\Area::all()->lists('dlivery_fees','dlivery_fees')->toArray(); @endphp 
			<td>Restaurant</td>
			<td>Driver</td>
			<td>Status</td>
			<td>TC</td>
			<td>Sales</td>
			<td>Avg. Check</td>
			<td>delivery 8</td>
			<td>delivery 10</td>
			<td>delivery 15</td>
			<td>delivery 20</td>
			<td>delivery 21</td>
			<td>delivery 25</td>						
		</tr>
	</thead>
	<tbody>
		@foreach($reports as $report)
			<tr>
				<td>{{$report->Restaurant}}</td>
				<td>{{$report->Driver}}</td>
				<td>{{$report->Status}}</td>
				<td>{{$report->TC}}</td>
				<td>{{$report->Sales}}</td>
				<td>{{$report->Avg}}</td>
				<td>{{$report->delivery8}}</td>				
				<td>{{$report->delivery10}}</td>
				<td>{{$report->delivery15}}</td>
				<td>{{$report->delivery20}}</td>
				<td>{{$report->delivery21}}</td>
				<td>{{$report->delivery25}}</td>
			</tr>
		@endforeach
            <tfooter>
                 <tr style="color: #fff;background-color: #034d88">
                     <td colspan="3"> الاجمالى </td>
                     <td>{{$reports->sum('TC')}}</td>
                     <td>{{$reports->sum('Sales')}}</td>
                     <td>{{$reports->sum('Avg')}}</td>                     
                     <td>{{$reports->sum('delivery8')}}</td>
                     <td>{{$reports->sum('delivery10')}}</td>
                     <td>{{$reports->sum('delivery15')}}</td>
                     <td>{{$reports->sum('delivery20')}}</td>
                     <td>{{$reports->sum('delivery21')}}</td>
                     <td>{{$reports->sum('delivery25')}}</td>
                 </tr>
            </tfooter>

	</tbody>






	
</table>