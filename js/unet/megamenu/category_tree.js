/**
 * Created by duc on 28/08/2015.
 */
var visible = false;
window.onload = function(){
    $("category_tree").style.display = "none";
}
getCategoryTree = function(url) {
    if(visible){
        $("category_tree").style.display = "none";
        visible = false;
        return;
    }
    visible = true;
    $("category_tree").style.display = "block";
    new Ajax.Request(
        url, {
            method: 'post',
            onSuccess: function(result){
                var tree = $("category_tree");
                tree.update(result.responseText);
            }
        }
    );
}