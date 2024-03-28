document.addEventListener("DOMContentLoaded", () =>{
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const filter = document.querySelector("#filter");
    const roleSearch = document.querySelector("#roleSearch");
    const userSection = document.querySelector(".users");

    const userSearchForm = document.querySelector(".userSearchForm");
    userSearchForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = {
            "filter": filter.value,
            "role": roleSearch.value
        };

        try {
            const response = await fetch(baseUrl + "api/user/search", {
                "method": "POST",
                "headers": {
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify(data)
            });

            if (response.ok) {
                const users = await response.json();

                userSection.innerHTML = "";
                for (let user of users) {
                    userSection.innerHTML += `
                        <article>
                            <div class="banner"></div>
                            <img src="image/profile/${user.image}" alt="profile user's picture">
                            <div class="userInfo">
                                <p>${user.username}</p>
                                <p>${user.email}</p>
                                <p class="roleP${user.id}">${user.role}</p>
                            </div>
            
                            <div class="roleSelection">
                                <p>Role:</p>
                                
                        </article>
                    `;

                    const loggedUserRole = document.querySelector(".userRole").value;


                    if (loggedUserRole == "SUPER_ADMIN") {
                        const roles = await getRoles();

                        userSection.lastElementChild.innerHTML += `
                            <select name="role" id="role" class="role" title="user roles">
                        `;

                        for (let role of roles) {
                            if (user.role == role.name) {
                                userSection.lastElementChild.innerHTML += `<option value="${role.id}" selected>${role.name}</option>`;
                            } else {
                                userSection.lastElementChild.innerHTML += `<option value="${role.id}">${role.name}</option>`;
                            }
                        }

                        userSection.lastElementChild.innerHTML += `</select>`;
                    } else {
                        userSection.lastElementChild.innerHTML += `<p>${user.role}</p>`;
                    }

                    userSection.lastElementChild.innerHTML += `
                        </div>
                        <button class="roleBtn userRole${user.id} hidden">Update role</button>
                    `;
                }

                addRoleUpdateBehavior();
            } else {
                const message = await response.text();

                popup.classList.add("success");
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
    });

    const popup = document.querySelector(".popup");

    function addRoleUpdateBehavior() {
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
    }

    async function getRoles() {
        try {
            const response = await fetch(baseUrl + "api/role");
            if (response.ok) {
                const roles = await response.json();
                return roles;
            } else {
                const message = await response.text();

                popup.classList.add("success");
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

    addRoleUpdateBehavior();
});