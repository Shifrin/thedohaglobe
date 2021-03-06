<?php

// Include custom navigation walker that supports Bootstrap 4 style
require_once('classes/class-wp-bootstrap-navwalker.php');
// Theme setup functions and default overrides
require_once('inc/theme_init.php');
// Placement taxonomy related functions
require_once('inc/placement_taxonomy.php');
// Breadcrumbs
require_once('inc/breadcrumbs.php');
// Pagination
require_once('inc/pagination.php');

/**
 * Filter post categories to not showing the columnist names.
 *
 * @return array
 */
function getTheFilteredCategories()
{
    $categories = get_the_category();
    $exclude    = ['columnist', 'quotes'];

    foreach ($categories as $key => $category) {
        if (in_array($category->slug, $exclude)) {
            unset($categories[$key]);
        }

        if (verifyColumnist($category->name)) {
            unset($categories[$key]);
        }
    }

    return array_values($categories);
}

/**
 * Filter categories to not showing the columnist names.
 *
 * @param string|array $args     Optional. Arguments to retrieve categories. See get_terms() for additional options.
 *
 * @return array
 * @var string         $taxonomy Taxonomy to retrieve terms for. In this case, default 'category'.
 *
 */
function getFilteredCategories($args)
{
    $categories = get_categories($args);
    $exclude    = ['columnist', 'quotes'];

    foreach ($categories as $key => $category) {
        if (in_array($category->slug, $exclude)) {
            unset($categories[$key]);
        }

        if (verifyColumnist($category->name)) {
            unset($categories[$key]);
        }
    }

    return array_values($categories);
}

/**
 * Get the columnist of the opinion post
 *
 * @return WP_Term|null The columnist category object
 */
function getTheColumnist()
{
    $categories      = get_the_category();
    $columnistCatObj = get_category_by_slug('columnist');

    if ($columnistCatObj instanceof WP_Term) {
        foreach ($categories as $category) {
            if ($category->parent == $columnistCatObj->term_id) {
                return $category;
            }
        }
    }

    return null;
}

/**
 * Verifying the columnist by given name.
 *
 * @param string $name The columnist name
 *
 * @return bool if found return true else false
 */
function verifyColumnist($name)
{
    $columnistCatObj = get_category_by_slug('columnist');

    if ($columnistCatObj instanceof WP_Term) {
        $children = get_categories(['parent' => $columnistCatObj->term_id]);

        foreach ($children as $child) {
            if ($child->name == $name) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Check the given columnist is a editor in chief
 *
 * @param WP_Term|string $term The term object of columnist or columnist name
 *
 * @return bool If editor in chief return true else false
 */
function isEditorInChief($term)
{
    $editorInChief = 'Khalid Al Sayed';

    if ($term instanceof WP_Term) {
        return $term->name == $editorInChief;
    } elseif (is_string($term)) {
        return $term == $editorInChief;
    }

    return false;
}

/**
 * Get post author name. If the author is a columnist it will be override.
 *
 * @return string The found author name
 */
function getPostAuthorName()
{
    global $post;

    $author    = get_post_meta($post->ID, 'author', true);
    $columnist = getTheColumnist();

    if ($columnist instanceof WP_Term) {
        $author = $columnist->name;
    }

    if (!$author) {
        $author = get_bloginfo('name');
    }

    return $author;
}

/**
 * Get columnist picture
 *
 * @param WP_Term|int|string $term The columnist can be any of these term/term_id/slug/name
 *
 * @return string The picture url if not found will give common
 */
function getTheColumnistPictureUrl($term)
{
    // Default image for columnist
    $srcDefault = get_template_directory_uri() . '/img/columnist.png';
    $src        = false;

    if (!($term instanceof WP_Term)) {
        $field = is_numeric($term) ? 'term_id' : 'slug';
        $value = is_numeric($term) ? $term : sanitize_title($term);
        $term  = get_term_by($field, $value, 'category');
    }

    if ($term instanceof WP_Term && function_exists('get_wp_term_image')) {
        $src = get_wp_term_image($term->term_id);
    }

    // Use default image
    return !empty($src) ? $src : $srcDefault;
}

/**
 * Count the post views accurately whenever a visitor's visits a post
 *
 * @param integer $postID the current post id
 */
function addPostViewCount($postID)
{
    $countKey = 'views';
    $count    = get_post_meta($postID, $countKey, true);

    if ($count) {
        // Add new count and update the views
        update_post_meta($postID, $countKey, ($count + 1));
    } else {
        // Add new count
        add_post_meta($postID, $countKey, 1);
    }
}

/**
 * Track post views
 */
function trackPostViews()
{
    // Current post
    global $post;

    if (is_single() && !is_preview()) {
        addPostViewCount($post->ID);
    }
}

// Track the post view
add_action('wp_head', 'trackPostViews');

/**
 * Get trending news based on views for up to last 3 days.
 *
 * @param int $number_of_posts
 *
 * @return WP_Query|null
 */
function getTrendingNews($number_of_posts)
{
    $quoteCat   = get_category_by_slug('quotes');
    $excludeCat = '';

    if ($quoteCat instanceof WP_Term) {
        $excludeCat .= '-' . $quoteCat->term_id;
    }

    return new WP_Query([
        'cat'            => $excludeCat,
        'meta_key'       => 'views',
        'orderby'        => 'meta_value_num',
        'posts_per_page' => $number_of_posts,
        'date_query'     => [
            ['after' => '-7 days']
        ],
    ]);
}

/**
 * Update the image markup according to our needs.
 *
 * @see get_image_send_to_editor()
 */
function updateImageCaption($html, $id, $caption, $title, $align, $url, $size, $alt)
{
    // Remove wordpress default shorcode to add image caption
    remove_filter('image_send_to_editor', 'image_add_caption', 20);

    $src  = wp_get_attachment_image_src($id, 'full');
    $html = '<figure class="figure" id="attachment_' . $id . '">';

    if ($url) {
        $html = '<a href="' . esc_url($url) . '">';
        $html .= '<img src="' . $src[0] . '" alt="' . esc_html($alt) . '" class="align-' . $align
            . ' figure-img img-fluid' . '" width="' . $src[1] . '" height="' . $src[2] . '">';
        $html .= '</a>';
    } else {
        $html .= '<img src="' . $src[0] . '" alt="' . esc_html($alt) . '" class="align-' . $align
            . ' figure-img img-fluid rounded' . '" width="' . $src[1] . '" height="' . $src[2] . '">';
    }

    if ($caption) {
        $html .= '<figcaption class="figure-caption">' . esc_html($caption) . '</figcaption>';
    }

    $html .= '</figure>';

    return $html;
}

add_filter('image_send_to_editor', 'updateImageCaption', 10, 8);

/**
 * Exclude latest posts in category page from main query
 *
 * @param WP_Query $query
 */
function excludeLatestPostsInCategoryPage($query)
{
    if (!is_admin() && $query->is_main_query() && $query->is_category()) {
        $category = get_queried_object();
        $ppp      = get_option('posts_per_page');
        $offset   = 5;

        if ($category instanceof WP_Term) {
            if ($query->is_category('briefs') || isMediaCategory($category->slug)) {
                $offset = 0;
                $query->set('posts_per_page', 12);
            }

            if ($category->slug == 'opinion' || verifyColumnist($category->name)) {
                $offset = 3;
            }
        }

        if ($query->is_paged) {
            $pageOffset = $offset + ($query->query_vars['paged'] - 1) * $ppp;

            $query->set('offset', $pageOffset);
        } else {
            $query->set('offset', $offset);
        }
    }
}

add_action('pre_get_posts', 'excludeLatestPostsInCategoryPage');

/**
 * Adjust offset to the main query in category pages
 *
 * @param int      $found_posts
 * @param WP_Query $query
 *
 * @return int
 */
function adjustOffsetForPaginationInCategoryPage($found_posts, $query)
{
    if (is_admin()) {
        return $found_posts;
    }

    if ($query->is_category() && $query->is_main_query()) {
        $category = get_queried_object();
        $offset   = $category->slug == 'opinion' || verifyColumnist($category->name) ? 3 : 5;

        return $found_posts - $offset;
    }

    return $found_posts;
}

add_filter('found_posts', 'adjustOffsetForPaginationInCategoryPage', 1, 2);

function loadMorePostsAjaxHandler()
{
    $args          = json_decode(stripslashes($_POST['query']), true);
    $args['paged'] = $_POST['page'];
    $category      = $_POST['category'];

    if ($category != 'Briefs') {
        $columnist      = get_queried_object();
        $offset         = $columnist instanceof WP_Term && verifyColumnist($columnist->name) ? 3 : 5;
        $args['offset'] = $offset + ($_POST['page'] - 1) * get_option('posts_per_page');
    }

    query_posts($args);

    if (have_posts()) {
        if ($category != 'Brief') {
            get_template_part('template-parts/content/category/more-stories');
        } else {
            get_template_part('template-parts/content/category/brief-more-stories');
        }
    }

    wp_die();
}

add_action('wp_ajax_load_more_posts', 'loadMorePostsAjaxHandler');
add_action('wp_ajax_nopriv_load_more_posts', 'loadMorePostsAjaxHandler');

function loadMorePostsAjaxHandlerOnSearch()
{
    $args          = json_decode(stripslashes($_POST['query']), true);
    $args['paged'] = $_POST['page'];
    $query         = new WP_Query($args);

    if ($query->have_posts()) {
        ?>
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="card the-story mb-4">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <?php the_post_thumbnail('featured', [
                                'class' => 'card-img img-fluid h-100'
                            ]); ?>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>

                                <p class="card-text text-muted">
                                    <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>

                        <p class="card-text text-muted">
                            <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
        <?php
        wp_reset_postdata();
    }

    wp_die();
}

add_action('wp_ajax_load_more_posts_search', 'loadMorePostsAjaxHandlerOnSearch');
add_action('wp_ajax_nopriv_load_more_posts_search', 'loadMorePostsAjaxHandlerOnSearch');

function loadMoreScript()
{
    if (is_category()) {
        global $wp_query;

        $queryVars = json_encode($wp_query->query_vars); ?>
        <script async type="text/javascript">
            jQuery(document).ready(function ($) {
                var page = 2,
                    maxPage = <?php echo $wp_query->max_num_pages; ?>;

                $('body').on('click', '#loadMore', function () {
                    var $button = $(this),
                        data = {
                            action: 'load_more_posts',
                            query: '<?php echo $queryVars; ?>',
                            page: page,
                            category: '<?php single_cat_title(); ?>'
                        };

                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data: data,
                        type: 'POST',
                        beforeSend: function () {
                            $button.find('span').addClass('d-none');
                            $button.find('svg').removeClass('d-none');
                            $button.prop('disabled', true);
                        },
                        success: function (response) {
                            $button.find('span').removeClass('d-none');
                            $button.find('svg').addClass('d-none');
                            $button.prop('disabled', false);

                            if (response) {
                                if (page >= maxPage) {
                                    $button.remove();
                                }

                                $('#moreStories').append(response);
                                page++;
                            } else {
                                $button.remove();
                            }
                        }
                    });
                });
            });
        </script>
        <?php
    }
}

add_action('wp_footer', 'loadMoreScript');

/**
 * Process contact form submission via ajax
 */
function contactFormAjaxCall()
{
    check_ajax_referer('__contact_form_ajax', 'security');

    $post     = $_POST;
    $data     = [];
    $errors   = [];
    $response = [];

    // Validate the all inputs
    foreach ($post as $field => $value) {
        if (empty($value)) {
            $errors[$field] = __('Please fill out all the fields.');
        } else {
            if ($field == 'email') {
                $email = filter_var($value, FILTER_VALIDATE_EMAIL);

                if (!$email) {
                    $errors[$field] = __('Please provide a valid email address.');
                } else {
                    $data[$field] = $email;
                }
            } else {
                $data[$field] = sanitize_text_field($value);
            }
        }
    }

    if (!empty($errors)) {
        $response['success'] = false;
        $response['message'] = $errors;
    } else {
        $to      = 'info@thedohaglobe.com';
        $body    = "Name: {$data['sender']} \n\nEmail: {$data['email']} \n\nSubject: {$data['subject']} \n\nMessage:\n{$data['message']}";
        $headers = 'From: ' . get_bloginfo('name') . ' <' . $to . '>' . "\r\n" . 'Reply-To: ' . $data['email'];

        if (wp_mail($to, $data['subject'], $body, $headers)) {
            $response['message'] = 'Thank you for contacting us, our representative will respond you shortly.';
            $response['success'] = true;
        } else {
            $response['message'] = 'Apologies, we could not able to send your inquiry at the moment. Please try again.';
            $response['success'] = false;
        }
    }

    wp_send_json($response);
}

add_action('wp_ajax_contact_form_ajax_call', 'contactFormAjaxCall');
add_action('wp_ajax_nopriv_contact_form_ajax_call', 'contactFormAjaxCall');

/**
 * Adding some script to the footer
 */
function footerScript()
{
    $contactNonce = wp_create_nonce('__contact_form_ajax');
    ?>
    <script type="text/javascript">
        (function () {
            var clockEle = document.getElementById('clock');

            setInterval(function () {
                clockEle.getElementsByTagName('span')[0].innerHTML = new Date().toLocaleTimeString();
            }, 1000);

            <?php if (is_home() || is_front_page()) : ?>
            var blurred = false;

            window.onblur = function () {
                blurred = true;
            };
            window.onfocus = function () {
                blurred && (location.reload());
            };
            <?php endif; ?>

            <?php if (isInMediaCategory()) : ?>
            var lightbox = new SimpleLightbox('.post-gallery a', {});
            <?php endif; ?>
        }());

        jQuery(document).ready(function ($) {
            $(window).scroll(function () {
                var scroll = $(this).scrollTop();

                $('#navbar').toggleClass('fixed-top', (scroll >= 100));
                $('.trending-widget').toggleClass('sticky-top', (scroll >= 300));
                $('.offers-widget').toggleClass('sticky-top', (scroll >= 300));
            });

            <?php if (is_page('contact-us')) : ?>
            $('#contactform').submit(function (e) {
                var errorClass = 'is-invalid';
                var successClass = 'is-valid';
                var submitBtn = $('#submit');
                var datas = {
                    'action': 'contact_form_ajax_call',
                    'security': '<?php echo $contactNonce; ?>',
                    'sender': $('#sender').val(),
                    'email': $('#email').val(),
                    'subject': $('#subject').val(),
                    'message': $.trim($("#message").val())
                };
                var output;

                $('#alert').removeClass().html('').slideUp();

                $.ajax({
                    type: "POST",
                    url: "<?php echo get_bloginfo('wpurl') . '/wp-admin/admin-ajax.php'; ?>",
                    data: datas,
                    dataType: "json",
                    encode: true,
                    beforeSend: function () {
                        submitBtn.find('span').addClass('d-none');
                        submitBtn.find('svg').removeClass('d-none');
                        submitBtn.prop('disabled', true);
                        $('.invalid-feedback').remove();
                        $('#contactform input, #contactform textarea').removeClass(errorClass +
                            ' ' + successClass);
                    }
                }).done(function (data) {
                    submitBtn.find('span').removeClass('d-none');
                    submitBtn.find('svg').addClass('d-none');
                    submitBtn.prop('disabled', false);

                    if (data.success) {
                        output = '<strong>Success!</strong> ' + data.message;

                        $('#contactform input, #contactform textarea').addClass(successClass);
                        submitBtn.prop('disabled', true);
                        $('#alert').addClass('alert alert-success');
                        $('#alert').html(output).slideDown();
                    } else {
                        if ($.type(data.message) === 'string') {
                            output = '<strong>Failed!</strong> ' + data.message;
                        } else {
                            output =
                                '<strong>Failed!</strong> Please validate your inputs and submit again.';
                        }

                        $('#alert').addClass('alert alert-danger');
                        $('#alert').html(output).slideDown();

                        if (data.message.sender) {
                            $('#sender').addClass(errorClass);
                            $('.sender').append('<div class="invalid-feedback">' + data.message.sender +
                                '</div>');
                        } else {
                            $('#sender').addClass(successClass);
                        }

                        if (data.message.email) {
                            $('#email').addClass(errorClass);
                            $('.email').append('<div class="invalid-feedback">' + data.message.email +
                                '</div>');
                        } else {
                            $('#email').addClass(successClass);
                        }

                        if (data.message.subject) {
                            $('#subject').addClass(errorClass);
                            $('.subject').append('<div class="invalid-feedback">' + data.message
                                .subject + '</div>');
                        } else {
                            $('#subject').addClass(successClass);
                        }

                        if (data.message.message) {
                            $('#message').addClass(errorClass);
                            $('.message').append('<div class="invalid-feedback">' + data.message
                                .message + '</div>');
                        } else {
                            $('#message').addClass(successClass);
                        }
                    }

                    $('html, body').animate({
                        scrollTop: $('#alert').offset().top - 100
                    }, 'slow');
                });

                e.preventDefault();
            });
            <?php endif; ?>
        });
    </script>
    <?php
}

add_action('wp_footer', 'footerScript');

/**
 * Make sub categories to use it's parent category template if available
 */
function subCategoryTemplateHierarchy()
{
    $category  = get_queried_object();
    $templates = [];

    if ($category instanceof WP_Term) {
        if (isset($category->slug)) {
            $slugDecoded = urldecode($category->slug);

            if ($slugDecoded !== $category->slug) {
                $templates[] = "category-{$slugDecoded}.php";
            }

            $templates[] = "category-{$category->slug}.php";
            $templates[] = "category-{$category->term_id}.php";
        }

        if (!empty($category->parent)) {
            $parent = get_category($category->parent);

            if ($parent) {
                $templates[] = "category-{$parent->slug}.php";
                $templates[] = "category-{$parent->term_id}.php";
            }
        }
    }

    $templates[] = 'category.php';

    return locate_template($templates);
}

add_filter('category_template', 'subCategoryTemplateHierarchy');

/**
 * Add custom css file to the login page head section
 */
function loginPageCssModification()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_theme_file_uri('/css/login.css') . '">';
}

add_action('login_head', 'loginPageCssModification');

/**
 * Changing login logo url to our website
 *
 * @return string|void
 */
function loginLogoUrl()
{
    return get_bloginfo('url');
}

add_filter('login_headerurl', 'loginLogoUrl');

/**
 * Changing login url text to our website title
 *
 * @return string|void
 */
function loginLogoUrlText()
{
    return get_bloginfo('name');
}

add_filter('login_headertext', 'loginLogoUrlText');

/**
 * Change filename based on upload time
 *
 * @param string $filename The file name
 *
 * @return string
 */
function fileRenameOnUpload($filename)
{
    $info           = pathinfo($filename);
    $ext            = empty($info['extension']) ? '' : '.' . $info['extension'];
    $chars          = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $generatedChars = substr(str_shuffle($chars), 0, 12);

    return $generatedChars . '_' . time() . $ext;
}

add_filter('sanitize_file_name', 'fileRenameOnUpload', 10);

/**
 * Check the post that in the brief.
 *
 * @param bool|int $post_ID Optional, default to current post ID. The post ID.
 *
 * @return bool
 */
function isPostInBrief($post_ID = false)
{
    if (!$post_ID) {
        global $post;

        $post_ID = $post instanceof WP_Post ? $post->ID : false;
    }

    $categories = get_the_category($post_ID);

    if (!empty($categories)) {
        foreach ($categories as $category) {
            if ($category->slug == 'briefs') {
                return true;
            }
        }
    }

    return false;
}

/**
 * This tells third party services that there are tags other than pure HTML tags within the document.
 * This lets Open Graph parsers read your meta tags properly. And we use language_attributes filter to add this.
 *
 * @param string $output
 *
 * @return string
 */
function doctypeOpenGraph($output)
{
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

//add_filter( 'language_attributes' , 'doctypeOpenGraph' );

/**
 * Manually adding essential social media meta tags.
 */
function addOpenGraphTags()
{
    if (is_single()) {
        $columnist = getTheColumnist();

        if ($columnist !== null) {
            $imgSrc    = getTheColumnistPictureUrl($columnist);
            $imgAttr   = getimagesize($imgSrc);
            $imgWidth  = $imgAttr[0];
            $imgHeight = $imgAttr[1];
        } else {
            if (has_post_thumbnail()) {
                $image     = wp_get_attachment_image_src(get_post_thumbnail_id());
                $imgSrc    = $image[0];
                $imgWidth  = $image[1];
                $imgHeight = $image[2];
            } else {
                $imgSrc    = get_stylesheet_directory_uri() . '/img/open_graph_default.jpg';
                $imgWidth  = '300';
                $imgHeight = '300';
            }
        }

        $imgType = exif_imagetype($imgSrc); ?>

        <!-- Essential meta tags -->
        <meta property="og:title" content="<?php the_title('', ' - ' . get_bloginfo('name')); ?>">
        <meta property="og:description" content="<?php echo get_the_excerpt(); ?>">
        <meta property="og:type" content="article">
        <meta property="og:url" content="<?php the_permalink(); ?>">
        <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
        <meta property="og:image" content="<?php echo $imgSrc; ?>">
        <meta property="og:image:secure_url" content="<?php echo $imgSrc; ?>">
        <meta property="og:image:type" content="<?php echo $imgType; ?>">
        <meta property="og:image:width" content="<?php echo $imgWidth; ?>">
        <meta property="og:image:height" content="<?php echo $imgHeight; ?>">
        <meta property="twitter:card" content="summary_large_image">
        <?php
    }
}

// add_action('wp_head', 'addOpenGraphTags');

// Removing Jetpack plugin open graph meta tags
// add_filter('jetpack_enable_open_graph', '__return_false');

/**
 * Check weather the category or given category slug is media category.
 *
 * @param null $slug
 *
 * @return bool
 */
function isMediaCategory($slug = null)
{
    if ($slug === null) {
        $category = get_queried_object();

        if ($category instanceof WP_Term) {
            $slug = $category->slug;
        }
    }

    $mediaCategories = [
//        'briefs',
'videos',
'pictures',
'infographics',
'cartoons',
    ];

    return in_array($slug, $mediaCategories);
}

/**
 * Check weather the post or given post is in media category.
 *
 * @param false $post_ID
 *
 * @return bool
 */
function isInMediaCategory($post_ID = false)
{
    if (!$post_ID) {
        global $post;

        $post_ID = $post instanceof WP_Post ? $post->ID : false;
    }

    $categories      = get_the_category($post_ID);
    $mediaCategories = [
        'infographics',
        'pictures',
        'videos',
        'cartoons',
    ];

    if (!empty($categories)) {
        foreach ($categories as $category) {
            if (in_array($category->slug, $mediaCategories)) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Category based single post template
 *
 * @param string
 *
 * @return string
 */
function categoryBasedSingleTemplate($single_template)
{
    global $post;

    $categories = get_the_category($post->ID);

    if (empty($categories)) {
        return $single_template;
    }

    if (isInMediaCategory($post->ID)) {
        $template = get_template_directory() . '/single-media.php';

        if (file_exists($template)) {
            $single_template = $template;
        }
    }

    if ($categories[0]->slug === 'qatar-top-5') {
        $template = get_template_directory() . '/single-qatar-top-5.php';

        if (file_exists($template)) {
            $single_template = $template;
        }
    }

    return $single_template;
}

add_filter('single_template', 'categoryBasedSingleTemplate');

/**
 * Modify class to wp_oembed to support bootstrap responsive behaviour
 *
 * @param string $html
 *
 * @return string
 */
function modifyWpOEmbedOutput($html)
{
    $divOpen       = '<div class="embed-responsive embed-responsive-16by9">';
    $divClose      = '</div>';
    $urlParameters = '?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1';
    $frame         = str_replace('?feature=oembed', $urlParameters, $html);

    return $divOpen . str_replace('<iframe', '<iframe class="embed-responsive-item" allowfullscreen',
            $frame) . $divClose;
}

add_filter('embed_oembed_html', 'modifyWpOEmbedOutput', 99, 4);

/**
 * @param string $iconName the icon svg file name.
 * @param boolean $display weather to echo or return.
 *
 * @return string|null the icon url
 */
function displayIcon($iconName, $display = true)
{
    $svg  = get_stylesheet_directory() . '/svg/' . $iconName . '.svg';
    $html = '';

    if (file_exists($svg)) {
        $html = file_get_contents($svg);
    }

    if ($display) {
        echo $html;
    } else {
        return $html;
    }
}

/**
 * Display social media links.
 *
 * @param $class
 */
function displaySocialMediaLinks($class = '')
{
    $locations    = get_nav_menu_locations();

    if (isset($locations['social_media'])) {
        $wpMenu = get_term($locations['social_media'], 'nav_menu');
        $items  = wp_get_nav_menu_items($wpMenu->term_id);
        $list   = '<ul class="' . $class . '">' . "\n";

        foreach ($items as $item) {
            $icon = displayIcon($item->title, false);
            $list .= '<li class="nav-item">' . "\n";
            $list .= '<a href="' . $item->url . '" class="nav-link">' . $icon . '</a>' . "\n";
            $list .= '</li>' . "\n";
        }

        $list .= '</ul>' . "\n";

        echo $list;
    }

    echo '';
}