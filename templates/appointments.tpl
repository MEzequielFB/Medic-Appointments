{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/appointments.css">
<link rel="stylesheet" href="{$baseUrl}css/dashboard.css">

<script src="{$baseUrl}js/nav.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

{if $nearest neq null}
    <h2>Nearest visit</h2>
    <li class="appointment" id="appointment{$nearest->id}">
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

        {if $nearest->status eq "to be confirmed" || $nearest->status eq "confirmed"}
            <div class="appointmentBtns">
                <button>Cancel</button>
                <button>Reschedule</button>
            </div>
        {/if}
    </li>
{/if}

<h2>Future visits</h2>
{include file="appointmentsList.tpl"}