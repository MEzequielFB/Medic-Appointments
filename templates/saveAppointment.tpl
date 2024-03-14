{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}/css/global.css">
<link rel="stylesheet" href="{$baseUrl}/css/nav.css">
<link rel="stylesheet" href="{$baseUrl}/css/appointments.css">
<script src="{$baseUrl}/js/saveAppointment.js"></script>
</head>

<div class="container">
    {include file="header.tpl"}

    <button class="doctorBtn" type="button">Choose a doctor</button>
    <article class="chosenDoctor hidden">
        
    </article>

    <div class="dateDiv">
        <h1>Date</h1>
        <input type="date" name="date" id="date" class="date">
    </div>

    <div class="timeDiv">
        <h1>Available Times</h1>
        {* <input type="datetime-local" name="date" id="date" class="date"> *}
        <ul class="times">
            <li>11:00</li>
            <li>11:00</li>
            <li>11:00</li>
            <li>11:00</li>
        </ul>
    </div>

    <button class="scheduleBtn" type="button">Schedule</button>
    <p class="message"></p>

    <div class="doctorsDiv">
        <img src="image/left-arrow.png" alt="left arrow" class="leftArrow">

        <h1>Doctors</h1>
        <input type="search" placeholder="name, specialization, hospital...">

        <section class="doctorsSection">
            
        </section>
    </div>
</div>
