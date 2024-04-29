document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    let baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    if (!baseUrl.includes("localhost")) {
        baseUrl = window.location.origin + "/";
    }
    console.log(baseUrl);

    const upcomingAppointments = document.querySelector(".upcomingAppointments");
    const completedAppointments = document.querySelector(".completedAppointments");
    const cancelledAppointments = document.querySelector(".cancelledAppointments");

    const upcomingBtn = document.querySelector(".upcomingBtn");
    const completedBtn = document.querySelector(".completedBtn");
    const cancelledBtn = document.querySelector(".cancelledBtn");

    const loader = document.querySelector(".loader");
    setTimeout(() => {
        loader.classList.add("hidden");
        upcomingAppointments.classList.remove("hidden");
    }, 500);

    upcomingBtn.addEventListener("click", async () => {
        if (upcomingAppointments.classList.contains("hidden")) {
            loader.classList.remove("hidden");
        }

        upcomingBtn.classList.add("selected");
        completedBtn.classList.remove("selected");
        cancelledBtn.classList.remove("selected");

        completedAppointments.classList.add("hidden");
        cancelledAppointments.classList.add("hidden");

        setTimeout(() => {
            loader.classList.add("hidden");
            upcomingAppointments.classList.remove("hidden");
        }, 500);
    });

    completedBtn.addEventListener("click", async () => {
        upcomingBtn.classList.remove("selected");
        completedBtn.classList.add("selected");
        cancelledBtn.classList.remove("selected");

        upcomingAppointments.classList.add("hidden");
        completedAppointments.classList.remove("hidden");
        cancelledAppointments.classList.add("hidden");

        completedAppointments.innerHTML = "<div class='loader margin'></div>";
        try {
            const response = await fetch(baseUrl + "api/appointment/completed");
            if (response.ok) {
                const appointments = await response.json();

                if (appointments.length == 0) {
                    completedAppointments.innerHTML = "<p class='appointmentsMessage'>No appointments!</p>";
                } else {
                    setTimeout(() => {
                        renderAppointments(appointments, "completedAppointments");
                    }, 500);
                }
            } else {
                completedAppointments.innerHTML = "<p>Error while fetching appointments</p>";
            }
        } catch (error) {
            console.error(error);
            completedAppointments.innerHTML = "<p>Error while fetching appointments</p>";
        }
    });

    cancelledBtn.addEventListener("click", async () => {
        upcomingBtn.classList.remove("selected");
        completedBtn.classList.remove("selected");
        cancelledBtn.classList.add("selected");

        upcomingAppointments.classList.add("hidden");
        completedAppointments.classList.add("hidden");
        cancelledAppointments.classList.remove("hidden");

        cancelledAppointments.innerHTML = "<div class='loader margin'></div>";
        try {
            const response = await fetch(baseUrl + "api/appointment/cancelled");
            if (response.ok) {
                const appointments = await response.json();

                if (appointments.length == 0) {
                    cancelledAppointments.innerHTML = "<p class='appointmentsMessage'>No appointments!</p>";
                } else {
                    setTimeout(() => {
                        renderAppointments(appointments, "cancelledAppointments");
                    }, 500);
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

        container.innerHTML += "<ul class='appointmentsList'></ul>";
        for (let appointment of appointments) {
            container.lastElementChild.innerHTML += `
            <li class="appointment" id="appointment${appointment.id}">
                <div class="doctorInfo">
                    <div>
                        <h1>${appointment.doctor_name}</h1>
                        <p>${appointment.doctor_specialization} - ${appointment.doctor_hospital}</p>
                        <p>Reason: ${appointment.reason}</p>
                    </div>

                    <img src="${appointment.doctor_image}">
                </div>

                <ul class='appointmentInfo'>
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
    }
});