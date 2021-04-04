<?php

$widgets = [
    'widget-contacts.php',
    'widget-text.php',
    'widget-iframe.php',
    'widget-social-link.php',
    'widget-info.php'
];

foreach($widgets as $w){
   require_once(__DIR__ . '/inc/' . $w);
}

add_action('after_setup_theme', 'si_setup');
add_action('wp_enqueue_scripts', 'si_scripts');
add_action('widgets_init', 'si_register');
add_action('init', 'si_registration_types');
add_action('add_meta_boxes', 'si_meta_boxes');
add_action('save_post', 'si_like_save_meta');
add_action('admin_init', 'si_register_my_slogan');

add_shortcode('si-paste-link', 'si_paste_link');

// add_filter('show_admin_bar', '__return_false');
add_filter('si_widget_text', 'do_shortcode');
function si_setup(){

    register_nav_menu('menu-header', 'Menu in header');
    register_nav_menu('menu-footer', 'Menu in footer');

    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // add_theme_support('menus');
}

function si_scripts(){
    wp_enqueue_script( 'js', _si_assets_path('js/js.js'), [], '1.0',true);
    wp_enqueue_style('si-style', _si_assets_path('css/styles.css'), [],  '1.0', 'all');
}

function si_register(){
    register_sidebar([
        'name' => 'Sidebar in header',
        'id' => 'si-header',
        'before_widget' => null,
        'after_widget' => null,
    ]);
    register_sidebar([
        'name' => 'Contacts in footer',
        'id' => 'si-footer',
        'before_widget' => null,
        'after_widget' => null,
    ]);
    register_sidebar([
        'name' => 'Sidebar in footer column 1',
        'id' => 'si-footer-column-1',
        'before_widget' => null,
        'after_widget' => null,
    ]);
    register_sidebar([
        'name' => 'Sidebar in footer column 2',
        'id' => 'si-footer-column-2',
        'before_widget' => null,
        'after_widget' => null,
    ]);
     register_sidebar([
        'name' => 'Sidebar in footer column 3',
        'id' => 'si-footer-column-3',
        'before_widget' => null,
        'after_widget' => null,
    ]);   
    register_sidebar([
        'name' => 'Map',
        'id' => 'si-map',
        'before_widget' => null,
        'after_widget' => null,
    ]);  
    register_sidebar([
        'name' => 'Sidebar after map',
        'id' => 'si-after-map',
        'before_widget' => null,
        'after_widget' => null,
    ]);  
    register_widget('SI_Widget_Text');
    register_widget('SI_Widget_contacts');
    register_widget('SI_Widget_Iframe');
    register_widget('SI_Widget_Social_Links');
    register_widget('SI_Widget_Info');
}

function _si_assets_path($path){
    return get_template_directory_uri() . '/assets/'. $path;
}
function si_paste_link($attr){
  $params = shortcode_atts([
    'link' => '',
    'text' => '', 
    'type' => 'links'
  ], $attr);
  $params['text'] = $params['text'] ? $params['text'] : $params['link'];
  if($params['link']){
    $protocol = '';
    switch($params['type']){
        case 'email':
            $protocol = 'mailto:';
        break;    
        case 'phone':
            $protocol = 'tel:';
            $params['link'] =preg_replace('/[^+0-9]/', '', $params['link']);
            default:
            $protocol = '';
            break;
    }
    $link = $protocol . $params['link'];
    $text = $params['text'];
    return "<a href=\"${link}\">${text}</a>";
  }else{
      return '';
  }
}
function si_registration_types(){
    register_post_type( 'services', [
        'labels' => [
            'name'               => 'Услуги', 
            'singular_name'      => 'Услуга', 
            'add_new'            => 'Добавить новую услугу',
            'add_new_item'       => 'Добавить новую услугу',
            'edit_item'          => 'Редактировать услугу', 
            'new_item'           => 'Новая услуга', 
            'view_item'          => 'Смотреть услуги',
            'search_items'       => 'Искать услуги',
            'not_found'          => 'Не найдено',
            'not_found_in_trash' => 'Не найдено в корзине', 
            'parent_item_colon'  => '', 
            'menu_name'          => 'Услуги', 
        ],
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           =>'dashicons-smiley', 
        'hierarchical'        => false,
        'supports'            => ['title'],
        'has_archive' => true
    ]);
    register_post_type( 'trainers', [
        'labels' => [
            'name'               => 'Тренеры', 
            'singular_name'      => 'Тренер', 
            'add_new'            => 'Добавить нового Тренера',
            'add_new_item'       => 'Добавить нового Тренера',
            'edit_item'          => 'Редактировать Тренера', 
            'new_item'           => 'Новый Тренер', 
            'view_item'          => 'Смотреть Тренеры',
            'search_items'       => 'Искать Тренеры',
            'not_found'          => 'Не найдено',
            'not_found_in_trash' => 'Не найдено в корзине', 
            'parent_item_colon'  => '', 
            'menu_name'          => 'Тренеры', 
        ],
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           =>'dashicons-groups', 
        'hierarchical'        => false,
        'supports'            => ['title'],
        'has_archive' => true
    ]);
    register_post_type( 'schedule', [
        'labels' => [
            'name'               => 'Занятия',  
            'singular_name'      => 'Занятия', 
            'add_new'            => 'Добавить новый График',
            'add_new_item'       => 'Добавить новый График',
            'edit_item'          => 'Редактировать График', 
            'new_item'           => 'Новый График', 
            'view_item'          => 'Смотреть График',
            'search_items'       => 'Искать График',
            'not_found'          => 'Не найдено',
            'not_found_in_trash' => 'Не найдено в корзине', 
            'parent_item_colon'  => '', 
            'menu_name'          => 'Занятия', 
        ],
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           =>'dashicons-text-page', 
        'hierarchical'        => false,
        'supports'            => ['title'],
        'has_archive' => true
    ]);
    register_post_type( 'prices', [
        'labels' => [
            'name'               => 'Прайсы', 
            'singular_name'      => 'Прайсы', 
            'add_new'            => 'Добавить новый Прайс',
            'add_new_item'       => 'Добавить новый Прайс',
            'edit_item'          => 'Редактировать Прайс', 
            'new_item'           => 'Новый Прайс', 
            'view_item'          => 'Смотреть Прайс',
            'search_items'       => 'Искать Прайс',
            'not_found'          => 'Не найдено',
            'not_found_in_trash' => 'Не найдено в корзине', 
            'parent_item_colon'  => '', 
            'menu_name'          => 'Прайс', 
        ],
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           =>'dashicons-text-page', 
        'hierarchical'        => false,
        'supports'            => ['title'],
        'has_archive' => true
    ]);
    register_post_type( 'cards', [
        'labels' => [
            'name'               => 'Клубные Карты', 
            'singular_name'      => 'Клубные Карты', 
            'add_new'            => 'Добавить новый Карту',
            'add_new_item'       => 'Добавить новый Карту',
            'edit_item'          => 'Редактировать Карту', 
            'new_item'           => 'Новый Картf', 
            'view_item'          => 'Смотреть Картe',
            'search_items'       => 'Искать Карта',
            'not_found'          => 'Не найдено',
            'not_found_in_trash' => 'Не найдено в корзине', 
            'parent_item_colon'  => '', 
            'menu_name'          => 'Клубные Картs', 
        ],
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           =>'dashicons-tickets-alt', 
        'hierarchical'        => false,
        'supports'            => ['title'],
        'has_archive' => false
    ]);
    register_taxonomy('schedule_days', ['schedule'], [
        'labels'                => [
            'name'              => 'Дни недели',
            'singular_name'     => 'День',
            'search_items'      => 'Найти день недели',
            'all_items'         => 'Все дни недели',
            'view_item '        => 'Посмотреть дни недели',
            'edit_item'         => 'Редактировать дни недели',
            'update_item'       => 'Обновить',
            'add_new_item'      => 'Добавить день недели',
            'new_item_name'     => 'Добавить день недели',
            'menu_name'         => 'Все дни недели',
        ],
        'description'           => '',
        'public'                => true,
        'hierarchical'          => true
    ]);
    register_taxonomy('places', ['schedule'], [
        'labels'                => [
            'name'              => 'Залы',
            'singular_name'     => 'Залы',
            'search_items'      => 'Найти  залы',
            'all_items'         => 'Все залы',
            'view_item '        => 'Посмотреть залы',
            'edit_item'         => 'Редактировать залы',
            'update_item'       => 'Обновить',
            'add_new_item'      => 'Добавить залы',
            'new_item_name'     => 'Добавить залы',
            'menu_name'         => 'Все залы',
        ],
        'description'           => '',
        'public'                => true,
        'hierarchical'          => true
    ]);
    register_taxonomy('method', ['schedule'], [
        'labels'                => [
            'name'              => 'Методы тренировок',
            'singular_name'     => 'Методы тренировок',
            'search_items'      => 'Найти  методы тренировок',
            'all_items'         => 'Все методы тренировок',
            'view_item '        => 'Посмотреть залы',
            'edit_item'         => 'Редактировать методы тренировок',
            'update_item'       => 'Обновить',
            'add_new_item'      => 'Добавить методы тренировок',
            'new_item_name'     => 'Добавить методы тренировок',
            'menu_name'         => 'Методы тренировок',
        ],
        'description'           => '',
        'public'                => true,
        'hierarchical'          => true,
        'show_admin_column'     => false
    ]);
}


function si_meta_boxes(){
    add_meta_box(
        'si-like',
        'Количество лайков: ',
        'si_meta_like_cb',
        'post'
    );
}
function si_meta_like_cb($post_obj){
    $likes = get_post_meta($post_obj->ID, 'si-like', true);
    $likes = $likes ? $likes: 0;
    echo "<input type=\"text\"  name=\"si-like\" value=\"${likes}\">";
    // echo '<p>' . $likes  . '</p>';
}

function si_like_save_meta($post_id){
   if(isset($_POST['si-like'])){
       update_post_meta($post_id, 'si-like', $_POST['si-like']);
   }
}

function si_register_my_slogan(){
    add_settings_field(
        'si_option_field_slogan',
        'Слоган вашего сайта: ',
        'si_option_slogan_cb',
        'general',
        'default',
        ['label_for' => 'si_option_field_slogan' ]
    );
    register_setting(
        'general',
        'si_option_field_slogan',
        'strval'
    );
}

function si_option_slogan_cb($args){
    $slug = $args['label_for'];
    ?>
    <input 
    type="text"
    id="<?php echo $slug; ?>"
    value="<?php echo get_option($slug); ?>"
    name="<?php echo $slug;?>"
    class="regular-text code"
    >
    <?php
}
?>