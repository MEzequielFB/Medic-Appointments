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

<form action="{$baseUrl}appointments/search" method="post" class="appointmentsSearchForm">
    <input type="search" placeholder="username" class="appointmentSearch">

    <div>
        <input type="date" name="dateSearch" id="dateSearch" class="dateSearch">
        <select name="statusSearch" id="statusSearch" class="statusSearch">

        </select>
    </div>

    <button type="submit" class="appointmentSearchBtn">Search</button>
</form>

<p class="errorMsg"></p>

<h1>Appointments</h1>
<ul class="appointments">

</ul>

{include file="doctorsDiv.tpl"}