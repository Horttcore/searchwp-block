/**
 * Import block dependencies
 */
import attributes from "./attributes";
import edit from "./edit";

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register Block
 */
registerBlockType("searchwp/search", {
    title: __("SearchWP", "searchwp-block"),
    icon: "search",
    category: "widget",
    keywords: [
        __("Search"),
    ],
    attributes,
    edit,
});
