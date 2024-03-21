document.addEventListener("DOMContentLoaded", () => {
    "use  strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const pageHeader = document.querySelector(".pageHeader");
    const form = document.querySelector(".saveHospitalForm");
    const nameField = document.querySelector("#name");
    const addressField = document.querySelector("#address");
    const saveBtn = document.querySelector(".saveBtn");

    const cancelBtn = document.querySelector(".cancelBtn");
    cancelBtn.addEventListener("click", showHospitalSave);

    const hospitals = document.querySelectorAll(".eligibleHospital");
    for (let hospital of hospitals) {
        hospital.addEventListener("click", () => {
            const hospitalId = hospital.className.charAt(hospital.className.length-1);
            showHospitalEdit(hospitalId);
        });
    }

    function showHospitalSave() {
        pageHeader.innerHTML = "Save hospital";
        pageHeader.scrollIntoView({
            "behavior": "smooth",
            "block": "start"
        });

        nameField.value = "";
        addressField.value = "";
        cancelBtn.classList.add("hidden");
        saveBtn.innerHTML = "Save";

        form.action = baseUrl + "hospital";
    }

    async function showHospitalEdit(hospitalId) {
        pageHeader.innerHTML = "Edit hospital";
        pageHeader.scrollIntoView({
            "behavior": "smooth",
            "block": "start"
        });

        try {
            const response = await fetch(baseUrl + `api/hospital/${hospitalId}`);
            if (response.ok) {
                const hospital = await response.json();

                nameField.value = hospital.name;
                addressField.value = hospital.address;
                cancelBtn.classList.remove("hidden");
                saveBtn.innerHTML = "Edit";
                
                form.action = baseUrl + `hospital/${hospitalId}/update`;
            } else {
                const msg = await response.text();
                errorMsgP.innerHTML = msg;
            }
        } catch (error) {
            console.error(error);
            showHospitalSave();
        }
    }

});