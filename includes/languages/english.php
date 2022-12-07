<?php

function lang($phrase)
{
    static $lang     = array(
        'HOME_PAGE'   => 'Home',
        'CATEGORY'    => 'Categories',
        'ITEMS'       => 'Items',
        'MEMBERS'     => 'Members',
        'STATICTICS'  => 'Statictics',
        'LOGS'        => 'Logs',
        'DROP_MENUE'  => 'Options',
        'PROFILE'     => 'Edit Profile',
        'SETTING'     => 'Setting',
        'COMMENTS'     => 'Comments',
        'LOG_OUT'     => 'Log out'

    );

    return  $lang[$phrase];
}
