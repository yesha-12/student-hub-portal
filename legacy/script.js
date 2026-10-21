"use strict";

document.addEventListener("DOMContentLoaded", function () {

    function getStudentData() {
        try {
            return JSON.parse(localStorage.getItem("studentData"));
        } catch (e) {
            return null;
        }
    }

    const loggedUser = getStudentData();
    const userName = loggedUser ? loggedUser.name : null;

    const heading =
        document.querySelector(".section-title h2") ||
        document.querySelector(".hero h1");

    if (heading && userName) {
        heading.innerHTML += "<br><small>Welcome, " + userName + " 👋</small>";
    }

    const hour = new Date().getHours();

    let greeting = "Welcome";

    if (hour < 12) {
        greeting = "Good Morning";
    } else if (hour < 17) {
        greeting = "Good Afternoon";
    } else {
        greeting = "Good Evening";
    }

    console.log(greeting + ", " + userName);

    const currentPage =
        window.location.pathname.split("/").pop();

    const navLinks =
        document.querySelectorAll(".sidebar a");

    navLinks.forEach(function (link) {

        const href = link.getAttribute("href");

        if (href === currentPage) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });

    // Show profile only when a user is logged in
    const profileEl = document.querySelector(".profile");
    if (profileEl) {
        if (loggedUser) {
            profileEl.classList.add("logged-in");
            var img = profileEl.querySelector("img");
            var span = profileEl.querySelector("span");
            if (img && loggedUser.profilePic) img.src = loggedUser.profilePic;
            if (span && loggedUser.name) span.textContent = loggedUser.name;
        } else {
            profileEl.classList.remove("logged-in");
        }
    }

    const buttons =
        document.querySelectorAll(".btn");

    buttons.forEach(function (btn) {

        btn.addEventListener("mouseenter", function () {
            btn.style.transform = "scale(1.05)";
        });

        btn.addEventListener("mouseleave", function () {
            btn.style.transform = "scale(1)";
        });
    });

    const cards =
        document.querySelectorAll(".card");

    cards.forEach(function (card) {

        card.addEventListener("mouseenter", function () {
            card.style.transform = "translateY(-8px)";
            card.style.transition = "0.3s";
        });

        card.addEventListener("mouseleave", function () {
            card.style.transform = "translateY(0)";
        });
    });

    const images =
        document.querySelectorAll("img");

    images.forEach(function (img) {

        img.addEventListener("mouseover", function () {
            img.style.opacity = "0.9";
        });

        img.addEventListener("mouseout", function () {
            img.style.opacity = "1";
        });
    });

    const topButton =
        document.createElement("button");

    topButton.innerHTML = "↑";

    topButton.id = "topButton";

    topButton.style.position = "fixed";
    topButton.style.right = "25px";
    topButton.style.bottom = "25px";
    topButton.style.width = "45px";
    topButton.style.height = "45px";
    topButton.style.borderRadius = "50%";
    topButton.style.border = "none";
    topButton.style.background = "#003366";
    topButton.style.color = "white";
    topButton.style.cursor = "pointer";
    topButton.style.display = "none";
    topButton.style.fontSize = "20px";
    topButton.style.zIndex = "999";

    document.body.appendChild(topButton);

    window.addEventListener("scroll", function () {

        if (window.scrollY > 300) {
            topButton.style.display = "block";
        } else {
            topButton.style.display = "none";
        }
    });

    topButton.addEventListener("click", function () {

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

    });

    document.body.style.opacity = "0";

    setTimeout(function () {

        document.body.style.transition = "0.5s";
        document.body.style.opacity = "1";

    }, 100);

});
const contactForm = document.querySelector("form");

if (contactForm && document.title.toLowerCase().includes("contact")) {

    contactForm.addEventListener("submit", function (e) {

        e.preventDefault();

        const inputs = contactForm.querySelectorAll("input, textarea");

        let valid = true;

        inputs.forEach(function (input) {

            if (input.value.trim() === "") {

                valid = false;

                input.style.border = "2px solid red";

            } else {

                input.style.border = "2px solid green";

            }

        });

        if (!valid) {

            alert("Please fill all fields.");

            return;

        }

        var fields = contactForm.querySelectorAll("input, textarea");
        var messageData = {
            action: "contact",
            name: fields[0].value.trim(),
            email: fields[1].value.trim(),
            message: fields[2].value.trim()
        };

        fetch("process.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(messageData)
        }).then(function (response) {
            return response.json().then(function (result) {
                if (!response.ok || !result.success) {
                    throw new Error(result.message || "Unable to send your message.");
                }
                return result;
            });
        }).then(function (result) {
            alert(result.message);
            contactForm.reset();
        }).catch(function (error) {
            alert(error.message);
        });

    });

}

const logoutButtons = document.querySelectorAll(".logout");

logoutButtons.forEach(function (button) {

    button.addEventListener("click", function (e) {

        e.preventDefault();

        if (confirm("Are you sure you want to logout?")) {

            window.location.href = "login.html";

        }

    });

});

document.querySelectorAll("input").forEach(function (input) {

    input.addEventListener("focus", function () {

        input.style.background = "#f4f9ff";

    });

    input.addEventListener("blur", function () {

        input.style.background = "";

    });

});

document.querySelectorAll("textarea").forEach(function (textarea) {

    textarea.addEventListener("focus", function () {

        textarea.style.background = "#f4f9ff";

    });

    textarea.addEventListener("blur", function () {

        textarea.style.background = "";

    });

});

window.addEventListener("beforeunload", function () {

    console.log("Leaving Student Hub Portal...");

});const searchBox = document.querySelector("#search");

if (searchBox) {

    searchBox.addEventListener("keyup", function () {

        const value = this.value.toLowerCase();

        document.querySelectorAll(".course,.faculty,.notice,.card").forEach(function (item) {

            if (item.innerText.toLowerCase().indexOf(value) > -1) {

                item.style.display = "";

            } else {

                item.style.display = "none";

            }

        });

    });

}

const attendanceTable = document.querySelector("table");

if (attendanceTable && document.title.toLowerCase().includes("attendance")) {

    const rows = attendanceTable.querySelectorAll("tr");

    rows.forEach(function (row, index) {

        if (index === 0) return;

        const cells = row.querySelectorAll("td");

        if (cells.length >= 5) {

            const total = parseFloat(cells[1].innerText);

            const present = parseFloat(cells[2].innerText);

            const percent = ((present / total) * 100).toFixed(0);

            cells[4].innerText = percent + "%";

            if (percent >= 75) {

                cells[4].style.color = "green";

                cells[4].style.fontWeight = "bold";

            } else {

                cells[4].style.color = "red";

                cells[4].style.fontWeight = "bold";

            }

        }

    });

}

if (document.title.toLowerCase().includes("assignment")) {

    document.querySelectorAll("table tr").forEach(function (row, index) {

        if (index === 0) return;

        const status = row.cells[3];

        if (!status) return;

        if (status.innerText.toLowerCase() === "completed") {

            status.style.color = "green";

            status.style.fontWeight = "bold";

        } else {

            status.style.color = "red";

            status.style.fontWeight = "bold";

        }

    });

}

document.querySelectorAll(".course").forEach(function (course) {

    course.addEventListener("click", function () {

        alert(course.querySelector("h3").innerText);

    });

});

document.querySelectorAll(".faculty").forEach(function (faculty) {

    faculty.addEventListener("click", function () {

        alert(faculty.querySelector("h3").innerText);

    });

});

document.querySelectorAll(".notice").forEach(function (notice) {

    notice.addEventListener("click", function () {

        alert(notice.querySelector("h3").innerText);

    });

});

const cards = document.querySelectorAll(".card");

cards.forEach(function (card, index) {

    card.style.opacity = "0";

    setTimeout(function () {

        card.style.transition = "0.5s";

        card.style.opacity = "1";

    }, index * 200);

});

document.querySelectorAll("table tr").forEach(function (row) {

    row.addEventListener("mouseenter", function () {

        row.style.background = "#eef6ff";

    });

    row.addEventListener("mouseleave", function () {

        row.style.background = "";

    });

});

document.querySelectorAll(".course,.faculty,.notice").forEach(function (box) {

    box.style.cursor = "pointer";

    box.addEventListener("mouseenter", function () {

        box.style.transform = "scale(1.02)";

        box.style.transition = "0.3s";

    });

    box.addEventListener("mouseleave", function () {

        box.style.transform = "scale(1)";

    });

});

const dashboardCards = document.querySelectorAll(".card h3");

dashboardCards.forEach(function (item) {

    item.style.color = "#003366";

});

document.querySelectorAll(".btn").forEach(function (btn) {

    btn.addEventListener("click", function () {

        btn.style.transform = "scale(0.95)";

        setTimeout(function () {

            btn.style.transform = "scale(1)";

        }, 150);

    });

});

if (document.title.toLowerCase().includes("admin")) {

    const section = document.querySelector(".section");

    if (section) {

        const addBtn = document.createElement("button");

        addBtn.innerHTML = "Add Notice";

        addBtn.className = "btn";

        section.appendChild(addBtn);

        addBtn.addEventListener("click", function () {

            const notice = prompt("Enter New Notice");

            if (notice) {

                alert("Notice Added\n\n" + notice);

            }

        });

    }

}

function toast(message) {

    const box = document.createElement("div");

    box.innerHTML = message;

    box.style.position = "fixed";
    box.style.top = "20px";
    box.style.right = "20px";
    box.style.background = "#003366";
    box.style.color = "#fff";
    box.style.padding = "12px 20px";
    box.style.borderRadius = "8px";
    box.style.zIndex = "9999";
    box.style.fontWeight = "bold";

    document.body.appendChild(box);

    setTimeout(function () {

        box.remove();

    }, 3000);

}

document.querySelectorAll(".btn").forEach(function (btn) {

    btn.addEventListener("click", function () {

        toast("Action Completed Successfully");

    });

});

window.addEventListener("load", function () {

    console.log("Student Hub Portal Ready");

});

window.addEventListener("online", function () {

    toast("Internet Connected");

});

window.addEventListener("offline", function () {

    toast("Internet Disconnected");

});

document.addEventListener("keydown", function (e) {

    if (e.key === "Escape") {

        toast("Escape Pressed");

    }

});

document.querySelectorAll("img").forEach(function (img) {

    img.setAttribute("draggable", "false");

});

document.querySelectorAll("a").forEach(function (link) {

    link.addEventListener("click", function () {

        console.log("Opening : " + link.getAttribute("href"));

    });

});

console.log("Student Hub Portal Script Loaded Successfully");