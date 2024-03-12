document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const form = document.querySelector(".saveDoctorForm");
    const specializationSelect = document.querySelector("#specialization");
    const hospitalSelect = document.querySelector("#hospital");
    const errorMsgP = document.querySelector(".errorMsg");

    async function findAllSpecializations() {
        try {
            const response = await fetch(baseUrl + "api/specialization");
            if (response.ok) {
                const specializations = await response.json();
                return specializations;
            } else {
                errorMsgP.innerHTML = "Error while fetching specializations";
            }
        } catch (error) {
            console.error(error);
        }
    }

    async function findAllHospitals() {
        try {
            const response = await fetch(baseUrl + "api/hospital");
            if (response.ok) {
                const hospitals = await response.json();
                return hospitals;
            } else {
                errorMsgP.innerHTML = "Error while fetching hospitals";
            }
        } catch (error) {
            console.error(error);
        }
    }

    async function renderOptions() {
        try {
            const specializations = await findAllSpecializations();
            const hospitals = await findAllHospitals();

            specializationSelect.innerHTML = "";
            specializations.forEach(specialization => {
                specializationSelect.innerHTML += `
                    <option value="${specialization.id}">${specialization.name}</option>
                `;
            });

            hospitalSelect.innerHTML = "";
            hospitals.forEach(hospital => {
                hospitalSelect.innerHTML += `
                    <option value="${hospital.id}">${hospital.name}</option>
                `;
            });
        } catch (error) {
            console.error(error);
        }
    }

    renderOptions();
});