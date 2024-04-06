<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='$this->baseUrl/css/global.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/nav.css'>
    <link rel='stylesheet' href='$this->baseUrl//css/doctors.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/save.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/dashboard.css'>

    <script src='$this->baseUrl/js/saveDoctor.js'></script>
    <script src='$this->baseUrl/js/nav.js'></script>
</head>");

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

echo("
<h1 class='pageHeader'>Save doctor</h1>

<form action='$this->baseUrl/doctor' method='post' enctype='multipart/form-data' class='saveDoctorForm'>
    <input type='text' name='fullname' id='fullname' placeholder='Fullname'>

    <label for='specialization'>Specialization:</label>
    <select name='specialization' id='specialization'>
        
    </select>

    <label for='hospital'>Hospital:</label>
    <select name='hospital' id='hospital'>

    </select>

    <label for='startTime'>Start time:</label>
    <input type='time' name='startTime' id='startTime'>

    <label for='endTime'>End time:</label>
    <input type='time' name='endTime' id='endTime'>
    
    <input type='file' name='image' id='image'>

    <div class='formBtns'>
        <button type='button' class='cancelBtn hidden'>Cancel</button>
        <button type='submit' class='saveBtn'>Save</button>
    </div>
</form>
<p class='errorMsg'>$errorMsg</p>

<p class='adviceMsg'>Click a doctor to edit it!</p>
<section class='doctorsSection'>");
    foreach ($doctors as $doctor) {
        echo("
        <article class='eligibleDoctor doctor$doctor->id'>
            <div>
                <div>
                    <h1>Dr. $doctor->fullname</h1>
                    <p>$doctor->specialization</p>
                </div>
                <p class='hospitalP'>$doctor->hospital</p>
            </div>
            <img src='$doctor->image' alt='doctor's image'>
        </article>");
    }
echo("
</section>");