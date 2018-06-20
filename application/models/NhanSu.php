<?php

/**
 * Class NhanSu
 */
class NhanSu extends CI_Model
{
	/**
	 * @var string
	 */
	private $name = '';

	/**
	 * @var int
	 */
	private $luongCoBan = 3000;

	/**
	 * @var float
	 */
	private $nangSuatCoBan = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc1 = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc2 = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc3 = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc4 = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc5 = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc6 = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc7 = 0.1;

	/**
	 * @var float
	 */
	private $nangSuatMuc8 = 0.1;

	/**
	 * @var float
	 */
	private $tiLe = 0.5;

	/**
	 * @var float
	 */
	private $batCap = '';

	/**
	 * @var float
	 */
	private $cong = 0;

	/**
	 * @var float
	 */
	private $congDem = 0;

	/**
	 * @var array
	 */
	private $tuyen = array();

	/**
	 * NhanSu constructor.
	 *
	 * @param string|bool $name
	 * @param array       $data
	 */
	public function __construct(
		$name = false,
		$data = array()
	) {
		if (!$name) {
			return;
		}
		$data = array_replace(
			array(
				'Luong co ban'     => 0,
				'Nang suat co ban' => 0,
				'12.5'             => 0,
				'20'               => 0,
				'25'               => 0,
				'30'               => 0,
				'35'               => 0,
				'42.5'             => 0,
				'50'               => 0,
				'max'              => 0,
			), $data);
		$this->setName($name)
			 ->setLuongCoBan($data['Luong co ban'] ? : 0)
			 ->setNangSuatCoBan($data['Nang suat co ban'] ? : 0)
			 ->setNangSuatMuc1($data['12.5'] ? : 0)
			 ->setNangSuatMuc2($data['20'] ? : 0)
			 ->setNangSuatMuc3($data['25'] ? : 0)
			 ->setNangSuatMuc4($data['30'] ? : 0)
			 ->setNangSuatMuc5($data['35'] ? : 0)
			 ->setNangSuatMuc6($data['42.5'] ? : 0)
			 ->setNangSuatMuc7($data['50'] ? : 0)
			 ->setNangSuatMuc8($data['max'] ? : 0)
			 ->setTiLe($data['Ti le'] ? : 0.5)
			 ->setBatCap($data['Bat cap'] ? : '*');
	}

	/**
	 * @param array $chamCong
	 *
	 * @return $this
	 */
	public function setCongNhat($chamCong = array())
	{
		foreach ($chamCong as $time => $cong) {
			if (!isset($cong[$this->getName()])) {
				continue;
			}
			$cong = floatval($cong[$this->getName()]);
			if ($cong >= 2) {
				$this->addCong(1);
				$this->addCongDem($cong - 1);
			} else {
				$this->addCong($cong);
			}
		}

		return $this;
	}

	/**
	 * @return float|int
	 */
	public function getCongNhat()
	{
		$cong = $this->getCong();
		$cong = $cong >= 28 ? 28 : $cong;
		$cong += $this->getCongDem();
		$cong *= $this->getLuongCoBan() / 28;
		$cong = intval($cong);

		return $cong;
	}

	/**
	 * @return array
	 */
	public function getNangSuat()
	{
		$luong = 0;
		foreach ($this->getTuyen() as $time => $ns) {
			$luong += $ns['luong'];
		}
		$luong = intval($luong);

		return $luong;
	}

	/**
	 * @param array $phanCong
	 *
	 * @return $this
	 */
	public function setTuyen($phanCong = array())
	{
		foreach ($phanCong as $time => $xe) {
			$this->addTuyen($time, $xe);
		}

		return $this;
	}

	/**
	 * @param array $nangSuat
	 *
	 * @return $this
	 */
	public function setNangSuat($nangSuat = array())
	{
		foreach ($nangSuat as $time => $ns) {
			$this->addNangSuat($time, $ns);
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function setName(
		string $name
	) {
		$this->name = $name;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getLuongCoBan(): int
	{
		return $this->luongCoBan;
	}

	/**
	 * @param int $luongCoBan
	 *
	 * @return $this
	 */
	public function setLuongCoBan(
		int $luongCoBan
	) {
		$this->luongCoBan = $luongCoBan;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatCoBan(): float
	{
		return $this->nangSuatCoBan;
	}

	/**
	 * @param float $nangSuatCoBan
	 *
	 * @return $this
	 */
	public function setNangSuatCoBan(
		float $nangSuatCoBan
	) {
		$this->nangSuatCoBan = $nangSuatCoBan;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc1(): float
	{
		return $this->nangSuatMuc1;
	}

	/**
	 * @param float $nangSuatMuc1
	 *
	 * @return $this
	 */
	public function setNangSuatMuc1(
		float $nangSuatMuc1
	) {
		$this->nangSuatMuc1 = $nangSuatMuc1;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc2(): float
	{
		return $this->nangSuatMuc2;
	}

	/**
	 * @param float $nangSuatMuc2
	 *
	 * @return $this
	 */
	public function setNangSuatMuc2(
		float $nangSuatMuc2
	) {
		$this->nangSuatMuc2 = $nangSuatMuc2;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc3(): float
	{
		return $this->nangSuatMuc3;
	}

	/**
	 * @param float $nangSuatMuc3
	 *
	 * @return $this
	 */
	public function setNangSuatMuc3(float $nangSuatMuc3)
	{
		$this->nangSuatMuc3 = $nangSuatMuc3;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc4(): float
	{
		return $this->nangSuatMuc4;
	}

	/**
	 * @param float $nangSuatMuc4
	 *
	 * @return $this
	 */
	public function setNangSuatMuc4(float $nangSuatMuc4)
	{
		$this->nangSuatMuc4 = $nangSuatMuc4;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc5(): float
	{
		return $this->nangSuatMuc5;
	}

	/**
	 * @param float $nangSuatMuc5
	 *
	 * @return $this
	 */
	public function setNangSuatMuc5(float $nangSuatMuc5)
	{
		$this->nangSuatMuc5 = $nangSuatMuc5;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc6(): float
	{
		return $this->nangSuatMuc6;
	}

	/**
	 * @param float $nangSuatMuc6
	 *
	 * @return $this
	 */
	public function setNangSuatMuc6(float $nangSuatMuc6)
	{
		$this->nangSuatMuc6 = $nangSuatMuc6;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc7(): float
	{
		return $this->nangSuatMuc7;
	}

	/**
	 * @param float $nangSuatMuc7
	 *
	 * @return $this
	 */
	public function setNangSuatMuc7(float $nangSuatMuc7)
	{
		$this->nangSuatMuc7 = $nangSuatMuc7;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getNangSuatMuc8(): float
	{
		return $this->nangSuatMuc8;
	}

	/**
	 * @param float $nangSuatMuc8
	 *
	 * @return $this
	 */
	public function setNangSuatMuc8(float $nangSuatMuc8)
	{
		$this->nangSuatMuc8 = $nangSuatMuc8;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getTiLe(): float
	{
		return $this->tiLe;
	}

	/**
	 * @param float $tiLe
	 *
	 * @return $this
	 */
	public function setTiLe(float $tiLe)
	{
		$this->tiLe = $tiLe;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBatCap(): string
	{
		return $this->batCap;
	}

	/**
	 * @param string $batCap
	 *
	 * @return $this
	 */
	public function setBatCap(string $batCap)
	{
		$this->batCap = $batCap;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getCong(): float
	{
		return $this->cong;
	}

	/**
	 * @param float $cong
	 *
	 * @return $this
	 */
	public function setCong(float $cong)
	{
		$this->cong = $cong;

		return $this;
	}

	/**
	 * @param float $cong
	 *
	 * @return $this
	 */
	public function addCong(float $cong)
	{
		$this->cong += $cong;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getCongDem(): float
	{
		return $this->congDem;
	}

	/**
	 * @param float $congDem
	 *
	 * @return $this
	 */
	public function setCongDem(float $congDem)
	{
		$this->congDem = $congDem;

		return $this;
	}

	/**
	 * @param float $cong
	 *
	 * @return $this
	 */
	public function addCongDem(float $cong)
	{
		$this->congDem += $cong;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getTuyen(): array
	{
		return $this->tuyen;
	}

	/**
	 * @param $time
	 * @param $xe
	 *
	 * @return $this
	 */
	public function addTuyen($time, $xe)
	{
		foreach ($xe as $xe_bs => $xe_lai) {
			$xe_lai = strtolower($xe_lai);
			$xe_lai = explode('-', $xe_lai);
			if (in_array(strtolower($this->getName()), $xe_lai)) {
				$this->tuyen[$time]          = (isset($this->tuyen[$time]) && is_array($this->tuyen[$time]))
					? $this->tuyen[$time] : array();
				$this->tuyen[$time]['xe']    = trim($xe_bs, 'x');
				$this->tuyen[$time]['ti le'] = 1 / sizeof($xe_lai);

				if (sizeof($xe_lai) == 2 && in_array(strtolower($this->getBatCap()), $xe_lai)) {
					$this->tuyen[$time]['ti le'] = $this->getTiLe();
				}
			}

		}

		return $this;
	}

	/**
	 * @param $time
	 * @param $ns
	 *
	 * @return $this
	 */
	public function addNangSuat($time, $ns)
	{
		if (!isset($this->tuyen[$time]) || !is_array($this->tuyen[$time])) {
			return $this;
		}
		$this->tuyen[$time]['cho no']       = $ns['no '.$this->tuyen[$time]['xe']] ? : 0;
		$this->tuyen[$time]['thu no']       = $ns['thu no '.$this->tuyen[$time]['xe']] ? : 0;
		$this->tuyen[$time]['nang suat xe'] = $ns['ns '.$this->tuyen[$time]['xe']] ? : 0;
		$this->tuyen[$time]['nang suat']    = $ns['ns '.$this->tuyen[$time]['xe']] ? : 0;
		$this->tuyen[$time]['nang suat']    += $this->tuyen[$time]['cho no'] * 0.7;
		$this->tuyen[$time]['nang suat']    -= $this->tuyen[$time]['thu no'] * 0.7;
		$this->tuyen[$time]['nang suat']    *= $this->tuyen[$time]['ti le'] ? : 0;
		$ti_suat                            = $this->getNangSuatMuc1();
		switch (true) {

			case $this->tuyen[$time]['nang suat'] > 50000:
				$ti_suat = $this->getNangSuatMuc8();
				break;

			case $this->tuyen[$time]['nang suat'] > 42500:
				$ti_suat = $this->getNangSuatMuc7();
				break;

			case $this->tuyen[$time]['nang suat'] > 35000:
				$ti_suat = $this->getNangSuatMuc6();
				break;

			case $this->tuyen[$time]['nang suat'] > 30000:
				$ti_suat = $this->getNangSuatMuc5();
				break;

			case $this->tuyen[$time]['nang suat'] > 25000:
				$ti_suat = $this->getNangSuatMuc4();
				break;

			case $this->tuyen[$time]['nang suat'] > 20000:
				$ti_suat = $this->getNangSuatMuc3();
				break;

			case $this->tuyen[$time]['nang suat'] > 12500:
				$ti_suat = $this->getNangSuatMuc2();
				break;

			default:
				$ti_suat = $this->getNangSuatMuc1();
				break;
		}

		$this->tuyen[$time]['ti suat'] = $ti_suat;
		$this->tuyen[$time]['luong']   = $this->tuyen[$time]['nang suat'];
		$this->tuyen[$time]['luong']   *= $ti_suat;

		return $this;
	}

	/**
	 * @param $arg
	 */
	private function debug($arg)
	{
		echo '<pre>';
		print_r($arg);
		echo '</pre>';
	}
}
