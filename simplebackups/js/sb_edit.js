function toggle_fieldsets() {
    $("fieldset.type").hide();
    $("#fs_" + $("form#add select[name=type]").val()).show();
}
$(function() {
    toggle_fieldsets();
    $("form#add select[name=type]").change(function(){
        toggle_fieldsets();
    });
});
