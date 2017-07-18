<?php

class Show {

    /**
     * Format full name to apresentation.
     * 
     * @param string $full_name
     * @return string
     */
    public static function name($full_name) {
        $new_name = '';

        foreach (explode(' ', mb_strtolower($full_name)) as $name)
            $new_name .= ucfirst($name) . ' ';

        return substr($new_name, 0, strlen($new_name) - 1);
    }

    /**
     * Format full name to first name.
     * 
     * @param string $name
     * 
     * @return string
     */
    public static function firstName($full_name) {
        $full_name = explode(' ', $full_name);
        return ucfirst(mb_strtolower($full_name[0]));
    }

    /**
     * Format date time to date pr-BR.
     * 
     * @param string $date
     * @return string
     */
    public static function dateHour($date) {
        $date = explode(' ', $date);

        $hour = explode(':', $date[1]);
        $date = explode('-', $date[0]);

        return $date[2] . '/' . $date[1] . '/' . $date[0] . ' ' . $hour[0] . ':' . $hour[1];
    }

    /**
     * Format ID to front apresentation.
     * 
     * @param string $string
     * @param string $max_chars
     * @param string $complete_with
     * @return string
     */
    public static function id($string) {
        return format_limit_str($string);
    }

    public static function email($email) {
        return '&lt;' . $email . '&gt;';
    }

}
