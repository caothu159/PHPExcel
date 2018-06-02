<?php

/**
 * Class NhanSu
 */
class NhanSu extends CI_Model
{
	private $name          = '';
	private $luongCoBan    = 3000;
	private $nangSuatCoBan = 0.1;
	private $nangSuatMuc1  = 0.1;
	private $nangSuatMuc2  = 0.1;

	public function __construct()
	{
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
	 */
	public function setName(
		string $name
	) {
		$this->name = $name;
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
	 */
	public function setLuongCoBan(
		int $luongCoBan
	) {
		$this->luongCoBan = $luongCoBan;
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
	 */
	public function setNangSuatCoBan(
		float $nangSuatCoBan
	) {
		$this->nangSuatCoBan = $nangSuatCoBan;
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
	 */
	public function setNangSuatMuc1(
		float $nangSuatMuc1
	) {
		$this->nangSuatMuc1 = $nangSuatMuc1;
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
	 */
	public function setNangSuatMuc2(
		float $nangSuatMuc2
	) {
		$this->nangSuatMuc2 = $nangSuatMuc2;
	}
}
