/* eclint mocha, env, es6 */

(function ($) {

    'use strict';

    $(function () {

        'use strict';

        /* ==================
            Ajax
        ================== */

        const $_POST = (url, name, data) => {

            let str = '';

            $.each(data.split('.'), function (k, v) {
                str += `&${v}=${$('#' + v).val()}`;
            });

            $.ajax({
                url: '/' + url,
                type: 'POST',
                data: name + '_f' + str,
                cache: false,
                success: function (result) {
                    let obj = jQuery.parseJSON(result);
                }
            })

        };

        const $_GET = key => {
            let p = window.location.search;
            p = p.match(new RegExp(key + '=([^&=]+)'));
            return p ? p[1] : false;
        };

        let cntDiv = $('#editor-content'),
            cntArea = $('#editor-content-area'),
            ansBth = $('#create-com-buttons'),
            ctBth = $('#ct-bth');

        if (cntArea || cntDiv) {

            $('form').on('submit', function () {

                cntArea.val(cntDiv.html());
                console.log(cntArea.val());
                
            });

        }
        
    });

})(jQuery, window, document);