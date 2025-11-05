/**
 * WordPress Dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Save component
 */
export default function save({ attributes }) {
    const blockProps = useBlockProps.save();
    
    return (
        <div {...blockProps} data-gf-attributes={JSON.stringify(attributes.gfAttributes || {})}>
        </div>
    );
}