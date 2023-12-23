

let removeMode = false;

let currentPage = "upcoming";

//getTasks("upcoming");

function addTask(task, desc, date) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getTasks(currentPage);
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=addTask&task=" + task + "&descr=" + desc + "&date=" + date, true);
    xmlhttp.send();
}

function taskAdder() {
    task = document.getElementById("modal-task").value;
    desc = document.getElementById("modal-desc").value;
    date = document.getElementById("modal-date").value;
    addTask(task, desc, date);
}

function removeTask(taskid) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getTasks(currentPage);
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=removeTask&taskid=" + taskid, true);
    xmlhttp.send();
}

function taskManagement(taskid, section, success) {
    if (removeMode) {
        removeTask(taskid, section);
    } else {
        if (success) {
            unsuccessTask(taskid, section);
        } else {
            successTask(taskid, section);
        }
    }
}

function successTask(taskid, section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getTasks(section);
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=successTask&taskid=" + taskid, true);
    xmlhttp.send();
}

function unsuccessTask(taskid, section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getTasks(section);
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=unsuccessTask&taskid=" + taskid, true);
    xmlhttp.send();
}

function getTasks(section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("taskList").innerHTML = this.responseText;
            let titleToday = '<i class="fa-solid fa-bell mb-4"></i> Today <span class="text-secondary"> - <span id="taskCount"></span>';
            let titleUpcoming = '<i class="fa-solid fa-angles-right mb-4"></i> Upcoming <span class="text-secondary"> - <span id="taskCount"></span>';
            let titleCalendar = '<i class="fa-solid fa-angles-left mb-4"></i> Outdated <span class="text-secondary"> - <span id="taskCount"></span>';
            switch (section) {
                case "today":
                    document.getElementById("taskTitle").innerHTML = titleToday;
                    break;
                case "upcoming":
                    document.getElementById("taskTitle").innerHTML = titleUpcoming;
                    break;
                case "former":
                    document.getElementById("taskTitle").innerHTML = titleCalendar;
                    break;
            }
            currentPage = section;
            getTaskCount(section);
            if (removeMode) {
                let removeButtons = document.getElementsByName("removeButton");
                removeButtons.forEach(btn => {
                    btn.classList.remove("d-none")
                });
            }
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=getTasks&section=" + section, true);
    xmlhttp.send();
}

function getTaskCount(section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (document.getElementById("taskCount") != null) {
                document.getElementById("taskCount").innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=getTaskCount&section=" + section, true);
    xmlhttp.send();
}

let intervalID;

function removeModeSW() {
    let removeButtons = document.getElementsByName("removeButton");
    switch (removeMode) {
        case true:
            removeMode = false;
            removeButtons.forEach(btn => {
                btn.classList.add("d-none")
            });
            document.getElementById("removemodswitch").classList.replace("btn-danger", "btn-dark");
            console.log("Remove mod deactivated");
            break;
        case false:
            removeMode = true;
            removeButtons.forEach(btn => {
                btn.classList.remove("d-none")
            });
            document.getElementById("removemodswitch").classList.replace("btn-dark", "btn-danger");
            console.log("Remove mod activated");
            break;
    }
}