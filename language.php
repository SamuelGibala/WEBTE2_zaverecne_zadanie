<?php
if (!isset($_SESSION['lang']))
    $_SESSION['lang'] = 'SK';
$_SESSION['lang'] = 'SK';
function get_localized($term) {
    global $localized_terms;
    if (isset($localized_terms[$term]))
        return $localized_terms[$term][$_SESSION['lang']];
    else
        return 'Missing value';
}

$localized_terms = [
    'login_header' => [
        'SK' => 'Prihlásenie',
        'EN' => 'Login'
    ],
    'login_pass' => [
        'SK' => 'Heslo',
        'EN' => 'Password'
    ],
    'login_btn' => [
        'SK' => 'Prihlásiť sa',
        'EN' => 'Login'
    ],
    'err_name_req' => [
        'SK' => 'Meno je povinné',
        'EN' => 'Name is required'
    ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
    // '' => [
    //     'SK' => '',
    //     'EN' => ''
    // ],
];
?>