<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='../css/global.css'>
    <link rel='stylesheet' href='../css/nav.css'>
    <link rel='stylesheet' href='../css/doctors.css'>
    <link rel='stylesheet' href='../css/appointments.css'>
    <link rel='stylesheet' href='../css/dashboard.css'>

    <script src='../js/nav.js'></script>
    <script src='../js/appointmentsSearch.js'></script>
</head>");

require_once __DIR__ . "/../templates/doctorsDiv.php";

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

echo("
<button class='doctorBtn' type='button'>Choose a doctor</button>
<article class='chosenDoctor hidden'>
    
</article>

<form class='appointmentsSearchForm'>
    <input type='search' placeholder='pacient's username' name='usernameSearch' id='usernameSearch' class='usernameSearch'>

    <div>
        <input type='date' name='dateSearch' id='dateSearch' class='dateSearch'>

        <div class='statusSearchContainer'>
            <label for='statusSearch'>Status:</label>
            <select name='statusSearch' id='statusSearch' class='statusSearch'>
                <option value=''></option>");
                foreach ($status as $s) {
                    echo "<option value='$s->id'>$s->name</option>";
                }
echo("
            </select>
        </div>
    </div>

    <button type='submit' class='appointmentSearchBtn'>Search</button>
</form>

<p class='message'></p>

<h1>Appointments</h1>
<ul class='appointments'>

</ul>");