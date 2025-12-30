/**
 * Incredibuild Theme Scripts
 */

(function($) {
    'use strict';


  $(document).on('click', '.article_top-video-play', function () {

    const $btn    = $(this);
    const $parent = $btn.closest('.article_top-video');
    const $iframe = $parent.find('iframe');

    if (!$iframe.length) return;

    // fade out play button
    $btn.fadeOut(300);

    // remove pause class
    $parent.removeClass('pause');

    const src = $iframe.attr('src');

    // 👉 YOUTUBE
    if (src.indexOf('youtube.com') !== -1 || src.indexOf('youtu.be') !== -1) {

      // enable JS API if missing (reloads once)
      if (src.indexOf('enablejsapi=1') === -1) {
        $iframe.attr(
          'src',
          src + (src.indexOf('?') !== -1 ? '&' : '?') + 'enablejsapi=1'
        );
      }

      $iframe[0].contentWindow.postMessage(
        '{"event":"command","func":"playVideo","args":""}',
        '*'
      );
    }

    // 👉 VIMEO
    if (src.indexOf('vimeo.com') !== -1) {
      $iframe[0].contentWindow.postMessage(
        { method: 'play' },
        '*'
      );
    }

  });


        /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        /**
         * Debounce helper
         *
         * @param {Function} fn 
         * @param {number} delay 
         * @returns {Function}
         */
        function debounce(fn, delay = 150) {
            let timeoutId;

            return function debouncedFunction() {
                const context = this;
                const args = arguments;

                clearTimeout(timeoutId);

                timeoutId = setTimeout(function() {
                    fn.apply(context, args);
                }, delay);
            };
        }

            /**
     * Update first/last visible classes for styling
     */
    function updateVisibleClasses(category = false) {
        const $visibleCategories = $('.cpt_list-category:visible');
        
        // Remove all first/last classes
        $('.cpt_list-category').removeClass('first-visible last-visible');
        
        // Add first-visible to first visible category
        $visibleCategories.first().addClass('first-visible');
        
        // Add last-visible to last visible category
        $visibleCategories.last().addClass('last-visible');
                    // Scroll to content on mobile
                   
                    if (category && $(window).width() <= 768) {
                        const $category = $(`.cpt_list-category[data-category="${category}"]`);
                        console.log($category.offset().top);
                        if ($category.length) {
                            $('html, body').animate({
                                scrollTop: $category.offset().top - 20
                            }, 300);
                        }
                    }
    }

    // Store header height to prevent content jump
    var $headerSticky = $('.header_main-sticky');
    var headerHeight = 0;
    
    function updateHeaderHeight() {
        if(!$headerSticky.hasClass('header-fixed')){
            headerHeight = $headerSticky.outerHeight();
        }
    }
    
    // Initial calculation
    updateHeaderHeight();
    
    $(window).scroll(function(){
        if($(window).scrollTop() > 0){
            if(!$headerSticky.hasClass('header-fixed')){
                // Ensure we have the latest height
                updateHeaderHeight();
                // Add padding to body to prevent content jump
                $('body').css('padding-top', headerHeight + 'px');
            }
            $headerSticky.addClass('header-fixed');
        } else {
            $headerSticky.removeClass('header-fixed');
            // Remove padding when header is not fixed
            $('body').css('padding-top', '0');
            // Recalculate height for next time
            updateHeaderHeight();
        }
    });
    
    // Recalculate header height on window resize
    $(window).on('resize', function(){
        updateHeaderHeight();
        // Update padding if header is fixed
        if($headerSticky.hasClass('header-fixed')){
            $('body').css('padding-top', headerHeight + 'px');
        }
    });
    
    /**
     * CPT Filter by Category - Multiple Selection
     */
    function initCPTFilter() {
        // Set toggle as active by default (showing all)
        $('.cpt_list-aside-toggle').addClass('active');
        
        // Set initial visible classes
        updateVisibleClasses();
        
        // Handle toggle click (Show All)
        $(document).on('click', '.cpt_list-aside-toggle', function(e) {
            e.preventDefault();
            
            const $allCategories = $('.cpt_list-category');
            
            // Clear all active filters
            $('.cpt_list-aside-item-link').removeClass('active blue').addClass('white-45');
            $('.cpt_list-aside-toggle').addClass('active');
            
            // Show all categories
            $allCategories.fadeIn(0, function() {
                updateVisibleClasses();
            });
        });
        

        
        // Handle filter link clicks (toggle behavior)
        $(document).on('click', '.cpt_list-aside-item-link', function(e) {
            e.preventDefault();
            
            const $link = $(this);
            const category = $link.data('category') || $link.attr('href');
            
            // Remove active from toggle
            $('.cpt_list-aside-toggle').removeClass('active');
            
            // Toggle active state on this link
            $link.toggleClass('active blue white-45');
        
            
            // Get all active categories
            const activeCategories = [];
            $('.cpt_list-aside-item-link.active').each(function() {
                activeCategories.push($(this).data('category') || $(this).attr('href'));
            });
            
            // Show/hide categories based on selection
            if (activeCategories.length === 0) {
                // If none selected, show all and activate toggle
                $('.cpt_list-category').fadeIn(0, function() {
                    updateVisibleClasses();
                });
                $('.cpt_list-aside-toggle').addClass('active');
            } else {
                
                $('.cpt_list-category').each(function() {
                    const $category = $(this);
                    const categorySlug = $category.data('category');
                    
                    if (activeCategories.indexOf(categorySlug) !== -1) {
                        // Show selected categories
                        if (!$category.is(':visible')) {
                            $category.fadeIn(0, function() {
                                updateVisibleClasses(category);
                            });
                        } 
                    } else {
                        // Hide unselected categories
                        if ($category.is(':visible')) {
                            $category.fadeOut(0, function() {
                                updateVisibleClasses();
                            });
                        } 
                    }
                });
                
            }
        });
    }

        // Initialize CPT filter if container exists
        if ($('.cpt_list').length) {
            initCPTFilter();
        } 

        $('.show-more').click(function(){
            var list = '.' + $(this).data('show-more');
            $(list).fadeIn(300);
            $(this).fadeOut(300);
        });

        /**
         * Table of Contents scroll tracking
         * Handles both H2 headings (table_content) and H1 headings (hero_content)
         */
        function initTableOfContentsSpy() {
            // Find all table of contents containers
            const $tocContainers = $('.ib-table-content');

            if (0 === $tocContainers.length) {
                return;
            }

            // Process each TOC container independently
            $tocContainers.each(function initTOC() {
                const $container = $(this);
                const $links = $container.find('.ib-table-content__link');

                if (0 === $links.length) {
                    return;
                }

                const headings = [];

                // Collect headings from links (supports both H1 and H2)
                $links.each(function collectHeadings() {
                    const href = $(this).attr('href');

                    if (!href || href.charAt(0) !== '#') {
                        return;
                    }

                    const id = href.slice(1);
                    // Look for heading with this ID (can be h1, h2, or any element with id)
                    const $heading = $('#' + id);

                    if ($heading.length) {
                        headings.push({
                            id: id,
                            $el: $heading
                        });
                    }
                });

                if (0 === headings.length) {
                    return;
                }

                let offsets = [];
                let activeId = null;

                function computeOffsets() {
                    offsets = headings
                        .map(function mapHeading(item) {
                            const offset = item.$el.offset();
                            return {
                                id: item.id,
                                top: offset ? offset.top : 0
                            };
                        })
                        .filter(function filterValid(item) {
                            return item.top > 0;
                        })
                        .sort(function sortByTop(a, b) {
                            return a.top - b.top;
                        });
                }

                function setActive(id) {
                    if (!id || activeId === id) {
                        return;
                    }

                    const $current = $links.filter('[href="#' + id + '"]').first();

                    if (0 === $current.length) {
                        return;
                    }

                    activeId = id;

                    // Remove classes from all links in this container
                    $links.removeClass('current prev');

                    const currentIndex = $links.index($current);

                    $current.addClass('current');

                    if (currentIndex > 0) {
                        $links.slice(0, currentIndex).addClass('prev');
                    }
                }

                function scrollToHeading(id, animated) {
                    const heading = headings.find(function(item) {
                        return item.id === id;
                    });

                    if (!heading || !heading.$el || !heading.$el.length) {
                        return;
                    }

                    const offset = heading.$el.offset();
                    if (!offset) {
                        return;
                    }

                    const targetOffset = offset.top - 80;

                    if (animated) {
                        $('html, body').stop().animate(
                            {
                                scrollTop: targetOffset
                            },
                            400
                        );
                    } else {
                        window.scrollTo({
                            top: targetOffset,
                            behavior: 'auto'
                        });
                    }
                }

                function handleScroll() {
                    if (0 === offsets.length) {
                        return;
                    }

                    const scrollTarget = (window.scrollY || window.pageYOffset || 0) + window.innerHeight * 0.25;
                    let nextActiveId = offsets[0].id;

                    for (let i = 0; i < offsets.length; i++) {
                        if (scrollTarget >= offsets[i].top - 10) {
                            nextActiveId = offsets[i].id;
                        } else {
                            break;
                        }
                    }

                    setActive(nextActiveId);
                }

                // Initial computation
                computeOffsets();
                
                // Recompute after a delay to handle dynamically loaded content
                setTimeout(function() {
                    computeOffsets();
                    handleScroll();
                }, 300);

                // Recompute on resize
                $(window).on('resize.toc-' + $container.index(), debounce(function onResize() {
                    computeOffsets();
                    handleScroll();
                }, 200));

                // Handle scroll events
                $(window).on('scroll.toc-' + $container.index(), debounce(handleScroll, 10));

                // Initial scroll check
                handleScroll();

                // Handle link clicks
                $links.on('click', function onLinkClick(event) {
                    const href = $(this).attr('href');

                    if (href && href.charAt(0) === '#') {
                        event.preventDefault();
                        const id = href.slice(1);

                        scrollToHeading(id, true);
                        setActive(id);
                    }
                });

                // Handle initial hash in URL
                if (window.location.hash) {
                    const initialId = window.location.hash.slice(1);
                    const hasInitialHeading = headings.some(function(item) {
                        return item.id === initialId;
                    });

                    if (hasInitialHeading) {
                        setTimeout(function() {
                            scrollToHeading(initialId, false);
                            setActive(initialId);
                        }, 50);
                    }
                }
            });
        }

        initTableOfContentsSpy();

        /**
         * Point list progress tracking
         */
        function initPointListProgress() {
            const $sections = $('.point_list');

            if (!$sections.length) {
                return;
            }

            function updateProgress() {
                const scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
                const viewportHeight = window.innerHeight || document.documentElement.clientHeight || 0;
                const viewportMiddle = scrollY + viewportHeight * 0.35;

                $sections.each(function handleSection() {
                    const $section = $(this);
                    if ($section.hasClass('is-finished')) {
                        return;
                    }
                    
                    const $progressBar = $section.find('.point_list-inner-progress-bar');
                    const $items = $section.find('.point_list-scroll-item');

                
                    if ( !$progressBar.length || !$items.length ) {
                        return;
                    }

                    const sectionTop = $section.offset().top;
                    const sectionHeight = $section.outerHeight();
                    const relativePosition = (viewportMiddle - sectionTop) / sectionHeight;
                    let progress = Math.min(1, Math.max(0, relativePosition));
                    
                    // Divide progress by 2 on mobile
                    if ($(window).width() <= 768) {
                        progress = progress;
                    }

                    $progressBar.css('height', (progress * 100) + '%');

                    if (progress >= 1) {
                        $section.addClass('is-finished');
                    } else {
                        $section.removeClass('is-finished');
                    }

                    // Remove active class from all items first
                    $items.removeClass('is-active');
                    
                    let activeIndex = 0;
                    const isMobile = $(window).width() <= 768;
                    
                    $items.each(function assignActive(index) {
                        const $item = $(this);
                        let itemTop = $item.offset().top;
                        
                        // On mobile, adjust the offset calculation relative to section
                        if (isMobile) {
                            // Use relative position from section top for better accuracy on mobile
                            const itemTopRelative = itemTop - sectionTop;
                            const viewportMiddleRelative = viewportMiddle - sectionTop;
                            
                            if (viewportMiddleRelative >= itemTopRelative) {
                                activeIndex = index;
                                $item.addClass('is-active');
                            }
                        } else {

                            // Desktop: use absolute offset
                            if (viewportMiddle >= (itemTop - 200)) {
                                activeIndex = index;
                                $item.addClass('is-active');
                            }
                        }
                    });

                    // $items.removeClass('is-active');
                    // $items.eq(activeIndex).addClass('is-active');
                });
            }

            const throttledUpdate = debounce(updateProgress, 50);
            $(window).on('scroll', throttledUpdate);
            $(window).on('resize', throttledUpdate);
            updateProgress();
        }

        initPointListProgress();

        /**
         * Mobile menu toggle
         */
        $('.menu_toggle').on('click', function(e) {
            e.stopPropagation();
            $('.header_menu').toggleClass('menu-open');
            $(this).toggleClass('active');
        });

        // Close menu when clicking outside or on backdrop
        $(document).on('click', function(event) {
            const $target = $(event.target);
            const $menu = $('.header_menu');
            const $toggle = $('.menu_toggle');
            
            // Close if clicking outside menu and toggle, or if clicking directly on the menu container (backdrop)
            if (!$target.closest('.header_menu .menu, .header_buttons, .menu_toggle').length) {
                $menu.removeClass('menu-open');
                $toggle.removeClass('active');
            }
        });
        
        // Prevent menu from closing when clicking inside menu content
        $('.header_menu').on('click', function(e) {
            if ($(e.target).closest('.menu, .header_buttons').length) {
                e.stopPropagation();
            }
        });
        
        /**
         * Mobile sub-menu toggle on click
         */
        $(document).on('click', '.header_menu .menu > li.menu-item-has-children > .menu-item-inner > a', function(e) {
            // Only handle on mobile
            if ($(window).width() <= 1024) {
                e.preventDefault();
                const $parent = $(this).closest('li.menu-item-has-children');
                $parent.toggleClass('sub-menu-open');
                
                // Close other sub-menus (optional - remove if you want multiple open)
                $('.header_menu .menu > li.menu-item-has-children').not($parent).removeClass('sub-menu-open');
            }
        });
        
        // Handle window resize to reinitialize if needed
        $(window).on('resize', debounce(function() {
            // Reset sub-menu states on resize if switching between mobile/desktop
            if ($(window).width() > 1024) {
                $('.header_menu .menu > li.menu-item-has-children').removeClass('sub-menu-open');
            }
        }, 200));

        $('.header_menu .menu > li.menu-item-has-children, .lang-switcher-current').click(function(){
            
            if($(this).hasClass('active')){
                $(this).removeClass('active');
            }else{
                $('.header_menu .menu > li.menu-item-has-children, .lang-switcher-current').removeClass('active'); 
                $(this).addClass('active');
            }
            // $(this).toggleClass('active');
        });

        /**
         * Smooth scroll for internal anchor links outside the TOC
         */
        $(document).on('click', 'a[href*="#"]:not([href="#"]):not(.ib-table-content__link)', function(event) {
            const href = $(this).attr('href');

            if (!href || href.charAt(0) !== '#') {
                return;
            }

            const targetId = href.slice(1);
            const $target = $('#' + targetId);

            if (!$target.length) {
                return;
            }

            event.preventDefault();

            $('html, body').stop().animate(
                {
                    scrollTop: $target.offset().top - 80
                },
                400
            );
        });
    });

    $('.cpt_carousel-owl').owlCarousel({
        // autoWidth: true,
        loop: true,
        margin: 32,
        nav: true,
        dots: true,
        // autoplay: true,
        // autoplayTimeout: 10000,
        responsive: {
            0: {
                items: 1,
                autoWidth: false,
                autoHeight: true,
                autoHeightClass: 'owl-height'                
            },
            768: {
                // items: 2,
                autoWidth: true,
                autoHeight: false,
                // autoHeightClass: 'owl-height'                
            }
        }
    });

    $('.country_list-gallery').owlCarousel({
        autoWidth:true,
        loop: true,             // Loop through items
        margin: 12,            // Space between items
        nav: false,              // Show next/prev buttons
        dots: false,            // Hide dots navigation
        autoplay: true,        // Disable autoplay
        autoplayTimeout: 3000,  // Autoplay timeout (not used here)
        smartSpeed: 3000,        // Speed of the transition
        slideTransition: 'linear', // Ensure even speed
        mouseDrag: false, 
        touchDrag: false,
        pullDrag: false, 
        freeDrag: false,
        center: true,
    });

    $('.brand_carousel-gallery').owlCarousel({
        autoWidth:true,
        loop: true,             // Loop through items
        margin: 0,            // Space between items
        nav: false,              // Show next/prev buttons
        dots: false,            // Hide dots navigation
        autoplay: true,        // Disable autoplay
        autoplayTimeout: 3000,  // Autoplay timeout (not used here)
        smartSpeed: 3000,        // Speed of the transition
        slideTransition: 'linear', // Ensure even speed
        mouseDrag: false, 
        touchDrag: false,
        pullDrag: false, 
        freeDrag: false,
        center: true,
    });

    $('.title_gallery-gallery').owlCarousel({
        autoWidth: true,
        loop: true,             // Loop through items
        margin: 32,            // Space between items
        nav: false,              // Show next/prev buttons
        dots: false,            // Hide dots navigation
        autoplay: true,        // Disable autoplay
        autoplayTimeout: 10000,  // Autoplay timeout (not used here)
        // smartSpeed: 3000,        // Speed of the transition
        // slideTransition: 'linear', // Ensure even speed
    });

    $('.reviews_slider-inner').owlCarousel({
        items: 1,
        loop: true,
        margin: 32,
        nav: true,
        dots: true,
        // autoplay: true,
        // autoplayTimeout: 10000,
    });

    // Glossary alphabet filters carousel - mobile only
    function initGlossaryAlphabetCarousel() {
        var $filters = $('.cpt-list-filters');

        if (!$filters.length) {
            return;
        }

        // Only initialize on mobile widths
        if ($(window).width() > 768) {
            return;
        }

        // Avoid double-initialization
        if ($filters.hasClass('owl-loaded')) {
            return;
        }

        $filters
            .addClass('owl-carousel')
            .owlCarousel({
                autoWidth: true,
                loop: false,
                margin: 0,
                nav: false,
                dots: false,
                mouseDrag: true,
                touchDrag: true,
                pullDrag: true,
                freeDrag: false
            });
    }

    // Run on load
    initGlossaryAlphabetCarousel();

    // Optionally handle orientation changes / resizes back to mobile
    $(window).on('resize', function () {
        initGlossaryAlphabetCarousel();
    });

    $('.title_box_list-list-aside-label').click(function(){
        const index = $(this).data('index');
        $('.title_box_list-list-aside-label').removeClass('active');
        $(this).addClass('active');
        $('.title_box_list-list-content-item').fadeOut(0);
        $('.title_box_list-list-content-item').eq(index - 1).fadeIn(300);
    });

    function initSelect2() {
        if (typeof $.fn.select2 !== 'undefined') {
            $('.open_positions-search-select').each(function() {
                var $select = $(this);
                if (!$select.hasClass('select2-hidden-accessible') && !$select.data('select2')) {
                    $select.select2({
                        minimumResultsForSearch: Infinity
                    });
                }
            });
        }
    }
    
    // Filter jobs based on location and department
    function filterJobs() {
        var $locationSelect = $('#jobs_locations');
        var $departmentSelect = $('#jobs_departments');
        var $jobItems = $('.open_positions-list-item');
        var $countSpan = $('.open_positions-search-count');
        
        if ($locationSelect.length === 0 && $departmentSelect.length === 0) {
            return;
        }
        
        var selectedLocation = $locationSelect.length > 0 ? $locationSelect.val() : 'all';
        var selectedDepartment = $departmentSelect.length > 0 ? $departmentSelect.val() : 'all';
        
        var visibleCount = 0;
        
        $jobItems.each(function() {
            var $item = $(this);
            var itemLocation = $item.data('location') || '';
            var itemDepartment = $item.data('department') || '';
            
            // Check if item matches filters
            var locationMatch = (selectedLocation === 'all' || selectedLocation === itemLocation);
            var departmentMatch = (selectedDepartment === 'all' || selectedDepartment === itemDepartment);
            
            if (locationMatch && departmentMatch) {
                $item.show();
                visibleCount++;
            } else {
                $item.hide();
            }
        });
        
        // Update count
        if ($countSpan.length) {
            $countSpan.text(visibleCount + ' Open position' + (visibleCount !== 1 ? 's' : ''));
        }
    }
    
    // Initialize Select2 and set up filters
    $(document).ready(function() {
        initSelect2();
        setTimeout(initSelect2, 100);
        setTimeout(initSelect2, 500);
        
        // Set up change handlers for filtering
        $('#jobs_locations, #jobs_departments').on('change', function() {
            filterJobs();
        });
        
        // Initial filter in case there are pre-selected values
        setTimeout(filterJobs, 200);
    });
    
    $(window).on('load', function() {
        initSelect2();
        filterJobs();
    });

    $('.faq-item-title').click(function(){
        $(this).parent().toggleClass('active');
        $(this).next('.faq-item-answer').slideToggle(300);
    });

    /**
     * Copy to clipboard functionality for hcb_wrap pre elements
     */
    $(document).on('click', '.hcb_wrap', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $pre = $(this).find('pre');
        const codeText = $pre.text() || $pre.html().replace(/<[^>]*>/g, '');
        
        if (!codeText.trim()) {
            return;
        }
        
        // Use modern Clipboard API
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(codeText).then(function() {
                // Visual feedback - add a class temporarily
                const $wrap = $pre.closest('.hcb_wrap');
                $wrap.addClass('copied');
                
                setTimeout(function() {
                    $wrap.removeClass('copied');
                }, 1000);
            }).catch(function(err) {
                console.error('Failed to copy text:', err);
                // Fallback to older method
                fallbackCopyTextToClipboard(codeText, $pre);
            });
        } else {
            // Fallback for older browsers
            fallbackCopyTextToClipboard(codeText, $pre);
        }
    });
    
    /**
     * Fallback copy method for older browsers
     */
    function fallbackCopyTextToClipboard(text, $pre) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                const $wrap = $pre.closest('.hcb_wrap');
                $wrap.addClass('copied');
                setTimeout(function() {
                    $wrap.removeClass('copied');
                }, 2000);
            }
        } catch (err) {
            console.error('Fallback copy failed:', err);
        }
        
        document.body.removeChild(textArea);
    }

    /**
     * Randomly highlight N integration icons inside .hpblock
     * (ported from hp_v2.js)
     */
    function initIconRandomizer() {
        const MAX_ACTIVE = 6;      // how many icons to highlight at once
        const SWITCH_EVERY = 2500; // ms between switches

        const icons = Array.from(document.querySelectorAll('.hpblock .intIcons img'));
        if (!icons.length) return;

        let last = [];

        function pick(n) {
            const pool = icons.slice();
            for (let i = pool.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [pool[i], pool[j]] = [pool[j], pool[i]];
            }
            return pool.slice(0, Math.min(n, pool.length));
        }

        function tick() {
            last.forEach(el => el.classList.remove('is-active'));
            last.length = 0;

            const next = pick(MAX_ACTIVE);
            next.forEach(el => el.classList.add('is-active'));
            last = next;
        }

        tick();
        setInterval(tick, SWITCH_EVERY);
    }

    // Initialize icon randomizer after DOM is ready
    $(document).ready(function() {
        initIconRandomizer();
    });

})(jQuery);