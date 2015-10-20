<?php

namespace TimetablePusher\TimetablePusher;

class Hot
{

    protected $hotFormatArray;

    protected $periodColumnNum = 0;
    protected $startTimeColumnNum = 1;
    protected $endTimeColumnNum = 2;
    protected $mondayColumnNum = 3;

    protected $maxPeriodsAllowed = 10;

    public function __construct()
    {
        //
    }

    public function parseHotFormatJson($json)
    {
        $this->hotFormatArray = json_decode($json);
    }

    public function validateHotFormatData()
    {
        $errors = [];

        $rowCount = count($this->hotFormatArray);
        // Ensure that there are an even number of rows
        if ($rowCount % 2 !== 0) {
            $errors[] = "The submitted timetable is invalid. [Row count is odd]";
        }

        // Ensure that there is an allowed number of lessons
        if ($rowCount / 2 > $this->maxPeriodsAllowed) {
            $errors[] = "Only a maximum of {$this->maxPeriodsAllowed} periods are allowed.";
        }

        // Ensure time is in valid HH:MM format
        $timeRegex = "/^(2[0-3]|[01][0-9]):([0-5][0-9])$/";

        for ($rowNum = 0; $rowNum < $rowCount; $rowNum += 2) {
            $row = $this->hotFormatArray[$rowNum];

            if (!preg_match($timeRegex, $row[$this->startTimeColumnNum]) || !preg_match($timeRegex,
                    $row[$this->endTimeColumnNum])
            ) {
                $errors[] = "The submitted timetable is invalid. Ensure that all start and end times are in 'HH:MM' format.";
            }
        }

        // Ensure that period numbers have not been modified
        for ($rowNum = 0; $rowNum < $rowCount; $rowNum += 2) {
            $row = $this->hotFormatArray[$rowNum];
            if ($row[$this->periodColumnNum] !== ($rowNum / 2 + 1)) {
                $errors[] = "The submitted timetable is invalid. [Period numbers invalid]";
            }
        }

        // Ensure that lesson names exist where locations have been filled in
        for ($rowNum = 1; $rowNum < $rowCount; $rowNum += 2) {
            $row = $this->hotFormatArray[$rowNum];
            $previousRow = $this->hotFormatArray[$rowNum - 1];
            for ($columnNum = $this->mondayColumnNum; $columnNum < $this->mondayColumnNum + 7; $columnNum++) {
                if (strlen($row[$columnNum]) > 0 && strlen($previousRow[$columnNum]) === 0) {
                    $errors[] = "If you enter the location of a lesson, you must enter the name.";
                }
            }
        }

        if (count($errors) !== 0) {
            return $errors;
        }

        return true;
    }

    public function stringifyHotFormatData()
    {
        return json_encode($this->hotFormatArray);
    }

}