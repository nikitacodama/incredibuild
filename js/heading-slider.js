wp.domReady(() => {
    const { addFilter } = wp.hooks;

    // Add the widthValue attribute to the Heading and Paragraph blocks
    const addWidthValueAttribute = (settings, name) => {
        if (['core/heading', 'core/paragraph'].includes(name)) {
            settings.attributes = {
                ...settings.attributes,
                widthValue: {
                    type: 'number',
                    default: 100, // Default value
                },
            };
        }
        return settings;
    };

    // Add custom slider control to the block's sidebar
    const addWidthSliderControl = (props) => {
        const { attributes, setAttributes } = props;

        // Ensure default value
        const widthValue = attributes.widthValue ?? 100;

        return wp.element.createElement(
            wp.blockEditor.InspectorControls,
            null,
            wp.element.createElement(
                wp.components.PanelBody,
                {
                    title: 'Width Control',
                    initialOpen: true,
                },
                wp.element.createElement(wp.components.RangeControl, {
                    label: 'Width',
                    value: widthValue,
                    onChange: (newValue) => setAttributes({ widthValue: newValue }),
                    min: 50,
                    max: 100,
                    step: 5,
                })
            )
        );
    };

    // Dynamically apply cwidth-{value} class in the editor
    const applyWidthClassInEditor = (BlockListBlock) => (props) => {
        const { attributes, className } = props;
        const { widthValue } = attributes;

        if (['core/heading', 'core/paragraph'].includes(props.name)) {
            const updatedClassName = [
                className || '',
                widthValue ? `cwidth-${widthValue}` : '',
            ]
                .join(' ')
                .trim();

            return wp.element.createElement(BlockListBlock, {
                ...props,
                className: updatedClassName, // Dynamically update className
            });
        }

        return wp.element.createElement(BlockListBlock, props);
    };

    // Add cwidth-{value} class to the saved content
    const applyWidthClass = (extraProps, blockType, attributes) => {
        if (['core/heading', 'core/paragraph'].includes(blockType.name) && attributes.widthValue) {
            const { widthValue } = attributes;

            // Clean existing classes
            extraProps.className = `${extraProps.className || ''}`
                .split(' ')
                .filter((cls) => !cls.startsWith('cwidth-'))
                .join(' ');

            // Add the new class
            extraProps.className += ` cwidth-${widthValue}`;
        }
        return extraProps;
    };

    // Register filters
    addFilter(
        'blocks.registerBlockType',
        'heading-slider/add-width-value-attribute',
        addWidthValueAttribute
    );

    addFilter(
        'editor.BlockEdit',
        'heading-slider/add-width-slider-control',
        (BlockEdit) => (props) => {
            if (['core/heading', 'core/paragraph'].includes(props.name)) {
                return wp.element.createElement(
                    wp.element.Fragment,
                    null,
                    wp.element.createElement(BlockEdit, props),
                    addWidthSliderControl(props)
                );
            }
            return wp.element.createElement(BlockEdit, props);
        }
    );

    addFilter(
        'editor.BlockListBlock',
        'heading-slider/apply-width-class-in-editor',
        applyWidthClassInEditor
    );

    addFilter(
        'blocks.getSaveContent.extraProps',
        'heading-slider/apply-width-class',
        applyWidthClass
    );
});

console.log("heading-slider.js updated and loaded");
