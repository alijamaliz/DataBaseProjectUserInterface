<?php

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
require_once(realpath(dirname(__FILE__) . "/../resources/queries.php"));

require_once(TEMPLATES_PATH . "/header.php");

$connection = new mysqli($config[db][host], $config[db][username], $config[db][password], $config[db][dbname]);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = $_GET['id'];

$event = $connection->query(get_event_by_id($id));
$comments = $connection->query(get_event_comments_by_id($id));
$hashtags = $connection->query(get_event_hashtags_by_id($id));
$participants = $connection->query(get_event_participants_by_id($id));

?>

    <h1>جزییات رویداد</h1>
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
        if ($event->num_rows == 1) {
            // output data of each row
            while ($row = $event->fetch_assoc()) {
                echo sprintf('<tr><th scope="row">%d</th><td>%d</td><td><a href="single-holder.php?username=%s">%s</a></td><td>%s</td><td>%s</td><td><a href="single-event.php?id=%d">%s</a></td><td>%d</td></tr>',
                    $row["date_to"], $row["date_from"], $row["holder_username"], $row["holder_name"], $row["location_title"], $row["subject_title"], $row["event_id"], $row["event_title"], $row["event_id"]);
            }
        } else {
            echo "Not found";
        }
        ?>

        </tbody>
    </table>


    <h1>برچسب‌ها</h1>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">برچسب</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($hashtags->num_rows > 0) {
            // output data of each row
            while ($row = $hashtags->fetch_assoc()) {
                echo sprintf('<tr><th scope="row">%s</th><td>%d</td>', $row["hashtag_text"], $row["hashtag_id"]);
            }
        } else {
            echo "Not found";
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
                echo sprintf('<tr><th scope="row">%s</th><td>%s</td><td>%d</td>', $row["comment_text"], $row["particicpant_name"], $row["comment_id"]);
            }
        } else {
            echo "Not found";
        }
        ?>

        </tbody>
    </table>


    <h1>شرکت‌کننده‌ها</h1>
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">شماره‌ملی</th>
            <th scope="col">شماره‌تلفن</th>
            <th scope="col">جنسیت</th>
            <th scope="col">نام</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if ($participants->num_rows > 0) {
            $i = 1;
            // output data of each row
            while ($row = $participants->fetch_assoc()) {
                $gender = "مرد";
                if ($row["participant_gender"] == 0)
                    $gender = "زن";
                echo sprintf('<tr><th scope="row">%s</th><td>%s</td><td>%s</td><td>%s</td><td>%d</td>', $row["participant_national_code"], $row["participant_number"], $gender, $row["participant_name"], $i);
                $i++;
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