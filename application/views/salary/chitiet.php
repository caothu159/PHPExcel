<table class="table table-hover">
	<tr>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach ($nhansu->getTuyen() as $date => $ns): ?>
		<tr>
			<td><?php echo date('d/m/Y', ($date - 25569) * 86400); ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	<?php endforeach; ?>
</table>

<pre>
	<?php print_r($nhansu); ?>
</pre>
