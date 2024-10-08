{{$from}} To {{$to}} 
<table border="1" style="writing-mode: vertical-rl;-webkit-writing-mode: vertical-rl;-ms-writing-mode: vertical-rl;margin:50px;text-orientation: mixed; ">
	<thead>
		<tr style="color: #fff;background-color: #034d88">
			@php $dlivery_fees = \App\Area::all()->lists('dlivery_fees','dlivery_fees')->toArray(); @endphp 
			<td>Restaurant</td>
			<td>Driver</td>
			<td>Status</td>
			<td>TC</td>
			<td>Sales</td>
			<td>Avg. Check</td>
			<td>delivery 7</td>
			<td>delivery 8</td>
			<td>delivery 8.5</td>
			<td>delivery 9</td>
			<td>delivery 10</td>
			<td>delivery 12</td>
			<td>delivery 15</td>
			<td>delivery 17</td>
			<td>delivery 20</td>
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
				<td>{{$report->delivery7}}</td>
				<td>{{$report->delivery8}}</td>
				<td>{{$report->delivery85}}</td>
				<td>{{$report->delivery9}}</td>
				<td>{{$report->delivery10}}</td>
				<td>{{$report->delivery12}}</td>
				<td>{{$report->delivery15}}</td>
				<td>{{$report->delivery17}}</td>
				<td>{{$report->delivery20}}</td>
			</tr>
		@endforeach
            <tfooter>
                 <tr style="color: #fff;background-color: #034d88">
                     <td colspan="3"> الاجمالى </td>
                     <td>{{$reports->sum('TC')}}</td>
                     <td>{{$reports->sum('Sales')}}</td>
                     <td>{{$reports->sum('Avg')}}</td>
                     <td>{{$reports->sum('delivery7')}}</td>
                     <td>{{$reports->sum('delivery8')}}</td>
                     <td>{{$reports->sum('delivery85')}}</td>
                     <td>{{$reports->sum('delivery9')}}</td>
                     <td>{{$reports->sum('delivery10')}}</td>
                     <td>{{$reports->sum('delivery12')}}</td>
                     <td>{{$reports->sum('delivery15')}}</td>
                     <td>{{$reports->sum('delivery17')}}</td>
                     <td>{{$reports->sum('delivery20')}}</td>
                 </tr>
            </tfooter>

	</tbody>
</table>