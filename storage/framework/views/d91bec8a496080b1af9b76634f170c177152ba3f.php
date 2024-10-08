<table border="1">
	<thead>
		<tr>
			<td colspan="12"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="12"><h3>Total Menu sales <?php echo e($from); ?> To <?php echo e($to); ?> </h3></td>
		</tr>
		<tr>
			<td colspan="12"><h4>Total Menu sales: </h4></td>
		</tr>
		<tr style="color: #fff;background-color: #034d88">
			<td>اسم الصنف</td>
			<td>السعر</td>
			<td>الكميه </td>
			<td>اجمالى السعر </td>
		</tr>
	</thead>
	<tbody>

		
		<?php  $tquantity = 0;$tprice = 0;  ?>
		<?php foreach($reports as $report): ?>
			<tr>
				<td><?php echo e($report->name); ?> 		</td>
				<td align="center"><?php echo e($report->uprice); ?> 	</td>
				<td align="center"><?php echo e($report->quantity); ?> 	<?php  $tquantity = $tquantity + $report->quantity;  ?></td>
				<td align="center"><?php echo e($report->tprice); ?>  	<?php  $tprice	= $tprice + $report->tprice;  ?></td>
			</tr>
		<?php endforeach; ?>
            <tfooter>
                 <tr style="color: #fff;background-color: #034d88">
                     <td> الاجمالى </td>                     
                     <td></td>
                     <td align="center"><?php echo e($tquantity); ?></td>
                     <td align="center"><?php echo e($tprice); ?></td>
                 </tr>
            </tfooter>

	</tbody>






	
</table>