<table class="table table-hover table-striped table-condensed chitiet">
	<tr>
		<th></th>
		<th>Xe</th>
		<!--		<th>Năng suất xe</th>-->
		<!--		<th>Cho nợ</th>-->
		<!--		<th>Thu nợ</th>-->
		<th>Tỉ lệ chia</th>
		<th>Năng suất</th>
		<th>Hệ số</th>
		<th>Lương</th>
	</tr>
	<?php foreach ($nhansu->getTuyen() as $date => $ns): ?>
		<tr>
			<th><?php echo date('d/m/Y', ($date - 25569) * 86400); ?></th>
			<td>
				<span class="xe"><?php echo $ns['xe']; ?>: <span><?php echo $ns['nang suat xe']; ?></span></span>
				<span class="cho-no">Cho nợ: <span><?php echo $ns['cho no']; ?></span></span>
				<span class="thu-no">Thu nợ: <span><?php echo $ns['thu no']; ?></span></span>
			</td>
			<!--			<td>--><?php //echo $ns['nang suat xe'];?><!--</td>-->
			<!--			<td>--><?php //echo $ns['cho no'];?><!--</td>-->
			<!--			<td>--><?php //echo $ns['thu no'];?><!--</td>-->
			<td><?php echo number_format((float) $ns['ti le'], 2, '.', ''); ?></td>
			<td><?php echo number_format((float) $ns['nang suat'], 2, '.', ''); ?></td>
			<td><?php echo $ns['ti suat']; ?></td>
			<td><?php echo number_format((float) $ns['luong'], 2, '.', ''); ?></td>
		</tr>
	<?php endforeach; ?>
</table>
