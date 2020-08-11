<?php

class Theme_Plugin_Limit {

    // only allow plugin to a certain site
    // remove XXX to use the correct name if you want this feature
    private $plugin_siteId_map = [
        'AntonXXX' => 1
    ];

    // only allow theme to a certain site
    // remove XXX to use the correct name if you want this feature
    private $theme_siteId_map = [
        'hello-elementorXXX' => 1
    ];

    public function filter_plugins($plugins) {
        $filtered_plugins = [];
        foreach ($plugins as $key => $plugin) {
            if (array_key_exists($plugin['Name'], $this->plugin_siteId_map)) {
                if (get_current_blog_id() == $this->plugin_siteId_map[$plugin['Name']]) {
                    $filtered_plugins[$key] = $plugin;
                }
            } else {
                $filtered_plugins[$key] = $plugin;
            }
        }
        return $filtered_plugins;
    }

    public function filter_themes($themes) {
        $filtered_themes = [];
        foreach ($themes as $key => $theme) {
            if (array_key_exists($key, $this->theme_siteId_map)) {
                if (get_current_blog_id() == $this->theme_siteId_map[$key]) {
                    $filtered_themes[$key] = $theme;
                }
            } else {
                $filtered_themes[$key] = $theme;
            }
        }
        return $filtered_themes;
    }

}
