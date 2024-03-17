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
                <li>
                    <img src="{$baseUrl}/image/status-to-be-confirmed.png" alt="dot">
                    <p>{$appointment->status}</p>
                </li>
            </ul>

            <div class="appointmentBtns">
                <button>Cancel</button>
                <button>Reschedule</button>
            </div>
        </li>
    {/foreach}
</ul>