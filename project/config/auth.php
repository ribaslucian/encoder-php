<?php

/**
 * @config Auth
 */

Auth::model('User');

# default or offline user hierarchy
Auth::defaultHierarchy('visitor');

# session key the will be save user dadas
# Auth::useSecurityKey();
Auth::sessionKey(PROJECT_FOLDER);

# table fields save on session
Auth::sessionFields('id, merchant_id, name, email, hierarchy, active, benefits_id');

# max user login attempts before block the user account
Auth::maxLoginAttempts(10);

# set username table field
Auth::usernameField('email');

# set password table field
Auth::passwordField('password');

# set active table field
Auth::activeField('active');

# password encrypt method
Auth::encryptMethod(function($password) {
    return md5($password);
});
