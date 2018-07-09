<?php

require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));
require_once(realpath(dirname(__FILE__) . "/../resources/queries.php"));

require_once(TEMPLATES_PATH . "/header.php");

$connection = new mysqli($config[db][host], $config[db][username], $config[db][password], $config[db][dbname]);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$subject_id = $_GET['id'];

$events = $connection->query(get_events_by_subject_id($subject_id));
?>

    <h1>رویدادهای حول این موضوع</h1>
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


<?php
$connection->close();
?>

<?php
require_once(TEMPLATES_PATH . "/footer.php");
?>