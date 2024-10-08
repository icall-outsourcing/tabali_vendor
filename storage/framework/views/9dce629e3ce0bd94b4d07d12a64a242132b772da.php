<table border="1">
	<thead>
		<tr>
			<td colspan="12"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="12"><h3>Sales Report By Driver From <?php echo e($from); ?> To <?php echo e($to); ?> </h3></td>
		</tr>
		<tr>
			<td colspan="12"><h4>Restaurants: </h4></td>
		</tr>
		<tr style="color: #fff;background-color: #034d88">
			<?php  $dlivery_fees = \App\Area::all()->lists('dlivery_fees','dlivery_fees')->toArray();  ?> 
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
		<?php foreach($reports as $report): ?>
			<tr>
				<td><?php echo e($report->Restaurant); ?></td>
				<td><?php echo e($report->Driver); ?></td>
				<td><?php echo e($report->Status); ?></td>
				<td><?php echo e($report->TC); ?></td>
				<td><?php echo e($report->Sales); ?></td>
				<td><?php echo e($report->Avg); ?></td>
				<td><?php echo e($report->delivery7); ?></td>
				<td><?php echo e($report->delivery8); ?></td>
				<td><?php echo e($report->delivery85); ?></td>
				<td><?php echo e($report->delivery9); ?></td>
				<td><?php echo e($report->delivery10); ?></td>
				<td><?php echo e($report->delivery12); ?></td>
				<td><?php echo e($report->delivery15); ?></td>
				<td><?php echo e($report->delivery17); ?></td>
				<td><?php echo e($report->delivery20); ?></td>
			</tr>
		<?php endforeach; ?>
            <tfooter>
                 <tr style="color: #fff;background-color: #034d88">
                     <td colspan="3"> الاجمالى </td>
                     <td><?php echo e($reports->sum('TC')); ?></td>
                     <td><?php echo e($reports->sum('Sales')); ?></td>
                     <td><?php echo e($reports->sum('Avg')); ?></td>
                     <td><?php echo e($reports->sum('delivery7')); ?></td>
                     <td><?php echo e($reports->sum('delivery8')); ?></td>
                     <td><?php echo e($reports->sum('delivery85')); ?></td>
                     <td><?php echo e($reports->sum('delivery9')); ?></td>
                     <td><?php echo e($reports->sum('delivery10')); ?></td>
                     <td><?php echo e($reports->sum('delivery12')); ?></td>
                     <td><?php echo e($reports->sum('delivery15')); ?></td>
                     <td><?php echo e($reports->sum('delivery17')); ?></td>
                     <td><?php echo e($reports->sum('delivery20')); ?></td>
                 </tr>
            </tfooter>

	</tbody>






	
</table>