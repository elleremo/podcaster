<?php

namespace src\Podcasts\Classes;


class TypePosts
{
    public static $type = 'podcast';
    public static $taxonomy = 'podcast-page';

    public function post_type()
    {
        register_post_type(
            self::$type,
            [
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
                'taxonomies' => [self::$taxonomy],
                'supports' => ['title'],
            ]);
    }

    public function taxonomy()
    {
        $labels = [
            'name' => __('Страница подкаста', 'Podcasts'),
            'singular_name' => __('Страница', 'Podcasts'),
            'search_items' => __('Поиск страниц', 'Podcasts'),
            'all_items' => __('Все страницы', 'Podcasts'),
            'parent_item' => __('Родительская страница', 'Podcasts'),
            'parent_item_colon' => __('Родительская страница:', 'Podcasts'),
            'edit_item' => __('Редактировать страницу', 'Podcasts'),
            'update_item' => __('Обновить страницу', 'Podcasts'),
            'add_new_item' => __('Добавить новую страницу', 'Podcasts'),
            'new_item_name' => __('Добавить новую страницу', 'Podcasts'),
            'menu_name' => __('Ленты RSS', 'Podcasts'),
        ];
        register_taxonomy(self::$taxonomy, self::$type, [
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'podcast'),
        ]);
    }

}
