<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='$this->baseUrl/css/global.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/nav.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/doctors.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/appointments.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/dashboard.css'>

    <script src='$this->baseUrl/js/saveAppointment.js'></script>
    <script src='$this->baseUrl/js/nav.js'></script>
</head>");

require_once __DIR__ . "/../templates/doctorsDiv.php";

if ($this->userRole == "ADMIN" || $this->userRole == "SUPER_ADMIN") {
    require_once __DIR__ . "/../templates/usersDiv.php";
}

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

if ($appointment == null) {
    echo("
    <button class='doctorBtn' type='button'>Choose a doctor</button>
    <article class='chosenDoctor hidden'>
    
    </article>");
    if ($this->userRole == "ADMIN" || $this->userRole == "SUPER_ADMIN") {
        echo("
        <button class='userBtn' type='button'>Choose user</button>
        <article class='chosenUser hidden'>
    
        </article>");
    }
    echo("
    <div class='dateDiv hidden'>
        <h1>Date</h1>
        <input type='date' name='date' id='date' class='date'>
    </div>");
} else {
    if ($this->userRole == "USER") {
        echo "<button class='doctorBtn hidden' type='button'>Choose a doctor</button>";
    } else {
        echo "<button class='doctorBtn' type='button'>Choose a doctor</button>";
    }

    echo("
    <article class='chosenDoctor'>
        <div>
            <div>
                <h1>Dr. $appointment->doctor_name</h1>
                <p>$appointment->doctor_specialization</p>
            </div>
            <p class='hospitalP'>$appointment->doctor_hospital</p>
        </div>
        <img src='$appointment->doctor_image' alt='doctor's image'>
        <input type='hidden' name='doctorId' class='doctorId' value='$appointment->doctor_id'>
    </article>

    <div class='dateDiv'>
        <h1>Date</h1>
        <input type='date' name='date' id='date' class='date' value='$appointment->date'>
    </div>");
}

if ($times == null) {
    echo("
    <div class='timeDiv hidden'>
        <h1>Available Times</h1>
        <ul class='times'>

        </ul>
    </div>");
} else {
    echo("
    <div class='timeDiv'>
        <h1>Available Times</h1>
        <ul class='times'>");
            foreach ($times as $time) {
                echo "<li>$time->hour</li>";
            }
    echo("
        </ul>
    </div>");
}

if ($this->userRole == "ADMIN" || $this->userRole == "SUPER_ADMIN") {
    echo("
    <div class='sliderContainer'>
        <label for='duration'>Select duration:</label>
        <input type='range' name='duration' id='duration' min='30' max='1000' step='30' value='30'>
        <p class='durationP'><span class='durationValue'>30</span> minutes</p>
    </div>

    <input type='text' name='reason' id='reason' placeholder='reason of appointment'>");
}

if ($appointment == null) {
    echo "<button class='scheduleBtn' type='button'>Schedule</button>";
} else {
    echo "<button class='rescheduleBtn' type='button'>Reschedule</button>";
}

echo "<p class='message'></p>";