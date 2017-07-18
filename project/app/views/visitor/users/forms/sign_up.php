<?php
echo form_open($entity);

echo field_icon('&#xE7FD;', 'name', 'Nome:', array(
    'required' => true,
    'maxlength' => 92
));
?>

<?php
echo field_icon('&#xE0BE;', 'email', 'E-mail: *', array(
    'type' => 'email',
    'required' => true,
    'maxlength' => 64
));
?>

<div class="row">
    <div class="col s6">
        <?php
        echo field_icon('&#xE897;', 'password', 'Senha: *', array(
            'type' => 'password',
            'required' => true,
            'maxlength' => 16
        ));
        ?>
    </div>

    <div class="col s6">
        <?php
        echo field('password_confirm', 'Confirme sua senha: *', array(
            'type' => 'password',
            'required' => true,
            'maxlength' => 16
        ));
        ?>
    </div>
</div>

<?php
echo element('form/footer', array('cancel_url' => url('/')));
echo form_close();
?>