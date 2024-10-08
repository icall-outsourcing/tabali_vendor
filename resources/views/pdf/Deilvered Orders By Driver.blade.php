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
			<tr><td colspan="6"><h2>Order Management System</h2></td></tr>
			<tr><td colspan="6"><h3>Sales Report By Driver From {{$from}} To {{$to}} </h3></td></tr>
		</thead>
	</table>
	<hr/>
	@foreach($reports as $report)		
		<p>Total				: {{ number_format(($report->Sales - $report->totaldiscount) + $report->Delivery,2) }}</p>
		<p>Total Service 		: {{ number_format($report->Delivery,2) }}</p>
		<p>Total without Service: {{ number_format(($report->Sales - $report->totaldiscount),2) }}</p>
		<p>order Count 			: {{ $report->TC }}</p>
		<p>Name  				: {{ $report->Driver }}</p>
		<hr/>
	@endforeach
		<hr/>
	<center><p> Total  </p></center>
	<p>Total Order : {{$reports->sum('TC')}}</p>
	<p>Amount: {{number_format((($reports->sum('Sales') - $reports->sum('totaldiscount')) + $reports->sum('Delivery')),2) }}</p>						
			

</body>
</html>