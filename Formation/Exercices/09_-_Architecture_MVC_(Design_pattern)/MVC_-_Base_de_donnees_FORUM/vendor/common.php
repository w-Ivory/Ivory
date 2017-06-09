<?php
function initialize_i18n($locale) {
    putenv('LANG='.$locale);
    setlocale(LC_ALL,"");
    setlocale(LC_MESSAGES,$locale);
    setlocale(LC_CTYPE,$locale);
    $domains = glob($locales_root.'/'.$locale.'/LC_MESSAGES/messages-*.mo');
    $current = basename($domains[0],'.mo');
    $timestamp = preg_replace('{messages-}i','',$current);
    bindtextdomain($current,$locales_root);
    textdomain($current);
}