<?php

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
require_once(realpath(dirname(__FILE__) . "/../resources/queries.php"));

require_once(TEMPLATES_PATH . "/header.php");

$connection = new mysqli($config[db][host], $config[db][username], $config[db][password], $config[db][dbname]);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$national_code = $_GET['national_code'];

$participant = $connection->query(get_participant_by_national_code($national_code));
$events = $connection->query(get_participant_events_by_national_code($national_code));
$comments = $connection->query(get_participant_comments_by_national_code($national_code));


?>

    <h1>مشخصات شرکت‌کننده</h1>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">شماره موبایل</th>
            <th scope="col">جنسیت</th>
            <th scope="col">رایانامه</th>
            <th scope="col">نام</th>
            <th scope="col">شماره‌ملی</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($participant->num_rows == 1) {
            // output data of each row
            while ($row = $participant->fetch_assoc()) {
                $gender = "مرد";
                if ($row["participant_gender"] == 0)
                    $gender = "زن";
                echo sprintf('<tr><th scope="row">%s</th><td>%s</td><td>%s</td><td><a href="single-participant.php?national_code=%s">%s</a></td><td>%s</td></tr>',
                    $row["participant_number"], $gender, $row["participant_email"], $row["participant_national_code"], $row["participant_name"], $row["participant_national_code"]);
            }
        } else {
            echo "یافت نشد";
        }
        ?>

        </tbody>
    </table>

    <h1>رویدادهای شرکت‌کننده</h1>
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
            echo "موردی یافت نشد";
        }
        ?>

        </tbody>
    </table>


    <h1>نظرات داده شده</h1>
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
                echo sprintf('<tr><th scope="row">%s</th><td><a href="single-participant.php?national_code=%s">%s</a></td><td>%d</td>',
                    $row["comment_text"], $row["participant_national_code"], $row["participant_name"], $row["comment_id"]);
            }
        } else {
            echo "Not found";
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