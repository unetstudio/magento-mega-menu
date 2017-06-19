/**
 * Created by duc on 27/08/2015.
 */
/**
 * Grid sort order edit inline
 */
function updateField(button, fieldId){
    new Ajax.Request("<?php echo Mage::helper(\"adminhtml\")->getUrl(\"*/*/updateSort\"); ?>", {
        method: "post",
        parameters: {
            id: fieldId,
            sort_order: $(button).previous("input").getValue(),
        },
    });
}
