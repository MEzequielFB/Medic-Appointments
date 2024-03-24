document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const baseUrl = window.location.origin + "/" + window.location.pathname.split( '/' )[1] + "/";
    console.log(baseUrl);

    const doctorBtn = document.querySelector(".doctorBtn");
    doctorBtn.addEventListener("click", showDoctors);

    // userBtn is only avaiblable for admins
    try {
        const userBtn = document.querySelector(".userBtn");
        userBtn.addEventListener("click", showUsers);
    } catch (error) {
        console.warn(error);
    }

    // try catch because just one of the button can be render on the tpl (saveAppointment.tpl). Prevents the application to stop
    try {
        const scheduleBtn = document.querySelector(".scheduleBtn");
        scheduleBtn.addEventListener("click", saveAppointment);
    } catch (error) {
        console.warn(error);
    }

    try {
        const rescheduleBtn = document.querySelector(".rescheduleBtn");
        rescheduleBtn.addEventListener("click", rescheduleAppointment);
    } catch (error) {
        console.warn(error);
    }

    const doctorsDiv = document.querySelector(".doctorsDiv");
    const doctorsSection = document.querySelector(".doctorsSection");

    const leftArrow = document.querySelector(".leftArrow")
    leftArrow.addEventListener("click", hideDoctors);

    // only available for admins
    try {
        const usersLeftArrow = document.querySelector(".usersLeftArrow")
        usersLeftArrow.addEventListener("click", hideUsers);
    } catch (error) {
        console.warn(error);
    }

    const chosenDoctor = document.querySelector(".chosenDoctor");

    const timesList = document.querySelector(".times");

    const timeDiv = document.querySelector(".timeDiv");
    const dateDiv = document.querySelector(".dateDiv");

    const doctorSearch = document.querySelector(".doctorSearch");
    doctorSearch.addEventListener("input", searchDoctors);

    try {
        const date = document.querySelector(".date");
        date.addEventListener("input", getAvailableTimesByDateAndDoctor);
    } catch (error) {
        console.warn(error);
    }

    const messageP = document.querySelector(".message");

    try {
        const durationInput = document.querySelector("#duration");
        durationInput.addEventListener("input", showDurationValue);
    } catch (error) {
        console.warn(error);
    }

    function showDurationValue() {
        const durationInput = document.querySelector("#duration");
        const durationSpan = document.querySelector(".durationValue");
        durationSpan.innerHTML = durationInput.value;
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

    async function showUsers() {
        const usersSection = document.querySelector(".usersSection");
        const usersDiv = document.querySelector(".usersDiv");

        usersSection.innerHTML = "<div class='loader'></div>"
        usersDiv.classList.add("visible");

        try {
            const response = await fetch(baseUrl + "api/user");
            if (response.ok) {
                const users = await response.json();
                console.log(users);

                setTimeout(() => {
                    renderUsers(users);
                }, 1000);
            } else {
                usersSection.innerHTML = "<p class='message'>Error while fetching users</p>";
            }
        } catch (error) {
            console.error(error);
        }
    }

    function hideDoctors() {
        doctorsDiv.classList.remove("visible");
    }

    function hideUsers() {
        // only available for admins
        try {
            const usersDiv = document.querySelector(".usersDiv");
            usersDiv.classList.remove("visible");
        } catch (error) {
            console.warn(error);
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

    function renderUsers(users) {
        const usersSection = document.querySelector(".usersSection");
        usersSection.innerHTML = "";
        users.forEach(user => {
            usersSection.innerHTML += `
            <article class="eligibleUser user${user.id}">
                <div>
                    <h1>${user.username}</h1>
                    <p>${user.email}</p>
                </div>
                <img src="${baseUrl}image/profile/${user.image}" alt="user's image">
            </article>`;
        });

        addUsersBehavior();
    }

    function addDoctorsBehavior() {
        const doctors = document.querySelectorAll(".eligibleDoctor");
        doctors.forEach(doctor => {
            doctor.addEventListener("click", async () => { // Choose doctor
                chosenDoctor.innerHTML = doctor.innerHTML;
                const doctorId = doctor.className.charAt(doctor.className.length-1);
                chosenDoctor.innerHTML += `<input type="hidden" name="doctorId" class="doctorId" value="${doctorId}">`;

                if (date.value != "") {
                    getAvailableTimesByDateAndDoctor();
                }

                chosenDoctor.classList.remove("hidden");
                dateDiv.classList.remove("hidden");
                doctorsDiv.classList.remove("visible");
            });
        });
    }

    function addUsersBehavior() {
        const usersDiv = document.querySelector(".usersDiv");
        const chosenUser = document.querySelector(".chosenUser");
        const users = document.querySelectorAll(".eligibleUser");
        users.forEach(user => {
            user.addEventListener("click", async () => { // Choose user
                chosenUser.innerHTML = user.innerHTML;
                const userId = user.className.charAt(user.className.length-1);
                chosenUser.innerHTML += `<input type="hidden" name="userId" class="userId" value="${userId}">`;

                chosenUser.classList.remove("hidden");
                usersDiv.classList.remove("visible");
            });
        });
    }

    async function getAvailableTimesByDateAndDoctor() {
        try {
            const doctorId = chosenDoctor.lastElementChild.value;
            const data = {
                "date": date.value
            };

            const response = await fetch(baseUrl + `api/doctor/${doctorId}/times`, {
                "method": "POST",
                "headers": {
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify(data)
            });

            if (response.ok) {
                let times = await response.json();
                console.log("times", times);

                timeDiv.classList.remove("hidden");

                timesList.innerHTML = "";
                times.forEach(time => {
                    timesList.innerHTML += `
                        <li>${time.hour}</li>
                    `;
                });

                addTimesBehavior();
            } else {
                messageP.innerHTML = await response.text();
            }
        } catch (error) {
            console.error(error);
        }
    }

    function addTimesBehavior() {
        console.log(timesList.children);

        for (let time of timesList.children) {
            time.addEventListener("click", () => {
                for (let time2 of timesList.children) {
                    time2.classList.remove("selected");
                }
                time.classList.add("selected");
            })
        }
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

    async function saveAppointment() {
        let emptyFields = [];

        const doctorId = chosenDoctor.lastElementChild;
        if (!doctorId) {
            emptyFields.push("doctor");
        }

        let userId = null
        let duration = null;
        let reason = null
        try {
            const chosenUser = document.querySelector(".chosenUser");
            userId = chosenUser.lastElementChild;
            if (!userId) {
                emptyFields.push("user");
            }

            duration = document.querySelector("#duration").value;
            reason = document.querySelector("#reason").value;
            console.log("REASON", reason);
            if (reason == "") {
                emptyFields.push("reason");
            }
        } catch (error) {
            console.warn(error);
        }

        if (date.value == "") {
            emptyFields.push("date");
        }

        const selectedTime = document.querySelector(".selected");
        if (!selectedTime) {
            emptyFields.push("time");
        }

        if (emptyFields.length != 0) {
            messageP.innerHTML = "The following fields are empty: " + emptyFields.join(", ");
            return;
        }

        console.log("Date: ", `${date.value} ${selectedTime.innerHTML}`);

        let data = {
            "date": `${date.value} ${selectedTime.innerHTML}`,
            "duration": 30,
            "reason": "consultation",
            "doctorId": doctorId.value
        };

        if (userId) {
            data["userId"] = userId.value;
        }
        if (duration) {
            data["duration"] = duration;
        }
        if (reason != "" && reason != null) {
            data["reason"] = reason;
        }

        console.log("DATA: ", data);

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
            }
        } catch (error) {
            console.error(error);
        }
    }

    function fieldsHaveBeenEntered() {
        let emptyFields = [];

        const doctorId = chosenDoctor.lastElementChild;
        if (!doctorId) {
            emptyFields.push("doctor");
        }

        if (date.value == "") {
            emptyFields.push("date");
        }

        const selectedTime = document.querySelector(".selected");
        if (!selectedTime) {
            emptyFields.push("time");
        }

        if (emptyFields.length != 0) {
            messageP.innerHTML = "The following fields are empty: " + emptyFields.join(", ");
            return false;
        }

        return true;
    }

    async function rescheduleAppointment() {
        if (!fieldsHaveBeenEntered()) {
            return;
        }

        const selectedTime = document.querySelector(".selected");
        const doctorId = chosenDoctor.lastElementChild;
        console.log("Date: ", `${date.value} ${selectedTime.innerHTML}`);

        let data = {
            "date": `${date.value} ${selectedTime.innerHTML}`,
            "duration": 30,
            "reason": "consultation",
            "doctorId": doctorId.value,
        };

        try {
            // window.location.pathname.split( '/' )[3] is the id of the appointment from the url path
            const response = await fetch(baseUrl + `api/appointment/${window.location.pathname.split( '/' )[3]}/reschedule`, {
                "method": "PUT",
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
            }
        } catch (error) {
            console.error(error);
        }
    }
});