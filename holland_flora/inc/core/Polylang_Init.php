<?php

class Polylang_Init
{
    use Singleton;

    const GROUP_0 = 'menus';
    const GROUP_1 = 'polylang custom';

    public static function register()
    {
        $instance = self::get_instance();

        add_action('init', [$instance, 'static_text']);
    }

    public function static_text()
    {
        if (function_exists('pll_register_string')) {
            pll_register_string(TEXTDOMAIN . '_home', 'Главная', self::GROUP_0);
            pll_register_string(TEXTDOMAIN . '_about_company', 'О компании', self::GROUP_0);
            pll_register_string(TEXTDOMAIN . '_terms_of_cooperation', 'Условия сотрудничества', self::GROUP_0);
            pll_register_string(TEXTDOMAIN . '_delivery', 'Доставка и оплата', self::GROUP_0);
            pll_register_string(TEXTDOMAIN . '_blog', 'Блог', self::GROUP_0);
            pll_register_string(TEXTDOMAIN . '_magazine', 'Магазин', self::GROUP_0);
            pll_register_string(TEXTDOMAIN . '_contacts', 'Контакты', self::GROUP_0);

            pll_register_string(TEXTDOMAIN . '_catalog', 'Каталог', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_benefits', 'Выгоды', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_about_us', 'О нас', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_features', 'Преимущества', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_scheme_of_work', 'Схема работы', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_reviews', 'Отзывы', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_qna', 'Вопросы и ответы', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_request_a_call', 'Заказать звонок', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_subscribe', 'Подписывайтесь на нас в соц. сетях и узнавайте первыми об акциях и новостях.', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_more_details', 'Подробнее.', self::GROUP_1);

            pll_register_string(TEXTDOMAIN . '_order_time', 'Время для заказа', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_my_account', 'Личный кабинет', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_my_account_entry', 'Вход в личный кабинет', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_your_login', 'Ваш логин', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_password', 'Пароль', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_remember_me', 'Запомнить меня', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_login', 'Вход', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_forgot_pass', 'Забыли пароль?', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_register', 'Регистрация', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_auth', 'Зарегистрироваться', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_full_name', 'ФИО', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_phone', 'Телефон', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_your_company_name', 'Название вашей фирмы', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_business', 'Тип бизнеса', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_city', 'Город', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_del_address', 'Адрес доставки', self::GROUP_1);


            pll_register_string(TEXTDOMAIN . '_ozn1', 'Ознакомился с', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_ozn2', 'Политикой Конфиденциальности', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_ozn3', 'Ознакомтесь с Политикой Конфиденциальности', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_already_register', 'Уже зарегистрированы', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_auth_now', 'Авторизуйтесь', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_personal_info', 'Личные данные', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_edit', 'Редактировать', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_my_orders', 'Мои заказы', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_order', 'Заказ', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_product_name', 'Название товара', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_cost', 'Стоимость', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_count', 'Количество', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_sum', 'Общая сумма', self::GROUP_1);
            pll_register_string(TEXTDOMAIN . '_order_again', 'Повторить заказ', self::GROUP_1);

            pll_register_string(TEXTDOMAIN . '_step', 'шаг', self::GROUP_1);


        }
    }
}