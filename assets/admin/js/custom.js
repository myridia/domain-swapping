(function ($) {
    'use strict';
    $(document).ready(() => {
        /****************
         * Add Clone
         */

        $(document).on('click',".wphc_include_btn_new_row", function(e)
        {
            wphc_clone_row('include',wphc_localize.allow_host);
        });

        $(document).on('click',".wphc_exclude_btn_new_row", function(e)
        {
            wphc_clone_row('exclude',wphc_localize.allow_host);
        });


        /******************
         * Remove Clone
         */
        $(document).on('click',".wphc_btn_row_delete", function(e)
        {
            $(this).closest('tr').remove();
            wphc_hide_row_delete_btn('include')
            wphc_hide_row_delete_btn('exclude')
        });

        function wphc_show_row_delete_btn(type){
            if ($(document).find('.wphc_tbl_' + type).find("tr").length > 2)
            {
                $(document).find('.wphc_tbl_' + type).find('.wphc_btn_row_delete').show();
            }else{
                $(document).find('.wphc_tbl_' + type).find('.wphc_btn_row_delete').hide();
            }
        }

        function wphc_hide_row_delete_btn(type){
            if ($(document).find('.wphc_tbl_' + type).find("tr").length < 3) {
                $(document).find('.wphc_tbl_' + type).find('.wphc_btn_row_delete').hide();
            }
        }

        function wphc_clone_row(type ,heading){
            var tableBody = $(document).find('.wphc_tbl_' + type);
            var trlength=tableBody.find("tr");
            if (trlength.length > 1) {
                var trFirst = tableBody.find("tr:first");
                var trNew = trFirst.clone();
                trNew.find('th').text(heading);
                trNew.find('td').find('span').show();
                trNew.find(':input').val('');
                tableBody.find("tr:last").prev().after(trNew);
            }
            else {
                alert(wphc_localize.no_item);
            }
            wphc_show_row_delete_btn(type);
        }

    });
})(jQuery);