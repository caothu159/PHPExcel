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
		$this->setName($name)
			 ->setLuongCoBan($data['Luong co ban'])
			 ->setNangSuatCoBan($data['Nang suat co ban'])
			 ->setNangSuatMuc1($data['Nang suat muc 1'])
			 ->setNangSuatMuc2($data['Nang suat muc 2']);
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
			$xe_lai = explode('-', $xe_lai);
			if (in_array(strtolower($this->getName()), $xe_lai)) {
				$this->tuyen[$time]          = (isset($this->tuyen[$time]) && is_array($this->tuyen[$time]))
					? $this->tuyen[$time] : array();
				$this->tuyen[$time]['xe']    = $xe_bs;
				$this->tuyen[$time]['ti le'] = 1 / sizeof($xe_lai);
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
		$this->tuyen[$time]['nang suat'] = $ns[$this->tuyen[$time]['xe']];
		$ti_suat                         = $this->getNangSuatCoBan();
		if ($this->tuyen[$time]['nang suat'] > 20000) {
			$ti_suat = $this->getNangSuatMuc1();
		}
		if ($this->tuyen[$time]['nang suat'] > 45000) {
			$ti_suat = $this->getNangSuatMuc2();
		}
		$this->tuyen[$time]['luong'] = $this->tuyen[$time]['nang suat'];
		$this->tuyen[$time]['luong'] *= $ti_suat;
		$this->tuyen[$time]['luong'] *= $this->tuyen[$time]['ti le'];

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
