document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const chosenDoctor = document.querySelector(".chosenDoctor");
    const doctorsDiv = document.querySelector(".doctorsDiv");
    const doctorsSection = document.querySelector(".doctorsSection");

    const leftArrow = document.querySelector(".leftArrow")
    leftArrow.addEventListener("click", hideDoctors);

    const doctorBtn = document.querySelector(".doctorBtn");
    doctorBtn.addEventListener("click", showDoctors);

    const doctorSearch = document.querySelector(".doctorSearch");
    doctorSearch.addEventListener("input", searchDoctors);

    const messageP = document.querySelector(".message");
    const appointmentsList = document.querySelector(".appointments");

    const searchForm = document.querySelector(".appointmentsSearchForm");
    searchForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (!chosenDoctor.classList.contains("hidden")) {
            const data =  {
                "username": document.querySelector(".usernameSearch").value,
                "date": document.querySelector(".dateSearch").value,
                "statusId": document.querySelector(".statusSearch").value,
                "doctorId": document.querySelector(".doctorId").value // Hidden input value from chosenDoctor
            }

            try {
                const response = await fetch(baseUrl + "api/appointment/search", {
                    "method": "POST",
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "body": JSON.stringify(data)
                });

                if (response.ok) {
                    const appointments = await response.json();
                    renderAppointments(appointments);

                    messageP.innerHTML = "";
                } else {
                    messageP.innerHTML = "Error while fetching appointments";
                }
            } catch (error) {
                console.log(error);
                const message = await response.text();
                messageP.innerHTML = message;
            }
        } else {
            messageP.innerHTML = "Please choose a doctor";
        }
        
    });

    function hideDoctors() {
        doctorsDiv.classList.remove("visible");
    }

    async function showDoctors() {
        doctorsSection.innerHTML = "<div class='loader'></div>"
        doctorsDiv.classList.add("visible");

        try {
            const response = await fetch(baseUrl + "api/doctor");
            if (response.ok) {
                const doctors = await response.json();
                console.log(doctors);

                setTimeout(() => {
                    renderDoctors(doctors);
                }, 1000);
            } else {
                doctorsSection.innerHTML = "<p class='message'>Error while fetching doctors</p>";
            }
        } catch (error) {
            console.error(error);
        }
    }

    function renderDoctors(doctors) {
        doctorsSection.innerHTML = "";
        doctors.forEach(doctor => {
            doctorsSection.innerHTML += `
            <article class="eligibleDoctor doctor${doctor.id}">
                <div>
                    <div>
                        <h1>Dr. ${doctor.fullname}</h1>
                        <p>${doctor.specialization}</p>
                    </div>
                    <p class="hospitalP">${doctor.hospital}</p>
                </div>
                <img src="${baseUrl}image/profile/${doctor.image}" alt="doctor's image">
            </article>`;
        });

        addDoctorsBehavior();
    }

    function addDoctorsBehavior() {
        const doctors = document.querySelectorAll(".eligibleDoctor");
        doctors.forEach(doctor => {
            doctor.addEventListener("click", async () => { // Choose doctor
                chosenDoctor.innerHTML = doctor.innerHTML;
                const doctorId = doctor.className.charAt(doctor.className.length-1);
                chosenDoctor.innerHTML += `<input type="hidden" name="doctorId" class="doctorId" value="${doctorId}">`;

                chosenDoctor.classList.remove("hidden");
                doctorsDiv.classList.remove("visible");

                try {
                    const response = await fetch(baseUrl + `api/appointment/doctor/${doctorId}`);
                    if (response.ok) {
                        const appointments = await response.json();
                        console.log(appointments);

                        renderAppointments(appointments);

                        messageP.innerHTML = "";
                    } else {
                        const message = await response.text();
                        messageP.innerHTML = message;
                    }
                } catch (error) {
                    console.error(error);
                    messageP.innerHTML = "Error while fetching appointments";
                }
            });
        });
    }

    async function searchDoctors() {
        doctorsSection.innerHTML = "<div class='loader'></div>"
        const data = {
            "filter": doctorSearch.value
        };

        try {
            const response = await fetch(baseUrl + "api/doctor/search", {
                "method": "POST",
                "headers": {
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify(data)
            });
            if (response.ok) {
                const doctors = await response.json();

                if (doctors.length == 0) {
                    doctorsSection.innerHTML = "<p>No doctors found</p>";
                } else {
                    setTimeout(() => {
                        renderDoctors(doctors);
                    }, 1000);
                }
            } else{
                const message = await response.text();
                messageP.innerHTML = message;
            }
        } catch (error) {
            console.error(error);
            messageP.innerHTML = "Error while fetching doctors";
        }
    }

    function renderAppointments(appointments) {
        appointmentsList.innerHTML = "";
        for (let appointment of appointments) {
            appointmentsList.innerHTML += `
                <li class="appointment" id="appointment${appointment.id}">
                    <div class="doctorInfo">
                        <div>
                            <h1>${appointment.doctor_name}</h1>
                            <p>${appointment.doctor_specialization} - ${appointment.doctor_hospital}</p>
                            <p>Pacient: ${appointment.user_username}</p>
                            <p>Reason: ${appointment.reason}</p>
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
                </li>
            `;

            createButtons(appointment);
        }
    }

    function createButtons(appointment) {
        const appointmentLi = appointmentsList.lastElementChild;
        if (appointment.status == "to be confirmed" || appointment.status == "confirmed") {
            appointmentLi.innerHTML += `
                <div class="appointmentBtns">
                    <a href="${baseUrl}appointment/${appointment.id}/cancel">
                        <button type="button">Cancel</button>
                    </a>
                    <a href="${baseUrl}appointment/${appointment.id}/reschedule">
                        <button type="button" class="rescheduleButton">Reschedule</button>
                    </a>
                </div>
            `;
        }

        if (appointment.status == "to be confirmed") {
            appointmentLi.lastElementChild.innerHTML += `
                <a href="${baseUrl}appointment/${appointment.id}/confirm">
                    <button type="button" class="confirmButton">Confirm</button>
                </a>
            `
        }
    }
});