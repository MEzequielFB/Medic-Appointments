<section class="dashboard">
    <img src="{$baseUrl}image/cross.png" alt="cross" class="cross">

    <div class="userInfo">
        {if $userImage neq null && $userImage neq ""}
            <img src="{$baseUrl}image/profile/{$userImage}" alt="profile image">
        {else}
            <img src="{$baseUrl}image/profile/default.png" alt="profile image">
        {/if}
        <p>{$userUsername}</p>
    </div>

    <nav>
        <ul>
            <li><a href="{$baseUrl}appointments">HOME</a></li>

            {if $userRole eq "ADMIN" || $userRole eq "SUPER_ADMIN"}
                <li><a href="{$baseUrl}appointments/manage">MANAGE APPOINTMENTS</a></li>
                <li><a href="{$baseUrl}doctor/save">DOCTORS</a></li>
                <li><a href="{$baseUrl}hospital/save">HOSPITALS</a></li>
                <li><a href="{$baseUrl}specialization/save">SPECIALIZATIONS</a></li>
            {/if}

            <li><a href="{$baseUrl}settings">SETTINGS</a></li>
            <li><a href="{$baseUrl}logout">SIGN OUT</a></li>
        </ul>
    </nav>
</section>