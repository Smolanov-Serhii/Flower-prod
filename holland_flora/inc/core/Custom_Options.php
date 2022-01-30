<?php

if (!class_exists('Custom_Options')) {

    class Custom_Options extends Options
    {
        protected $fields = [
            'main' => [
                'title' => 'Общие',
                'fields' => [
                    [
                        'id' => 'phone',
                        'title' => 'Номер тел.',
                        'type' => 'input',
                    ],
                    [
                        'id' => 'business_type',
                        'title' => 'Тип бизнеса',
                        'type' => 'textarea'
                    ],
                    [
                        'id' => 'euro_course',
                        'title' => 'Курс евро',
                        'type' => 'input'
                    ],
                    [
                        'id' => 'color_filters',
                        'title' => 'Color filters',
                        'type' => 'textarea'
                    ],
                ]
            ],
            'socials' => [
                'title' => 'Социалки',
                'fields' => [
                    [
                        'id' => 'facebook',
                        'title' => 'FB',
                        'type' => 'input',
                    ],
                    [
                        'id' => 'insta',
                        'title' => 'Insta',
                        'type' => 'input',
                    ],
                    [
                        'id' => 'youtube',
                        'title' => 'YouTube',
                        'type' => 'input',
                    ],
                ]
            ],
            'popups' => [
                'title' => 'Попапы',
                'func_to_fill_fields' => 'popups_translates',
                'fields' => []
            ]
        ];

        public static function popups_translates()
        {
            $fields = array();
            if (function_exists('pll_languages_list')) {
                $langs = pll_languages_list();

                array_push($fields, [
                    'id' => 'popup_time',
                    'title' => 'Время показа попапа (день недели/время: "02.16:00" - вторник 16:00)',
                    'type' => 'input'
                ]);

                foreach ($langs as $lang) {
                    array_push($fields, array(
                        'id' => "popup_attention_{$lang}",
                        'title' => "Попап \"Внимание\" перед покупкой в корзине (${lang})",
                        'type' => 'textarea'
                    ));
                }
            }

            return $fields;
        }
    }
}
