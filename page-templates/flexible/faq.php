<?php 
    $title = get_sub_field('title');
    $list = get_sub_field('list');
?>

<section class="faq">
    <div class="container container_sm">
        <?php if($title): ?>
            <h2 class="faq-title white text_l"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($list): ?>
            <div class="faq-list">
                <?php foreach($list as $item): ?>
                    <div class="faq-item flex dir_col">
                        <h5 class="faq-item-title fz_20 medium white lh-150"><?php echo $item['title']; ?></h5>
                        <div class="faq-item-answer fz_20">
                            <?php echo $item['text']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>