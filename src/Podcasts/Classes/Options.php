<?php

namespace Podcasts\Classes;


class Options
{

    public function categoriesSelectBox($name)
    {
        $categories = $this->categories();

        $html = '';
        $html .= "<select name='{$name}' multiple='multiple' required='required'>";

        $iterator = function ($array) {
            $html = '';

            foreach ($array as $key => $value) {
                $html .= "<option name='$value'>{$value}</option>";
            }
            return $html;
        };

        foreach ($categories as $key => $value) {
            if (is_string($value)) {
                $html .= "<option name='$value'>{$value}</option>";
            } else {
                $html .= "<optgroup label='{$key}'>";
                $html .= "<option name='$key'>{$key} (common)</option>";
                $html .= $iterator($value);
                $html .= "</optgroup>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    /**
     * Возвращает категории подкастов
     *
     * @return array
     */
    public function categories()
    {
        return [
            'Arts & Entertainment' => [
                'Architecture',
                'Books',
                'Design',
                'Entertainment',
                'Games',
                'Performing Arts',
                'Photography',
                'Poetry',
                'Science Fiction',
            ],
            'Audio Blogs' => 'Audio Blogs',
            'Business' => [
                'Careers',
                'Finance',
                'Investing',
                'Management',
                'Marketing',
            ],
            'Comedy' => 'Comedy',
            'Education' => [
                'K-12',
                'Higher Education'
            ],
            'Food' => 'Food',
            'Health' => [
                'Diet & Nutrition',
                'Fitness',
                'Relationships',
                'Self-Help',
                'Sexuality',
            ],
            'International' => [
                'Australian',
                'Belgian',
                'Brazilian',
                'Canadian',
                'Chinese',
                'utch',
                'French',
                'German',
                'Hebrew',
                'Italian',
                'Japanese',
                'Norwegian',
                'Polish',
                'Portuguese',
                'Spanish',
                'Swedish',
            ],
            'Movies & Television',
            'Music' => 'Music',
            'News' => 'News',
            'Politics' => 'Politics',
            'Public Radio' => 'Public Radio',
            'Religion & Spirituality' => [
                'Buddhism',
                'Christianity',
                'Islam',
                'Judaism',
                'New Age',
                'Philosophy',
                'Spirituality',
            ],
            'Science' => 'Science',
            'Sports' => 'Sports',
            'Talk Radio' => 'Talk Radio',
            'Technology' => [
                'Computers',
                'Developers',
                'Gadgets',
                'Information Technology',
                'News',
                'Operating Systems',
                'Podcasting',
                'Smart Phones',
                'Text/Speech',
            ],
            'Travel' => 'Travel',
        ];
    }


}
