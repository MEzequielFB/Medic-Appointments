<section class="dashboard">
    <img src="{$baseUrl}image/cross.png" alt="cross" class="cross">

    <div class="userInfo">
        <img src="{$baseUrl}image/profile/therapist.jpg" alt="profile image">
        <p>{$userUsername}</p>
    </div>

    <nav>
        <ul>
            <li><a href="{$baseUrl}appointments">HOME</a></li>

            {if $userRole eq "ADMIN" || $userRole eq "SUPER_ADMIN"}
                <li><a href="{$baseUrl}doctor/save">DOCTORS</a></li>
                <li><a href="{$baseUrl}hospital/save">HOSPITALS</a></li>
                <li><a href="{$baseUrl}specialization/save">SPECIALIZATIONS</a></li>
            {/if}

            <li><a>SETTINGS</a></li>
            <li><a href="{$baseUrl}logout">SIGN OUT</a></li>
        </ul>
    </nav>
</section>