<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ini_set('html_errors', 1);
ini_set('memory_limit', -1);
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';

class stdObject extends StdClass
{}

class D_app_core extends stdObject
{
    public $_data = array();
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
    public function __set($property, $argument)
    {
        try {
            $this->_data[$property] = $argument;
        } catch (Exception $e) {
            printf('<pre>%s</pre>', $e);
        }
    }
    public function __unset($key)
    {
        unset($this->{$key});
    }
    public function _valid_file($path)
    {
        if (file_exists($path)) {
            return $path;
        }
        return false;
    }
}

class D_app_file extends D_app_core
{
    public $length = 1024;
    public $line   = 5;

    public function __construct()
    {
        if ($this->fileUploaded == 'ok' && $_FILES['fileToUpload']['name'] != null) {

            $target_dir  = 'Data/';
            $target_file = $_FILES['fileToUpload']['tmp_name'];
            $target_name = $target_dir . basename($_FILES['fileToUpload']['name']);

            if (file_exists($target_name)) {
                unlink($target_name);
            }
            move_uploaded_file($target_file, $target_name);
            header('Location: ' . $_SERVER['PHP_SELF']);
        }
    }

    public function _content()
    {
        $_content    = '';
        $objPHPExcel = PHPExcel_IOFactory::load($this->file);

        $sheet         = $objPHPExcel->getActiveSheet();
        $highestRow    = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $hasHeader     = false;

        echo '<table class="table table-hover table-condensed" style="white-space: nowrap;">';
        for ($row = 1; $row <= $highestRow; $row++) {
            $rowsData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                null,
                true,
                false);
            foreach ($rowsData as $rowData) {
                echo '<tr>';
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

                    if (!$hasHeader) {
                        printf('<th><small>%s</small></th>', $cellData);
                    } else {
                        echo sprintf('<td><small>%s</small></td>', $cellData);
                    }
                }

                echo '</tr>';
                if (!$hasHeader) {
                    $hasHeader = true;
                }
            }
        }

        echo '</table>';
        return $_content;
    }

    public function _contentRepair($content = '')
    {
        $content = nl2br($content);
        return $content;
    }

    public function isDownload()
    {
        return $this->download == 1 || $this->download == '1';
    }

    public function file_open()
    {
        $this->handle = fopen($this->file_text, 'w');
        stream_set_blocking($this->handle, 0);
        ob_start();
    }

    public function file_write($buffer = '')
    {
        usleep(50);
        if (flock($this->handle, LOCK_EX)) {
            fwrite($this->handle, $buffer);
        }
        flock($this->handle, LOCK_UN);
        return;
    }

    public function file_close()
    {
        $this->file_write(ob_get_clean());
        fclose($this->handle);
    }

    public function file_download()
    {
        ob_start();
        $this->sendHeaders($this->file_text);

        $objPHPExcel = PHPExcel_IOFactory::load($this->file);

        $sheet         = $objPHPExcel->getActiveSheet();
        $highestRow    = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $hasHeader     = false;

        for ($row = 1; $row <= $highestRow; $row++) {
            $rowsData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                null,
                true,
                false);
            foreach ($rowsData as $rowData) {
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

                    echo (sprintf("%s\t", $cellData));
                    ob_flush();
                    flush();
                }

                echo ("\r\n");
                ob_flush();
                flush();
            }
        }
        exit;
    }

    public function file_delete($path = '')
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->file_delete(realpath($path) . DIRECTORY_SEPARATOR . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

    public function sendHeaders($file, $type, $name = null)
    {
        if (empty($name)) {
            $name = basename($file);
        }
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: attachment; filename="' . $name . '";');
        header('Content-Type: ' . $type);
        header('Content-Length: ' . filesize($file));
    }
}

class D_app extends D_app_file
{
    protected $request;
    public function __construct()
    {
        parent::__construct();
        if (!$this->isDownload() && !$this->isDelete()) {
            $this->load('html/html.phtml');
        }


        if ($this->isDownload()) {
            $this->file_download();
        }
    }

    public function html()
    {
        $this->load('html/title.phtml');
        $this->load('html/files.phtml');
        if ($this->file) {
            $this->_content();
        }
    }

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
new D_app;
