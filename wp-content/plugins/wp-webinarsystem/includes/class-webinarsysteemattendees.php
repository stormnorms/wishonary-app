<?php

class WebinarSysteemAttendees
{
    public static function get_webinar_attendees($webinar_id)
    {
        global $wpdb;
        $table = WSWEB_DB_TABLE_PREFIX . 'subscribers';

        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table WHERE webinar_id=%d ORDER BY id DESC",
                $webinar_id
            )
        );
    }

    public static function get_by_webinar_id_and_key($webinar_id, $key)
    {
        global $wpdb;
        $table = WSWEB_DB_TABLE_PREFIX . 'subscribers';
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table WHERE webinar_id = %d AND random_key = %s",
                $webinar_id,
                $key
            )
        );
    }

    public static function get_by_session($webinar_id, $day, $time)
    {
        global $wpdb;
        $table = WSWEB_DB_TABLE_PREFIX . 'subscribers';

        $query = "SELECT *
            FROM $table
            WHERE webinar_id=%d AND watch_day=%s AND watch_time=%s
            ORDER BY id DESC";

        return $wpdb->get_results(
            $wpdb->prepare(
                $query,
                $webinar_id,
                $day,
                $time
            )
        );
    }

    public static function get_attendee_by_id($id)
    {
        global $wpdb;
        $table = WSWEB_DB_TABLE_PREFIX . 'subscribers';

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$table} WHERE id=%d LIMIT 1",
                $id
            )
        );
    }

    public static function add_or_update_attendee($array, $format = array())
    {
        global $wpdb;

        $attendee_data = self::get_attendee_by_email($array['email'], $array['webinar_id']);

        if (!empty($attendee_data)) {
            self::modify_attendee($attendee_data->id, $array, $format);
        } else {
            $wpdb->insert(WSWEB_DB_TABLE_PREFIX . "subscribers", $array, $format);
        }
    }

    public static function get_attendee_by_email($email, $webinar_id)
    {
        global $wpdb;
        $table = WSWEB_DB_TABLE_PREFIX . 'subscribers';

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table WHERE email=%s AND webinar_id=%d LIMIT 1",
                $email,
                $webinar_id
            )
        );
    }

    public static function modify_attendee($row_id, $columns, $format = array('%d'))
    {
        global $wpdb;
        return $wpdb->update(WSWEB_DB_TABLE_PREFIX . 'subscribers', $columns, array('id' => $row_id), $format, array('%d'));
    }

    public static function update_last_seen($attendee_id, $seconds_attended = null) {

        // get the attendee
        $attendee = self::get_attendee_by_id($attendee_id);

        if ($attendee == null) {
            WebinarSysteemLog::log("Attendee not found, exiting");
            return false;
        }

        $attended = $attendee->attended;

        // if we have seconds attended (the page is live) and we have not yet
        // attended then fire events and set to attended
        if ($attendee->attended == 0 && $seconds_attended > 0) {
            WebinarSysteemLog::log("Firing attended flags for {$attendee_id}");
            WebinarSysteemWebHooks::send_attended($attendee->webinar_id, $attendee);
            WebinarSysteemActions::fire_attended($attendee->webinar_id, $attendee);

            $attended = 1;
        }

        // update the attendee
        if ($seconds_attended != null) {
            return self::modify_attendee(
                $attendee_id,
                [
                    'attended' => $attended,
                    'last_seen' => gmdate('Y-m-d H:i:s'),
                    'seconds_attended' => $seconds_attended
                ],
                ['%d', '%s', '%d']);
        }

        return self::modify_attendee(
            $attendee_id,
            [
                'attended' => $attended,
                'last_seen' => gmdate('Y-m-d H:i:s')
            ],
            ['%d', '%s']);
    }

    public static function update_last_seen_multiple($attendee_ids, $seconds_to_add = 0) {
        WebinarSysteemLog::log("Got multiple attendee last seen update: ".json_encode($attendee_ids));
        foreach ($attendee_ids as $attendee_id) {
            self::update_last_seen($attendee_id, $seconds_to_add);
        };
    }

    public static function get_attendee($webinar_id)
    {
        $data = WebinarSysteemAttendees::get_attendee_session();

        if (!isset($data->email) || !isset($data->random_key)) {
            return array();
        }

        global $wpdb;
        $table = WSWEB_DB_TABLE_PREFIX . 'subscribers';

        $query = "
          SELECT *
          FROM {$table}
          WHERE webinar_id=%d AND
            email=%s AND
            random_key=%s
          LIMIT 1
        ";

        $attendee = null;

        return $wpdb->get_row(
            $wpdb->prepare($query, $webinar_id, $data->email, $data->random_key)
        );
    }

    public static function get_attendee_session()
    {
        $obj = new stdClass();

        if (isset($_COOKIE['_wswebinar_registered_email']))
            $obj->email = $_COOKIE['_wswebinar_registered_email'];

        if (isset($_COOKIE['_wswebinar_registered_key']))
            $obj->key = $_COOKIE['_wswebinar_registered_key'];

        if (isset($_COOKIE['_wswebinar_regrandom_key']))
            $obj->random_key = $_COOKIE['_wswebinar_regrandom_key'];

        return $obj;
    }

    public static function get_attendee_count($webinar_id)
    {
        global $wpdb;
        $table = WSWEB_DB_TABLE_PREFIX . 'subscribers';

        return $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$table} WHERE webinar_id=%d",
                $webinar_id
            )
        );
    }

    public static function notification_has_been_sent($attendee, $type, $isRecurring)
    {
        global $wpdb;
        /*
        * Email Types
        *
        * One Hour Email = 1;
        * One Day Email = 2;
        * Webinar Starting Email = 3;
        */

        if ($isRecurring) {
            $table = WSWEB_DB_TABLE_PREFIX . 'notifications';
            $query = "SELECT COUNT(*)
                FROM {$table}
                WHERE attendee_id=%d AND
                    notification_type=%s AND
                    DATE(sent_at) > (NOW() - INTERVAL 6 DAY);";

            return (bool)$wpdb->get_var(
                $wpdb->prepare(
                    $query,
                    $attendee->id,
                    $type
                )
            );
        }

        switch ($type) {
            case 1:
                return $attendee->onehourmailsent == 1;

            case 2:
                return $attendee->onedaymailsent == 1;

            case 3:
                return $attendee->wbstartingmailsent == 1;
        }

        return false;
    }

    /*
     * 
     * Create and let user to download attendee CSV of a requested webinar.
     * 
     */

    public static function set_attendee_has_been_notified($attendee, $type, $isRecurring)
    {
        /*
        * Email Types
        *
        * One Hour Email = 1;
        * One Day Email = 2;
        * Webinar Starting Email = 3;
        */

        if ($isRecurring) {
            self::saveNotificationSend($attendee->id, $type);
        } else {
            switch ($type) {
                case 1:
                    $key = 'onehourmailsent';
                    break;

                case 2:
                    $key = 'onedaymailsent';
                    break;

                case 3:
                    $key = 'wbstartingmailsent';
                    break;

                default:
                    return;
            }

            self::update_attendee($attendee->id, [$key => '1'], ['%d']);
        }
    }


    public static function saveNotificationSend($attendeeId, $type)
    {
        global $wpdb;

        return $wpdb->insert(
            WSWEB_DB_TABLE_PREFIX . 'notifications',
            ['attendee_id' => $attendeeId, 'notification_type' => $type],
            ['%d', '%d']
        );
    }

    public static function delete_attendees($webinar_id, $attendee_ids)
    {
        global $wpdb;

        foreach ($attendee_ids as $attendee_id) {
            $wpdb->delete(
                WebinarSysteemTables::get_subscribers(), [
                    'webinar_id' => $webinar_id,
                    'id' => (int)$attendee_id
                ]
            );
        }
    }

    public static function update_attendee($row_id, $columns, $format = ['%d'])
    {
        global $wpdb;
        return $wpdb->update(
            WSWEB_DB_TABLE_PREFIX . 'subscribers',
            $columns,
            ['id' => $row_id], $format, ['%d']);
    }

    public static function set_attendee_is_not_newly_registered($attendee) {
        self::update_attendee($attendee->id, ['newly_registered' => '0'], ['%d']);
    }
}
