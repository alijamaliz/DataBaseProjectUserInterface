<?php

$EVENTS_TABLE_NAME = "event";
$SUBJECTS_TABLE_NAME = "subject";
$LOCATIONS_TABLE_NAME = "location";
$DISCOUNT_CODES_TABLE_NAME = "discount_Code";
$HASH_TAGS_TABLE_NAME = "hashtag";
$COMMENTS_TABLE_NAME = "comment";
$USERS_TABLE_NAME = "user";
$EVENT_HOLDERS_TABLE_NAME = "event_holder";
$PARTICIPANTS_TABLE_NAME = "participant";
$TICKETS_TABLE_NAME = "ticket";
$EVENT_PARTICIPATE_TABLE_NAME = "participate";
$HOLDER_FOLLOW_TABLE_NAME = "follow";
$EVENT_DISCOUNT_TABLE_NAME = "event_discount";
$EVENT_HASH_TAG_TABLE_NAME = "event_hashtag";
$EVENT_COMMENTS_TABLE_NAME = "event_comment";
$HOLDER_COMMENTS_TABLE_NAME = "holder_comment";

$get_all_event = "
SELECT event.id as event_id,
    event.title as event_title,
    subject.text as subject_title,
    location.title as location_title,
    CONCAT(user.first_name, ' ', user.last_name) as holder_name,
    event.date_from as date_from,
    event.date_to as date_to
FROM `event` JOIN `subject` JOIN `location` JOIN `event_holder` JOIN `user`
WHERE `location`.`id` = `event`.`location_id` AND `subject`.`id` = `event`.`subject_id` AND 
  `event`.`holder_national_code` = `event_holder`.`user_national_code` AND 
  `event_holder`.`user_national_code` = `user`.`national_code`";
