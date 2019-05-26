<?php

/*
 * Copyright © 2019 Dxvn, Inc. All rights reserved.
 */

class ThoiGian extends CI_Model
{
    const DATADIR = DTPATH;

    /**
     * @var bool|int
     */
    private $years = false;

    /**
     * @var bool|int
     */
    private $year = false;

    /**
     * @var bool|int
     */
    private $month = false;

    /**
     * @param array $ignored
     *
     * @return array
     */
    public function years($ignored = ['.', '..'])
    {
        if ($this->years) {
            return $this->years ?: [];
        }

        $this->years = [];
        foreach (array_diff(scandir(self::DATADIR), $ignored) as $year) {
            $this->years[$year] = [];
            $this->years[$year]['path'] = '/salary/t'.DIRECTORY_SEPARATOR.$year;
            foreach (array_diff(scandir(self::DATADIR.DIRECTORY_SEPARATOR.$year), $ignored) as $month) {
                $this->years[$year][$month] = '/salary/t'
                                              .DIRECTORY_SEPARATOR.$year
                                              .DIRECTORY_SEPARATOR.$month;
            }
        }

        return $this->years ?: [];
    }

    /**
     * @param $year
     *
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return bool|int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param $month
     *
     * @return $this
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return bool|int
     */
    public function getMonth()
    {
        return $this->month;
    }
}
