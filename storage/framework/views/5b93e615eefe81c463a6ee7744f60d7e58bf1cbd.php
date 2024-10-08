<table border="1">
	<thead>
		<tr>
			<td colspan="4"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="4"><h3>Sales Report By Restaurant From <?php echo e($from); ?> To <?php echo e($to); ?> </h3></td>
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
		<?php foreach($Delivery as $report): ?>
			<tr>
				<td style="background-color: #89bee8"><?php echo e($report->Restaurant); ?></td>
				<td><?php echo e($report->TC); ?></td>
				<td><?php echo e($report->Sales); ?></td>
				<td><?php echo e($report->Avg); ?></td>			
			</tr>
		<?php endforeach; ?>
		<tr style="background-color: #89bee8">
			<td>Total</td>
			<td><?php echo e($Delivery->sum('TC')); ?></td>
			<td><?php echo e($Delivery->sum('Sales')); ?></td>
			<td><?php echo e(number_format((float)$Delivery->sum('Sales') / $Delivery->sum('TC'), 2, '.', '')); ?></td>
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
		<?php foreach($HotSpot as $report): ?>
			<tr>
				<td style="background-color: #89bee8"><?php echo e($report->Restaurant); ?></td>
				<td><?php echo e($report->TC); ?></td>
				<td><?php echo e($report->Sales); ?></td>
				<td><?php echo e($report->Avg); ?></td>			
			</tr>
		<?php endforeach; ?>
		<tr style="background-color: #89bee8">
			<td>Total</td>
			<td><?php echo e($HotSpot->sum('TC')); ?></td>
			<td><?php echo e($HotSpot->sum('Sales')); ?></td>
			<td><?php echo e(number_format((float)$HotSpot->sum('Sales') / $HotSpot->sum('TC'), 2, '.', '')); ?></td>
		</tr>
	</tbody>







	
</table>