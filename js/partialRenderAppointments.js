document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const upcomingAppointments = document.querySelector(".upcomingAppointments");
    const completedAppointments = document.querySelector(".completedAppointments");
    const cancelledAppointments = document.querySelector(".cancelledAppointments");

    const upcomingBtn = document.querySelector(".upcomingBtn");
    upcomingBtn.addEventListener("click", async () => {
        upcomingAppointments.classList.remove("hidden");
        completedAppointments.classList.add("hidden");
        cancelledAppointments.classList.add("hidden");
    });

    const completedBtn = document.querySelector(".completedBtn");
    completedBtn.addEventListener("click", async () => {
        upcomingAppointments.classList.add("hidden");
        completedAppointments.classList.remove("hidden");
        cancelledAppointments.classList.add("hidden");

        try {
            const response = await fetch(baseUrl + "api/appointment/completed");
            if (response.ok) {
                const appointments = await response.json();

                if (appointments.length == 0) {
                    completedAppointments.innerHTML = "<p>No appointments!</p>";
                } else {
                    renderAppointments(appointments, "completedAppointments");
                }
            } else {
                completedAppointments.innerHTML = "<p>Error while fetching appointments</p>";
            }
        } catch (error) {
            console.error(error);
            completedAppointments.innerHTML = "<p>Error while fetching appointments</p>";
        }
    });

    const cancelledBtn = document.querySelector(".cancelledBtn");
    cancelledBtn.addEventListener("click", async () => {
        upcomingAppointments.classList.add("hidden");
        completedAppointments.classList.add("hidden");
        cancelledAppointments.classList.remove("hidden");

        try {
            const response = await fetch(baseUrl + "api/appointment/cancelled");
            if (response.ok) {
                const appointments = await response.json();

                if (appointments.length == 0) {
                    cancelledAppointments.innerHTML = "<p>No appointments!</p>";
                } else {
                    renderAppointments(appointments, "cancelledAppointments");
                }
            } else {
                cancelledAppointments.innerHTML = "<p>Error while fetching appointments</p>";
            }
        } catch (error) {
            console.error(error);
            cancelledAppointments.innerHTML = "<p>Error while fetching appointments</p>";
        }
    });

    function renderAppointments(appointments, containerClass) {
        const container = document.querySelector(`.${containerClass}`);

        container.innerHTML = "";

        container.innerHTML += "<ul>";
            for (let appointment of appointments) {
                container.innerHTML += `
                <li class="appointment" id="appointment${appointment.id}">
                    <div class="doctorInfo">
                        <div>
                            <h1>${appointment.doctor_name}<h1>
                            <p>${appointment.doctor_specialization} - ${appointment.doctor_hospital}</p>
                        </div>

                        <img src="image/profile/${appointment.doctor_image}">
                    </div>

                    <ul>
                        <li>
                            <img src="${baseUrl}/image/calendar.png" alt="calendar">
                            <p>${appointment.date}</p>
                        </li>
                        <li>
                            <img src="${baseUrl}/image/clock.png" alt="clock">
                            <p>${appointment.time}</p>
                        </li>
                        <li class="">
                            <img src="${baseUrl}/image/${appointment.status_image}" alt="dot">
                            <p>${appointment.status}</p>
                        </li>
                    </ul>
                </li>`;
            }
        container.innerHTML += "</ul>";
    }
});