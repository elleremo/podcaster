<?php

namespace Podcasts\Classes;


class TemplateHelper
{
    private $plugin_path;
    private $version;

    public function __construct($instance)
    {
        $this->plugin_path = $instance->pluginDir();
        $this->version = $instance->version;
    }

    /**
     * Метод подстановки данных в шаблон
     *
     * @param $file
     * @return string
     */
    public function pluginTemplatePath($file, $atts = [])
    {
        return $this->plugin_path . 'templates/' . $file . '.php';
    }

    public function getTemplatePart($file, $atts = [], $default = [])
    {
        $atts = wp_parse_args($atts, $default);

        if (!file_exists($this->pluginTemplatePath($file, $atts))) {
            if (function_exists('d')) {
                d('File not exists ', $this->pluginTemplatePath($file, $atts));
            }
            return false;
        }

        ob_start();
        include $this->pluginTemplatePath($file, $atts);
        return ob_get_clean();
    }

}
