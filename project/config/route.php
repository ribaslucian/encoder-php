<?php

/**
 * @config Route
 */

route_add('/', 'visitor\Users sign_in');
route_add('/visitor', 'visitor\Users sign_in');
route_add('/admin', 'admin\Pages index');