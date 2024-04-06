<?php
echo("
<section class='dashboard'>
    <img src='$this->baseUrl/image/cross.png' alt='cross' class='cross'>

    <div class='userInfo'>
        <img src='$this->userImage' alt='profile image'>
        <p>$this->userUsername</p>
    </div>

    <nav>
        <ul>
            <li><a href='appointments'>HOME</a></li>");
            if ($this->userRole == "ADMIN" || $this->userRole == "SUPER_ADMIN") {
                echo("
                <li><a href='$this->baseUrl/appointments/manage'>MANAGE APPOINTMENTS</a></li>
                <li><a href='$this->baseUrl/users/manage'>MANAGE USERS</a></li>
                <li><a href='$this->baseUrl/doctor/save'>DOCTORS</a></li>
                <li><a href='$this->baseUrl/hospital/save'>HOSPITALS</a></li>
                <li><a href='$this->baseUrl/specialization/save'>SPECIALIZATIONS</a></li>");
            }
echo("
            <li><a href='$this->baseUrl/settings'>SETTINGS</a></li>
            <li><a href='$this->baseUrl/logout'>SIGN OUT</a></li>
        </ul>
    </nav>
</section>");