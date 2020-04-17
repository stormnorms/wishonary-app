<?php

class WebinarSysteemEmails {
    protected static $ONE_HOUR_BEFORE = 1;
    protected static $ONE_DAY_BEFORE = 2;
    protected static $STARTING = 3;
    protected static $REPLAY = 4;

    public function __construct() {
        add_action('init', [$this, 'register_mail_sender']);
        add_action('wswebinar_send_scheduled_mails', [$this, 'send_scheduled_emails']);
        add_action('wswebinar_send_queued_mails', [$this, 'send_queued_emails']);
        add_filter('cron_schedules', [$this, 'cron_add_5_minutes']);
    }

    public function send_question_to_host($webinar_id, $attendee_name, $attendee_email, $question) {
        $webinar = WebinarSysteemWebinar::create_from_id($webinar_id);
        $email_questions = $webinar->get_email_questions_to_host();

        if (!$email_questions) {
            return false;
        }

        $to = $webinar->get_email_questions_address();

        if (empty($to)) {
            $to = WebinarSysteemSettings::instance()->get_admin_email_address();
        }

        // TODO, replace this with something customisable by the user?
        $content = "Hey,

{$attendee_name} asked the following question during {$webinar->get_name()}:

<i>$question</i>";

        $content = apply_filters('meta_content', $content);

        return $this->send_email(
            $webinar_id,
            $to,
            'New question from '.$attendee_email,
            $content,
            true);
    }

    public function send_attendee_email($email_settings, $attendee, $to, $send_later = false) {
        if (!$email_settings->enabled) {
            WebinarSysteemLog::log("Email type is disabled, not sending to {$to}");
            return false;
        }

        WebinarSysteemLog::log("Sending email to {$to}");

        $body = self::replace_tags(
            $email_settings->content,
            $attendee->webinar_id,
            $attendee->name,
            $attendee->email,
            $attendee->secretkey
        );

        $subject = self::replace_tags(
            $email_settings->subject,
            $attendee->webinar_id,
            $attendee->name,
            $attendee->email,
            $attendee->secretkey,
            false);

        return $this->send_email($attendee->webinar_id, $to, $subject, $body, false, $send_later);
    }

    public function send_preview($to, $subject, $content, $attendee_name = 'Joe Bloggs') {
        $posts = query_posts(['post_type' => 'wswebinars']);
        $post_id = $posts[0]->ID;

        $body = self::replace_tags(
            $content,
            $post_id,
            $attendee_name,
            $to, null);

        $subject = self::replace_tags(
            $subject,
            $post_id,
            $attendee_name,
            $to,
            null,
            false);

        return $this->send_email($post_id, $to, $subject, $body);
    }

    function get_email_settings($webinar_id, $type) {
        $settings = WebinarSysteemSettings::instance();
        return $settings->get_email_template_options($type);
    }

    public function send_new_registration_email_to_admin($attendee) {
        return $this->send_attendee_email(
            $this->get_email_settings($attendee->webinar_id, 'newreg'),
            $attendee,
            WebinarSysteemSettings::instance()->get_admin_email_address(),
            true);
    }

    public function send_new_registration_email($attendee) {
        return $this->send_attendee_email(
            $this->get_email_settings($attendee->webinar_id, 'regconfirm'),
            $attendee,
            $attendee->email,
            true);
    }

    public function send_mail_to_attendee_24hr_template($attendee) {
        return $this->send_attendee_email(
            $this->get_email_settings($attendee->webinar_id, '24hrb4'),
            $attendee,
            $attendee->email);
    }

    public function send_mail_to_attendee_1hr_template($attendee) {
        return $this->send_attendee_email(
            $this->get_email_settings($attendee->webinar_id, '1hrb4'),
            $attendee,
            $attendee->email);
    }

    public function send_mail_to_attendee_started_template($attendee) {
        return $this->send_attendee_email(
            $this->get_email_settings($attendee->webinar_id, 'wbnstarted'),
            $attendee,
            $attendee->email);
    }

    public function send_mail_to_reader_on_wc_order_complete($attendee) {
        $this->send_attendee_email(
            $this->get_email_settings($attendee->webinar_id, 'order_complete'),
            $attendee,
            $attendee->email,
            true);
    }

    public function send_webinar_reply_email($attendee) {
        return $this->send_attendee_email(
            $this->get_email_settings($attendee->webinar_id, 'wbnreplay'),
            $attendee,
            $attendee->email,
            false);
    }

    public static function replace_tags($text, $webinar_id, $name, $email, $secret, $is_html = true) {
        try {
            $webinar = WebinarSysteemWebinar::create_from_id($webinar_id);

            if ($webinar == null) {
                return $text;
            }

            $wb_timezone = get_post_meta($webinar_id, '_wswebinar_timezoneidentifier', true);
            $time_format = WebinarSysteem::get_wp_datetime_formats(WebinarSysteem::$WP_TIME_FORMAT);
            $wp_date_format = WebinarSysteem::get_wp_datetime_formats(WebinarSysteem::$WP_DATE_FORMAT);

            if (empty($wb_timezone)) {
                $timezone_string = get_option('timezone_string');
                $wpoffset = get_option('gmt_offset');
                $gmt_offset = WebinarSysteemDateTime::format_timezone(($wpoffset > 0) ? '+' . $wpoffset : $wpoffset);
                $wb_timezone = (!empty($timezone_string)) ? $timezone_string : 'UTC' . $gmt_offset . '';
            }

            if ($webinar->is_recurring()) {
                $attendee = WebinarSysteemAttendees::get_attendee_by_email($email, $webinar_id);
                $time = $attendee->exact_time;
                $wb_time = date($time_format, strtotime($time));
                $wb_date = date($wp_date_format, strtotime($time));
            } else {
                $data_hour = get_post_meta($webinar_id, '_wswebinar_gener_hour', true);
                $data_min = get_post_meta($webinar_id, '_wswebinar_gener_min', true);
                $wb_time = date($time_format, strtotime($data_hour . ':' . $data_min));

                $gener_date = get_post_meta($webinar_id, '_wswebinar_gener_date', true);
                $wb_date = date($wp_date_format, strtotime($gener_date));
            }

            // generate the webinar url
            if ($secret != null) {
                $webinar_link = $webinar->get_url_with_auth($email, $secret);
            } else {
                $webinar_link = get_permalink($webinar_id, false);
            }

            $replacements = [
                'attendee-name' => $name,
                'attendee-email' => $email,
                'receiver-name' => $name,
                'receiver-email' => $email,
                'webinar-title' => get_the_title($webinar_id),
                'webinar-link' => $webinar_link,
                'webinar-link-button' => function ($args) use ($webinar_link) {
                    $text = __('Join the webinar', WebinarSysteem::$lang_slug);
                    if (isset($args->text)) {
                        $text = $args->text;
                    }
                    return self::render_link_button_html(
                        $text,
                        $webinar_link
                    );
                },
                'webinar-date' => $wb_date,
                'webinar-time' => $wb_time,
                'webinar-timezone' => $wb_timezone
            ];

            return WebinarSysteemHelperFunctions::replace_tags($text, $replacements, $is_html);

        } catch (Exception $e) {
            return $text;
        }
    }

    private function get_email_headers() {
        $settings = WebinarSysteemSettings::instance();
        $name = $settings->get_email_from_name();
        $email = $settings->get_email_from_address();

        $headers = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=utf-8";
        $headers[] = "From: ".$name." <".$email.'>';

        return implode("\r\n", $headers);
    }

    protected static function render_link_button_html($text, $url) {
        // get settings
        $settings = WebinarSysteemSettings::instance();

        $params = (object) [
            'text' => $text,
            'url' => $url,
            'button_background_color' => $settings->get_email_button_background_color(),
            'button_text_color' => $settings->get_email_button_text_color(),
        ];

        // render the file
        $file = WebinarSysteemTemplates::get_path('template-email-cta.php');
        ob_start();
        include $file;

        // return the contents
        return ob_get_clean();
    }

    private function render_webinar_email(
        $title,
        $content,
        $include_unsubscribe_link,
        $manage_url,
        $unsubscribe_url
    ) {
        // get settings
        $settings = WebinarSysteemSettings::instance();

        $params = (object) [
            'title' => $title,
            'preview' => $title,
            'content' => $content,
            'include_unsubscribe_link' => $include_unsubscribe_link,
            'manage_url' => $manage_url,
            'unsubscribe_url' => $unsubscribe_url,
            'footer_text' => $settings->get_email_footer_text(),
            'header_image_url' => $settings->get_email_header_image(),
            'base_color' => $settings->get_email_base_color(),
            'background_color' => $settings->get_email_background_color(),
            'body_background_color' => $settings->get_email_body_background_color(),
            'text_color' => $settings->get_email_body_text_color(),
        ];

        // render the file
        $file = WebinarSysteemTemplates::get_path('template-email-layout.php');
        ob_start();
        include $file;

        // return the contents
        return ob_get_clean();
    }

    private function send_email(
        $webinar_id,
        $to,
        $subject,
        $body,
        $disable_unsubscribe_links = false,
        $send_later = false
    ) {
        $settings = WebinarSysteemSettings::instance();
        $unsubscribe_url = WebinarSysteemUserPages::get_unsubscribe_url($webinar_id, $to);
        $manage_url = WebinarSysteemUserPages::get_email_management_url($to);

        $body = $this->render_webinar_email(
            $subject,
            $body,
            $settings->get_include_unsubscribe_links() && !$disable_unsubscribe_links,
            $manage_url,
            $unsubscribe_url);

        if ($send_later) {
            WebinarSysteemLog::log("Queuing mail to send later ($to, $subject)");

            $this->enqueue_mail_for_sending_later((object) [
                'to' => $to,
                'subject' => $subject,
                'body' => $body
            ]);

            return true;
        }

        WebinarSysteemLog::log("Sending webinar email ($to, $subject)");
        $email_was_sent = wp_mail($to, $subject, $body, $this->get_email_headers());

        if ($email_was_sent == true) {
            WebinarSysteemLog::log("Email successfully sent (according to wp_mail)");
        } else {
            WebinarSysteemLog::log("Failed to send (according to wp_mail)");
        }

        return $email_was_sent;
    }

    /*
     * Queue an email for sending later so it doesn't block the response to the visitor
     * Some email servers are really slow which can cause delays when registering
     */

    public function enqueue_mail_for_sending_later($args) {
        global $wpdb;
        $wpdb->insert(WebinarSysteemTables::get_email_queue(),
            ['args' => serialize($args)],
            ['%s']);
    }

    public function send_queued_emails() {
        global $wpdb;

        // update the cron last active time
        WebinarSysteemCron::update_cron_last_active();
        WebinarSysteemLog::log('Sending queued emails');

        while (true) {
            $table = WebinarSysteemTables::get_email_queue();
            $row = $wpdb->get_row("SELECT * FROM $table LIMIT 1");

            // no emails to process
            if ($row == null) {
                WebinarSysteemLog::log('No more queued emails, exiting');
                break;
            }

            // delete the row from the db
            $wpdb->delete(
                WebinarSysteemTables::get_email_queue(), ['id' => (int)$row->id]
            );

            // send the mail
            $args = unserialize($row->args);

            WebinarSysteemLog::log("Sending webinar email from queue ($args->to, $args->subject)");
            $email_was_sent = wp_mail($args->to, $args->subject, $args->body, $this->get_email_headers());

            if ($email_was_sent == true) {
                WebinarSysteemLog::log("Email successfully sent (according to wp_mail)");
            } else {
                WebinarSysteemLog::log("Failed to send (according to wp_mail)");
            }
        }
    }

    /**
     *
     * @param WebinarSysteemWebinar $webinar
     * @param string $type
     * @return object
     *
     */

    protected function get_second_range_for_type($webinar, $type) {
        switch ($type) {
            case self::$ONE_HOUR_BEFORE:
                return (object) [
                    'description' => 'one hour before',
                    'from' => 55,
                    'to' => 65,
                    'multiplier' => MINUTE_IN_SECONDS,
                    'sent_field' => 'onehourmailsent',
                    'offset_duration' => false
                ];

            case self::$ONE_DAY_BEFORE:
                return (object) [
                    'description' => 'one day before',
                    'from' => 23,
                    'to' => 24,
                    'multiplier' => HOUR_IN_SECONDS,
                    'sent_field' => 'onedaymailsent',
                    'offset_duration' => false
                ];

            case self::$STARTING:
                return (object) [
                    'description' => '5 minutes before',
                    'from' => -5,
                    'to' => 5,
                    'multiplier' => MINUTE_IN_SECONDS,
                    'sent_field' => 'wbstartingmailsent',
                    'offset_duration' => false
                ];

            case self::$REPLAY:
                return (object) [
                    'description' => '10 minutes after (replay)',
                    // using negative values because we are checking after the webinar ends.. not before it starts :/
                    'from' => -10,
                    'to' => 0,
                    'multiplier' => MINUTE_IN_SECONDS,
                    'sent_field' => 'replaymailsent',
                    'offset_duration' => true
                ];

            default:
                return null;
        }
    }

    protected function send_email_for_type($type, $attendee) {
        switch ($type) {
            case self::$STARTING:
                return $this->send_mail_to_attendee_started_template($attendee);

            case self::$ONE_HOUR_BEFORE:
                return $this->send_mail_to_attendee_1hr_template($attendee);

            case self::$ONE_DAY_BEFORE:
                return $this->send_mail_to_attendee_24hr_template($attendee);

            case self::$REPLAY:
                return $this->send_webinar_reply_email($attendee);

            default:
                return false;
        }
    }

    /**
     *
     * @param WebinarSysteemWebinar $webinar
     * @param string $type
     * @return void
     *
     */

    protected function send_scheduled_emails_between($webinar, $type) {
        global $wpdb;

        $config = $this->get_second_range_for_type($webinar, $type);

        $webinar_title = get_the_title($webinar->id);
        WebinarSysteemLog::log("Checking emails for {$webinar_title} ({$webinar->id}) {$config->description}");

        $subscribers_table = WebinarSysteemTables::get_subscribers();
        $notifications_table = WebinarSysteemTables::get_notifications();

        $webinar_now = date('Y-m-d H:i:s',
            WebinarSysteemWebinar::get_now_in_webinar_timezone($webinar->id));

        // add an offset of the webinar time
        $offset = $config->offset_duration
            ? $webinar->get_duration()
            : 0;

        // Calculate the time from webinar end
        $sql = "
            SELECT s.id, s.name, s.email, s.webinar_id, s.secretkey
            FROM {$subscribers_table} s
            LEFT JOIN {$notifications_table} n
              ON s.id = n.attendee_id
                AND n.notification_type = %d
            WHERE webinar_id=%d
                AND DATE_ADD(exact_time, INTERVAL %d SECOND) > DATE_ADD(%s, INTERVAL %d SECOND)
                AND DATE_ADD(exact_time, INTERVAL %d SECOND) < DATE_ADD(%s, INTERVAL %d SECOND)
                AND s.{$config->sent_field} != 1
                AND n.id IS null
        ";

        $query = $wpdb->prepare(
            $sql,
            $type,
            $webinar->id,
            $offset,
            $webinar_now,
            $config->from * $config->multiplier,
            $offset,
            $webinar_now,
            $config->to * $config->multiplier);

        $attendees = $wpdb->get_results($query);

        if (!empty($attendees)) {
            WebinarSysteemLog::log('Found '.count($attendees).' attendees');
        }

        foreach ($attendees as $attendee) {
            WebinarSysteemLog::log("Sending email to {$attendee->email} for webinar {$attendee->webinar_id}");

            $this->send_email_for_type($type, $attendee);

            $wpdb->insert(
                $notifications_table,
                ['attendee_id' => $attendee->id, 'notification_type' => $type],
                ['%d', '%d']
            );
        }
    }

    public function send_replay_emails($webinar_id) {
        global $wpdb;

        $webinar_title = get_the_title($webinar_id);
        WebinarSysteemLog::log("Checking replay emails for {$webinar_title} ({$webinar_id})");

        $subscribers_table = WebinarSysteemTables::get_subscribers();
        $notifications_table = WebinarSysteemTables::get_notifications();

        $sql = "
            SELECT s.id, s.name, s.email, s.webinar_id, s.secretkey
            FROM {$subscribers_table} s
            LEFT JOIN {$notifications_table} n
              ON s.id = n.attendee_id
                AND n.notification_type = %d
            WHERE webinar_id=%d
                AND s.replaymailsent != 1
                AND n.id IS null
        ";

        $attendees = $wpdb->get_results(
            $wpdb->prepare(
                $sql,
                self::$REPLAY,
                $webinar_id)
        );

        if (!empty($attendees)) {
            WebinarSysteemLog::log('Found '.count($attendees).' attendees');
        }

        foreach ($attendees as $attendee) {
            WebinarSysteemLog::log("Sending replay email to {$attendee->email} for webinar {$attendee->webinar_id}");

            $this->send_email_for_type(self::$REPLAY, $attendee);

            $wpdb->insert(
                $notifications_table,
                ['attendee_id' => $attendee->id, 'notification_type' => self::$REPLAY],
                ['%d', '%d']
            );
        }
    }

    public function send_scheduled_emails() {
        /*
         * TODO, add exact_time_utc to attendees so we can just do one query for each
         *
         * The problem with that is if there is an hour change after the user registers the UTC
         * time will then be wrong.
         *
         * Is the only way to accurately check the time is re-calculate it every time? It could be done
         * by calculating the UTC time in the webinar for a future date?
         */

        $loop = new WP_Query([
            'post_type' => 'wswebinars',
            'meta_key' => '_wswebinar_gener_webinar_status',
            'meta_value' => 'clo',
            'meta_compare' => '!=',
            'posts_per_page' => -1,
            'suppress_filters' => true,
        ]);

        while ($loop->have_posts()) {
            $loop->the_post();

            $webinar = WebinarSysteemWebinar::create_from_id(get_the_ID());

            $this->send_scheduled_emails_between($webinar, self::$STARTING);
            $this->send_scheduled_emails_between($webinar, self::$ONE_HOUR_BEFORE);
            $this->send_scheduled_emails_between($webinar, self::$ONE_DAY_BEFORE);

            if ($webinar->is_automated() && $webinar->get_automated_replay_enabled()) {
                $this->send_scheduled_emails_between($webinar, self::$REPLAY);
            }
        }

        // check manual reply posts
        $loop = new WP_Query([
            'post_type' => 'wswebinars',
            'meta_key' => '_wswebinar_gener_webinar_status',
            'meta_value' => 'rep',
            'meta_compare' => '=',
            'posts_per_page' => -1,
            'suppress_filters' => true,
        ]);

        while ($loop->have_posts()) {
            $loop->the_post();
            $this->send_replay_emails(get_the_ID());
        }
    }

    // add custom interval
    public function cron_add_5_minutes($schedules) {
        $schedules['every5minutes'] = [
            'interval' => 60 * 5,
            'display' => __('Every 5 minutes'),
        ];

        $schedules['every1minute'] = [
            'interval' => 60,
            'display' => __('Every 1 minute'),
        ];

        return $schedules;
    }

    public function register_mail_sender() {
        if (!wp_next_scheduled('wswebinar_send_scheduled_mails')) {
            wp_schedule_event(time(), 'every5minutes',
                'wswebinar_send_scheduled_mails');
        }

        if (!wp_next_scheduled('wswebinar_send_queued_mails')) {
            wp_schedule_event(time(), 'every1minute',
                'wswebinar_send_queued_mails');
        }
    }
}
