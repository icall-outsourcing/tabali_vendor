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
				<tr><th colspan="4"  align="left"><h2>Tabali</h2><?php foreach($branch_name as $name): ?> <p> <?php echo e($name->name); ?> </p> <?php endforeach; ?></th></tr>
				<tr><th colspan="4" align="left"><h3>Total Menu sales <?php echo e($from); ?> To <?php echo e($to); ?> </h3></th></tr>							
				<hr/>
				<tr>
					<th align="left"> الصنف</th>					
					<th align="center">الكميه </th>
					<th align="center" colspan="2"> السعر </th>
				</tr>			
				<tr><td colspan="4"><hr/></td></tr>
			</thead>				
			<tbody>			
				<?php  $tquantity = 0;$tprice = 0;  ?>
				<?php foreach($reports as $report): ?>
					<tr>
						<td align="left"><?php echo e($report->name); ?></td>						
						<td align="center"><?php echo e($report->quantity); ?> 	<?php  $tquantity = $tquantity + $report->quantity;  ?></td>
						<td align="center" colspan="2"><?php echo e(number_format($report->tprice,2)); ?>  	<?php  $tprice	= $tprice + $report->tprice;  ?></td>
					</tr>
				<?php endforeach; ?>
				<tr><td colspan="4"><hr/></td></tr>
				<tr><td colspan="2"> T.item sales </td><td colspan="2" align="right"><?php echo e(number_format($total->total,2)); ?></td></tr>							
				<tr><td colspan="2"> T.discount	</td><td  colspan="2" align="right"> - <?php echo e(number_format($total->totaldiscount,2)); ?></td></tr>
				<tr><td colspan="2"> service	  </td><td colspan="2" align="right"><?php echo e(number_format($total->deliveryfees,2)); ?></td></tr>
				<tr><td colspan="2"> vat	  	  </td><td colspan="2" align="right"><?php echo e(number_format($total->taxfees,2)); ?></td></tr>
				<tr><td colspan="2"> Gross sales  </td><td style="background-color:#9f9c9c !important;" colspan="2" align="right"><?php echo e(number_format(($total->total_amount - $total->totaldiscount),2)); ?></td></tr>														
				<tr><td colspan="4"><hr/></td></tr>
				<tr><td colspan="2"> cash 		</td><td align="center"><?php echo e($SumOrder->Tcash); ?></td><td align="right"><?php echo e(number_format($SumOrder->cash - $SumOrder->cashDiscount,2)); ?></td></tr>
<tr><td colspan="2"> VisaCard 		</td><td align="center"><?php echo e($SumOrder->TVisaCard); ?></td><td align="right"><?php echo e(number_format($SumOrder->VisaCard - $SumOrder->VisaCardDiscount,2)); ?></td></tr>
				<tr><td colspan="2"> on-line	</td><td align="center"><?php echo e($SumOrder->Ton_line); ?></td><td align="right"><?php echo e(number_format($SumOrder->on_line - $SumOrder->on_lineDiscount,2)); ?></td></tr>				
				<tr><td colspan="2"> Collect    </td><td style="background-color:#9f9c9c !important;" colspan="2" align="right"><?php echo e(number_format(($SumOrder->cash + $SumOrder->on_line + $SumOrder->VisaCard) - $total->totaldiscount     ,2)); ?></td></tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr><td colspan="2"> void  		</td><td align="center"><?php echo e($SumOrder->Tvoid); ?></td><td align="center"><?php echo e(number_format($SumOrder->void,2)); ?></td></tr>
				<tr><td colspan="4"><hr/></td></tr>
				
				
				
					
					
					

					

			</tbody>

			
		</table>
	</body>
</html>