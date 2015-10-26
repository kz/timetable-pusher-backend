<?php

namespace TimetablePusher\TimetablePusher;

use Carbon\Carbon;
use DateTime;
use Log;

class Hot
{

    protected $hotFormatArray;

    protected $periodColumnNum = 0;
    protected $startTimeColumnNum = 1;
    protected $endTimeColumnNum = 2;
    protected $mondayColumnNum = 3;
    protected $totalColumnCount = 10;

    protected $maxPeriodsAllowed = 10;

    public function __construct()
    {
        //
    }

    /**
     * @param $json
     */
    public function parseJson($json)
    {
        $this->hotFormatArray = json_decode($json);
    }

    /**
     * @return string
     */
    public function stringifyHotFormatArray()
    {
        return json_encode($this->hotFormatArray);
    }

    /**
     * @return array|bool
     */
    public function validateHotFormatData()
    {
        $errors = [];

        $rowCount = count($this->hotFormatArray);
        // Ensure that there are an even number of rows
        if ($rowCount % 2 !== 0) {
            $errors[] = "The submitted timetable is invalid. [Invalid row count]";
        }

        // Ensure that there is an allowed number of lessons
        if ($rowCount / 2 > $this->maxPeriodsAllowed) {
            $errors[] = "Only a maximum of {$this->maxPeriodsAllowed} periods are allowed.";
        }

        // Ensure time is in valid HH:MM format and ensure time is in correct order
        $timeRegex = "/^(2[0-3]|[01][0-9]):([0-5][0-9])$/";

        for ($rowNum = 0; $rowNum < $rowCount; $rowNum += 2) {
            $row = $this->hotFormatArray[$rowNum];

            if (!preg_match($timeRegex, $row[$this->startTimeColumnNum]) || !preg_match($timeRegex,
                    $row[$this->endTimeColumnNum])
            ) {
                $errors[] = "The submitted timetable is invalid. Ensure that all start and end times are in 'HH:MM' format.";
                break;
            } elseif (intval(preg_replace("/[^0-9]/", "",
                    $row[$this->startTimeColumnNum])) > intval(preg_replace("/[^0-9]/", "",
                    $row[$this->endTimeColumnNum]))
            ) {
                $errors[] = "The submitted timetable is invalid. Ensure that all end times are later than start times.";
                break;
            }
        }

        // Ensure that columns have not been modified
        $firstRow = $this->hotFormatArray[0];
        if (count($firstRow) !== $this->totalColumnCount) {
            $errors[] = "The submitted timetable is invalid. [Invalid column count]";
        }

        // Ensure that period numbers have not been modified
        for ($rowNum = 0; $rowNum < $rowCount; $rowNum += 2) {
            $row = $this->hotFormatArray[$rowNum];
            if ($row[$this->periodColumnNum] != ($rowNum / 2 + 1)) {
                $errors[] = "The submitted timetable is invalid. [Invalid period numbers]";
                break;
            }
        }

        // Ensure that lesson names exist where locations have been filled in
        for ($rowNum = 1; $rowNum < $rowCount; $rowNum += 2) {
            $row = $this->hotFormatArray[$rowNum];
            $previousRow = $this->hotFormatArray[$rowNum - 1];
            for ($columnNum = $this->mondayColumnNum; $columnNum < $this->mondayColumnNum + 7; $columnNum++) {
                if (strlen($row[$columnNum]) > 0 && strlen($previousRow[$columnNum]) === 0) {
                    $errors[] = "If you enter the location of a lesson, you must enter the name.";
                    break 2;
                }
            }
        }

        if (count($errors) !== 0) {
            return $errors;
        }

        return true;
    }

    /**
     * @return array
     */
    public function outputHotFormatToWebFormat()
    {
        $viewableRows = [];

        $hotFormatRowCount = count($this->hotFormatArray);

        for ($rowNum = 0; $rowNum < $hotFormatRowCount; $rowNum += 2) {
            $viewableRow = [];

            $currentRow = $this->hotFormatArray[$rowNum];
            $nextRow = $this->hotFormatArray[$rowNum + 1];

            // Period
            $viewableRow[] = e($currentRow[$this->periodColumnNum]);
            // Times
            $viewableRow[] = e($currentRow[$this->startTimeColumnNum]) . ' -<br />' . e($currentRow[$this->endTimeColumnNum]);
            // Monday to Sunday
            for ($columnNum = $this->mondayColumnNum; $columnNum < $this->mondayColumnNum + 7; $columnNum++) {
                if ($currentRow[$columnNum] !== "") {
                    $viewableRow[] = e($currentRow[$columnNum]) . '<br />' . e($nextRow[$columnNum]);
                } else {
                    $viewableRow[] = "";
                }
            }

            $viewableRows[] = $viewableRow;
        }

        return $viewableRows;
    }

    /**
     * @param Carbon $weekBeginning
     * @param int $offsetFromUTC
     * @return array
     */
    public function outputHotFormatToPinFormat(Carbon $weekBeginning, $offsetFromUTC = 0)
    {
        $hotFormat = $this->hotFormatArray; // $hotFormat[period][day]

        $days = [];

        // Add days
        for ($dayNum = $this->mondayColumnNum; $dayNum < $this->mondayColumnNum + 7; $dayNum++) {
            $day = [];

            // Add periods
            for ($periodNum = 0; $periodNum < count($hotFormat); $periodNum += 2) {
                $hotName = $hotFormat[$periodNum][$dayNum];

                // Skip empty periods
                if (str_replace(' ', '', $hotName) == "") {
                    continue;
                }

                $hotPeriod = $hotFormat[$periodNum][$this->periodColumnNum];
                $hotStartTime = $hotFormat[$periodNum][$this->startTimeColumnNum];
                $hotEndTime = $hotFormat[$periodNum][$this->endTimeColumnNum];
                $hotLocation = $hotFormat[$periodNum + 1][$dayNum];

                $startTime = Carbon::parse($hotStartTime);
                $endTime = Carbon::parse($hotEndTime);
                $carbon = $weekBeginning->copy();

                $lessonDateTime = $carbon->addDays($dayNum - $this->mondayColumnNum)
                    ->hour($startTime->hour)
                    ->minute($startTime->minute)
                    ->subMinutes($offsetFromUTC);

                dd($lessonDateTime);

                $day[] = [
                    'id' => '',
                    'time' => $lessonDateTime->format('Y-m-d\TH:i:s\Z'),
                    'duration' => $startTime->diffInMinutes($endTime),
                    'layout' => [
                        'type' => 'calendarPin',
                        'title' => $hotPeriod . ' - ' . $hotName,
                    ]
                ];

                if (!empty($hotLocation)) {
                    $day[count($day) - 1]['layout']['locationName'] = $hotLocation;
                }
            }

            $days[] = $day;
        }

        return $days;
    }

}