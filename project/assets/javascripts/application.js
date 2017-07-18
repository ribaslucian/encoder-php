/**
 * Scripts da aplicação.
 * 
 * include: ../../../$shared/vendor/javascripts/manifest.min
 * include: ../../../$shared/vendor/inspinia/toastr.min
 * include: ../../../$shared/vendor/materializecss/materialize.min
 * include: ../../../$shared/lib/javascripts/functions
 * include: ../../../$shared/lib/javascripts/dropdown
 * include: ../../../$shared/lib/javascripts/paginate
 * 
 * Graphics Module
 * include: ../../../$shared/vendor/highcharts/js/highcharts
 * include: ../../../$shared/vendor/highcharts/js/highcharts-more
 * include: ../../../$shared/vendor/highcharts/js/modules/exporting
 */

$(document).ready(function () {
    
    // encriptar a senha do formulário antes do seu submit.
    $('form.encrypt_password').submit(function () {
        $('[type="password"]', $(this)).each(function (k, i) {
            if (!empty($(i).val()))
                $(i).val(encrypt($(i).val(), 'md5'));
        });
    });

    // Ao sair de uma página, mostrar o loader.
    $(window).on('beforeunload', function () {
        $('.page_content').hide();
        $('page-loader').show();
    });

    // Esconder o loader da página após concluir o carregamento.
    $(window).bind('load', function () {
        $('page-loader').hide();
        $('.page_content').show();
    });

    // Ao terminar de carregar a página, vamos posicionar no centro vertical 
    // um determinado elemento, que comunente será o conteúdo da página.
    $(window).bind('load', function () {
        var element = '.vertical.align';

        $(element).each(function (k, e) {
            var margin_top = $(window).height() / 2 - $(e).height() / 2;
            margin_top = margin_top < 0 ? 0 : margin_top;
            $(e).attr('style', 'margin-top: ' + margin_top + 'px;');
        });
    });

    // Formulários enviados a partir de um elemento não button nem submit.
    // Submitar formulário através de um determinado elemento.
    $('submitter').click(function () {
        $(this).parent('form').submit();
    });

    // Mascaras que serão utilizadas nos campos da aplicação.
    $('.mask.date').mask('99/99/9999');
    $('.mask.date_hour').mask('99/99/9999 99:99');
    $('.mask.hour').mask('99:99');
    $('.mask.cpf').mask('999.999.999-99');
    $('.mask.cnpj').mask('99.999.999/9999-99');
    $('.mask.rg').mask('99.999.999-9');
    $('.mask.phone').mask('(99) 9999-9999');
    $('.mask.plate').mask('AAA-9999');
    $('.mask.cep').mask('99999-999');
    $('.mask.money').mask('000.000.000.000.000,00', {reverse: true});
    
    $('.plate.mask').mask('SSS-9999', {'translation': {S: {pattern: /[A-Za-z]/}}});

    $('.mask.number').keydown(function (e) {
        allow_key_code = [8, 9, 13, 37, 38, 39, 40, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 116, 109, 189];
        return $.inArray(e.keyCode, allow_key_code) == -1 ? false : true;
    });

    $('.mask.natural.number').keydown(function (e) {
        allow_key_code = [8, 9, 13, 37, 38, 39, 40, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 116];
        return $.inArray(e.keyCode, allow_key_code) == -1 ? false : true;
    });

    // Mensagem de confirmação antes de acessar um página.
    $("[confirm]").click(function () {
        return confirm($(this).attr("confirm"));
    });

    // Mensagem de confirmação antes do submit de um formulário.
    $("form [confirm]").submit(function () {
        return false;
    });

    // Exibição mensagens flash através do componente toastr.
    toastr.options = {closeButton: false, debug: false, progressBar: true, positionClass: 'toast-top-left', onclick: null, showDuration: '400', hideDuration: '1000', timeOut: '20000', extendedTimeOut: '1000', showEasing: 'swing', hideEasing: 'linear', showMethod: 'fadeIn', hideMethod: 'fadeOut', preventDuplicates: false};
    $('.toastr').each(function (k, i) {
        toastr[$(i).attr('type')]($(i).attr('message'));
    });

    // ativar modal caso existe um modal pronto pra ser ativado.
    if ($('.modal.active').length) {
        $('.modal.active').modal();
        $('.modal.active').modal('open');
    }
    
    $('.modal').modal();

    // Initialize collapse button
    $(".button-collapse").sideNav();
    // Initialize collapsible (uncomment the line below if you use the dropdown variation)
    $('.collapsible').collapsible();
});