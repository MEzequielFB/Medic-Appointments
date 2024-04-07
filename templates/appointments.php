<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='css/global.css'>
    <link rel='stylesheet' href='css/nav.css'>
    <link rel='stylesheet' href='css/appointments.css'>
    <link rel='stylesheet' href='css/dashboard.css'>

    <script src='js/nav.js'></script>
    <script src='js/partialRenderAppointments.js'></script>
</head>");

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

echo("
<nav class='appointmentsNav'>
    <button type='button' class='upcomingBtn selected'>Upcoming</button>
    <button type='button' class='completedBtn'>Completed</button>
    <button type='button' class='cancelledBtn'>Cancelled</button>
</nav>

<div class='loader margin'></div>

<div class='upcomingAppointments hidden'>");
    if ($nearest != null) {
        echo("
        <h2>Nearest visit</h2>
        <li class='appointment nearest' id='appointment$nearest->id'>
            <div class='doctorInfo'>
                <div>
                    <h1>$nearest->doctor_name</h1>
                    <p>$nearest->doctor_specialization - $nearest->doctor_hospital</p>
                    <p>Reason: $nearest->reason</p>
                </div>

                <img src='$nearest->doctor_image'>
            </div>

            <ul>
                <li>
                    <img src='image/calendar.png' alt='calendar'>
                    <p>$nearest->date</p>
                </li>
                <li>
                    <img src='image/clock.png' alt='clock'>
                    <p>$nearest->time</p>
                </li>
                <li class=''>
                    <img src='image/$nearest->status_image' alt='dot'>
                    <p>$nearest->status</p>
                </li>
            </ul>");

        if ($nearest->status == "to be confirmed" || $nearest->status == "confirmed") {
            echo("
            <div class='appointmentBtns'>
                <a href='appointment/$nearest->id/cancel'>
                    <button type='button'>Cancel</button>
                </a>");
                if ($nearest->reason == "consultation") {
                    echo("
                    <a href='appointment/$nearest->id/reschedule'>
                        <button type='button' class='rescheduleButton'>Reschedule</button>
                    </a>");
                }
            echo("
            </div>");
        }
        echo("
        </li>");
    }

if (count($appointments) > 0) {
    echo "<h2>Future visits</h2>";
    require_once __DIR__ . "/../templates/appointmentsList.php";
} else {
    echo "<p class='appointmentsMessage'>No appointments!</p>";
}

echo("
</div>

<div class='completedAppointments hidden'></div>

<div class='cancelledAppointments hidden'></div>");