<?php

class AlertHelper
{

    private static $alert_types = array(
        "primary",
        "secondary",
        "danger",
        "warning"
    );

    public static function alert($type, $string)
    {
        if (in_array($type, self::$alert_types)) {
            echo '<div class="alert alert-' . $type . '">' . $string . '</div>';
        } else {
            echo $type . ' n\'appartient pas à une valeur connue des alerts';
        }
    }

}
