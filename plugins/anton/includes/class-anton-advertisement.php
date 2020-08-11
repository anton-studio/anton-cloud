<?php

class Advertisement {
    public function render_admin_notices() {
        global $pagenow;
        switch ($pagenow) {
            case 'plugins.php': {
                echo '<h2>want to develop custom PLUGIN ???</h2>';
                break;
            }
            case 'themes.php': {
                echo '<h2> want to develop custom THEME ???</h2>';
                break;
            }
        }
    }
}