(function ($) {
    'use strict';

    const ajaxUrl = (window.IncredibuildCptFilters && window.IncredibuildCptFilters.ajaxUrl) || '';

    if (!ajaxUrl) {
        return;
    }

    function setLoadMoreState($button, hasMore, nextPage) {
        if (!$button.length) {
            return;
        }
        if (hasMore) {
            $button.show().data('next-page', nextPage || 2);
        } else {
            $button.hide().data('next-page', null);
        }
    }

    function requestPosts($wrap, args, append) {
        const $grid = $wrap.find('.cpt-list-grid');
        const $loadMore = $wrap.find('.cpt-list-load-more');

        if ($wrap.data('loading')) {
            return;
        }

        $wrap.data('loading', true).addClass('is-loading');

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: args,
        })
            .done(function (response) {
                if (!response || !response.success || !response.data) {
                    return;
                }

                const data = response.data;

                if (append) {
                    $grid.append(data.html);
                } else {
                    $grid.html(data.html);
                }

                $wrap.data('shortcode-rendered', data.shortcodeRendered ? 1 : 0);
                setLoadMoreState($loadMore, !!data.hasMore, data.nextPage);
            })
            .fail(function () {
                // Optionally handle errors.
            })
            .always(function () {
                $wrap.data('loading', false).removeClass('is-loading');
            });
    }

    function initBlock($wrap) {
        const $filters = $wrap.find('.cpt-list-filters__item');
        const $selectFilters = $('.cpt-list-filters__select');
        const $loadMore = $wrap.find('.cpt-list-load-more');

        const postsPerPage = parseInt($wrap.data('posts-per-page'), 10) || 9;
        const postType = $wrap.data('cpt');
        const filterType = $wrap.data('filter-type') || 'term';
        const taxonomy = $wrap.data('taxonomy') || 'category';
        const shortcodeLine = parseInt($wrap.data('shortcode-line'), 10) || 0;
        const shortcode = $wrap.data('shortcode') || '';
        const nonce = $wrap.data('nonce');
        const include = $wrap.data('include') || '';
        const tagTaxonomy = $wrap.data('tag-taxonomy') || '';
        const boxView = $wrap.data('box-view') || 'post';
        const order = $wrap.data('order') || 'DESC';
        const orderby = $wrap.data('orderby') || 'date';
        const defaultOffset = parseInt($wrap.data('default-offset'), 10) || 0;

        let currentTerm = 'all';
        const initialCategoryData = ($wrap.data('selected-categories') || '').toString();
        const initialTagData = ($wrap.data('selected-tags') || '').toString();
        const initialInclude = ($wrap.data('include') || '').toString();
        let selectedCategoryIds = normalizeSelection(initialCategoryData ? initialCategoryData.split(',') : []);
        let selectedTagIds = normalizeSelection(initialTagData ? initialTagData.split(',') : []);
        const initialCategoryIds = normalizeSelection(initialCategoryData ? initialCategoryData.split(',') : []);
        const initialIncludeIds = normalizeSelection(initialInclude ? initialInclude.split(',') : []);

        setLoadMoreState($loadMore, !!$wrap.data('has-more'), 2);

        if ($selectFilters.length) {
            $selectFilters.select2();
        }

        function normalizeSelection(value) {
            if (!value || (Array.isArray(value) && value.length === 0)) {
                return [];
            }

            const values = Array.isArray(value) ? value : [value];

            return values
                .map(function (item) {
                    const parsed = parseInt(item, 10);
                    return Number.isNaN(parsed) ? null : parsed;
                })
                .filter(function (item) {
                    return item !== null;
                });
        }

        function buildPayload(page, append) {
            // Check if current filters match initial/default state
            const categoriesMatch = JSON.stringify(selectedCategoryIds.sort()) === JSON.stringify(initialCategoryIds.sort());
            const tagsMatch = selectedTagIds.length === 0 && initialTagData === '';
            const termMatches = currentTerm === 'all';
            const isDefaultState = categoriesMatch && tagsMatch && termMatches;
            
            return {
                action: 'cpt_list_with_filters',
                nonce: nonce,
                postType: postType,
                taxonomy: taxonomy,
                term: currentTerm,
                filterType: filterType,
                page: page,
                postsPerPage: postsPerPage,
                shortcode: shortcode,
                shortcodeLine: shortcodeLine,
                shortcodeRendered: append ? ($wrap.data('shortcode-rendered') || 0) : 0,
                include: include,
                categories: selectedCategoryIds.join(','),
                tags: selectedTagIds.join(','),
                tagTaxonomy: tagTaxonomy,
                boxView: boxView,
                order: order,
                orderby: orderby,
                offset: isDefaultState ? defaultOffset : 0,
                initialCategories: initialCategoryIds.join(','),
                initialInclude: include,
            };
        }

        $filters.on('click', function (event) {
            event.preventDefault();

            const $btn = $(this);
            const term = $btn.data('term');

            if (term === currentTerm || $wrap.data('loading')) {
                return;
            }

            currentTerm = term;
            $filters.removeClass('is-active');
            $btn.addClass('is-active');

            $wrap.data('shortcode-rendered', 0);
            selectedCategoryIds = [];
            selectedTagIds = [];
            $wrap.data('selectedCategories', '');
            $wrap.data('selectedTags', '');
            $wrap.data('selectedFilterType', '');
            if ($selectFilters.length) {
                $selectFilters.val(null).trigger('change.select2');
            }

            requestPosts($wrap, buildPayload(1, false), false);
        });

        $selectFilters.on('change select2:select', function () {

            console.log('changed')
            const $select = $(this);
            const taxonomyType = $select.data('taxonomy');
            const value = $select.val();
            const normalizedSelection = normalizeSelection(value);

            $filters.removeClass('is-active');
            currentTerm = 'all';

            if (taxonomyType === taxonomy) {
                selectedCategoryIds = normalizedSelection;
                $wrap.data('selectedCategories', selectedCategoryIds.join(','));
            } else if (tagTaxonomy && taxonomyType === tagTaxonomy) {
                selectedTagIds = normalizedSelection;
                $wrap.data('selectedTags', selectedTagIds.join(','));
            }

            $wrap.data('shortcode-rendered', 0);
            setLoadMoreState($loadMore, false, 2);
            requestPosts($wrap, buildPayload(1, false), false);
        });

        $loadMore.on('click', function (event) {
            event.preventDefault();

            const nextPage = parseInt($(this).data('next-page'), 10) || 0;

            if (!nextPage || $wrap.data('loading')) {
                return;
            }

            requestPosts($wrap, buildPayload(nextPage, true), true);
        });
    }

    $(function () {
        $('.cpt-list-with-filters').each(function () {
            initBlock($(this));
        });
    });
})(jQuery);