{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}/css/global.css">
<link rel="stylesheet" href="{$baseUrl}/css/nav.css">
<link rel="stylesheet" href="{$baseUrl}/css/appointments.css">
</head>

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