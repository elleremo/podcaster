<?php

namespace Podcasts\Classes;


class TemplateHelper
{
    private $plugin_path;
    private $version;

    public function __construct($instance)
    {
        $this->plugin_path = $instance->path;
        $this->version = $instance->version;
    }

    /**
     * Метод подстановки данных в шаблон
     *
     * @param $file
     * @return string
     */
    public function pluginTemplatePath($file)
    {
        return $this->plugin_path . 'templates/' . $file . '.php';
    }

    public function getTemplatePart($file, $atts = array(), $default = array())
    {
        $atts = wp_parse_args($atts, $default);

        if (file_exists($this->pluginTemplatePath($file))) {
            d('File not exists ', $this->pluginTemplatePath($file));
            return false;
        }

        ob_start();
        include $this->pluginTemplatePath($file);
        return ob_get_clean();
    }

}
