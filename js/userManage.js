document.addEventListener("DOMContentLoaded", () =>{
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const popup = document.querySelector(".popup");
    const roleSelects = document.querySelectorAll(".role");
    for (let select of roleSelects) {
        select.addEventListener("input", () => {
            const selectedOption = select.options[select.selectedIndex];
        
            for (let option of select.options) {
                option.removeAttribute('selected');
            }

            selectedOption.setAttribute('selected', 'selected');

            const userRole = select.parentElement.previousElementSibling.lastElementChild.innerHTML;
            const updateRoleBtn = select.parentElement.nextElementSibling;
            if (userRole != selectedOption.innerHTML) {
                updateRoleBtn.classList.remove("hidden");
            } else {
                updateRoleBtn.classList.add("hidden");
            }
        });
    }

    const roleBtns = document.querySelectorAll(".roleBtn");
    for (let btn of roleBtns) {
        btn.addEventListener("click", () => {
            const userId = btn.className.charAt(btn.className.length-1);
            const select = btn.previousElementSibling.lastElementChild;
            updateRole(btn, select, userId);
        });
    }

    async function updateRole(btn, select, userId) {
        const data = {
            "roleId": select.value
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
                var roleName = select.options[select.selectedIndex].text;

                roleP.innerHTML = roleName;

                popup.classList.add("success");
                popup.classList.remove("hidden");
                popup.firstElementChild.innerHTML = message;

                setTimeout(() => {
                    popup.classList.add("hidden");
                    popup.firstElementChild.innerHTML = "";
                }, 5000);

                btn.classList.add("hidden");
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