<?php
class Security {
    public static function esc($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
