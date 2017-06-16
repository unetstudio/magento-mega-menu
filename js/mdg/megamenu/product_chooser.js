/**
 * Created by duc on 18/08/2015.
 */

/**
 * Product chooser toggle
 */
$.noConflict();
jQuery(document).ready(function($){
    $("#product_chooser").removeClass('show');
    $("#product_chooser").addClass('hide');
    $("#content_type").change(function(){
        $(this).find("option:selected").each(function(){
            if(($(this).attr("value") == "product") &&
                ($("#product_type").find("option:selected").attr("value") == "select"))
            {
                $("#product_chooser").removeClass('hide');
                $("#product_chooser").addClass('show');
            }
            else {
                $("#product_chooser").removeClass('show');
                $("#product_chooser").addClass('hide');
            }
        });
    });
    $("#product_type").change(function(){
        $(this).find("option:selected").each(function(){
            if(($(this).attr("value") == "select")){
                $("#product_chooser").removeClass('hide');
                $("#product_chooser").addClass('show');
            }
            else {
                $("#product_chooser").removeClass('show');
                $("#product_chooser").addClass('hide');
            }
        });
    });
    $("#product_type").find("option:selected").each(function(){
        if(($(this).attr("value") == "select")){
            $("#product_chooser").removeClass('hide');
            $("#product_chooser").addClass('show');
        }
        else {
            $("#product_chooser").removeClass('show');
            $("#product_chooser").addClass('hide');
        }
    });
});
