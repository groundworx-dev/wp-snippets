/**
 * WordPress Dependencies
 */
import { __ } from '@wordpress/i18n';

import { useBlockProps, InspectorControls, withColors } from '@wordpress/block-editor';
import { getBlockType } from '@wordpress/blocks';
import { createElement, useMemo, useEffect, useState } from '@wordpress/element';
import MultiColorControl from './multi-color-control';
import { getColorCSSVar } from './utils.js';
import { colord } from 'colord';

function Edit({
    attributes, setAttributes, 
    labelColor, setLabelColor,
    requiredColor, setRequiredColor,
    inputTextColor, setInputTextColor,
    inputBackgroundColor, setInputBackgroundColor,
    inputBorderColor, setInputBorderColor,
    inputRadioTextColor, setInputRadioTextColor,
    inputRadioBackgroundColor, setInputRadioBackgroundColor,
    progressbarForegroundTextColor, setProgressbarForegroundTextColor,
    progressbarForegroundColor, setProgressbarForegroundColor,
    progressbarBackgroundColor, setProgressbarBackgroundColor,
    clientId
}) {

    const saveRgbValue = (colorObj, rgbAttrName) => {
        if (colorObj?.color) {
            const parsed = colord(colorObj.color);
            const rgba = parsed.toRgb();
            setAttributes({ 
                [rgbAttrName]: `rgba(${rgba.r}, ${rgba.g}, ${rgba.b}, ${rgba.a})` 
            });
        } else {
            setAttributes({ [rgbAttrName]: '' });
        }
    };

    useEffect(() => {
        saveRgbValue(labelColor, 'rgbLabelColor');
    }, [labelColor]);

    useEffect(() => {
        saveRgbValue(requiredColor, 'rgbRequiredColor');
    }, [requiredColor]);

    useEffect(() => {
        saveRgbValue(inputTextColor, 'rgbInputTextColor');
    }, [inputTextColor]);

    useEffect(() => {
        saveRgbValue(inputBackgroundColor, 'rgbInputBackgroundColor');
    }, [inputBackgroundColor]);

    useEffect(() => {
        saveRgbValue(inputBorderColor, 'rgbInputBorderColor');
    }, [inputBorderColor]);

    useEffect(() => {
        saveRgbValue(inputRadioTextColor, 'rgbInputRadioTextColor');
    }, [inputRadioTextColor]);

    useEffect(() => {
        saveRgbValue(inputRadioBackgroundColor, 'rgbInputRadioBackgroundColor');
    }, [inputRadioBackgroundColor]);

    useEffect(() => {
        saveRgbValue(progressbarForegroundColor, 'rgbProgressbarForegroundColor');
    }, [progressbarForegroundColor]);

    useEffect(() => {
        saveRgbValue(progressbarForegroundTextColor, 'rgbProgressbarForegroundTextColor');
    }, [progressbarForegroundTextColor]);

    useEffect(() => {
        saveRgbValue(progressbarBackgroundColor, 'rgbProgressbarBackgroundColor');
    }, [progressbarBackgroundColor]);
    
    const blockProps = useBlockProps();
    const blockType = useMemo(() => getBlockType('gravityforms/form'), []);
    
    const [gfAttrs, setGfAttrs] = useState(attributes.gfAttributes || {});
    
    useEffect(() => {
        setGfAttrs(attributes.gfAttributes || {});
    }, [attributes.gfAttributes]);
    
    if (!blockType?.edit) {
        return <div {...blockProps}>Gravity Forms not found.</div>;
    }
    
    const GravityFormsEdit = blockType.edit;

    const labelColors = [
        { 
            key: 'text', 
            label: __('Text', 'groundworx'), 
            value: labelColor, 
            setValue: setLabelColor 
        },
        { 
            key: 'requiredtext', 
            label: __('Required Text', 'groundworx'), 
            value: requiredColor, 
            setValue: setRequiredColor 
        }
    ];

    const inputColors = [
        { 
            key: 'text', 
            label: __('Text', 'groundworx'), 
            value: inputTextColor, 
            setValue: setInputTextColor 
        },
        { 
            key: 'background', 
            label: __('Background', 'groundworx'), 
            value: inputBackgroundColor, 
            setValue: setInputBackgroundColor 
        },
        { 
            key: 'border', 
            label: __('Border', 'groundworx'), 
            value: inputBorderColor, 
            setValue: setInputBorderColor 
        },
    ];

    const inputRadioColors = [
        { 
            key: 'text', 
            label: __('Text', 'groundworx'), 
            value: inputRadioTextColor, 
            setValue: setInputRadioTextColor
        },
        { 
            key: 'background', 
            label: __('Background', 'groundworx'), 
            value: inputRadioBackgroundColor, 
            setValue: setInputRadioBackgroundColor 
        }
    ];

    const progressColors = [
        { 
            key: 'text', 
            label: __('Text', 'groundworx'), 
            value: progressbarForegroundTextColor, 
            setValue: setProgressbarForegroundTextColor
        },
        { 
            key: 'foreground', 
            label: __('Foreground', 'groundworx'), 
            value: progressbarForegroundColor, 
            setValue: setProgressbarForegroundColor 
        },
        { 
            key: 'background', 
            label: __('Background', 'groundworx'), 
            value: progressbarBackgroundColor, 
            setValue: setProgressbarBackgroundColor 
        },
    ];

    return (
        <>
            <InspectorControls group="color">
                <MultiColorControl
                    label={ __('Labels', 'groundworx') }
                    colors={ labelColors }
                    clientId={ clientId }
                />

                <MultiColorControl
                    label={ __('Input', 'groundworx') }
                    colors={ inputColors }
                    clientId={ clientId }
                />

                <MultiColorControl
                    label={ __('Radio and Checkbox', 'groundworx') }
                    colors={ inputRadioColors }
                    clientId={ clientId }
                />

                <MultiColorControl
                    label={ __('Progress Bar', 'groundworx') }
                    colors={ progressColors }
                    clientId={ clientId }
                />
            </InspectorControls>

            { createElement(GravityFormsEdit, {
                attributes: gfAttrs,
                setAttributes: (newAttrs) => {
                    setGfAttrs(prev => {
                        const updated = { ...prev, ...newAttrs, theme: 'gravity-theme' };
                        setAttributes({ gfAttributes: updated });
                        return updated;
                    });
                },
                isSelected: false,
            }) }
        </>
    );
}

export default withColors(
    { labelColor: 'color' },
    { requiredColor: 'color' },
    { inputTextColor: 'color' },
    { inputBackgroundColor: 'backgroundColor' },
    { inputBorderColor: 'borderColor' },
    { inputRadioTextColor: 'color' },
    { inputRadioBackgroundColor: 'backgroundColor' },
    { progressbarForegroundTextColor: 'color' },
    { progressbarForegroundColor: 'backgroundColor' },
    { progressbarBackgroundColor: 'backgroundColor' }
)( Edit );

import { addFilter } from '@wordpress/hooks';

addFilter(
    'editor.BlockListBlock',
    'groundworx/gforms-wrapper-styles',
    (BlockListBlock) => {
        return (props) => {
            const { block, attributes } = props;
            
            if (block.name !== 'groundworx/gutenberg-gravity-forms') {
                return <BlockListBlock {...props} />;
            }

            const selectArrowSvg = attributes.rgbInputTextColor 
                ? `url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 7.41'%3E%3Cpath d='M10.02,6,8.61,7.41,13.19,12,8.61,16.59,10.02,18l6-6Z' transform='translate(18 -8.61) rotate(90)' fill='${encodeURIComponent(attributes.rgbInputTextColor)}'/%3E%3C/svg%3E")`
                : undefined;
            
            const customProps = {
                ...props,
                wrapperProps: {
                    ...props.wrapperProps,
                    style: {
                        ...getColorCSSVar(attributes.labelColor, attributes.customLabelColor, '--form--labels'),
                        ...getColorCSSVar(attributes.requiredColor, attributes.customRequiredColor, '--form--labels--required'),
                        ...getColorCSSVar(attributes.inputTextColor, attributes.customInputTextColor, '--form--input--text'),
                        ...getColorCSSVar(attributes.inputBackgroundColor, attributes.customInputBackgroundColor, '--form--input--background'),
                        ...getColorCSSVar(attributes.inputBorderColor, attributes.customInputBorderColor, '--form--input--border--color'),

                        ...getColorCSSVar(attributes.inputRadioTextColor, attributes.customInputRadioTextColor, '--form--checkbox-radio--text'),
                        ...getColorCSSVar(attributes.inputRadioBackgroundColor, attributes.customInputRadioBackgroundColor, '--form--checkbox-radio--background'),

                        ...getColorCSSVar(attributes.progressbarForegroundTextColor, attributes.cusotmProgressbarForegroundTextColor, '--form--progressbar--foreground--text'),
                        ...getColorCSSVar(attributes.progressbarForegroundColor, attributes.cusotmProgressbarForegroundColor, '--form--progressbar--foreground'),
                        ...getColorCSSVar(attributes.progressbarBackgroundColor, attributes.customProgressbarBackgroundColor, '--form--progressbar--background'),
                        
                        ...(selectArrowSvg && { '--form--select--arrow': selectArrowSvg })
                    }
                }
            };
            
            return <BlockListBlock {...customProps} />;
        };
    }
);