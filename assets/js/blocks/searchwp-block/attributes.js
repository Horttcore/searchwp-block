const {
    __,
    _x
} = wp.i18n;

export default {
    label: {
        type: "string",
        default: _x('Search for:', 'label'),
    },
    placeholder: {
        type: "string",
        default: _x('Search &hellip;', 'placeholder'),
    },
    action: {
        type: "string",
        default: _x('Search', 'submit button'),
    },
    noResult: {
        type: "string",
        default: __('No results found.'),
    },
    engine: {
        type: "string",
        default: 'default',
    },
};
