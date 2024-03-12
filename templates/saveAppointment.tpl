{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}/css/global.css">
<link rel="stylesheet" href="{$baseUrl}/css/nav.css">
<link rel="stylesheet" href="{$baseUrl}/css/appointments.css">
<script src="{$baseUrl}/js/doctors.js"></script>
</head>

<div class="container">
    {include file="header.tpl"}

    <button class="doctorBtn" type="button">Choose a doctor</button>

    <div class="dateDiv">
        <h1>Date</h1>
        <input type="date" name="date" id="date" class="date">
    </div>

    <div class="timeDiv">
        <h1>Time</h1>
        <ul>
            <li>12:00</li>
            <li>16:30</li>
            <li>11:00</li>
            <li>11:00</li>
            <li>11:00</li>
            <li>11:00</li>
            {* {foreach from=$times item=time}
                <li>{$time}</li>
            {/foreach} *}
        </ul>
    </div>

    <button class="scheduleBtn" type="button">Schedule</button>

    <div class="doctorsDiv">
        <img src="image/left-arrow.png" alt="left arrow" class="leftArrow">

        <h1>Doctors</h1>
        <input type="search" placeholder="name, specialization, hospital...">

        <section class="doctorsSection">
            {* <article>
                <div>
                    <h1>Dr. Here the Name</h1>
                    <p>Specialist in this</p>
                    <p>The hospital</p>
                </div>
                <div style="width:50%;height:100%;background-color:blue"></div>
            </article> *}
        </section>
    </div>
</div>
