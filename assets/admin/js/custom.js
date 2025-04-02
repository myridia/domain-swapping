(function ($) {
    'use strict';
    $(document).ready(() => {
        /****************
         * Add Clone
         */

        $(document).on('click',".wpdsinclude_btn_new_row", function(e)
        {
            wpdsclone_row('include',wpdslocalize.allow_host);
        });

        $(document).on('click',".wpdsexclude_btn_new_row", function(e)
        {
            wpdsclone_row('exclude',wpdslocalize.allow_host);
        });


        /******************
         * Remove Clone
         */
        $(document).on('click',".wpdsbtn_row_delete", function(e)
        {
            $(this).closest('tr').remove();
            wpdshide_row_delete_btn('include')
            wpdshide_row_delete_btn('exclude')
        });

        function wpdsshow_row_delete_btn(type){
            if ($(document).find('.wpdstbl_' + type).find("tr").length > 2)
            {
                $(document).find('.wpdstbl_' + type).find('.wpdsbtn_row_delete').show();
            }else{
                $(document).find('.wpdstbl_' + type).find('.wpdsbtn_row_delete').hide();
            }
        }

        function wpdshide_row_delete_btn(type){
            if ($(document).find('.wpdstbl_' + type).find("tr").length < 3) {
                $(document).find('.wpdstbl_' + type).find('.wpdsbtn_row_delete').hide();
            }
        }

        function wpdsclone_row(type ,heading){
            var tableBody = $(document).find('.wpdstbl_' + type);
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
                alert(wpdslocalize.no_item);
            }
            wpdsshow_row_delete_btn(type);
        }

    });
})(jQuery);