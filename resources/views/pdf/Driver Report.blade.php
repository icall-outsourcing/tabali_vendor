<!DOCTYPE html>

<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>Print Order Number #</title>    
    <style type="text/css" media="print">
      body {font-family: 'examplefont', sans-serif;  font-size: 11px !important;}      
	  hr{}
    </style>
  </head>
  <body>
	<table>
		<thead>
			<tr><td colspan="6"><h2>Driver Report</h2></td></tr>
			<tr><td colspan="6"><h3>Sales Report By Driver From {{$from}} To {{$to}} </h3></td></tr>
		</thead>
	</table>
	<hr/>
	<table>
		<theader>
			<tr>
				<th>ID</th>
				<th>Tel</th>
				<th>Address</th>
				<th>Amount</th>
				<th>Status</th>
			</tr>
		</theader>		
			@foreach($reports as $report)			
				<tr>
					<td>{{$report->id}}</td>
					<td>{{$report->tel}}</td>
					<td>{{$report->address}}</td>
					<td>{{number_format($report->total,2)}}</td>
					<td>{{$report->Status}}</td>
				</tr>
			@endforeach	
		<tr><td colspan="5"><hr/></td></tr>
		<tfooter>
			<tr style="background-color: #9f9c9c;color: white;">
				<td colspan="3"><h2>T with Paid</h2></td>
				<td colspan="2"><h2>{{number_format ($reports->sum('total'),2)   }}</h2></td>
			</tr>
			<tr style="background-color: #9f9c9c;color: white;">
				<td colspan="3"><h2>T Without Paid</h2></td>
				<td colspan="2"><h2>{{number_format ($reports->sum('totalWithoutPaid'),2)   }}</h2></td>
			</tr>
			
		</tfooter>
	</table>	
</body>
</html>