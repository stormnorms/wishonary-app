<?php

class WebinarSysteemPages {
    protected static function write_page($id, $params = []) {
        $ajax_url = admin_url('admin-ajax.php');
        ?>
        <div
            id="<?= $id ?>"
            data-url="<?= $ajax_url ?>"
            data-params='<?= str_replace('\'', '&apos;', json_encode($params)) ?>'
        ></div>
        <?php
    }

    public static function registration_widgets() {
        wp_enqueue_editor();
        self::write_page("wpws-registration-widgets");
    }

    public static function webinar_list() {
        if (isset($_GET['webinar_id'])) {
            wp_enqueue_editor();
            // wp_enqueue_media();
            self::write_page("wpws-webinar-editor", [
                'webinar_id' => $_GET['webinar_id'],
                'enabled_mailinglist_providers' => WebinarsysteemMailingListIntegrations::get_enabled_providers(),
                'woo_commerce_is_enabled' => WebinarSysteemWooCommerceIntegration::is_ready(),
                'is_cron_active' => WebinarSysteemCron::was_active_within(),
                'translations' => WebinarSysteemSettings::instance()->get_translations(),
                'max_hosted_attendee_count' => 0
            ]);
            return;
        }

        self::write_page("wpws-webinar-list");
    }

    public static function new_webinar() {
        wp_enqueue_editor();

        self::write_page("wpws-webinar-editor", [
            'webinar_id' => null,
            'enabled_mailinglist_providers' => WebinarsysteemMailingListIntegrations::get_enabled_providers(),
            'woo_commerce_is_enabled' => WebinarSysteemWooCommerceIntegration::is_ready(),
            'is_cron_active' => WebinarSysteemCron::was_active_within(),
            'translations' => WebinarSysteemSettings::instance()->get_translations(),
            'max_hosted_attendee_count' => 0
        ]);
    }

    public static function attendees() {
        $webinar_id = isset($_GET['id']) ? $_GET['id'] : null;
        self::write_page("wpws-attendees", [
            'webinar_id' => (int) $webinar_id,
        ]);
    }

    public static function chats() {
        $webinar_id = isset($_GET['id']) ? $_GET['id'] : null;
        self::write_page("wpws-chats", [
            'webinar_id' => (int) $webinar_id,
        ]);
    }

    public static function questions() {
        $webinar_id = isset($_GET['id']) ? $_GET['id'] : null;
        self::write_page("wpws-questions", [
            'webinar_id' => (int) $webinar_id,
        ]);
    }

    public static function settings() {
        wp_enqueue_editor();
        self::write_page("wpws-settings", []);
    }

    public static function redirect_to_pro_upgrade() {
        wp_redirect('https://getwebinarpress.com/?utm_source=freeplugin&utm_medium=menulink&utm_content=menulink&utm_campaign=menu-upgrade');
        exit();
    }

    public static function webinar_recordings() {
        self::write_page("wpws-webinar-recordings", [
            'license_key' => ''
        ]);
    }
}
