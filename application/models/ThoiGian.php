<?php

/**
 * Class ThoiGian
 */
class ThoiGian extends CI_Model
{
	const DATADIR = 'Data';

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

}
