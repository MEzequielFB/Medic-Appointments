<?php
class TimesHelper {
    private $doctor;

    function __construct($doctor) {
        $this->doctor = $doctor;
    }

    public function getAvailableTimes($appointmentsTime) {
        $startTime = strtotime($this->doctor->start_time);
        $currentTime = $startTime;
        $endTime = strtotime($this->doctor->end_time);

        $times = [];

        while ($currentTime <= $endTime) {
            if (!$this->isSuperposed($currentTime, $appointmentsTime)) {
                $objectTime = new stdClass();
                $objectTime->hour = date("H:i", $currentTime);

                array_push($times, $objectTime);
            }
            $currentTime = $currentTime + 30 * 60;
        }

        return $times;
    }

    private function isSuperposed($time, $appointmentsTime) {
        foreach ($appointmentsTime as $appointmentTime) {
            $appointmentStartTime = strtotime($appointmentTime->hour);
            $appointmentEndTime = strtotime($appointmentTime->hour) + ($appointmentTime->duration * 60);

            if ($time >= $appointmentStartTime && $time < $appointmentEndTime) {
                return true;
            }
        }

        return false;
    }
}
?>