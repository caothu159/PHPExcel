<?php

/**
 * Class ThoiGian
 */
class ThoiGian extends CI_Model
{
	const DATADIR = 'Data';

	/**
	 * @param       $dir
	 * @param array $ignored
	 *
	 * @return array
	 */
	public function list($ignored = array('.', '..'))
	{
		$files = array();
		foreach (array_diff(scandir(self::DATADIR), $ignored) as $file) {
			$files[$file] = filemtime(self::DATADIR.DIRECTORY_SEPARATOR.$file);
		}

		arsort($files);
		$files = array_keys($files);
		foreach ($files as $key => $file) {
			$files[$key] = '/salary/time'.DIRECTORY_SEPARATOR.$file;
		}

		return ($files) ? $files : array();
	}

}
