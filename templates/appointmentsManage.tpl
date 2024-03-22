{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}/css/doctors.css">
<link rel="stylesheet" href="{$baseUrl}css/appointments.css">
<link rel="stylesheet" href="{$baseUrl}css/dashboard.css">

<script src="{$baseUrl}js/nav.js"></script>
<script src="{$baseUrl}js/appointmentsSearch.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<button class="doctorBtn" type="button">Choose a doctor</button>
<article class="chosenDoctor hidden">
    
</article>

<form class="appointmentsSearchForm">
    <input type="search" placeholder="username" name="usernameSearch" id="usernameSearch" class="usernameSearch">

    <div>
        <input type="date" name="dateSearch" id="dateSearch" class="dateSearch">
        <select name="statusSearch" id="statusSearch" class="statusSearch">
            <option value=""></option>
            {foreach from=$status item=s}
                <option value="{$s->id}">{$s->name|capitalize}</option>
            {/foreach}
        </select>
    </div>

    <button type="submit" class="appointmentSearchBtn">Search</button>
</form>

<p class="message"></p>

<h1>Appointments</h1>
<ul class="appointments">

</ul>

{include file="doctorsDiv.tpl"}