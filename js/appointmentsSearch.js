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
                        <button type="button">Reschedule</button>
                    </a>
                </div>
            `;
        }
    }
});