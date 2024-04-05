document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    let baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    if (!baseUrl.includes("localhost")) {
        baseUrl = window.location.origin + "/";
    }
    console.log(baseUrl);

    const pageHeader = document.querySelector(".pageHeader");
    const form = document.querySelector(".saveSpecializationForm");
    const specializationField = document.querySelector("#name");
    const saveBtn = document.querySelector(".saveBtn");

    const cancelBtn = document.querySelector(".cancelBtn");
    cancelBtn.addEventListener("click", showSpecializationSave);

    const specializations = document.querySelectorAll(".eligibleSpecialization");
    for (let specialization of specializations) {
        specialization.addEventListener("click", () => {
            if (!specialization.classList.contains("selected")) {
                removeSelected();

                const specializationId = specialization.className.charAt(specialization.className.length-1);
                specialization.classList.add("selected");
                showSpecializationEdit(specializationId);
            }
        });
    }

    function showSpecializationSave() {
        pageHeader.innerHTML = "Save specialization";
        pageHeader.scrollIntoView({
            "behavior": "smooth",
            "block": "start"
        });

        removeSelected();

        specializationField.value = "";
        cancelBtn.classList.add("hidden");
        saveBtn.innerHTML = "Save";

        form.action = baseUrl + "specialization";
    }

    async function showSpecializationEdit(specializationId) {
        pageHeader.innerHTML = "Edit specialization";
        pageHeader.scrollIntoView({
            "behavior": "smooth",
            "block": "start"
        });

        try {
            const response = await fetch(baseUrl + `api/specialization/${specializationId}`);
            if (response.ok) {
                const specialization = await response.json();

                specializationField.value = specialization.name;
                cancelBtn.classList.remove("hidden");
                saveBtn.innerHTML = "Edit";
                
                form.action = baseUrl + `specialization/${specializationId}/update`;
            } else {
                const msg = await response.text();
                errorMsgP.innerHTML = msg;
            }
        } catch (error) {
            console.error(error);
            showSpecializationSave();
        }
    }

    function removeSelected() {
        for (let specialization of specializations) {
            specialization.classList.remove("selected");
        }
    }
});