$(document).ready(function() {
  $('.__search td').click(function () {
    $('td', $(this).parents('tr')).hide();                          // escondendo todas as colunas
    $(this).attr('colspan', 100);                                   // esticar coluna para a linha toda

    $('.__search_text', $(this)).hide();                            // escondendo texto
    $('.__search_inputs', $(this)).show();                          // exibindo inputs

    $('td', $(this).parents('tr')).first().show();                  // exibindo a Primeira Coluna
    $(this).show();                                                 // exibindo Coluna do Click

    $('input', $('.__search_inputs', $(this))).first().focus();     // selecionando Mouse no Input
  });

  $(document).click(function (event) {
    if (!$(event.target).closest('.__search').length) {
      $('.__search_inputs').hide();
      $('.__search_text').show();
      $('.__search td').attr('colspan', 1).show();
    }
  });
});
