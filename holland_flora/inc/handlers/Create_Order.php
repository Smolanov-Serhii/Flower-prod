<?php



if (!class_exists('Create_Order')) {

  class Create_Order

  {

    use Singleton;



    const ACTION = 'create_order';



    public static function register()

    {

      $handler = self::get_instance();



      add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);

      add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);

    }



    public function handle()

    {

      try {

        if (is_user_logged_in()) {



          if (!isset($_SESSION) || empty($_SESSION['cart'])) {

            wp_send_json([

              'success' => false,

              'msg' => pll__('Товаров в корзине не найдено.')

            ]);

          }



          extract($_POST);



          $items = Helper::get_cart_items();



          //                    $post_content = $this->generate_body($items, $comment);

          $post_content = $this->generate_body_profile($items);



          $data = array(

            'post_content' => $post_content['content'],

            'post_status' => 'publish',

            'post_author' => get_current_user_id(),

            'post_type' => Order_CPT::NAME

          );



          $id = wp_insert_post($data);



          wp_update_post(['ID' => $id, 'post_title' => "Заказ №{$id}"]);



          $user_info = get_userdata(get_current_user_id());



          update_post_meta($id, 'order_email', $user_info->user_email);

          update_post_meta($id, 'order_sum', $post_content['sum']);



          update_post_meta($id, 'cart', $_SESSION['cart']);

          update_post_meta($id, 'order_comment', $comment);



          unset($_SESSION['cart']);



          wp_send_json([

            'success' => true,

            'msg' => '',

            'id' => 'order',

            'orderId' => $id

          ]);

        } else {



          $_SESSION['redirect'] = site_url('basket/');



          wp_send_json([

            'success' => false,

            'msg' => pll__('Войдите или зарегистрируйтесь.'),

            'redirect' => get_page_url_by_template_name('template-pages/register')

          ]);

        }

      } catch (Exception $e) {

        wp_send_json([

          'success' => false,

          'msg' => '',

          'id' => ''

        ]);

      }

    }



    protected function generate_body_profile($items)

    {

      ob_start() ?>

      <table class="profile-order-table">

        <tbody>

          <tr class="profile-order-table__row">
            <th class="profile-order-table__head">#</th>
            <th class="profile-order-table__head">Артикул</th>

            <th class="profile-order-table__head"><?php pll_e('Продукт'); ?></th>

            <th class="profile-order-table__head">Название</th>

            <th class="profile-order-table__head">Опции</th>

            <th class="profile-order-table__head"><?php pll_e('Количество'); ?></th>

            <th class="profile-order-table__head"><?php pll_e('Цена, грн'); ?></th>

          </tr>
<!--          --><?php //roomble_ajax_create_order(); ?>
          <?php $sum = 0;

          foreach ($items as $item) : $sum += $item->count * $item->price; ?>
            <?php
            $code = get_post_meta($item->ID, 'code', true);
            ?>
            <tr class="profile-order-table__row">

              <td class="profile-order-table__item">1</td>
              <td class="profile-order-table__item"><?= $code; ?></td>
              <td class="profile-order-table__item">
                <img width="50px" height="" src="<?php echo get_the_post_thumbnail_url($item->ID);?>" alt="" class="profile-order-table__img">

              </td>

              <td class="profile-order-table__item">

                <a class="profile-order-table__link" href="javascript:;">

                  <?= $item->post_title; ?></a>

              </td>

              <td class="profile-order-table__item">

                <span>Цвет: <strong><?= get_field('product-color', $item->ID); ?></strong></span>

                <span>Высота: <strong><?= get_field('product-height', $item->ID); ?></strong></span>

              </td>

              <td class="profile-order-table__item"><?= $item->count; ?></td>

              <td class="profile-order-table__item"><?= Helper::get_price_grn($item->price * $item->count) . ' грн.'; ?> </td>

            </tr>

          <?php endforeach; ?>

        </tbody>

      </table>

    <?php



      return ['content' => ob_get_clean(), 'sum' => $sum];

    }



    protected function generate_body($items, $comment = '')

    {

      ob_start(); ?>

      <table width="100%">

        <tr>

          <th>Название товара</th>

          <th>Количество</th>

          <th>Цена</th>

        </tr>

        <?php $sum = 0;

        foreach ($items as $item) : $sum += $item->count * $item->price; ?>

          <tr class="basket__item productItem">

            <td><?= $item->post_title; ?></td>

            <td><?= $item->count; ?></td>

            <td><?= $item->count * $item->price; ?></td>

          </tr>

        <?php endforeach; ?>

      </table>



      <?php if (!empty($comment)) : ?>

        <h2>Комментарий к заказу</h2>

        <p><?= $comment; ?></p>

<?php endif;

      return ['content' => ob_get_clean(), 'sum' => $sum];

    }

  }

}

