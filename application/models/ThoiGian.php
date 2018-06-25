<?php

/**
 * Class ThoiGian
 */
class ThoiGian extends CI_Model
{
	const DATADIR = 'Data';

	/**
	 * @var bool|int
	 */
	private $time = false;

	/**
	 * @param array $ignored
	 *
	 * @return array
	 */
	public function list($ignored = array('.', '..'))
	{
		$files = array();
		foreach (array_diff(scandir(self::DATADIR), $ignored) as $file) {
			$files[$file] = '/salary/time'.DIRECTORY_SEPARATOR.$file;
		}

		return $files ? : array();
	}

	/**
	 * @param $time
	 *
	 * @return $this
	 */
	public function setTime($time)
	{
		$this->time = $time;

		return $this;
	}

	/**
	 * @return bool|int
	 */
	public function getTime()
	{
		return $this->time;
	}

}
