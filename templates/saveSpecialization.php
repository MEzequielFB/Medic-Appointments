<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='$this->baseUrl/css/global.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/nav.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/save.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/dashboard.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/hospitals.css'>

    <script src='$this->baseUrl/js/nav.js'></script>
    <script src='$this->baseUrl/js/saveSpecialization.js'></script>
</head>");

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

echo("
<h1 class='pageHeader'>Save specialization</h1>
<form action='$this->baseUrl/specialization' method='post' class='saveSpecializationForm'>
    <input type='text' name='name' id='name' placeholder='Specialization'>

    <div class='formBtns'>
        <button type='button' class='cancelBtn hidden'>Cancel</button>
        <button type='submit' class='saveBtn'>Save</button>
    </div>
</form>
<p class='errorMsg'>$errorMsg</p>

<p class='adviceMsg'>Click a specialization to edit it!</p>
<section class='specializationsSection'>");
    foreach ($specializations as $specialization) {
        echo("
        <article class='eligibleSpecialization specialization$specialization->id'>
            <h1>$specialization->name</h1>
        </article>");
    }
echo("
</section>");