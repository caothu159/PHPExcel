<!-- Danh sach -->
<div class="col-xs-12 col-sm-4 col-md-3">
	<div class="panel panel-primary">
		<table class="table">
			<?php if ($year): ?>
				<?php foreach ($years[$year] as $mNum => $mModel) : ?>
					<?php if ($mNum == 'path'): ?>
						<?php continue; ?>
					<?php endif; ?>
					<tr>
						<td>
							<a href="<?php echo $mModel; ?>"
							   class="text-primary">
								<?php if ($mNum == $month): ?>
									<strong>
										<?php echo "tháng $mNum"; ?>
									</strong>
								<?php else: ?>
									<?php echo "tháng $mNum"; ?>
								<?php endif; ?>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<?php foreach ($years as $yNum => $yModel) : ?>
					<tr>
						<td>
							<a href="<?php echo $yModel['path']; ?>"
							   class="text-primary">
								<?php echo "năm $yNum"; ?>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>
