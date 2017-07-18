<?php

echo form_open($entity);

echo field_icon('&#xE897;', 'password', 'Senha: *', array(
    'required' => true,
    'type' => 'password',
    'maxlength' => 24
));

echo field_icon('', 'password_confirm', 'Confirme sua senha: *', array(
    'required' => true,
    'type' => 'password',
    'maxlength' => 24
));

echo '<br/>' . element('form/footer', array('cancel_url' => url('/')));

echo form_close();
