<?php 
// Get buttons from args passed to template part
$buttons = isset($args['buttons']) ? $args['buttons'] : array();

if ($buttons): 
    foreach($buttons as $button): 
        $link = isset($button['link']) ? $button['link'] : array();
        $type = isset($button['type']) ? $button['type'] : '';
        $target = isset($link['target']) ? $link['target'] : '_self';
        $url = isset($link['url']) ? $link['url'] : '#';
        $title = isset($link['title']) ? $link['title'] : '';
?>
        <a target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($url); ?>" class="button_default <?php echo esc_attr($type); ?>"><?php echo esc_html($title); ?></a>
<?php 
    endforeach;
endif; 
?>