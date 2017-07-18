$(document).ready(function () {
    if ($('.encoder_paginate').length > 0) {
        
        console.log($('.encoder_paginate'));
        
        var total = parseInt($('.encoder_paginate').attr('total'));
        var current = parseInt($('.encoder_paginate').attr('current'));

        $('input', $('.encoder_paginate')).keypress(function (e) {
            if (e.keyCode == 13) {
                var page = parseInt($(this).val());

                if (page == current) {
                    $('.message_page_not_found', '.encoder_paginate').hide();
                    return $('.message_current_page', '.encoder_paginate').show();
                } else if (page <= 0 || page > total) {
                    $('.message_current_page', '.encoder_paginate').hide();
                    return $('.message_page_not_found', '.encoder_paginate').show();
                }

                // gerando o query dos parametros GET sobreescrevendo a página
                var query = "";
                var page_key_exists = false;

                $.each(get_params(), function (key, value) {
                    if (key == 'page')
                        page_key_exists = true;

                    query += key + '=' + (key == 'page' ? page : value) + '&';
                });

                if (empty(query) || !page_key_exists)
                    query += 'page=' + page;

                window.location.href = url_context() + '?' + query;
            }
        });
    }
});
