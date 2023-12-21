<?php
$host = "localhost";
$user = "root";
$pass = "123qweasd";
$db = "dev";

$con = mysqli_connect($host, $user, $pass, $db);

switch ($_GET['action']) {
    case "addTask":
        $userid = $_COOKIE['login'];
        $task = $_GET['task'];
        $section = $_GET['section'];
        $tags = $_GET['tags'];
        $date = $_GET['date'];

        if (mysqli_query($con, "INSERT INTO tasks(user, task, section, tags, date) VALUES ('$userid', '$task', $section, '$tags', DATE('$date'))")) {
            echo "task created";
        } else {
            echo "error";
        }
        break;

    case "getTasks":
        $section = $_GET['section'];
        $query = mysqli_query($con, "SELECT * FROM tasks WHERE section = $section");
        while ($task = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            taskHTML($task);
        }
        break;

    case "successTask":
        $taskid = $_GET['taskid'];
        if (mysqli_query($con, "UPDATE tasks SET status = 1 WHERE id = $taskid")) {
            echo "task finished";
        } else {
            echo "error";
        }
        break;

    case "unsuccessTask":
        $taskid = $_GET['taskid'];
        if (mysqli_query($con, "UPDATE tasks SET status = 0 WHERE id = $taskid")) {
            echo "task finished";
        } else {
            echo "error";
        }
        break;

    case "getTaskCount":
        $section = $_GET['section'];
        $query = mysqli_query($con, "SELECT COUNT(*) FROM tasks WHERE section = $section");
        echo mysqli_fetch_row($query)['0'];
        break;

}

function taskHTML($task)
{
    if (!$task['status']) {
        echo "
        <p onclick='successTask({$task['id']},{$task['section']})' class='btn btn-dark bg-dark-subtle w-100 text-start mb-3'>
            <span class='me-5'>
                <i class='fa-solid fa-square me-2'></i>{$task['task']}
            </span>
            <span class='text-secondary'>
                <span class='me-4'>{$task['section']}</span>
                <span class='me-1 bg-dark p-1 ps-2 pe-2 rounded-3'>{$task['tags']}</span>
            </span>
            <span class='float-end text-secondary'>
                <i class='fa-solid fa-clock me-2'></i>{$task['date']}
            </span>
        </p>";
    } else {
        echo "
        <p onclick='unsuccessTask({$task['id']},{$task['section']})' class='btn btn-dark bg-dark-subtle w-100 text-start mb-3'>
            <span class='me-5 text-decoration-line-through text-success'>
                <i class='fa-solid fa-check me-2'></i>{$task['task']}
            </span>
            <span class='text-secondary'>
                <span class='me-4'>{$task['section']}</span>
                <span class='me-1 bg-dark p-1 ps-2 pe-2 rounded-3'>{$task['tags']}</span>
            </span>
            <span class='float-end text-secondary'>
                <i class='fa-solid fa-clock me-2'></i>{$task['date']}
            </span>
        </p>";
    }
}
?>