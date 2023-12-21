getTasks(1);
getTaskCount(1);

//setInterval(getUsers, 300);
function addTask(task, section, tags, date) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getTasks(section);
            getTaskCount(section);
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=addTask&task=" + task + "&section=" + section + "&tags=" + tags + "&date=" + date, true);
    xmlhttp.send();
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
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=getTasks&section=" + section, true);
    xmlhttp.send();
}

function getTaskCount(section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("taskCount").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "tools/functions.php?action=getTaskCount&section=" + section, true);
    xmlhttp.send();
}