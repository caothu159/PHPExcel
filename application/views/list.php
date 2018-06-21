<!-- Danh sach -->
<div class="col-xs-12 col-sm-4 col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Thời gian</h3>
		</div>
		<table class="table">
			<?php foreach ($list as $time => $filename) : ?>
				<tr>
					<td>
						<a href="<?php echo $filename; ?>">
							<?php echo $time; ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
