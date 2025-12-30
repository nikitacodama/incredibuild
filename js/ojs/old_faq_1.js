jQuery('.faq-wrap .faq-question').on('click', function() {
    var faq =jQuery(this).closest('.faq-item');
    var faq_answer = faq.find('.faq-answer');

    if(faq.hasClass('active')) {
        faq.removeClass('active');
        faq_answer.slideUp();
    } else {
      jQuery('.faq-wrap .faq-item').removeClass('active');
      jQuery('.faq-wrap .faq-answer').slideUp();
        faq.addClass('active');
        faq_answer.slideDown();
    }
});