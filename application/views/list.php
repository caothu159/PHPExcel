<!-- Danh sach -->
<div class="col-xs-12 col-sm-4 col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Thời gian <?php echo $time; ?></h3>
		</div>
		<div class="panel-body">

			<form action="/upload/doupload/<?php echo $time; ?>" enctype="multipart/form-data" method="post">
				<div class="form-group">
					<label for="userfile">File input</label>
					<input type="file" id="userfile" name="userfile">
					<p class="help-block">Tải từng file lên.</p>
				</div>

				<button type="submit" class="btn btn-primary btn-xs">Tải lên</button>
			</form>
		</div>
		<table class="table">
			<?php foreach ($list as $t => $filename) : ?>
				<tr>
					<td>
						<a href="<?php echo $filename; ?>"
						   class="<?php echo strpos($t, 'Chinh-Thuc') ? 'text-primary' : 'text-danger'; ?>">
							<?php if ($t == $time): ?>
								<strong>
									<?php echo str_replace('-', ' ', $t); ?>
								</strong>
							<?php else: ?>
								<?php echo str_replace('-', ' ', $t); ?>
							<?php endif; ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
