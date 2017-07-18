/**
 * Function called on click out element.
 * 
 * @param {DOM} element
 * @param {function} function_act
 * @returns {void}
 */
function on_click_out(element, function_act) {
    $(document).mouseup(function (e) {
        var container = element;

        // if the target of the click isn't the container...
        if (!container.is(e.target))
            // ... nor a descendant of the container
            if (container.has(e.target).length === 0)
                function_act();
    });
}

/**
 * include CSS application
 * 
 * @param {string} css
 */
function css(css) {
    for (i = 0; i < css.length; i++)
        $('<link/>', {rel: 'stylesheet', type: 'text/css', href: 'app/assets/css/' + css[i] + '.css'}).appendTo('head');
}

/**
 * incluindo JS application
 * 
 * @param {string} js
 */
function js(js) {
    for (i = 0; i < js.length; i++)
        $('<script/>', {type: 'text/javascript', src: 'app/assets/js/' + js[i] + '.js'}).appendTo('head');
}

/**
 * Encrypt string
 * 
 * @param {string} str
 * @param {string} method: md5, sha1, b64enc
 * @returns {string}
 */
function encrypt(str, method) {
    return $().crypt({method: method, source: str});
}

/**
 * decrypt string
 * 
 * @param {string} str
 * @param {string} method: md5, sha1, b64enc
 * @returns {string}
 */
function decrypt(encrypted, method) {
    return $().crypt({method: method, source: encrypted});
}

/**
 * Check value is empty
 * 
 * @param {?} str
 * @returns {Boolean}
 */
function empty(str) {
    return !$.trim(str);
}

/**
 * Concat string on string.
 * 
 * @param {type} input
 * @param {type} pad_length
 * @param {type} pad_string
 * @param {type} pad_type
 * @returns {pad.output|String}
 */
function pad(input, pad_length, pad_string, pad_type) {
    var output = input.toString();
    if (pad_string === undefined) {
        pad_string = ' ';
    }
    if (pad_type === undefined) {
        pad_type = 'STR_PAD_RIGHT';
    }
    if (pad_type == 'STR_PAD_RIGHT') {
        while (output.length < pad_length) {
            output = output + pad_string;
        }
    } else if (pad_type == 'STR_PAD_LEFT') {
        while (output.length < pad_length) {
            output = pad_string + output;
        }
    } else if (pad_type == 'STR_PAD_BOTH') {
        var j = 0;
        while (output.length < pad_length) {
            if (j % 2) {
                output = output + pad_string;
            } else {
                output = pad_string + output;
            }
            j++;
        }
    }
    return output;
}

/**
 * Convert money to float.
 * 
 * @param {type} money
 * @returns {unresolved}
 */
function money_to_float(money) {
    money = money.replace(/\./g, "");
    return parseFloat(money.replace(/\,/g, "."));
}

/**
 * Convert float to money
 * 
 * @param {float} float
 * @returns {unresolved}
 */
function float_to_money(float) {
    return float.toFixed(2);
}

/**
 * Get params GET by URL.
 * 
 * @returns {object}
 */
function get_params() {
    var urlParams;
    (window.onpopstate = function () {
        var match,
                pl = /\+/g, // Regex for replacing addition symbol with a space
                search = /([^&=]+)=?([^&]*)/g,
                decode = function (s) {
                    return decodeURIComponent(s.replace(pl, " "));
                },
                query = window.location.search.substring(1);

        urlParams = {};
        while (match = search.exec(query))
            urlParams[decode(match[1])] = decode(match[2]);
    })();

    return urlParams;
}

/**
 * Get URL context.
 * 
 * @returns {string}
 */
function url_context() {
    var url = window.location.href;

    if (!url.indexOf('?'))
        return url;

    url = url.split('?');
    return url[0];
}

/**
 * Table quick filter, overwrite jQuery method to search table content.
 * 
 * @returns {void}
 */
(function () {
    // NEW selector
    jQuery.expr[':'].Contains = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };

    // OVERWRITES old selecor
    jQuery.expr[':'].contains = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };

    $('[filter-in-table]').keyup(function () {
        var trs = $(this).attr('filter-in-table') + ' tbody tr';
        $(trs).not(":contains('" + $(this).val() + "')").hide();
        $(trs + ":contains('" + $(this).val() + "')").show();
    });
})(jQuery);


/**
 * Zipcode Functions
 * 
 * @returns {void}
 */
(function () {

    /**
     * Identificador do elemento que ao ser clicado 
     * buscará os dados e enviará para seus elementos destinos.
     * 
     * @type string
     */
    var submit = '.zipcode_submit';

    /**
     * Identificador do elemento que o usuário irá entrar o CEP.
     * 
     * @type string
     */
    var cep = '.zipcode_zipcode';

    /**
     * Identificador do elemento que receberá a rua.
     * 
     * @type string
     */
    var street = '.zipcode_street';

    /**
     * Identificador do elemento que receberá a bairro.
     * 
     * @type string
     */
    var neighborhood = '.zipcode_neighborhood';

    /**
     * Identificador do elemento que receberá a cidade.
     * 
     * @type string
     */
    var city = '.zipcode_city';

    /**
     * Identificador do elemento que receberá o estado.
     * 
     * @type string
     */
    var state = '.zipcode_state';

    /**
     * URL que será requisitada para obter os dados stringdo endereço.
     * 
     * @type url
     */
    var url = 'http://clareslab.com.br/ws/cep/json/';

    /**
     * Mensagens que será retornado para o usuário caso ocarra algum erro.
     * not_count: CEP não identificado.
     * connection: Cliente sem conexão com a internet.
     */
    var message = {
        not_fount: 'O cep informado não foi localizado. Por favor, preencha os dados manualmente.',
        connection: 'Não foi possível buscar os dados, verifique sua Conexão e se o CEP informado é válido, ou preencha manualmente os dados.',
    };

    var load = '.zipcode_load';
    var val = $(cep).val();

    $(cep).keyup(function () {
        var val = $(this).val() + "";

        if (val.replace(/[^0-9\-]/g, '').length == 9) {
            set_zipcode();
        }
    });

    /**
     * Evento click no elemento de submit do CEP.
     */
    function set_zipcode() {
        $.ajax({
            async: false,
            dataType: 'JSON',
            url: url + "" + $(cep).val(),
            success: function (data) {

                // Cep não encontrado
                if (data == 0)
                    return alert(message.not_fount);

                // preenchendo valores
                $(street).val(data.endereco).focus();
                $(neighborhood).val(data.bairro).focus();
                $(city).val(data.cidade).focus();
                $(state).val(data.uf).focus();
                $(cep).focus();
            },
            // Sem conexão com a internet, ou algum erro desconhecido.
            error: function () {
                alert(message.connection);
            }
        });
    }

})(jQuery);

/* Função básica do evento de clicar fora de um element */
$.fn.clickOut = function (callback, selfDestroy) {
    var clicked = false;
    var parent = this;
    var destroy = selfDestroy || true;

    parent.click(function () {
        clicked = true;
    });

    $(document).click(function (event) {
        if (!clicked)
            callback(parent, event);

        if (destroy) {
            //parent.clickOff = function() {};
            //parent.off("click");
            //$(document).off("click");
            //parent.off("clickOff");
        }

        clicked = false;
    });
};