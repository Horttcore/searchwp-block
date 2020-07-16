/**
 * Inspector Controls
 */
const { __ } = wp.i18n;
const { Component } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Controls extends Component {
  constructor(props) {
    super(...arguments);
  }

  render() {
    const {
      setAttributes,
      attributes: {
        label,
        placeholder,
        action,
        engine,
      }
    } = this.props;


    return (
      <InspectorControls>
        <PanelBody title={__('Settings', 'searchwp-block')} initialOpen={true}>
          <TextControl
            label={__('Input Label', 'searchwp-block')}
            value={label}
            onChange={(label) => setAttributes({ label })}
          />
          <TextControl
            label={__('Input Placeholder', 'searchwp-block')}
            value={placeholder}
            onChange={(placeholder) => setAttributes({ placeholder })}
          />
          <TextControl
            label={__('Button Text', 'searchwp-block')}
            value={action}
            onChange={(action) => setAttributes({ action })}
          />
          <TextControl
            label={__('SearchWP Engine', 'searchwp-block')}
            value={engine}
            onChange={(engine) => setAttributes({ engine })}
          />
        </PanelBody>
      </InspectorControls>
    );
  }
}
