@php
namespace App;

use Walker_Nav_Menu;

use function get_post_type;
use function get_post_types;
use function get_post_type_archive_link;
use function is_search;
use function sanitize_title;
use function add_filter;
use function remove_filter;


/**
 * This NavWalker was forked from Roots/Soil/src/NavWalker.
 * The Soil plugin has been deprecated in favor of Acorn/Acorn-Prettify and is no longer maintained.
 * This NavWalker includes Soil's cleaner navigation markup and is modified to work with Bootstrap 5.
 * @link https://github.com/roots/soil/
 * @link https://getbootstrap.com/docs/5.0/components/navbar/
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * NavWalker example output:
 *   <li class="menu-home menu-item nav-item active"><a href="/" class="nav-link">Home</a></li>
 *   <li class="menu-sample-page menu-item nav-item"><a href="/sample-page/" class="nav-link">Sample Page</a></li>
 *
 */
class BootstrapNav extends Walker_Nav_Menu
{
    /**
     * Is current post a custom post type?
     *
     * @var bool
     */
    protected $is_cpt;

    /**
     * Archive page for current URL.
     *
     * @var string
     */
    protected $archive;

    public function __construct()
    {
        $cpt              = get_post_type();

        $this->is_cpt     = in_array($cpt, get_post_types(array('_builtin' => false)), true);
        $this->archive    = get_post_type_archive_link($cpt);
        $this->is_search  = is_search();
    }

    public function checkCurrent($classes)
    {
        return preg_match('/(current[-_])|active/', $classes);
    }

    public function displayElement($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        $element->is_subitem = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));
        $element->is_active = (!empty($element->url) && strpos($this->archive, $element->url));

        if ($element->is_active && !$this->is_search) {
            $element->classes[] = 'active';
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    public function cssClasses($classes, $item)
    {
        $slug = sanitize_title($item->title);

        // Fix core `active` behavior for custom post types
        if ($this->is_cpt) {
            $classes = str_replace('current_page_parent', '', $classes);

            if ($this->archive && !$this->is_search) {
                if (strpos($item->url, $this->archive) !== false) {
                    $classes[] = 'active';
                }
            }
        }

        // Remove most core classes
        $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
        $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

        // Re-add core `menu-item` class
        $classes[] = 'menu-item';

        // Add Bootstrap classes
        if ($item->menu_item_parent == 0) {
            $classes[] = 'nav-item';
        }
        if ($item->is_subitem) {
            $classes[] = 'dropdown';
        }

        // Re-add core `menu-item-has-children` class on parent elements
        if ($item->is_subitem) {
            $classes[] = 'menu-item-has-children';
        }

        // Add `menu-<slug>` class
        $classes[] = 'menu-' . $slug;

        $classes = array_unique($classes);
        $classes = array_map('trim', $classes);

        return array_filter($classes);
    }

    /**
     * Add "dropdown-menu" class to dropdown UL
     * @param $classes
     * @return array
     */
    function dropdownListClass($classes): array
    {
        $classes[] = 'dropdown-menu';
        return $classes;
    }

    /**
     * Add Bootstrap 5 classes and attributes to anchor links.
     * This method originally created by QWp6t.
     * @param $atts
     * @param $item
     * @param $args
     * @param $depth
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) This method overrides its parent
     * @link (credit) https://gist.github.com/QWp6t/8f94b7096bb0d3a72fedba68f73033a5#file-bootstrap-php-L63
     */
    public function linkAttributes($atts, $item, /** @noinspection PhpUnusedParameterInspection */ $args, $depth): array
    {
        $atts['class'] = $depth ? 'dropdown-item' : 'nav-link';
        if ($item->current || $item->current_item_ancestor) {
            $atts['class'] .= ' active';
        }
        if ($item->is_subitem) {
            $atts['class'] .= ' dropdown-toggle';
            $atts += [
                'data-bs-toggle' => 'dropdown',
                'role' => 'button',
                'aria-expanded' => 'false'
            ];
        }
        return $atts;
    }

    public function walk($elements, $max_depth, ...$args)
    {
        // Add filters
        add_filter('nav_menu_css_class', array($this, 'cssClasses'), 10, 2);
        add_filter('nav_menu_item_id', '__return_null');
        add_filter('nav_menu_submenu_css_class', [$this, 'dropdownListClass'], 10, 2);
        add_filter('nav_menu_link_attributes', [$this, 'linkAttributes'], 10, 4);

        // Perform usual walk
        $output = call_user_func_array(['parent', 'walk'], func_get_args());

        // Unregister filters
        remove_filter('nav_menu_css_class', [$this, 'cssClasses']);
        remove_filter('nav_menu_item_id', '__return_null');
        remove_filter('nav_menu_submenu_css_class', [$this, 'dropdownListClass']);
        remove_filter('nav_menu_link_attributes', [$this, 'linkAttributes']);

        // Return result
        return $output;
    }

    /**
     * Everything below this line is passthrus for WordPress.
     * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        return $this->displayElement($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
