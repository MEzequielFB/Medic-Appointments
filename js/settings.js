document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const profileInformationBtn = document.querySelector(".profileInformationBtn");
    const profilePictureBtn = document.querySelector(".profilePictureBtn");
    const changePasswordBtn = document.querySelector(".changePasswordBtn");

    const profileInformationSection = document.querySelector(".profileInformation");
    const profilePictureSection = document.querySelector(".profilePicture");
    const changePasswordSection = document.querySelector(".changePassword");

    const profileInformationForm = document.querySelector(".profileInformationForm");
    const emailInput = document.querySelector("#email");
    const usernameInput = document.querySelector("#username");

    const profilePictureForm = document.querySelector(".profilePictureForm");
    const imageInput = document.querySelector("#image");

    const passwordForm = document.querySelector(".passwordForm");

    const messageP = document.querySelector(".message");
    const popup = document.querySelector(".success-popup");

    /* profilePictureForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        let data = {
            "image": imageInput.files[0]
        }

        const formData = new FormData();
        formData.append('image', imageInput.files[0]);
        
        console.log("FILES ", imageInput.files[0]);
        console.log("FORM DATA: ", formData);

        try {
            const response = await fetch(baseUrl + "api/user/updateProfileImage", {
                "method": "POST",
                "headers": {
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify(data)
            });
            if (response.ok) {
                const message = await response.text();
                console.log(message);

                popup.firstElementChild.innerHTML = "Profile picture updated!";
                popup.classList.remove("hidden");
            } else {
                const message = await response.text();
                messageP.innerHTML = message;
            }
        } catch (error) {
            messageP.innerHTML = "Internal Server Error";
            console.error(error);
        }
    }); */

    profileInformationForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        let data = {
            "email": emailInput.value,
            "username": usernameInput.value
        }

        try {
            const response = await fetch(baseUrl + "api/user/updateInformation", {
                "method": "PUT",
                "headers": {
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify(data)
            });
            if (response.ok) {
                const user = await response.json();

                emailInput.value = user.email;
                usernameInput.value = user.username;

                popup.firstElementChild.innerHTML = "Profile information updated!";
                popup.classList.remove("hidden");

                setTimeout(() => {
                    popup.classList.add("hidden");
                    popup.firstElementChild.innerHTML = "";
                }, 4000);

                messageP.innerHTML = "";
            } else {
                const message = await response.text();
                messageP.innerHTML = message;
            }
        } catch (error) {
            messageP.innerHTML = "Internal Server Error";
            console.error(error);
        }
    });

    profileInformationBtn.addEventListener("click", () => {
        unselectButtons();
        profileInformationBtn.classList.add("selected");

        profileInformationSection.classList.remove("hidden");
        profilePictureSection.classList.add("hidden");
        changePasswordSection.classList.add("hidden");
    });

    profilePictureBtn.addEventListener("click", () => {
        unselectButtons();
        profilePictureBtn.classList.add("selected");

        profileInformationSection.classList.add("hidden");
        profilePictureSection.classList.remove("hidden");
        changePasswordSection.classList.add("hidden");
    });

    changePasswordBtn.addEventListener("click", () => {
        unselectButtons();
        changePasswordBtn.classList.add("selected");

        profileInformationSection.classList.add("hidden");
        profilePictureSection.classList.add("hidden");
        changePasswordSection.classList.remove("hidden");
    });

    function unselectButtons() {
        profileInformationBtn.classList.remove("selected");
        profilePictureBtn.classList.remove("selected");
        changePasswordBtn.classList.remove("selected");
    }

    // When changing profile picture and redirect to settings. After a time hide the popup again
    setTimeout(() => {
        popup.classList.add("hidden");
        popup.firstElementChild.innerHTML = "";
    }, 4000);
});