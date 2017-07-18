<?php

class User extends auth\Model {
    
    # static $table = 'users';
    # static $connection = 'default';

    /**
     * Validações de objetos auth\Model em determinadas ações do sistema.
     * 
     * @var array
     */
    static $validate = array(
        
        //sign in
        'notEmpty {email, password} {sign_in}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {email} {sign_in}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 92
        ),
        'strmin {email} {sign_in}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'email {email} {sign_in}' => array(
            'Este email não é válido.'
        ),
        
        //not_receive_confirmation, forgot_password, help_unlock_account
        'notEmpty {email} {not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {email} {not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 92
        ),
        'strmin {email} {not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'exists {email} {not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Não há registro com este e-mail.'
        ),
        'email {email} {not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Este email não é válido.'
        ),
        
        //sign_up, password_renew, password_expired
        'notEmpty {password} {sign_up, password_renew, password_expired}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {password} {sign_up, password_renew, password_expired}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 12
        ),
        'strmin {password} {sign_up, password_renew, password_expired}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'confirm {password_confirm} {sign_up, password_renew, password_expired}' => array(
            'As senhas não conferem.',
            'compare_to' => 'password'
        ),
        
        //sign_up
        'notEmpty {name, email, password} {sign_up}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {password} {sign_up}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 12
        ),
        'strmin {name, email, password} {sign_up}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'strmax {name, email} {sign_up}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 92
        ),
        'email {email} {sign_up}' => array(
            'Este email não é válido.'
        ),
        'unique {email} {sign_up}' => array(
            'Já existe um registro com este valor.'
        ),
        'confirm {password_confirm} {sign_up}' => array(
            'As senhas não conferem.',
            'compare_to' => 'password'
        )
    );
    
}
