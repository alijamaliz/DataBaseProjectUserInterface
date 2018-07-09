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


function get_event_by_id($id)
{
    return "
SELECT event.id as event_id,
    event.title as event_title,
    subject.text as subject_title,
    location.title as location_title,
    CONCAT(user.first_name, ' ', user.last_name) as holder_name,
    event.date_from as date_from,
    event.date_to as date_to
FROM `event` JOIN `subject` JOIN `location` JOIN `event_holder` JOIN `user`
WHERE `event`.`id` = $id AND `location`.`id` = `event`.`location_id` AND `subject`.`id` = `event`.`subject_id` AND 
  `event`.`holder_national_code` = `event_holder`.`user_national_code` AND 
  `event_holder`.`user_national_code` = `user`.`national_code`";
}


function get_event_comments_by_id($id)
{
    return "SELECT comment.id as comment_id, comment.text as comment_text, concat(user.first_name, ' ', user.last_name) as particicpant_name
            FROM `user` JOIN event_comment JOIN comment WHERE event_id = $id AND 
            event_comment.comment_id = comment.id AND event_comment.participant_national_code = user.national_code";
}

function get_event_hashtags_by_id($id)
{
    return "SELECT hashtag.id as hashtag_id, hashtag.text as hashtag_text 
            FROM event_hashtag JOIN hashtag WHERE event_id = $id AND event_hashtag.hashtag_id = hashtag.id";
}

function get_event_participants_by_id($id)
{
    return "SELECT concat(`user`.first_name, ' ', `user`.last_name) as participant_name, `participant`.gender as participant_gender, 
                  `user`.mobile_number as participant_number, `user`.national_code as participant_national_code
            FROM `participant` JOIN `participate` JOIN `user` 
            WHERE event_id = $id AND participant.user_national_code = participate.participant_national_code 
            AND participant.user_national_code = `user`.national_code";
}