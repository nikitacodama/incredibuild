<?php
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $buttons = get_sub_field('buttons');
    $embed_video = get_sub_field('embed_video'); 
    $file_video = get_sub_field('file_video');
    $file_video_preview = get_sub_field('file_video_preview');
?>

<section class="hero_embed_video">
    <div class="container  text_c">
        <?php if($title): ?>
            <div class="hero_embed_video__title strong_accent white"><?php echo $title; ?></div>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="hero_embed_video__text fz_18"><?php echo $text; ?></div>
        <?php endif; ?>
        <?php if($buttons): ?>
        <div class="hero_embed_video__buttons flex align_c justify_c gap_16">
            <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
        </div>
        <?php endif; ?>
        <?php if($embed_video): ?>
            <div class="hero_embed_video_container">
                <div class="hero_embed_video_container-inner">
                    <?php echo $embed_video; ?>
                </div>
            </div>
       <?php elseif($file_video): ?>
            <div class="hero_embed_video_container">
                <div class="hero_embed_video_container-inner">
                    <video poster="<?php echo $file_video_preview ? wp_get_attachment_image_url($file_video_preview['ID'], 'full') : ''; ?>" >
                        <source src="<?php echo wp_get_attachment_url($file_video['ID']); ?>" type="video/mp4">
                    </video>
                </div>
            </div>
       <?php endif; ?>
    </div>
</section>