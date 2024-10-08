<table border="1">
	<thead>
		<tr>
			<td colspan="4"><h2>Order Management System</h2></td>
		</tr>
		<tr>
			<td colspan="4"><h3>Orders per Restaurant per Status From <?php echo e($from); ?> To <?php echo e($to); ?> </h3></td>
		</tr>
		<tr>
			<td colspan="4"><h4>Restaurants: </h4></td>
		</tr>
		<tr><td colspan="4">Delivery</td></tr>
		<tr style="color: #fff;background-color: #034d88">
			<td>Restaurant</td>
			<td>Status</td>
			<td>TC</td>
			<td>Sales</td>
			<td>Avg. Check</td>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($branch_Delivery as $branch_id): ?>
			<?php  $Delivery  = \App\Order::whereBetween('orders.created_at', array($from, $to))->where('payment_type','Delivery')->where('branch_id',$branch_id)->getSalesOrdersRestStatusExport()->get();  ?>
			<?php foreach($Delivery as $report): ?>
			<tr>
				<td style="background-color: #89bee8"><?php echo e($report->Restaurant); ?></td>
				<td><?php echo e($report->Status); ?></td>
				<td><?php echo e($report->TC); ?></td>
				<td><?php echo e($report->Sales); ?></td>
				<td><?php echo e($report->Avg); ?></td>			
			</tr>
			<?php endforeach; ?>
			<tr style="background-color: #89bee8">
				<td></td>
				<td>Total</td>
				<td><?php echo e($Delivery->sum('TC')); ?></td>
				<td><?php echo e($Delivery->sum('Sales')); ?></td>
				<?php if($Delivery->sum('Sales') != 0): ?>
				<td><?php echo e(number_format((float)$Delivery->sum('Sales') / $Delivery->sum('TC'), 2, '.', '')); ?></td>
				<?php else: ?>
				<td>0</td>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>

	<tr>
		<td colspan="5">HotSpot</td>
	</tr>
	<tr style="color: #fff;background-color: #034d88">
			<td>Restaurant</td>
			<td>Status</td>
			<td>TC</td>
			<td>Sales</td>
			<td>Avg. Check</td>
		</tr>

	<?php foreach($branch_HotSpot as $branch_id): ?>
		<?php  $Delivery  = \App\Order::whereBetween('orders.created_at', array($from, $to))->where('payment_type','HotSpot')->where('branch_id',$branch_id)->getSalesOrdersRestStatusExport()->get();  ?>
		<tr>
			<td rowspan="<?php echo e($Delivery->count()); ?>" style="background-color: #89bee8">
		<?php foreach($Delivery as $report): ?>
				<?php echo e($report->Restaurant); ?></td>
			<td><?php echo e($report->Status); ?></td>
			<td><?php echo e($report->TC); ?></td>
			<td><?php echo e($report->Sales); ?></td>
			<td><?php echo e($report->Avg); ?></td>			
		</tr>
		<?php endforeach; ?>
		<tr style="background-color: #89bee8">
			<td></td>
			<td>Total</td>
			<td><?php echo e($Delivery->sum('TC')); ?></td>
			<td><?php echo e($Delivery->sum('Sales')); ?></td>
			<?php if($Delivery->sum('Sales') != 0): ?>
			<td><?php echo e(number_format((float)$Delivery->sum('Sales') / $Delivery->sum('TC'), 2, '.', '')); ?></td>
			<?php else: ?>
			<td>0</td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
	
</table>