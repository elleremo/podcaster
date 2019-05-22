<?php

namespace src\Podcasts\Classes;


class TypePosts
{

    public function post_type()
    {
        register_post_type('audio', array(
            'labels' => [
                'name' => __('Подкасты', 'Podcasts'),
                'singular_name' => __('Подкаст', 'Podcasts'),
                'add_new' => __('Добавить подкаст', 'Podcasts'),
                'add_new_item' => __('Добавить подкаст', 'Podcasts'),
                'edit_item' => __('Редактировать подкаст', 'Podcasts'),
                'new_item' => __('Новый подкаст', 'Podcasts'),
                'view_item' => __('Посмотреть подкаст', 'Podcasts'),
                'search_items' => __('Найти подкаст', 'Podcasts'),
                'not_found' => __('Подкастов не найдено', 'Podcasts'),
                'not_found_in_trash' => __('В корзине книг не подкастов', 'Podcasts'),
                'menu_name' => __('Подкасты', 'Podcasts'),
            ],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-microphone',
//            'taxonomies' => ['audio-page'],
            'supports' => ['title'],
        ));
    }

}
