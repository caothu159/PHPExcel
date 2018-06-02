<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ini_set('html_errors', 1);
ini_set('memory_limit', -1);
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once dirname(__FILE__).'/Classes/PHPExcel/IOFactory.php';

/**
 * Class stdObject
 */
class stdObject extends StdClass
{
}

/**
 * Class D_app_core
 */
class D_app_core extends stdObject
{
	/**
	 * @var array
	 */
	public $_data = array();

	/**
	 * @param $property
	 *
	 * @return bool|mixed
	 */
	public function __get($property)
	{
		$return = false;
		if ($property == 'file_title') {
			$_file_title      = $this->file;
			$_file_title      = str_replace('Data/', '', $_file_title);
			$_file_title      = str_replace('.xlsx', '', $_file_title);
			$this->file_title = $_file_title;
		}
		if ($property == 'file_text') {
			$_file_text      = $this->file;
			$_file_text      = str_replace('.xlsx', '.txt', $_file_text);
			$this->file_text = $_file_text;
		}
		if (isset($this->_data[$property])) {
			$return = $this->_data[$property];
		}
		if (filter_input(INPUT_POST, $property)) {
			$return = filter_input(INPUT_POST, $property);
		}
		if (filter_input(INPUT_GET, $property)) {
			$return = filter_input(INPUT_GET, $property);
		}
		if (filter_input(INPUT_SERVER, $property)) {
			$return = filter_input(INPUT_SERVER, $property);
		}
		if ($return) {
			$_method_valid = "_valid_$property";
			if (function_exists($_method_valid) || method_exists($this, $_method_valid)) {
				return $this->{$_method_valid}($return);
			}

			return $return;
		}

		return $return;
	}

	/**
	 * @param $property
	 * @param $argument
	 */
	public function __set($property, $argument)
	{
		try {
			$this->_data[$property] = $argument;
		} catch (Exception $e) {
			printf('<pre>%s</pre>', $e);
		}
	}

	/**
	 * @param $key
	 */
	public function __unset($key)
	{
		unset($this->{$key});
	}

	/**
	 * @param $path
	 *
	 * @return bool
	 */
	public function _valid_file($path)
	{
		if (file_exists($path)) {
			return $path;
		}

		return false;
	}

	/**
	 * @param $arg
	 */
	protected function debug($arg)
	{
		echo '<pre>';
		print_r($arg);
		echo '</pre>';
	}
}

/**
 * Class D_app_file
 */
class D_app_file extends D_app_core
{
	public $length = 1024;
	public $line   = 5;

	/**
	 * D_app_file constructor.
	 */
	public function __construct()
	{
		if ($this->fileUploaded == 'ok' && $_FILES['fileToUpload']['name'] != null) {

			$target_dir = 'Data/';
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}

			$target_file = $_FILES['fileToUpload']['tmp_name'];
			$target_name = $target_dir.basename($_FILES['fileToUpload']['name']);

			if (file_exists($target_name)) {
				unlink($target_name);
			}
			move_uploaded_file($target_file, $target_name);
			header('Location: '.$_SERVER['PHP_SELF']);
		}
	}

	/**
	 * @return string
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	public function _content()
	{
		$objPHPExcel   = PHPExcel_IOFactory::load($this->file);
		$sheet         = $objPHPExcel->getActiveSheet();
		$highestRow    = $sheet->getHighestRow();
		$highestColumn = $this->_getHighestColumn($sheet);
		$isHeader      = true;
		$_content      = '';

		$_content = '<table class="table table-hover table-condensed" style="white-space: nowrap;">';
		for ($row = 1; $row <= $highestRow; $row++) {
			$rowsData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,
											 null,
											 true,
											 false,
											 true);
			foreach ($rowsData as $rowData) {
				$_content .= '<tr>';
				foreach ($rowData as $cellRef => $cellData) {
					$cellData = $this->_contentRepair($cellData);

					if (!$isHeader) {
						$_content .= sprintf('<td><small>%s</small></td>', $cellData);
					} else {
						$_content .= sprintf('<th><small>[%s]%s</small></th>', $cellRef, $cellData);
					}
				}

				$_content .= '</tr>';
				if ($isHeader) {
					$isHeader = false;
				}
			}
		}

		$_content .= '</table>';

		return $_content;
	}

	/**
	 * @param $file
	 *
	 * @return array
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	protected function fileContent($file)
	{
		$excel      = PHPExcel_IOFactory::load($file);
		$sheet      = $excel->getActiveSheet();
		$highestRow = $sheet->getHighestRow();
		$isHeader   = true;
		$content    = array();
		$cols       = array();

		for ($row = 1; $row <= $highestRow; $row++) {

			$rowData = $this->rowContent($sheet, $row);
			foreach ($rowData as $cells) {

				foreach ($cells as $cellRef => $cellData) {
					if ($cellRef == 'A') {
						continue;
					}
					$cellData = $this->_contentRepair($cellData);

					if (!$isHeader) {
						$content[$cells['A']][$cols[$cellRef]] = $cellData;
					} else {
						$cols[$cellRef] = $cellData;
					}
				}

				$isHeader = false;
			}
		}

		return $content;
	}

	/**
	 * @param $sheet
	 * @param $row
	 *
	 * @return mixed
	 */
	protected function rowContent($sheet, $row)
	{
		$highestColumn = $this->_getHighestColumn($sheet);

		return $sheet->rangeToArray(
			'A'.$row.':'.$highestColumn.$row,
			null,
			true,
			false,
			true
		);
	}

	/**
	 * @param $sheet
	 *
	 * @return int|string
	 */
	protected function _getHighestColumn($sheet)
	{
		$highestColumn = $sheet->getHighestColumn();
		$headerRow     = 1;
		$rowsData      = $sheet->rangeToArray('A'.$headerRow.':'.$highestColumn.$headerRow,
											  null,
											  true,
											  false,
											  true);
		foreach ($rowsData as $rowData) {
			foreach ($rowData as $cellRef => $cellData) {
				$cellData = $this->_contentRepair($cellData);
				if (empty($cellData)
					|| is_null($cellData)
					|| $cellData == ''
				) {
					continue;
				}
				$highestColumn = $cellRef;
			}
		}

		return $highestColumn;
	}

	/**
	 * @param string $content
	 *
	 * @return array|null|string|string[]
	 */
	public function _contentRepair($content = '')
	{
		$content = explode(PHP_EOL, trim($content));
		$content = array_filter($content, function ($value) {
			return trim($value) !== '';
		});
		$content = implode(', ', $content);
		$content = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $content);
		$content = preg_replace('/[\x00-\x1F\x7F]/', '', $content);
		$content = preg_replace('/[\x00-\x1F\x7F]/u', '', $content);
		$content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $content);
		$content = nl2br($content);

		return $content;
	}

	/**
	 * @return bool
	 */
	public function isDownload()
	{
		return $this->download == 1 || $this->download == '1';
	}

	/**
	 * @return bool
	 */
	public function isDelete()
	{
		return $this->delete == 1 || $this->delete == '1';
	}

	/**
	 *
	 */
	public function file_open()
	{
		$this->handle = fopen($this->file_text, 'w');
		stream_set_blocking($this->handle, 0);
		ob_start();
	}

	/**
	 * @param string $buffer
	 */
	public function file_write($buffer = '')
	{
		usleep(50);
		if (flock($this->handle, LOCK_EX)) {
			fwrite($this->handle, $buffer);
		}
		flock($this->handle, LOCK_UN);

		return;
	}

	/**
	 *
	 */
	public function file_close()
	{
		$this->file_write(ob_get_clean());
		fclose($this->handle);
	}

	/**
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	public function file_download()
	{
		ob_start();
		$this->sendHeaders($this->file_text);

		$objPHPExcel = PHPExcel_IOFactory::load($this->file);

		$sheet         = $objPHPExcel->getActiveSheet();
		$highestRow    = $sheet->getHighestRow();
		$highestColumn = $this->_getHighestColumn($sheet);

		for ($row = 1; $row <= $highestRow; $row++) {
			$rowsData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,
											 null,
											 true,
											 false);
			foreach ($rowsData as $rowData) {
				$_rowContent = array();
				foreach ($rowData as $cellData) {
					$cellData = explode(PHP_EOL, trim($cellData));
					$cellData = array_filter($cellData, function ($value) {
						return trim($value) !== '';
					});
					$cellData = implode(', ', $cellData);
					$cellData = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $cellData);
					$cellData = preg_replace('/[\x00-\x1F\x7F]/', '', $cellData);
					$cellData = preg_replace('/[\x00-\x1F\x7F]/u', '', $cellData);
					$cellData = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $cellData);
					$cellData = nl2br($cellData);

					array_push($_rowContent, $cellData);
				}
				$_rowContent = implode("\t", $_rowContent);
				$this->_file_download(sprintf("%s\r\n", $_rowContent));
			}
		}
		exit;
	}

	/**
	 * @param $content
	 */
	protected function _file_download($content)
	{
		echo $content;
		ob_flush();
		flush();
	}

	/**
	 *
	 */
	public function file_delete()
	{
		if (is_file($this->file_text)) {
			$this->_file_delete($this->file_text);
		}
		if (is_file($this->file)) {
			$this->_file_delete($this->file);
		}
		header('Location: '.$_SERVER['PHP_SELF']);
	}

	/**
	 * @param string $path
	 *
	 * @return bool
	 */
	protected function _file_delete($path = '')
	{
		if (is_dir($path) === true) {
			$files = array_diff(scandir($path), array('.', '..'));

			foreach ($files as $file) {
				$this->_file_delete(realpath($path).DIRECTORY_SEPARATOR.$file);
			}

			return rmdir($path);
		} else {
			if (is_file($path) === true) {
				return unlink($path);
			}
		}

		return false;
	}

	/**
	 * @param       $dir
	 * @param array $ignored
	 *
	 * @return array
	 */
	public function files($dir, $ignored = array('.', '..'))
	{
		$files = array();
		foreach (array_diff(scandir($dir), $ignored) as $file) {
			$files[$file] = filemtime($dir.DIRECTORY_SEPARATOR.$file);
		}

		arsort($files);
		$files = array_keys($files);
		foreach ($files as $key => $file) {
			$files[$key] = $dir.DIRECTORY_SEPARATOR.$file;
		}

		return ($files) ? $files : array();
	}

	/**
	 * @param $bytes
	 *
	 * @return string
	 */
	public function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2).' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2).' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2).' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes.' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes.' byte';
		} else {
			$bytes = '0 bytes';
		}

		return $bytes;
	}

	/**
	 * @param $file
	 */
	public function sendHeaders($file)
	{
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: attachment; filename="'.basename($file).'";');
		header('Content-Type: text/plain');
	}
}

/**
 * Class DappSalary
 */
class DappSalary extends D_app_file
{
	protected $nangsuat = array();
	protected $chamcong = array();
	protected $phancong = array();
	protected $nhanvien = array();

	/**
	 * DappSalary constructor.
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	public function __construct()
	{
		$this->nangsuat = $this->nangsuat();
		$this->chamcong = $this->chamcong();
		$this->phancong = $this->phancong();
		$this->nhanvien = $this->nhanvien();
	}

	/**
	 *
	 */
	protected function salary()
	{
		foreach ($this->chamcong as $time => $chamcong) {

			$unixTime = ($time - 25569) * 86400;

			echo date('d/m/Y', $unixTime);
		}

		$this->debug($this->nhanvien);

		$this->debug($this->chamcong);
		$this->debug($this->phancong);
		$this->debug($this->nangsuat);
	}

	/**
	 *
	 */
	public function salaryHtml()
	{
		return $this->salary();
	}

	/**
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	private function nangsuat()
	{
		return $this->fileContent($this->getDir('nangsuat.xlsx'));
	}

	/**
	 * @return array
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	private function chamcong()
	{
		return $this->fileContent($this->getDir('chamcong.xlsx'));
	}

	/**
	 * @return array
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	private function phancong()
	{
		return $this->fileContent($this->getDir('phancong.xlsx'));
	}

	/**
	 * @return array
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	private function nhanvien()
	{
		return $this->fileContent($this->getDir('nhanvien.xlsx'));
	}

	/**
	 * @param string $file
	 *
	 * @return string
	 */
	private function getDir($file = '')
	{
		return 'Data'.DIRECTORY_SEPARATOR.$this->time.DIRECTORY_SEPARATOR.$file;
	}
}

/**
 * Class D_app
 */
class Dapp extends DappSalary
{
	protected $request;

	/**
	 * D_app constructor.
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	public function __construct()
	{
		parent::__construct();
		if (!$this->isDownload() && !$this->isDelete()) {
			$this->load('html/html.phtml');
		}

		if ($this->isDelete()) {
			$this->file_delete();
		}

		if ($this->isDownload()) {
			$this->file_download();
		}
	}

	/**
	 * @throws \PHPExcel_Exception
	 * @throws \PHPExcel_Reader_Exception
	 */
	public function html()
	{
		$this->load('html/title.phtml');
		$this->load('html/files.phtml');
		if ($this->time) {
			$this->salaryHtml();
		}
	}

	/**
	 * @param string $path
	 */
	public function load($path = '')
	{
		try {
			if (file_exists($path)) {
				include $path;
			}
		} catch (Exception $e) {
			printf('<pre>%s</pre>', $e);
		}
	}
}

new Dapp;
