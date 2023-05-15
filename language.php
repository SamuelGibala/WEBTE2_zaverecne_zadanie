<?php
if (!isset($_SESSION['lang']))
    $_SESSION['lang'] = 'SK';
$_SESSION['lang'] = 'EN';
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
    'form_pass' => [
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
    'err_surname_req' => [
        'SK' => 'Priezvisko je povinné',
        'EN' => 'Surname is required'
    ],
    'err_email_format' => [
        'SK' => 'Zlý formát emailu',
        'EN' => 'Wrong email format'
    ],
    'err_pass_length' => [
        'SK' => 'Heslo musí mať najmenej 6 znakov',
        'EN' => 'Password must be atleast 6 characters long'
    ],
    'err_role_req' => [
        'SK' => 'Výber role je povinný',
        'EN' => 'Role is required'
    ],
    'menu_header' => [
        'SK' => 'TESTY',
        'EN' => 'TESTS'
    ],
    'menu_create_tasks' => [
        'SK' => 'Generovanie úloh',
        'EN' => 'Create tasks'
    ],
    'menu_list_tasks' => [
        'SK' => 'Vygenerované úlohy',
        'EN' => 'List of tasks'
    ],
    'menu_list_students' => [
        'SK' => 'Zoznam študentov',
        'EN' => 'List of students'
    ],
    'menu_create_user' => [
        'SK' => 'Pridať používateľa',
        'EN' => 'Add user'
    ],
    'menu_assigned_tasks' => [
        'SK' => 'Priradené úlohy',
        'EN' => 'Assigned tasks'
    ],
    'menu_done_tasks' => [
        'SK' => 'Vypracované úlohy',
        'EN' => 'Finished tasks'
    ],
    'form_name' => [
        'SK' => 'Meno',
        'EN' => 'Name'
    ],
    'form_surname' => [
        'SK' => 'Priezvisko',
        'EN' => 'Surname'
    ],
    'form_role' => [
        'SK' => 'Roľa',
        'EN' => 'Role'
    ],
    'create_user_role_student' => [
        'SK' => 'Študent',
        'EN' => 'Student'
    ],
    'create_user_role_teacher' => [
        'SK' => 'Učiteľ',
        'EN' => 'Teacher'
    ],
    'create_user_submit_btn' => [
        'SK' => 'Pridaj',
        'EN' => 'Add'
    ],
    'check_correct_result' => [
        'SK' => 'Správne riešenie:',
        'EN' => 'Correct result:'
    ],
    'check_input' => [
        'SK' => 'Tvoje riešenie:',
        'EN' => 'Your input:'
    ],
    'check_points' => [
        'SK' => 'Získané body:',
        'EN' => 'Points:'
    ],
    'done_tasks_none_found' => [
        'SK' => 'Žiadne vypracované testy',
        'EN' => 'No finished tasks'
    ],
    'done_tasks_earned_points' => [
        'SK' => '',
        'EN' => ''
    ],
    'done_tasks_detail' => [
        'SK' => 'Nahliadnuť',
        'EN' => 'Show detail'
    ],
    'list_students_assigned_tasks_count' => [
        'SK' => 'Počet vygenerovaných úloh',
        'EN' => 'Number of assigned tasks'
    ],
    'list_students_finished_tasks_count' => [
        'SK' => 'Počet odovzdaných úloh',
        'EN' => 'Number of finished tasks'
    ],
    'list_students_points_count' => [
        'SK' => 'Počet bodov',
        'EN' => 'Number of points'
    ],
    'student_detail' => [
        'SK' => 'Detail Študenta',
        'EN' => 'Student detail'
    ],
    'student_detail_points' => [
        'SK' => 'bodov',
        'EN' => 'points'
    ],
    'student_detail_task_list' => [
        'SK' => 'Zoznam úloh študenta',
        'EN' => 'Task list of student'
    ],
    'create_tasks' => [
        'SK' => 'Generovanie testu',
        'EN' => 'Create test'
    ],
    'create_tasks_files' => [
        'SK' => 'Označ súbor(y), z ktorých chceš generovať test',
        'EN' => 'Select files that will be used to generate test'
    ],
    'create_tasks_submit_btn' => [
        'SK' => 'Generuj',
        'EN' => 'Create'
    ],
    'create_tasks_file_req' => [
        'SK' => 'Zaškrtni aspoň jedno políčko!',
        'EN' => 'Select atleast one checkbox!'
    ],
    'available_tests' => [
        'SK' => 'Dostupné testy',
        'EN' => 'Available tests'
    ],
    'available_tests_no_found' => [
        'SK' => 'Žiadne testy nie sú dostupné',
        'EN' => 'No available tests found'
    ],
    'ready_tests' => [
        'SK' => 'Testy na vypracovanie',
        'EN' => 'Tests ready to be started'
    ],
    'ready_tests_submit_btn' => [
        'SK' => 'Vypracovať',
        'EN' => 'Start test'
    ],
    'create_tasks_teacher' => [
        'SK' => 'Vygenerovanie úloh pre študentov',
        'EN' => 'Create tasks for students'
    ],
    'create_tasks_teacher_task_name' => [
        'SK' => 'Názov úlohy',
        'EN' => 'Task name'
    ],
    'create_tasks_teacher_start_date' => [
        'SK' => 'Dátum odkedy',
        'EN' => 'Start date'
    ],
    'create_tasks_teacher_end_date' => [
        'SK' => 'Dátum dokedy',
        'EN' => 'End date'
    ],
    'create_tasks_teacher_points' => [
        'SK' => 'Body',
        'EN' => 'Points'
    ],
    'create_tasks_teacher_submit_btn' => [
        'SK' => 'Vytvoriť',
        'EN' => 'Create'
    ],
    'login_wrong_role' => [
        'SK' => 'Zlá rola používateľa',
        'EN' => 'Wrong user role'
    ],
    'login_wrong_credentials' => [
        'SK' => 'Nesprávny email alebo heslo',
        'EN' => 'Invalid email or password'
    ],
    'login_user_not_found' => [
        'SK' => 'Používateľ nenájdený',
        'EN' => 'User not found'
    ],
    'solve_submit_btn' => [
        'SK' => 'Odoslať',
        'EN' => 'Submit'
    ],
    'err_solve_empty' => [
        'SK' => 'Vyplňte riešenie',
        'EN' => 'Fill out input'
    ],
];
?>