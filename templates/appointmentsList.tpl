<ul>
    {foreach from=$appointments item=appointment}
        <li class="appointment" id="appointment{$appointment->id}">
            <div class="doctorInfo">
                <div>
                    <h1>{$appointment->doctor_name}<h1>
                    <p>{$appointment->doctor_specialization} - {$appointment->doctor_hospital}</p>
                </div>

                <img src="image/profile/{$appointment->doctor_image}">
            </div>

            <ul>
                <li>
                    <img src="{$baseUrl}/image/calendar.png" alt="calendar">
                    <p>{$appointment->date}</p>
                </li>
                <li>
                    <img src="{$baseUrl}/image/clock.png" alt="clock">
                    <p>{$appointment->time}</p>
                </li>
                <li class="">
                    <img src="{$baseUrl}/image/{$appointment->status_image}" alt="dot">
                    <p>{$appointment->status}</p>
                </li>
            </ul>

            {if $appointment->status eq "to be confirmed" || $appointment->status eq "confirmed"}
                <div class="appointmentBtns">
                    <a href="{$baseUrl}appointment/{$appointment->id}/cancel">
                        <button type="button">Cancel</button>
                    </a>
                    <a href="{$baseUrl}appointment/{$appointment->id}/reschedule">
                        <button type="button">Reschedule</button>
                    </a>
                </div>
            {/if}
        </li>
    {/foreach}
</ul>