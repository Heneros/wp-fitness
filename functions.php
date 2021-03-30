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
        'supports'            => ['title', 'editor', 'thumbnail'],
        'has_archive' => true
    ]);

}

?>