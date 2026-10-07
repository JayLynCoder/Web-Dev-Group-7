document.addEventListener("DOMContentLoaded", () => {

    const attendanceAction =
        document.getElementById("attendanceAction");

    const confirmationModal =
        document.getElementById("confirmationModal");

    const successModal =
        document.getElementById("successModal");

    const closeModal =
        document.getElementById("closeModal");

    const cancelModal =
        document.getElementById("cancelModal");

    const confirmAttendance =
        document.getElementById("confirmAttendance");

    const modalTitle =
        document.getElementById("modalTitle");

    const modalDescription =
        document.getElementById("modalDescription");

    const modalTime =
        document.getElementById("modalTime");

    const modalDate =
        document.getElementById("modalDate");

    const successTitle =
        document.getElementById("successTitle");

    const successMessage =
        document.getElementById("successMessage");

    const successTime =
        document.getElementById("successTime");

    const statusText =
        document.getElementById("statusText");

    // FIXED: matches the class in employee/dashboard.blade.php
    const statusDot =
        document.querySelector(".employee-status-dot");

    const clockInTime =
        document.getElementById("clockInTime");

    const clockOutTime =
        document.getElementById("clockOutTime");

    const actionNote =
        document.getElementById("actionNote");

    const liveClock =
        document.getElementById("liveClock");

    const currentDate =
        document.getElementById("currentDate");

    const clockDate =
        document.getElementById("clockDate");

    const mobileMenuButton =
        document.getElementById("mobileMenuButton");

    const sidebar =
        document.querySelector(".employee-sidebar");

    const logoutButton =
        document.getElementById("logoutButton");


    let attendanceState = "not-clocked-in";


    /*
    |--------------------------------------------------------------------------
    | CURRENT DATE & TIME
    |--------------------------------------------------------------------------
    */

    function updateClock() {

        const now = new Date();

        const time = now.toLocaleTimeString(
            "en-US",
            {
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit"
            }
        );

        const date = now.toLocaleDateString(
            "en-US",
            {
                month: "long",
                day: "numeric",
                year: "numeric"
            }
        );

        if (liveClock) {
            liveClock.textContent = time;
        }

        if (currentDate) {
            currentDate.textContent = date;
        }

        if (clockDate) {
            clockDate.textContent = date;
        }

        if (modalDate) {
            modalDate.textContent = date;
        }

        if (modalTime) {
            modalTime.textContent =
                now.toLocaleTimeString(
                    "en-US",
                    {
                        hour: "numeric",
                        minute: "2-digit"
                    }
                );
        }
    }


    updateClock();

    setInterval(updateClock, 1000);


    /*
    |--------------------------------------------------------------------------
    | OPEN CLOCK IN / CLOCK OUT MODAL
    |--------------------------------------------------------------------------
    */

    if (attendanceAction) {

        attendanceAction.addEventListener(
            "click",
            () => {

                if (
                    attendanceState ===
                    "not-clocked-in"
                ) {

                    modalTitle.textContent =
                        "Confirm Clock In";

                    modalDescription.textContent =
                        "Are you sure you want to clock in and start your work session?";

                    confirmAttendance.textContent =
                        "Confirm Clock In";

                } else {

                    modalTitle.textContent =
                        "Confirm Clock Out";

                    modalDescription.textContent =
                        "Are you sure you want to clock out and end your work session?";

                    confirmAttendance.textContent =
                        "Confirm Clock Out";
                }


                confirmationModal.classList.add("show");
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    function closeConfirmation() {

        if (confirmationModal) {
            confirmationModal.classList.remove("show");
        }

    }


    if (closeModal) {
        closeModal.addEventListener(
            "click",
            closeConfirmation
        );
    }

    if (cancelModal) {
        cancelModal.addEventListener(
            "click",
            closeConfirmation
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CONFIRM ATTENDANCE
    |--------------------------------------------------------------------------
    */

    if (confirmAttendance) {

        confirmAttendance.addEventListener(
            "click",
            () => {

                const now = new Date();

                const formattedTime =
                    now.toLocaleTimeString(
                        "en-US",
                        {
                            hour: "numeric",
                            minute: "2-digit"
                        }
                    );


                confirmationModal.classList.remove(
                    "show"
                );


                /*
                |--------------------------------------------------------------------------
                | CLOCK IN
                |--------------------------------------------------------------------------
                */

                if (
                    attendanceState ===
                    "not-clocked-in"
                ) {

                    attendanceState =
                        "clocked-in";


                    if (clockInTime) {
                        clockInTime.textContent =
                            formattedTime;
                    }


                    if (statusText) {
                        statusText.textContent =
                            "On Duty";
                    }


                    if (statusDot) {
                        statusDot.style.background =
                            "#16a34a";
                    }


                    attendanceAction.textContent =
                        "Clock Out";


                    if (actionNote) {
                        actionNote.textContent =
                            "You are currently on duty.";
                    }


                    successTitle.textContent =
                        "Clock In Successful";


                    successMessage.textContent =
                        "Your work session has started.";

                }


                /*
                |--------------------------------------------------------------------------
                | CLOCK OUT
                |--------------------------------------------------------------------------
                */

                else {

                    attendanceState =
                        "clocked-out";


                    if (clockOutTime) {
                        clockOutTime.textContent =
                            formattedTime;
                    }


                    if (statusText) {
                        statusText.textContent =
                            "Workday Complete";
                    }


                    if (statusDot) {
                        statusDot.style.background =
                            "#2563eb";
                    }


                    attendanceAction.textContent =
                        "Workday Complete";

                    attendanceAction.disabled =
                        true;

                    attendanceAction.style.background =
                        "#94a3b8";


                    if (actionNote) {
                        actionNote.textContent =
                            "Your attendance for today is complete.";
                    }


                    successTitle.textContent =
                        "Clock Out Successful";


                    successMessage.textContent =
                        "Your work session has ended.";
                }


                successTime.textContent =
                    formattedTime;


                successModal.classList.add(
                    "show"
                );


                /*
                |--------------------------------------------------------------------------
                | KEEP SUCCESS SCREEN FOR 3 SECONDS
                |--------------------------------------------------------------------------
                */

                setTimeout(
                    () => {

                        successModal.classList.remove(
                            "show"
                        );

                    },
                    3000
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE MENU
    |--------------------------------------------------------------------------
    */

    if (mobileMenuButton && sidebar) {

        mobileMenuButton.addEventListener(
            "click",
            () => {

                sidebar.classList.toggle(
                    "open"
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SIGN OUT
    |--------------------------------------------------------------------------
    */

    if (logoutButton) {

        logoutButton.addEventListener(
            "click",
            () => {

                if (
                    attendanceState ===
                    "clocked-in"
                ) {

                    const result =
                        confirm(
                            "You're still on duty.\n\nYou haven't clocked out yet. Signing out will not automatically record a clock-out.\n\nClick OK to sign out anyway."
                        );


                    if (!result) {
                        return;
                    }

                }


                window.location.href =
                    "/login";

            }
        );

    }

});