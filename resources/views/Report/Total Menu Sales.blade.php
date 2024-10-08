<table border="1">
	<thead>
		<tr>
			<td colspan="12"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="12"><h3>Total Menu sales {{$from}} To {{$to}} </h3></td>
		</tr>
		<tr>
			<td colspan="12"><h4>Total Menu sales: </h4></td>
		</tr>
		<tr style="color: #fff;background-color: #034d88">
			<td>اسم الصنف</td>
			<td>السعر</td>
			<td>الكميه </td>
			<td>اجمالى السعر </td>
			<td>اسم السيكشن </td>
		</tr>
	</thead>
	<tbody>

		
		@php $tquantity = 0;$tprice = 0; @endphp
		@foreach($reports as $report)
			<tr>
				<td>{{$report->name}} 		</td>
				<td align="center">{{$report->uprice}} 	</td>
				<td align="center">{{$report->quantity}} 	@php $tquantity = $tquantity + $report->quantity; @endphp</td>
				<td align="center">{{$report->tprice}}  	@php $tprice	= $tprice + $report->tprice; @endphp</td>
				<td align="center">{{$report->section}} </td>
			</tr>
		@endforeach
            <tfooter>
                 <tr style="color: #fff;background-color: #034d88">
                     <td> الاجمالى </td>                     
                     <td></td>
                     <td align="center">{{$tquantity}}</td>
                     <td align="center">{{$tprice}}</td>
                 </tr>
            </tfooter>

	</tbody>






	
</table>