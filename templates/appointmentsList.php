<?php
echo "<ul class='appointmentsList'>";
foreach ($appointments as $appointment) {
    echo("
    <li class='appointment' id='appointment$appointment->id'>
        <div class='doctorInfo'>
            <div>
                <h1>$appointment->doctor_name</h1>
                <p>$appointment->doctor_specialization - $appointment->doctor_hospital</p>
                <p>Reason: $appointment->reason</p>
            </div>

            <img src='$appointment->doctor_image'>
        </div>

        <ul class='appointmentInfo'>
            <li>
                <img src='image/calendar.png' alt='calendar'>
                <p>$appointment->date</p>
            </li>
            <li>
                <img src='image/clock.png' alt='clock'>
                <p>$appointment->time</p>
            </li>
            <li class=''>
                <img src='image/$appointment->status_image' alt='dot'>
                <p>$appointment->status</p>
            </li>
        </ul>");

        if ($appointment->status == "to be confirmed" || $appointment->status == "confirmed") {
            echo("
            <div class='appointmentBtns'>
                <a href='appointment/$appointment->id/cancel'>
                    <button type='button'>Cancel</button>
                </a>");
                if ($appointment->reason == "consultation") {
                    echo("
                    <a href='appointment/$appointment->id/reschedule'>
                        <button type='button' class='rescheduleButton'>Reschedule</button>
                    </a>");
                }
            echo("
            </div>");
        }
    echo("
    </li>");
}
echo("
</ul>");