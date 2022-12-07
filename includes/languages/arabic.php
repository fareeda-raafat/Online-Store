<?php
function lang($phrase)
{
        static $lang     = array
  (

        'HOME_PAGE'  => 'الصفحة الرئيسية',
        'CATEGORY'   => 'التصنيفات',
        'ITEMS'      => 'العناصر',
        'MEMBERS'    => 'الأعضاء',
        'STATICTICS' => 'الإحصائيات',
        'LOGS'       => 'الدخول',
        'DROP_MENUE' => 'اختيارات',
        'PROFILE'    => 'تعديل الحساب الشخصي',
        'SETTING'    => 'الإعدادات',
        'COMMENTS'   =>  'التعليقات',
        'LOG_OUT'    => 'الخروج'
    );

    return  $lang[$phrase];
}
