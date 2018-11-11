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
	 * @var array
	 */
	private $dataNangSuat = array();

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

		$allow = array(
			gethostbyname('dxvn.ddns.net'),
			gethostbyname('kho2.ddns.net'),
		); //allowed IPs

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $allow)) {
			header("HTTP/1.0 404 Not Found");
			exit();
		}

		if (isset($_SERVER["REMOTE_ADDR"]) && !in_array($_SERVER['REMOTE_ADDR'], $allow)) {
			header("HTTP/1.0 404 Not Found");
			exit();
		}

		$data = array_replace(
			array(
				'Luong co ban' => 0,
				'Ti le'        => 0.5,
				'Bat cap'      => '',
			), $data);
		$this->setName($name)
			 ->setLuongCoBan($data['Luong co ban'] ? : 0)
			 ->setDuLieuNangSuat($data)
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
		$cong = $cong >= 30 ? 30 : $cong;
		$cong += $this->getCongDem();
		$cong *= $this->getLuongCoBan() / 30;
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
	 * @return array|float|int
	 */
	public function getHieuSuat()
	{
		$hieuSuat = $this->getCongNhat();
		$hieuSuat += $this->getNangSuat();
		$hieuSuat /= $this->getCong();
		$hieuSuat *= 30;
		$hieuSuat = intval($hieuSuat);

		return $hieuSuat;
	}

	/**
	 * @return array|float|int
	 */
	public function getDoanhSo()
	{
		$doanhso = 0;
		foreach ($this->getTuyen() as $time => $ds) {
			$doanhso += $ds['nang suat xe'];
		}
		$doanhso = intval($doanhso);

		return $doanhso;
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
	 * @param $data
	 *
	 * @return $this
	 */
	public function setDuLieuNangSuat($data)
	{
		foreach ($data as $nangSuat => $tiLe) {
			if (!is_numeric($nangSuat) || !is_numeric($tiLe)) {
				continue;
			}
			$this->dataNangSuat[$nangSuat] = floatval($tiLe);
		}

		return $this;
	}

	/**
	 * @param $ns
	 *
	 * @return int|mixed
	 */
	public function getDuLieuNangSuat($ns)
	{
		$return = 0;
		foreach ($this->dataNangSuat as $nangSuat => $tiLe) {
			if (!is_numeric($nangSuat) || !is_numeric($ns)) {
				continue;
			}
			if ($ns > $nangSuat * 1000) {
				$return = max($return, $tiLe);
			}
		}

		return $return;
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

	public function getTileBatCap($lx)
	{
		if (sizeof($lx) !== 2) {
			return 1 / sizeof($lx);
		}

		$bc = $this->getBatCap();
		$bc = explode('|', $bc);
		foreach ($bc as $cap) {
			if (in_array(strtolower($cap), $lx)) {
				return $this->getTiLe();
			}

			$caplv2 = explode(':', trim($cap));

			if (sizeof($caplv2) == 2 && in_array(strtolower($caplv2[0]), $lx)) {
				return $caplv2[1];
			}
		}

		return 1 / sizeof($lx);
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
				$this->tuyen[$time]['ti le'] = $this->getTileBatCap($xe_lai);
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
		$this->tuyen[$time]['ti suat']      = $this->getDuLieuNangSuat($this->tuyen[$time]['nang suat']);
		$this->tuyen[$time]['luong']        = $this->tuyen[$time]['nang suat'];
		$this->tuyen[$time]['luong']        *= $this->tuyen[$time]['ti suat'];

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
