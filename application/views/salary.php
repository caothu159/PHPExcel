<!-- Luong -->
<div class="container-fluid">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<?php foreach ($salary as $name => $ns): ?>
			<li role="presentation">
				<a href="#<?php echo implode('-', explode(' ', strtolower($name))); ?>"
				   role="tab"
				   aria-controls="<?php echo implode('-', explode(' ', strtolower($name))); ?>"
				   data-toggle="tab">
					<?php echo $name; ?>
				</a>
			</li>
		<?php endforeach; ?>

		<li role="presentation">
			<a href="#debug" aria-controls="debug" role="tab" data-toggle="tab">Debug</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<?php foreach ($salary as $name => $ns): ?>
			<div role="tabpanel" class="tab-pane"
				 id="<?php echo implode('-', explode(' ', strtolower($name))); ?>">
				<div class="nhansu">
					<?php $this->load->view('salary/nhansu', array('nhansu' => $ns)); ?>
				</div>
			</div>
		<?php endforeach; ?>
		<div role="tabpanel" class="tab-pane" id="debug">
			<pre>
				<?php print_r($salary); ?>
			</pre>
		</div>
	</div>

</div>
<!-- !Luong -->
