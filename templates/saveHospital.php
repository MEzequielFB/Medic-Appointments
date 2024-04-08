<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='$this->baseUrl/css/global.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/nav.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/save.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/hospitals.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/dashboard.css'>

    <script src='$this->baseUrl/js/nav.js'></script>
    <script src='$this->baseUrl/js/saveHospital.js'></script>
</head>");

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

echo("
<h1 class='pageHeader'>Save hospital</h1>

<form action='$this->baseUrl/hospital' method='post' class='saveHospitalForm'>
    <input type='text' name='name' id='name' placeholder='Name'>
    <input type='text' name='address' id='address' placeholder='Address'>

    <div class='formBtns'>
        <button type='button' class='cancelBtn hidden'>Cancel</button>
        <button type='submit' class='saveBtn'>Save</button>
    </div>
</form>
<p class='errorMsg'>$errorMsg</p>

<p class='adviceMsg'>Click a hospital to edit it!</p>
<section class='hospitalsSection'>");
    foreach ($hospitals as $hospital) {
        echo("
        <article class='eligibleHospital hospital$hospital->id'>
            <h1>$hospital->name</h1>
            <p>$hospital->address</p>
        </article>");
    }
echo("
</section>");