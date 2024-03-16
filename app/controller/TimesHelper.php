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
                array_push($times, date("H:i:s", $currentTime));
            }
            $currentTime = $currentTime + 30 * 60;
        }
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