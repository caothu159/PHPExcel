<!-- Luong -->
<div class="col-xs-12 col-sm-8 col-md-9">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<?php foreach ($salary as $name => $ns): ?>
			<div class="panel panel-default">
				<div class="panel-heading"
					 role="tab"
					 id="heading<?php echo implode('-', explode(' ', strtolower($name))); ?>">
					<h4 class="panel-title">
						<a role="button"
						   data-toggle="collapse"
						   data-parent="#accordion"
						   href="#<?php echo implode('-', explode(' ', strtolower($name))); ?>"
						   aria-expanded="true"
						   aria-controls="<?php echo implode('-', explode(' ', strtolower($name))); ?>">
							<?php echo $name; ?>
						</a>
					</h4>
				</div>
				<div id="<?php echo implode('-', explode(' ', strtolower($name))); ?>"
					 class="panel-collapse collapse"
					 role="tabpanel"
					 aria-labelledby="<?php echo implode('-', explode(' ', strtolower($name))); ?>">
					<div class="panel-body">
						<div class="nhansu">
							<?php $this->load->view('salary/nhansu', ['nhansu' => $ns]); ?>
						</div>
					</div>
					<?php if ($ns->getNangSuat() > 0): ?>
						<?php $this->load->view('salary/chitiet', ['nhansu' => $ns]); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

</div>
<!-- !Luong -->
