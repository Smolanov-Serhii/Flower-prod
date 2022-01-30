<?php

abstract class Options
{
    use Singleton;

    protected $fields;

    public static function register()
    {
        $instance = self::get_instance();

        add_action('admin_menu', [$instance, 'options_page']);
        add_action('admin_init', [$instance, 'register_settings']);
    }

    public function options_page()
    {
        $this->fields = $this->set_from_array($this->fields);
        add_theme_page('Theme Options', 'Расширенные настройки темы', 'manage_options', 'theme-options', [
            $this,
            'theme_options_page'
        ]);
    }

    public function theme_options_page()
    { ?>
        <div class="wrap custom_theme_options">
            <h2><?= __('Расширенные настройки темы', TEXTDOMAIN) ?></h2>

            <?php $this->tabbed_settings_sections('theme-options'); ?>
        </div>
        <?php
    }

    public function tabbed_settings_sections($page)
    {
        global $wp_settings_sections, $wp_settings_fields;

        if (!isset($wp_settings_sections[$page])) {
            return;
        } ?>

        <h2 class="nav-tab-wrapper">
            <?php $count = 1;
            foreach ((array)$wp_settings_sections[$page] as $id => $section) {
                $active = ($count == 1) ? 'nav-tab-active' : ''; ?>

                <a class="nav-tab <?= $active ?>" href="#" data-tab="<?= $id ?>">
                    <?= $section['title'] ?>
                </a>

                <?php $count++;
            } ?>
        </h2>

        <div id="tabs">
            <?php foreach ((array)$wp_settings_sections[$page] as $id => $section) {

                if ($section['callback']) {
                    call_user_func($section['callback'], $section);
                }

                if (!isset($wp_settings_fields) || !isset($wp_settings_fields[$page])
                    || !isset($wp_settings_fields[$page][$section['id']])
                ) {

                    continue;
                }
                ?>

                <form method="post" action="options.php">
                    <?php settings_fields($section['id']); ?>

                    <section class="tab_content" id="<?= $id ?>">
                        <table class="form-table">
                            <?php do_settings_fields($page, $section['id']); ?>
                        </table>

                        <?php submit_button(); ?>
                    </section>

                </form>
            <?php } ?>
        </div>
        <?php
    }

    public function register_settings()
    {
        foreach ($this->fields as $section_id => $section) {
            add_settings_section($section_id, $section['title'], null, 'theme-options');

            foreach ($section['fields'] as $field) {
                add_settings_field($field['id'], $field['title'], [
                    $this,
                    'settings_field_callback'
                ], 'theme-options', $section_id, $field);

                register_setting($section_id, $field['id']);
            }
        }
    }

    public function settings_field_callback($args)
    {
        $method = $args['type'] . '_callback';

        if (method_exists(self::class, $method)) {
            $this->$method($args);
        } else {
            throw new Exception('Method not exists. You should add them to Options class');
        }
    }

    private function input_callback($args)
    { ?>
        <input type='text' name='<?= $args['id'] ?>' id='<?= $args['id'] ?>' value='<?= get_option($args['id']) ?>'/>
        <?php
    }

    private function textarea_callback($args)
    { ?>
        <textarea class="large-text" rows="5" name="<?= $args['id'] ?>" id="<?= $args['id'] ?>"><?php
            echo get_option($args['id'])
            ?></textarea>
        <?php
    }

    private function wp_editor_callback($args)
    {
        wp_editor(get_option($args['id']), $args['id'] . '_editor', [
            'textarea_name' => $args['id'],
            'tinymce' => true,
            'teeny' => true,
            'quicktags' => false,
            'media_buttons' => false,
            'textarea_rows' => 20,
        ]);
    }

    private function image_callback($args)
    {
        $src = get_option($args['id']); ?>

        <input type='text' name='<?= $args['id'] ?>' id='<?= $args['id'] ?>' value='<?= $src ?>'/>
        <button class="button st_upload_button"><?= __('Select image') ?></button>
        <button class="button st_delete_upload_button"><?= __('Remove image') ?></button>

        <?php if (!empty($src)) { ?>
        <img class="image" alt="Uploaded image" src="<?= $src ?>"/>
    <?php }
    }

    private function radio_callback($args)
    { ?>
        <fieldset>
            <?php foreach ($args['values'] as $id => $title) {
                $value = get_option($args['id']);
                $cheched = ($value[0] == $id) ? 'checked="checked"' : '';
                ?>

                <label>
                    <input type="radio" name="<?= $args['id'] ?>[]" value="<?= $id ?>" <?= $cheched ?>>
                    <span><?= $title ?></span>
                </label><br>

            <?php } ?>
        </fieldset>
        <?php
    }

    private function checkbox_callback($args)
    { ?>
        <fieldset>
            <?php foreach ($args['values'] as $id => $title) {
                $value = get_option($args['id']);
                $cheched = (!empty($value) && in_array($id, $value)) ? 'checked="checked"' : '';
                ?>

                <label>
                    <input type="checkbox" name="<?= $args['id'] ?>[]" value="<?= $id ?>" <?= $cheched ?>>
                    <span><?= $title ?></span>
                </label>

            <?php } ?>
        </fieldset>
        <?php
    }

    private function select_callback($args)
    { ?>
        <select name="<?= $args['id'] ?>" id="<?= $args['id'] ?>">

            <?php foreach ($args['values'] as $id => $title) {
                $value = get_option($args['id']);
                $selected = ($value == $id) ? 'selected' : '';
                ?>

                <option value="<?= $id ?>" <?= $selected ?>><?= $title ?></option>
            <?php } ?>
        </select>
        <?php
    }

    private function set_from_array($fields)
    {
        foreach ($fields as $key => $field) {
            if (!empty($func = $field['func_to_fill_fields'] ?? false)) {
                if (method_exists(Custom_Options::class, $func)) {
                    $fields[$key]['fields'] = Custom_Options::$func();
                }
            }
        }

        return $fields;
    }
}