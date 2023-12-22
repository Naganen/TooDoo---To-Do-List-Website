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
        $descr = $_GET['descr'];
        $date = $_GET['date'];

        if (mysqli_query($con, "INSERT INTO tasks(user, task, section, descr, date) VALUES ('$userid', '$task', $section, '$descr', DATE('$date'))")) {
            echo "task created";
        } else {
            echo "error";
        }
        break;

    case "removeTask":
        $userid = $_COOKIE['login'];
        $taskid = $_GET['taskid'];

        if (mysqli_query($con, "DELETE FROM tasks WHERE id = $taskid")) {
            echo "task deleted";
        } else {
            echo "error";
        }
        break;

    case "getTasks":
        $section = $_GET['section'];
        switch ($section) {
            case 'today':
                $query = mysqli_query($con, "SELECT * FROM tasks WHERE date = CURDATE() ORDER BY date ASC");
                while ($task = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    taskHTML($task, $section);
                }
                break;
            case 'upcoming':
                $query = mysqli_query($con, "SELECT * FROM tasks WHERE date > CURDATE() ORDER BY date ASC");
                while ($task = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    taskHTML($task, $section);
                }
                break;
            case 'specific':
                $specificdate = $_GET['date'];
                $query = mysqli_query($con, "SELECT * FROM tasks WHERE date = DATE('$specificdate') ORDER BY date ASC");
                while ($task = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    taskHTML($task, $section);
                }
                break;
            default:
                $query = mysqli_query($con, "SELECT * FROM tasks WHERE section = $section ORDER BY date ASC");
                while ($task = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    taskHTML($task, $section);
                }
                break;
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
        switch ($section) {
            case 'today':
                $query = mysqli_query($con, "SELECT COUNT(*) FROM tasks WHERE date = CURDATE()");
                break;
            case 'upcoming':
                $query = mysqli_query($con, "SELECT COUNT(*) FROM tasks WHERE date > CURDATE()");
                break;
            case 'specific':
                $specificdate = $_GET['date'];
                $query = mysqli_query($con, "SELECT COUNT(*) FROM tasks WHERE date = DATE('$specificdate')");
                break;
            default:
                $query = mysqli_query($con, "SELECT COUNT(*) FROM tasks WHERE section = $section");
                break;

        }
        echo mysqli_fetch_row($query)['0'];
        break;

}

function taskHTML($task, $section)
{   
    $date = date_format(date_create($task['date']), 'd M Y');
    if (!$task['status']) {
        echo "
        <p onclick='taskManagement({$task['id']},\"{$section}\",{$task['status']})' class='btn btn-dark bg-dark-subtle w-100 text-start mb-3'>
            <span class='me-5'>
                <i class='fa-solid fa-square me-2'></i>{$task['task']}
            </span>
            <span class='text-secondary'>
                <span class='me-4'>{$task['section']}</span>
                <span class='me-1 bg-dark p-1 ps-2 pe-2 rounded-3'>{$task['descr']}</span>
            </span>
            <span class='float-end removeButton ms-2 text-danger d-none' name='removeButton'>
                <i class='fa-solid fa-trash'></i>
            </span>
            <span class='float-end text-secondary'>
                <i class='fa-solid fa-clock me-2'></i>{$date}
            </span>
        </p>";
    } else {
        echo "
        <p onclick='taskManagement({$task['id']},\"{$section}\",{$task['status']})' class='btn btn-dark bg-dark-subtle w-100 text-start mb-3'>
            <span class='me-5 text-decoration-line-through text-success'>
                <i class='fa-solid fa-check me-2'></i>{$task['task']}
            </span>
            <span class='text-secondary'>
                <span class='me-4'>{$task['section']}</span>
                <span class='me-1 bg-dark p-1 ps-2 pe-2 rounded-3'>{$task['descr']}</span>
            </span>
            <span class='float-end removeButton ms-2 text-danger d-none' name='removeButton'>
                <i class='fa-solid fa-trash'></i>
            </span>
            <span class='float-end text-secondary'>
                <i class='fa-solid fa-clock me-2'></i>{$date}
            </span>
        </p>";
    }
}
?>