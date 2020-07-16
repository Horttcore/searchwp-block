<?php
namespace RalfHortt\SearchWPBlock\Block;

use RalfHortt\WPBlock\Block;

class SearchWPBlock extends Block
{
    protected $name = 'searchwp/search';

    protected $attributes = [];

    public function register(): void
    {
        $this->attributes = [
            'label' => [
                'type' => 'string',
                'default' => _x('Search for:', 'label'),
            ],
            'placeholder' => [
                'type' => 'string',
                'default' => _x('Search &hellip;', 'placeholder'),
            ],
            'action' => [
                'type' => 'string',
                'default' => _x('Search', 'submit button'),
            ],
            'noResult' => [
                'type' => 'string',
                'default' => __('No results found.'),
            ],
            'engine' => [
                'type' => 'string',
                'default' => 'default',
            ],
        ];

        parent::register();
    }

    protected function render($atts, $content): void
    {
        $this->renderForm($atts, $content);

        if (isset($_GET['searchwp'])) {
            $this->renderResult($atts, $content);
        }
    }

    protected function renderForm($atts, $content)
    {
        ?>
        <form role="search" method="get" class="search-form" action="">
            <label class="search-form__label"><?= $atts['label'] ?></label>
            <input type="search" class="search-form__field" name="searchwp" placeholder="<?= esc_attr($atts['placeholder']) ?>" value="<?= isset($_GET['searchwp']) ? esc_attr($_GET['searchwp']) : '' ?>" title="<?= $atts['label'] ?>" />
            <input type="hidden" class="search-form__engine" name="engine" value="<?= $atts['engine'] ?>" />
            <button type="submit" class="search-form__submit"><?= $atts['action'] ?></button>
        </form>
        <?php
    }

    protected function renderResult($atts, $content)
    {
        // Retrieve applicable query parameters.
        $search_query = isset($_GET['searchwp']) ? sanitize_text_field($_GET['searchwp']) : null;
        $search_page  = isset($_GET['swppg']) ? absint($_GET['swppg']) : 1;

        // Perform the search.
        $search_results    = [];
        $search_pagination = '';
        if (! empty($search_query) && class_exists('\\SearchWP\\Query')) {
            $searchwp_query = new \SearchWP\Query($search_query, [
                'engine' => $atts['engine'], // The Engine name.
                'fields' => 'all',          // Load proper native objects of each result.
                'page'   => $search_page,
            ]);

            $search_results = $searchwp_query->get_results();

            $search_pagination = paginate_links(array(
                'format'  => '?swppg=%#%',
                'current' => $search_page,
                'total'   => $searchwp_query->max_num_pages,
            ));
        }

        do_action('searchwp-block/before-search-result', $search_query, $search_results);

        if (! empty($search_query) && ! empty($search_results)) {
            foreach ($search_results as $search_result) {
                $type = get_class($search_result);
                $title = ($type == 'WP_User') ? $search_result->data->display_name : get_the_title($search_result->ID);
                $link = ($type == 'WP_User') ? get_author_posts_url($search_result->data->ID) : get_permalink($search_result->ID);
                $excerpt = ($type == 'WP_User') ? wp_kses_post(get_the_author_meta('description', $search_result->data->ID)) : get_the_excerpt($search_result->ID);
                \ob_start(); ?>
				<article class="page hentry search-result">
                    <header class="entry-header">
                        <h1 class="entry-title"><a href="<?= $link ?>"><?= $title ?></a></h1>
                    </header>
                    <div class="entry-summary">
                        <?= $excerpt ?>
                    </div>
                </article>
                <?php
                $output = \ob_get_clean();
                wp_reset_postdata();
                echo apply_filters('searchwp-block\search-result-item', $output, $type, $title, $link, $excerpt, $search_result);
            }

            if ($searchwp_query->max_num_pages > 1) {
                ?>
				<div class="navigation pagination" role="navigation">
					<h2 class="screen-reader-text"><?php _e('Results navigation', 'searchwp-block') ?></h2>
					<div class="nav-links"><?php echo wp_kses_post($search_pagination); ?></div>
				</div>
                <?php
            }
        } elseif (! empty($search_query)) {
            ?>
			<p><?= $atts['noResult'] ?></p>
            <?php
        }

        do_action('searchwp-block/after-search-result', $search_query, $search_results);
    }
}
