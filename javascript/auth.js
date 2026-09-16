"use strict";

(function () {
    var protectedPages = [
        "student.html",
        "profile.html",
        "courses.html",
        "assignment.html",
        "attendance.html",
        "faculty.html",
        "notice.html"
    ];

    function getStudentData() {
        try {
            return JSON.parse(localStorage.getItem("studentData"));
        } catch (e) {
            return null;
        }
    }

    function isLoggedIn() {
        return localStorage.getItem("isLoggedIn") === "true" && getStudentData();
    }

    function saveStudentData(student) {
        localStorage.setItem("studentData", JSON.stringify(student));
        localStorage.setItem("isLoggedIn", "true");
    }

    function saveStudentToServer(student) {
        return fetch("process.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                action: "register",
                name: student.name,
                studentId: student.studentId,
                email: student.email,
                department: student.department,
                semester: student.semester,
                contactNumber: student.contactNumber,
                password: student.password,
                profilePic: student.profilePic
            })
        }).then(function (response) {
            return response.json().then(function (result) {
                if (!response.ok || !result.success) {
                    throw new Error(result.message || "Unable to save student data.");
                }
                return result.student;
            });
        });
    }

    window.logoutStudent = function () {
        localStorage.removeItem("studentData");
        localStorage.removeItem("isLoggedIn");
        window.location.href = "login.html";
    };

    function getCurrentPage() {
        return window.location.pathname.split("/").pop().toLowerCase();
    }

    function redirectToLoginIfRequired() {
        var currentPage = getCurrentPage();
        if (protectedPages.indexOf(currentPage) > -1 && !isLoggedIn()) {
            window.location.href = "login.html";
        }
    }

    function redirectToDashboardIfLoggedIn() {
        if (getCurrentPage() === "login.html" && isLoggedIn()) {
            window.location.href = "student.html";
        }
    }

    function readFileAsDataURL(file) {
        return new Promise(function (resolve, reject) {
            var reader = new FileReader();
            reader.onload = function () {
                resolve(reader.result);
            };
            reader.onerror = function () {
                reject(reader.error);
            };
            reader.readAsDataURL(file);
        });
    }

    function populateStudentInfo() {
        var student = getStudentData();
        if (!student) {
            return;
        }

        var nameEls = document.querySelectorAll(".student-name");
        var idEls = document.querySelectorAll(".student-id");
        var emailEls = document.querySelectorAll(".student-email");
        var departmentEls = document.querySelectorAll(".student-department");
        var semesterEls = document.querySelectorAll(".student-semester");
        var phoneEls = document.querySelectorAll(".student-phone");
        var profileEls = document.querySelectorAll(".student-profile");

        nameEls.forEach(function (el) {
            el.textContent = student.name || "";
        });

        idEls.forEach(function (el) {
            el.textContent = student.studentId || "";
        });

        emailEls.forEach(function (el) {
            el.textContent = student.email || "";
        });

        departmentEls.forEach(function (el) {
            el.textContent = student.department || "";
        });

        semesterEls.forEach(function (el) {
            el.textContent = student.semester || "";
        });

        phoneEls.forEach(function (el) {
            el.textContent = student.contactNumber || "";
        });

        profileEls.forEach(function (el) {
            if (el.tagName.toLowerCase() === "img") {
                el.src = student.profilePic || "images/profile.png";
            } else {
                el.style.backgroundImage = "url('" + (student.profilePic || "images/profile.png") + "')";
            }
        });

        var profileBlocks = document.querySelectorAll(".profile");
        profileBlocks.forEach(function (block) {
            block.classList.add("logged-in");
        });
    }

    function updateAuthNavigation() {
        document.querySelectorAll('.sidebar a[href="login.html"]').forEach(function (link) {
            if (isLoggedIn()) {
                link.innerHTML = '<i class="fa fa-sign-out-alt"></i> Logout';
                link.removeAttribute("href");
                link.addEventListener("click", function (event) {
                    event.preventDefault();
                    logoutStudent();
                });
            } else {
                link.innerHTML = '<i class="fa fa-sign-in-alt"></i> Login';
                link.setAttribute("href", "login.html");
            }
        });
    }

    function attachLogoutButtons() {
        document.querySelectorAll(".logout-btn").forEach(function (button) {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                logoutStudent();
            });
        });
    }

    function setupLoginForm() {
        if (getCurrentPage() !== "login.html") {
            return;
        }

        var loginForm = document.querySelector("form");
        if (!loginForm) {
            return;
        }

        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            var studentName = document.getElementById("studentName");
            var studentId = document.getElementById("studentId");
            var email = document.getElementById("email");
            var department = document.getElementById("department");
            var semester = document.getElementById("semester");
            var contactNumber = document.getElementById("contactNumber");
            var password = document.getElementById("password");
            var profilePic = document.getElementById("profilePic");

            if (!studentName || !studentId || !email || !department || !semester || !contactNumber || !password || !profilePic) {
                alert("Login form is not ready.");
                return;
            }

            if (studentName.value.trim() === "") {
                alert("Please enter your name.");
                studentName.focus();
                return;
            }

            if (studentId.value.trim() === "") {
                alert("Please enter your student ID.");
                studentId.focus();
                return;
            }

            if (email.value.trim() === "" || email.value.indexOf("@") === -1) {
                alert("Please enter a valid email.");
                email.focus();
                return;
            }

            if (department.value.trim() === "") {
                alert("Please enter your department.");
                department.focus();
                return;
            }

            if (semester.value.trim() === "") {
                alert("Please enter your semester.");
                semester.focus();
                return;
            }

            if (contactNumber.value.trim() === "") {
                alert("Please enter your contact number.");
                contactNumber.focus();
                return;
            }

            if (password.value.length < 6) {
                alert("Password must contain at least 6 characters.");
                password.focus();
                return;
            }

            if (!profilePic.files || profilePic.files.length === 0) {
                alert("Please upload a profile picture.");
                profilePic.focus();
                return;
            }

            var file = profilePic.files[0];
            if (!file.type.startsWith("image/")) {
                alert("Please upload a valid image file.");
                profilePic.focus();
                return;
            }

            readFileAsDataURL(file).then(function (imageData) {
                var studentRecord = {
                    name: studentName.value.trim(),
                    studentId: studentId.value.trim(),
                    email: email.value.trim(),
                    department: department.value.trim(),
                    semester: semester.value.trim(),
                    contactNumber: contactNumber.value.trim(),
                    password: password.value,
                    profilePic: imageData
                };

                saveStudentToServer(studentRecord).then(function (savedStudent) {
                    saveStudentData(savedStudent);
                    window.location.href = "student.html";
                }).catch(function (error) {
                    alert(error.message);
                });
            }).catch(function () {
                alert("Unable to read the profile picture. Please try again.");
            });
        });
    }

    redirectToLoginIfRequired();
    redirectToDashboardIfLoggedIn();

    document.addEventListener("DOMContentLoaded", function () {
        populateStudentInfo();
        updateAuthNavigation();
        attachLogoutButtons();
        setupLoginForm();
    });
})();
