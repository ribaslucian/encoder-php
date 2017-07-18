<?php

/**
 * @config encoder\Model
 */

# defindo conexão padrão para os modelos da aplicação
encoder\Model::connection('default');

# definindo nome campo que ficará armazenado as mensagens de erros de um modelo
encoder\Model::messageErrorsField('__messages');

# definindo nome campo que ficará armazenado o objeto 
# que irá gerar HTMLs referentes a entidade de acesso
encoder\Model::htmlField('html');