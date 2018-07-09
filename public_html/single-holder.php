<?php

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
require_once(realpath(dirname(__FILE__) . "/../resources/queries.php"));

require_once(TEMPLATES_PATH . "/header.php");

$connection = new mysqli($config[db][host], $config[db][username], $config[db][password], $config[db][dbname]);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$username = $_GET['username'];

$holder = $connection->query(get_event_holder_by_username($username));
$events = $connection->query(get_holder_events_by_username($username));
$follower = $connection->query(get_holder_followers_by_username($username));
$comments = $connection->query(get_holder_comments_by_username($username));

?>

    <h1>مشخصات برگزارکننده</h1>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">شماره</th>
            <th scope="col">رایانامه</th>
            <th scope="col">نام</th>
            <th scope="col">عنوان</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($holder->num_rows == 1) {
            // output data of each row
            while ($row = $holder->fetch_assoc()) {
                echo sprintf('<tr><th scope="row">%s</th><td>%s</td><td><a href="single-participant.php?national_code=%s">%s</a></td><td>%s</td></tr>',
                    $row["holder_number"], $row["holder_email"], $row["holder_national_code"], $row["holder_name"], $row["holder_title"]);
            }
        } else {
            echo "یافت نشد";
        }
        ?>

        </tbody>
    </table>

    <h1>رویدادهای برگزارکننده</h1>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">تا تاریخ</th>
            <th scope="col">از تاریخ</th>
            <th scope="col">برگزارکننده</th>
            <th scope="col">مکان</th>
            <th scope="col">موضوع</th>
            <th scope="col">عنوان</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($events->num_rows > 0) {
            // output data of each row
            while ($row = $events->fetch_assoc()) {
                echo sprintf('<tr><th scope="row">%d</th><td>%d</td><td><a href="single-holder.php?username=%s">%s</a></td><td>%s</td><td><a href="single-subject.php?id=%d">%s</a></td><td><a href="single-event.php?id=%d">%s</a></td><td>%d</td></tr>',
                    $row["date_to"], $row["date_from"], $row["holder_username"], $row["holder_name"], $row["location_title"], $row["subject_id"], $row["subject_title"], $row["event_id"], $row["event_title"], $row["event_id"]);
            }
        } else {
            echo "موردی یافت نشد.";
        }
        ?>

        </tbody>
    </table>

    <h1>دنبال‌کننده‌ها</h1>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">جنسیت</th>
            <th scope="col">نام</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($follower->num_rows > 0) {
            // output data of each row
            while ($row = $follower->fetch_assoc()) {
                $gender = "مرد";
                if ($row["follower_gender"] == 0)
                    $gender = "زن";
                echo sprintf('<tr><th scope="row">%s</th><td><a href="single-participant.php?national_code=%s">%s</a></td></tr>',
                    $gender, $row["follower_national_code"], $row["follower_name"]);
            }
        } else {
            echo "موردی یافت نشد.";
        }
        ?>

        </tbody>
    </table>



    <h1>نظرات</h1>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">نظر</th>
            <th scope="col">کاربر</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($comments->num_rows > 0) {
            // output data of each row
            while ($row = $comments->fetch_assoc()) {
                echo sprintf('<tr><th scope="row">%s</th><td>%s</td><td>%d</td></tr>',
                    $row["comment_text"], $row["particicpant_name"], $row["comment_id"]);
            }
        } else {
            echo "موردی یافت نشد.";
        }
        ?>

        </tbody>
    </table>

<?php
$connection->close();
?>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>