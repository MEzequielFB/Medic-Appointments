document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const doctorBtn = document.querySelector(".doctorBtn");
    doctorBtn.addEventListener("click", showDoctors);

    const scheduleBtn = document.querySelector(".scheduleBtn");
    scheduleBtn.addEventListener("click", saveAppointment);

    const doctorsDiv = document.querySelector(".doctorsDiv");
    const doctorsSection = document.querySelector(".doctorsSection");

    const leftArrow = document.querySelector(".leftArrow")
    leftArrow.addEventListener("click", hideDoctors);

    const chosenDoctor = document.querySelector(".chosenDoctor");
    const date = document.querySelector(".date");
    const messageP = document.querySelector(".message");

    async function showDoctors() {
        doctorsDiv.classList.add("visible");

        try {
            const response = await fetch(baseUrl + "api/doctor");
            if (response.ok) {
                const doctors = await response.json();
                console.log(doctors);
                renderDoctors(doctors);
            } else {
                doctorsSection.innerHTML = "<p>Error while fetching doctors</p>";
            }
        } catch (error) {
            console.error(error);
        }
    }

    function hideDoctors() {
        doctorsDiv.classList.remove("visible");
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

                try {
                    const response = await fetch(baseUrl + `api/doctor/${doctorId}/times`);
                    if (response.ok) {
                        const times = await response.json();
                        
                    } else {
                        messageP.innerHTML = "Error while fetching times";
                    }
                } catch (error) {
                    console.error(error);
                }

                chosenDoctor.classList.remove("hidden");
            });
        });
    }

    async function saveAppointment() {
        let emptyFields = [];

        const doctorId = chosenDoctor.lastElementChild;
        if (!doctorId) {
            emptyFields.push("doctor");
        }

        if (date.value == "") {
            emptyFields.push("date");
        }

        if (emptyFields.length != 0) {
            messageP.innerHTML = "The following fields are empty: " + emptyFields.join(", ");
        }

        console.log(emptyFields);

        let data = {
            "doctorId": doctorId,
            "date": date
        };

        try {
            const response = await fetch(baseUrl + "api/appointment", {
                "method": "POST",
                "headers": {
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify(data)
            });

            if (response.ok) {
                window.location.href = baseUrl + "appointments";
            } else {
                const message = await response.text();
                messageP.innerHTML = message;
                /* switch (response.status) {
                    case 404:
                        messageP.innerHTML = "The selected doctor is not available";
                        break;
                    case 400:
                        messageP.innerHTML = "The following fields are empty: " + response.statusText;
                        break;
                    case 500:
                        messageP.innerHTML = "Server Error";
                        break;
                    default:
                        break;
                } */
            }
        } catch (error) {
            console.error(error);
        }
    }
});