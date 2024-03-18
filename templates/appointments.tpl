{include file="head.tpl"}
<link rel="stylesheet" href="css/global.css">
<link rel="stylesheet" href="css/nav.css">
<link rel="stylesheet" href="css/appointments.css">
<link rel="stylesheet" href="css/dashboard.css">

<script src="{$baseUrl}js/nav.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<h2>Future visits</h2>
{include file="appointmentsList.tpl"}