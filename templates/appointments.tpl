{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/appointments.css">
<link rel="stylesheet" href="{$baseUrl}css/dashboard.css">

<script src="{$baseUrl}js/nav.js"></script>
<script src="{$baseUrl}js/partialRenderAppointments.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<nav class="appointmentsNav">
    <button type="button" class="upcomingBtn selected">Upcoming</button>
    <button type="button" class="completedBtn">Completed</button>
    <button type="button" class="cancelledBtn">Cancelled</button>
</nav>

<div class="loader margin"></div>

<div class="upcomingAppointments hidden">
    {if $nearest neq null}
        <h2>Nearest visit</h2>
        <li class="appointment nearest" id="appointment{$nearest->id}">
            <div class="doctorInfo">
                <div>
                    <h1>{$nearest->doctor_name}<h1>
                    <p>{$nearest->doctor_specialization} - {$nearest->doctor_hospital}</p>
                </div>

                <img src="image/profile/{$nearest->doctor_image}">
            </div>

            <ul>
                <li>
                    <img src="{$baseUrl}/image/calendar.png" alt="calendar">
                    <p>{$nearest->date}</p>
                </li>
                <li>
                    <img src="{$baseUrl}/image/clock.png" alt="clock">
                    <p>{$nearest->time}</p>
                </li>
                <li class="">
                    <img src="{$baseUrl}/image/{$nearest->status_image}" alt="dot">
                    <p>{$nearest->status}</p>
                </li>
            </ul>

            <div class="appointmentBtns">
                <a href="{$baseUrl}appointment/{$nearest->id}/cancel">
                    <button type="button">Cancel</button>
                </a>
                <a href="{$baseUrl}appointment/{$nearest->id}/reschedule">
                    <button type="button" class="rescheduleButton">Reschedule</button>
                </a>
            </div>
        </li>
    {/if}

    {if $appointments|@count > 0}
        <h2>Future visits</h2>
        {include file="appointmentsList.tpl"}
    {else}
        <p class="appointmentsMessage">No appointments!</p>
    {/if}
</div>

<div class="completedAppointments hidden"></div>

<div class="cancelledAppointments hidden"></div>