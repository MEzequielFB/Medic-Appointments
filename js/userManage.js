document.addEventListener("DOMContentLoaded", () =>{
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const popup = document.querySelector(".popup");
    const roleSelect = document.querySelector("#role");

    const roleBtns = document.querySelectorAll(".roleBtn");
    for (let btn of roleBtns) {
        btn.addEventListener("click", () => {
            const userId = btn.className.charAt(btn.className.length-1);
            updateRole(userId);
        });
    }

    async function updateRole(userId) {
        const data = {
            "roleId": roleSelect.value
        }

        try {
            const response = await fetch(baseUrl + `api/user/${userId}/updateRole`, {
                "method": "PUT",
                "headers": {
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify(data)
            });
            
            if (response.ok) {
                const message = await response.text();

                // The paraph that indicates the role of the user in the user's card
                const roleP = document.querySelector(`.roleP${userId}`);
                //The selected option in the role's select
                var roleName = roleSelect.options[roleSelect.selectedIndex].text;

                roleP.innerHTML = roleName;

                popup.classList.add("success");
                popup.classList.remove("hidden");
                popup.firstElementChild.innerHTML = message;

                setTimeout(() => {
                    popup.classList.add("hidden");
                    popup.firstElementChild.innerHTML = "";
                }, 5000);
            } else {
                const message = await response.text();

                popup.classList.remove("success");
                popup.classList.remove("hidden");
                popup.firstElementChild.innerHTML = message;

                setTimeout(() => {
                    popup.classList.add("hidden");
                    popup.firstElementChild.innerHTML = "";
                }, 5000);
            }
        } catch (error) {
            console.error(error);
        }
    }
});