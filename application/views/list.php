<!-- Danh sach -->
<div class="col-xs-12 col-sm-4 col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Thời gian</h3>
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
