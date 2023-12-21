<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TooDoo</title>
    <script src="https://kit.fontawesome.com/2a63621396.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body class="bg-dark overflow-x-hidden" data-bs-theme="dark">
    <div class="row align-top g-2 text-light" style="min-height: 100vh;">
        <div class="col-3 text-start justify-content-start align-items-start d-none d-md-block">
            <div class="position-fixed w-25 pe-3 bg-dark-subtle h-100">
                <h1 class="text-warning m-3">TooDoo</h1>
                <div class="m-4">
                    <input class="form-control w-100 ms-2 me-2 mb-4" type="text" placeholder="Search...">
                    <h5>Tasks</h5>
                    <p class="btn btn-dark w-100 text-start ms-2 me-2">Today<span class="float-end"><i
                                class="fa-solid fa-bell"></i></span></p>
                    <p class="btn btn-dark w-100 text-start ms-2 me-2">Upcoming<span class="float-end"><i
                                class="fa-solid fa-angles-right"></i></span></p>
                    <p class="btn btn-dark w-100 text-start ms-2 me-2">Calendar<span class="float-end"><i
                                class="fa-solid fa-calendar"></i></span></p>
                    <h5>Projects<span class="float-end">+</span></h5>
                    <p class="btn btn-dark w-100 text-start ms-2 me-2">Project 1</span></p>
                </div>
            </div>
        </div>
        <div class="col text-center justify-content-center align-items-center">
            <div class="m-4 text-start">
                <h1 id="taskTitle"><i class="fa-solid fa-bell mb-4"></i> Today <span class="text-secondary"> - <span id="taskCount"></span></span>
                    <span onclick="addTask('1', 1, '1,2', '2012-05-12')" class="float-end me-2">+</span>
                </h1>
                <div id="taskList">

                </div>
            </div>

        </div>
    </div>
    <script>
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
    </script>
</body>

</html>