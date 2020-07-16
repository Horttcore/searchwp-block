import InspectorControls from "./inspector-controls";

const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { serverSideRender: ServerSideRender } = wp;

export default class Edit extends Component {
    constructor(props) {
        super(...arguments);
    }

    render() {
        const {
            attributes: {
                label,
                placeholder,
                action,
                noResult,
                engine
            },
            className,
            setAttributes,
            isSelected
        } = this.props;

        return (
            <Fragment>
                <InspectorControls {...this.props} />
                <ServerSideRender
                    block="searchwp/search"
                    attributes={{ ...this.props.attributes }}
                />
            </Fragment>
        );
    }
}
