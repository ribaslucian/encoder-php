<?php

return;

# destruímos a tabela de usuários caso ela exista
query('DROP TABLE users;');

# criamos a tabela Users caso não exista
if (!in_array('users', tables()))
    query(file_get(SQL . 'users.sql'));

# inserimos usuários básicos
User::insert(array(
    'name' => 'Usuário Encoder',
    'email' => 'user@encoder.com', 
    'password' => auth_encrypt(12345)
));
