<div class="title cong">Ngày công: <span><?php echo $nhansu->getCong(); ?></span></div>

<?php if ($nhansu->getCongDem() > 0): ?>
	<div class="title cong">Công đêm: <span><?php echo $nhansu->getCongDem(); ?></span></div>
<?php endif; ?>

<?php if ($nhansu->getNangSuat() > 0): ?>
	<div class="title congnhat">Lương cứng: <span>
			<?php echo number_format($nhansu->getCongNhat()); ?></span></div>
	<div class="title nangsuat">Năng suất: <span>
			<?php echo number_format($nhansu->getNangSuat()); ?></span></div>
	<div class="title luong">Lương: <span>
			<?php echo number_format($nhansu->getCongNhat()
									 + $nhansu->getNangSuat()); ?></span></div>
	<div class="title hieusuat">Hiệu Suất: <span>
			<?php echo number_format(
				max($nhansu->getHieuSuat(), $nhansu->getCongNhat() + $nhansu->getNangSuat())
			); ?></span></div>
	<div class="title doanhso">Doanh Số: <span>
			<?php echo number_format($nhansu->getDoanhSo()); ?></span></div>
<?php else: ?>
	<div class="title luong">Lương: <span>
			<?php echo number_format($nhansu->getCongNhat()); ?></span></div>
<?php endif; ?>
