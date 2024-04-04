<?php
echo("
<section class='dashboard'>
    <img src='image/cross.png' alt='cross' class='cross'>

    <div class='userInfo'>");
    if ($this->userImage != null && $this->userImage != "") {
        echo "<img src='image/profile/$this->userImage' alt='profile image'>";
    } else {
        echo "<img src='image/profile/default.jpg' alt='profile image'>";
    }
    echo("
        <p>$this->userUsername</p>
    </div>

    <nav>
        <ul>
            <li><a href='appointments'>HOME</a></li>");
            if ($this->userRole == "ADMIN" || $this->userRole == "SUPER_ADMIN") {
                echo("
                <li><a href='appointments/manage'>MANAGE APPOINTMENTS</a></li>
                <li><a href='users/manage'>MANAGE USERS</a></li>
                <li><a href='doctor/save'>DOCTORS</a></li>
                <li><a href='hospital/save'>HOSPITALS</a></li>
                <li><a href='specialization/save'>SPECIALIZATIONS</a></li>");
            }
echo("
            <li><a href='settings'>SETTINGS</a></li>
            <li><a href='logout'>SIGN OUT</a></li>
        </ul>
    </nav>
</section>");