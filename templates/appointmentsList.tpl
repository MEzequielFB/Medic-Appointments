<ul>
    {foreach from=$appointments item=appointment}
        <li class="appointment" id="appointment{$appointment->id}">
            <div class="doctorInfo">
                <div>
                    <h1>{$appointment->doctor_name}<h1>
                    <p>{$appointment->doctor_specialization}</p>
                </div>

                <img src="image/profile/{$appointment->doctor_image}">
            </div>

            <ul>
                <li>{$appointment->date}</li>
                <li>{$appointment->time}</li>
                <li>{$appointment->status}</li>
            </ul>

            <div class="appointmentBtns">
                <button>Cancel</button>
                <button>Reschedule</button>
            </div>
        </li>
    {/foreach}
</ul>