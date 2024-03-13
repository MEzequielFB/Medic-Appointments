document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const doctorBtn = document.querySelector(".doctorBtn");
    doctorBtn.addEventListener("click", showDoctors);

    const doctorsDiv = document.querySelector(".doctorsDiv");
    const doctorsSection = document.querySelector(".doctorsSection");

    const leftArrow = document.querySelector(".leftArrow")
    leftArrow.addEventListener("click", hideDoctors);

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
            console.log(error);
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
            doctor.addEventListener("click", () => { // Choose doctor
                const chosenDoctor = document.querySelector(".chosenDoctor");
                chosenDoctor.innerHTML = doctor.innerHTML;

                const doctorId = doctor.className.charAt(doctor.className.length-1);
                chosenDoctor.innerHTML += `<input type="hidden" name="doctorId" class="doctorId" value="${doctorId}">`;

                chosenDoctor.classList.remove("hidden");
            });
        });
    }
});