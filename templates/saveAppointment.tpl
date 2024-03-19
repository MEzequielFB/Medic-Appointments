{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}/css/global.css">
<link rel="stylesheet" href="{$baseUrl}/css/nav.css">
<link rel="stylesheet" href="{$baseUrl}/css/appointments.css">
<link rel="stylesheet" href="{$baseUrl}/css/dashboard.css">

<script src="{$baseUrl}/js/saveAppointment.js"></script>
<script src="{$baseUrl}js/nav.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<button class="doctorBtn" type="button">Choose a doctor</button>

{if $appointment eq null}
    <article class="chosenDoctor hidden">
    
    </article>

    <div class="dateDiv hidden">
        <h1>Date</h1>
        <input type="date" name="date" id="date" class="date">
    </div>
{else}
    <article class="chosenDoctor">
        <div>
            <div>
                <h1>Dr. {$appointment->doctor_name}</h1>
                <p>{$appointment->doctor_specialization}</p>
            </div>
            <p class="hospitalP">{$appointment->doctor_hospital}</p>
        </div>
        <img src="{$baseUrl}image/profile/{$appointment->doctor_image}" alt="doctor's image">
        <input type="hidden" name="doctorId" class="doctorId" value="{$appointment->doctor_id}">
    </article>

    <div class="dateDiv">
        <h1>Date</h1>
        <input type="date" name="date" id="date" class="date" value="{$appointment->date}">
    </div>
{/if}

{if $times eq null}
    <div class="timeDiv hidden">
        <h1>Available Times</h1>
        <ul class="times">

        </ul>
    </div>
{else}
    <div class="timeDiv">
        <h1>Available Times</h1>
        <ul class="times">
            {foreach from=$times item=time}
                <li>{$time->hour}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{if $appointment eq null}
    <button class="scheduleBtn" type="button">Schedule</button>
{else}
    <button class="rescheduleBtn" type="button">Reschedule</button>
{/if}
<p class="message"></p>

<div class="doctorsDiv">
    <img src="image/left-arrow.png" alt="left arrow" class="leftArrow">

    <h1>Doctors</h1>
    <input type="search" placeholder="name, specialization, hospital..." class="doctorSearch">

    <section class="doctorsSection">
        <div class="loader"></div>
    </section>
</div>