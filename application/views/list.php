<!-- Danh sach -->
<div class="col-xs-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Thời gian</h3>
		</div>
		<table class="table">
			<?php foreach ($list as $filename) : ?>
				<tr>
					<td>
						<a href="<?php echo $filename; ?>">
							<?php echo $filename; ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
