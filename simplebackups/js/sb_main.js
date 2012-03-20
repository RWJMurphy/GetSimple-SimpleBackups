function toggle_fieldsets() {
    $("fieldset.type").hide();
    $("#fs_" + $("form#add select[name=type]").val()).show();
}

function filter_logs() {
    var level = parseInt($("form#logs select[name=level]").val());
    $("table.logs tr.logline").each(function(index, value){
        if (parseInt($(value).data("level")) >= level) {
            $(value).show();
        } else {
            $(value).hide();
        }
    });
}

$(function() {
    /* Edit/add pages */
    toggle_fieldsets();
    $("form#add select[name=type]").change(function(){
        toggle_fieldsets();
    });

    /* Log Page */
    filter_logs();
    $("form#logs select[name=level]").change(function(){
        filter_logs();
    });
});
