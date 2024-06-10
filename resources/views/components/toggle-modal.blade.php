@props(['object', 'timesheets', 'users'])

<!-- Modal Container -->
<div id="generalModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
    onclick="closeModalOnClick(event)">
    <div class="p-6 w-1/2" onclick="event.stopPropagation()">
        <div id="modalContent">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>
</div>

<script>
    function openModal(object, objectId = null) {
        let url = "";
        if (object == "timesheet") {
            if (objectId == null) {
                url = "{{ route('timesheet.create') }}";
            } else {
                url = "{{ route('timesheet.index') }}/" + objectId;
            }
        } else if (object == "user") {
            if (objectId == null) {
                url = "{{ route('user.create') }}";
            } else {
                url = "{{ route('user.index') }}/" + objectId;
            }
        }

        $.ajax({
            url: url,
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                const modalContent = document.getElementById("modalContent");
                modalContent.innerHTML = response;

                document.getElementById("generalModal").classList.remove("hidden");
            },
        });
    }

    function closeModal() {
        document.getElementById("generalModal").classList.add("hidden");
        document.getElementById("modalContent").innerHTML = "";
    }

    function closeModalOnClick(event) {
        if (event.target === event.currentTarget) {
            closeModal();
        }
    }

    function hideAllErrorMessages() {
        document
            .querySelectorAll(".x-input-error-bottom")
            .forEach(function(element) {
                element.classList.add("hidden");
                element.innerHTML = "";
            });
    }

    @if ($object == 'timesheet')
        function confirmDelete(objectId) {
            if (confirm("Are you sure you want to delete this timesheet?")) {
                deleteTimesheet(objectId);
            }
        }

        function checkTimesheetInputsValidity() {
            let date_input = document.querySelector('input[name="date"]');
            let time_in_input = document.querySelector('input[name="time_in"]');
            let time_out_input = document.querySelector('input[name="time_out"]');
            let task_information_input = document.querySelector(
                'textarea[name="task_information"]'
            );

            if (!date_input.checkValidity()) {
                date_input.reportValidity();
                return false;
            }

            if (!time_in_input.checkValidity()) {
                time_in_input.reportValidity();
                return false;
            }

            if (!time_out_input.checkValidity()) {
                time_out_input.reportValidity();
                return false;
            }

            if (!task_information_input.checkValidity()) {
                task_information_input.reportValidity();
                return false;
            }

            return true;
        }

        function createTimesheet() {
            hideAllErrorMessages();
            if (checkTimesheetInputsValidity()) {
                showLoading();
                let date = document.querySelector('input[name="date"]').value;
                let time_in = document.querySelector('input[name="time_in"]').value;
                let time_out = document.querySelector('input[name="time_out"]').value;
                let task_information = document.querySelector(
                    'textarea[name="task_information"]'
                ).value;

                $.ajax({
                    url: "{{ url('timesheet/') }}/" + "store",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {
                        date: date,
                        time_in: time_in,
                        time_out: time_out,
                        task_information: task_information,
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        hideLoading();
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            for (const [field, messages] of Object.entries(errors)) {
                                let errorElement = document.getElementById(
                                    "err-" + field
                                );
                                if (errorElement) {
                                    errorElement.innerHTML = messages[0];
                                    errorElement.classList.remove("hidden");
                                }
                            }
                        }
                    },
                });
            }
        }

        function updateTimesheet(timesheetId) {
            hideAllErrorMessages();

            if (checkTimesheetInputsValidity()) {
                showLoading();
                let date = document.querySelector('input[name="date"]').value;
                let time_in = document.querySelector('input[name="time_in"]').value;
                let time_out = document.querySelector('input[name="time_out"]').value;
                let task_information = document.querySelector(
                    'textarea[name="task_information"]'
                ).value;

                $.ajax({
                    url: "{{ url('/timesheet/') }}/" + timesheetId + "/update",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {
                        date: date,
                        time_in: time_in,
                        time_out: time_out,
                        task_information: task_information,
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        hideLoading();
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            for (const [field, messages] of Object.entries(errors)) {
                                let errorElement = document.getElementById(
                                    "err-" + field
                                );
                                if (errorElement) {
                                    errorElement.innerHTML = messages[0];
                                    errorElement.classList.remove("hidden");
                                }
                            }
                        }
                    },
                });
            }
        }

        function deleteTimesheet(timesheetId) {
            showLoading();
            hideAllErrorMessages();
            $.ajax({
                url: "{{ url('/timesheet/') }}/" + timesheetId + "/remove",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    location.reload();
                },
                error: function(response) {
                    hideLoading();
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        for (const [field, messages] of Object.entries(errors)) {
                            let errorElement = document.getElementById("err-" + field);
                            if (errorElement) {
                                errorElement.innerHTML = messages[0];
                                errorElement.classList.remove("hidden");
                            }
                        }
                    }
                },
            });
        }

        function approveTimesheet(timesheetId) {
            showLoading();
            hideAllErrorMessages();
            $.ajax({
                url: "{{ url('/timesheet/') }}/" + timesheetId + "/approve",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    location.reload();
                },
                error: function(response) {
                    hideLoading();
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        for (const [field, messages] of Object.entries(errors)) {
                            let errorElement = document.getElementById("err-" + field);
                            if (errorElement) {
                                errorElement.innerHTML = messages[0];
                                errorElement.classList.remove("hidden");
                            }
                        }
                    }
                },
            });
        }
    @else
        function confirmDelete(objectId) {
            if (confirm("Are you sure you want to delete this user?")) {
                deleteUser(objectId);
            }
        }

        function checkUserInputsValidity() {
            event.preventDefault();
            let name_input = document.querySelector('input[name="name"]');
            let email_input = document.querySelector('input[name="email"]');
            let password_input = document.querySelector('input[name="password"]');
            let ic_input = document.querySelector('input[name="ic"]');
            let epf_no_input = document.querySelector('input[name="epf_no"]');
            let socso_no_input = document.querySelector('input[name="socso_no"]');
            let employee_no_input = document.querySelector('input[name="employee_no"]');
            let role_input = document.querySelector('input[name="role"]');

            if (!name_input.checkValidity()) {
                name_input.reportValidity();
                return false;
            }

            if (!email_input.checkValidity()) {
                email_input.reportValidity();
                return false;
            }

            if (password_input != null && !password_input.checkValidity()) {
                password_input.reportValidity();
                return false;
            }

            if (!ic_input.checkValidity()) {
                ic_input.reportValidity();
                return false;
            }

            if (!epf_no_input.checkValidity()) {
                epf_no_input.reportValidity();
                return false;
            }

            if (!socso_no_input.checkValidity()) {
                socso_no_input.reportValidity();
                return false;
            }

            if (!employee_no_input.checkValidity()) {
                employee_no_input.reportValidity();
                return false;
            }

            if (role_input != null && !role_input.checkValidity()) {
                role_input.reportValidity();
                return false;
            }

            return true;
        }

        function setRole(role) {
            event.preventDefault();
            document.getElementById("role").value = role;
            document.getElementById("role-text").innerText =
                role.charAt(0).toUpperCase() + role.slice(1);
        }

        function createUser() {
            hideAllErrorMessages();
            if (checkUserInputsValidity()) {
                showLoading();
                let name = document.querySelector('input[name="name"]').value;
                let email = document.querySelector('input[name="email"]').value;
                let password = document.querySelector('input[name="password"]').value;
                let ic = document.querySelector('input[name="ic"]').value;
                let epf_no = document.querySelector('input[name="epf_no"]').value;
                let socso_no = document.querySelector('input[name="socso_no"]').value;
                let employee_no = document.querySelector(
                    'input[name="employee_no"]'
                ).value;
                let role = document.querySelector('input[name="role"]').value;

                $.ajax({
                    url: "{{ url('/user/') }}/" + "store",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        ic: ic,
                        epf_no: epf_no,
                        socso_no: socso_no,
                        employee_no: employee_no,
                        role: role,
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        hideLoading();
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            for (const [field, messages] of Object.entries(errors)) {
                                let errorElement = document.getElementById(
                                    "err-" + field
                                );
                                if (errorElement) {
                                    errorElement.innerHTML = messages[0];
                                    errorElement.classList.remove("hidden");
                                }
                            }
                        }
                    },
                });
            }
        }

        function updateUser(userId) {
            hideAllErrorMessages();

            if (checkUserInputsValidity()) {
                showLoading();
                let name = document.querySelector('input[name="name"]').value;
                let email = document.querySelector('input[name="email"]').value;
                let ic = document.querySelector('input[name="ic"]').value;
                let epf_no = document.querySelector('input[name="epf_no"]').value;
                let socso_no = document.querySelector('input[name="socso_no"]').value;
                let employee_no = document.querySelector(
                    'input[name="employee_no"]'
                ).value;

                $.ajax({
                    url: "{{ url('/user/') }}/" + userId + "/update",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: {
                        name: name,
                        email: email,
                        ic: ic,
                        epf_no: epf_no,
                        socso_no: socso_no,
                        employee_no: employee_no,
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        hideLoading();
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            for (const [field, messages] of Object.entries(errors)) {
                                let errorElement = document.getElementById(
                                    "err-" + field
                                );
                                if (errorElement) {
                                    errorElement.innerHTML = messages[0];
                                    errorElement.classList.remove("hidden");
                                }
                            }
                        }
                    },
                });
            }
        }

        function deleteUser(userId) {
            showLoading();
            hideAllErrorMessages();
            $.ajax({
                url: "{{ url('/user/') }}/" + userId + "/remove",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    location.reload();
                },
                error: function(response) {
                    hideLoading();
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        for (const [field, messages] of Object.entries(errors)) {
                            let errorElement = document.getElementById("err-" + field);
                            if (errorElement) {
                                errorElement.innerHTML = messages[0];
                                errorElement.classList.remove("hidden");
                            }
                        }
                    }
                },
            });
        }
    @endif
</script>
