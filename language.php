<?php
if (!isset($_SESSION['lang']))
    $_SESSION['lang'] = 'SK';

function switch_lang() {
    if (isset($_POST['SK'])) {
        $_SESSION['lang'] = 'SK';
        return true;
    }
    else if (isset($_POST['EN'])) {
        $_SESSION['lang'] = 'EN';
        return true;
    }
    else
        return false;
}

function get_localized($term) {
    global $localized_terms;
    if (isset($localized_terms[$term]))
        return $localized_terms[$term][$_SESSION['lang']];
    else
        return 'Missing value';
}

function get_lang_dropdown() {
    echo 
        '<form action="" method="post" id="lang_form"></form>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./flags/' . $_SESSION['lang'] . '.png" alt="">
            </a>
            <ul class="dropdown-menu">
                <li><button type="submit" form="lang_form" name="SK" class="btn dropdown-item d-flex justify-content-between">
                    <img src="./flags/SK.png" alt="slovak flag">
                    ' . get_localized('lang_slovak') . '
                </button></li>
                <li><button type="submit" form="lang_form" name="EN" class="btn dropdown-item d-flex justify-content-between">
                    <img src="./flags/EN.png" alt="english flag">
                    ' . get_localized('lang_english') . '
                </button></li>
            </ul>
        </li>';
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
        'EN' => 'Log in'
    ],
    'err_name_req' => [
        'SK' => 'Meno je povinné',
        'EN' => 'Name is required'
    ],
    'err_email_duplicit'=> [
        'SK' => 'Tento email sa už používa',
        'EN' => 'User with this email already exists'
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
        'SK' => 'Rola',
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
        'EN' => 'Score:'
    ],
    'done_tasks_none_found' => [
        'SK' => 'Žiadne vypracované testy',
        'EN' => 'No finished tasks'
    ],
    'done_tasks_detail' => [
        'SK' => 'Nahliadnuť',
        'EN' => 'Show detail'
    ],
    'list_students_assigned_tasks_count' => [
        'SK' => 'Počet <br /> vyg. <br /> úloh',
        'EN' => 'Number of<br />assigned<br />tasks'
    ],
    'list_students_finished_tasks_count' => [
        'SK' => 'Počet<br />odovz.<br />úloh',
        'EN' => 'Number of<br />finished<br />tasks'
    ],
    'list_students_points_count' => [
        'SK' => 'Počet<br />bodov',
        'EN' => 'Score'
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
        'EN' => 'Score'
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
    'download_csv' => [
        'SK' => 'Stiahni ako CSV',
        'EN' => 'Download as CSV'
    ],
    'download_pdf' => [
        'SK' => 'Stiahni ako PDF',
        'EN' => 'Download as PDF'
    ],
    'lang_slovak' => [
        'SK' => 'Slovenčina',
        'EN' => 'Slovak'
    ],
    'lang_english' => [
        'SK' => 'Angličtina',
        'EN' => 'English'
    ],
    'info_modal_title' => [
        'SK' => 'Návod na používanie aplikácie',
        'EN' => 'Instructions for using the app'
    ],
    'info_modal_body' => [
        'SK' => 
        'Študent<br>
        - Po prihlásení je možné v menu vľavo vybrať medzi priradenými úlohami na vypracovanie.<br>
        - Pri výbere priradených úloh sú zobrazené aktuálne dostupné úlohy.<br>
        - Z nich si študent môže v prvom kroku vygenerovať úlohu v prvej časti stránky s názvom "Dostupné testy"<br>
        - Pri generovaní študent môže označiť minimálne jeden súbor, z ktorého/ktorých bude úloha generovaná<br>
        - Po potvrdení študent presmerovaný naspäť na stránku priradených úloh, kde môže danú vygenerovanú úlohu vypracovať v druhej časti stránky s názvom "Testy na vypracovanie"<br>
        - Po kliknutí na tlačidlo "Vypracovať" je zobrazené zadanie úlohy a v časti "Tvoje riešenie" má študent možnosť zadať riešenie zadania pomocou matematického editora. Pri ňom sa po kliknutí na symbol klávesnice zobrazí virtuálna klávesnica so všetkými potrebnými matematickými operáciami a znakmi.<br>
        - Po stlačení tlačidla "Odoslať" je študent presmerovaný na stránku "Vypracované úlohy", kde má možnosť prehliadať už vypracované testy spolu so získaným ohodnotením.<br>
        - Po kliknutí na tlačidlo "Nahliadnuť" sa študentovi zobrazí náhľad vypracovanej úlohy spolu so zadaným a správnym riešením<br>
        - V hornej časti aplikácie sa nachádza sprava tlačidlo na odhlásenie, identifikátor prihláseného používateľa, rozbaľovacie menu na zmenu jazyka a informačné tlačidlo pre zobrazenie tohto dokumentu s možnosťou tlače do PDF<br>
        <br>
        Učiteľ<br>
        - Po prihlásení je užívateľ presmerovaný do aplikácie konkrétne do nástroja na generovanie úloh.<br>
        - Tu je možné po vyplnení formulára vytvoriť úlohu pre študentov s alebo bez dátumov začiatku platnosti, s bodovým ohodnotením a z vybraných dokumentov<br>
        - Po vygenerovaní je používateľ presmerovaný na zoznam vygenerovaných úloh<br>
        - Ďalej má používateľ možnosť prehliadať zoznam študentov. Po kliknutí na študenta je zobrazený detail jeho profilu spolu s vypracovanými úlohami<br>
        - Po kliknutí na tlačidlo "Nahliadnuť" má používateľ možnosť nahliadnuť do odovzdaného testu, kde okrem iného vidí zadaný výsledok študenta<br>
        - Tabuľku študentov je možné exportovať kliknutím na tlačidlo "Stiahni ako CSV" do csv formátu<br>
        - Učiteľ, ako správca aplikácie má možnosť pridať ďalšieho poúžívateľa, študednta alebo učiteľa<br>
        - V hornej časti aplikácie sa nachádza sprava tlačidlo na odhlásenie, identifikátor prihláseného používateľa, rozbaľovacie menu na zmenu jazyka a informačné tlačidlo pre zobrazenie tohto dokumentu s možnosťou tlače do PDF<br>
        - Pri pridaní nového testu je potrebné dodržať štruktúru podľa už existujúcich LaTex dokumentov, rovnako ako pri prípadnej grafickej podobe zadania nastaviť správne cesty k obrázku podľa príslušnej použitej architektúry!<br>',
        'EN' => 
        'Student<br>
        - After logging in, it is possible to select among the assigned tasks to work on in the menu on the left.<br>
        - When you select the assigned tasks, the currently available tasks are displayed.<br>
        - From these, the student can generate a task in the first step in the first part of the page called "Available tests"<br>
        - When generating, the student can indicate at least one file from which the assignment(s) will be generated<br>
        - After confirmation, the student is redirected back to the Assignments page, where he/she can work out the generated assignment in the second part of the page called "Tests to work out"<br>
        - After clicking on the "Elaborate" button, the assignment is displayed and in the "Your Solution" section the student has the option to enter a solution to the assignment using the math editor. When clicking on the keyboard symbol, a virtual keyboard with all the necessary mathematical operations and characters is displayed.<br>
        - After pressing the "Submit" button, the student is redirected to the "Completed Assignments" page, where he/she has the possibility to browse through the already completed tests together with the grades obtained.<br>
        - After clicking on the "Preview" button, the student will be presented with a preview of the completed assignment along with the given and correct solution.<br>
        - At the top of the application there is a logout button on the right, a logged-in user identifier, a drop-down menu to change the language and an information button to view this document with the option to print it to PDF<br>
        <br>
        Teacher<br>
        - After logging in, the user is redirected to the application specifically to the task generation tool.<br>
        - Here, after filling in the form, it is possible to create an assignment for students with or without start dates, with a score and from selected documents<br>
        - Once generated, the user is redirected to the list of generated jobs<br>
        - Furthermore, the user has the possibility to browse the list of students. After clicking on a student, a detail of his/her profile is displayed along with the completed assignments<br>
        - After clicking on the "Show detail" button, the user has the possibility to look into the submitted test, where, among other things, they can see the entered result of the student<br>
        - The student spreadsheet can be exported to csv format by clicking the "Download as CSV" button<br>
        - The teacher, as the administrator of the application, has the possibility to add another user, student or teacher<br>
        - At the top of the application there is a logout button on the right, a logged-in user identifier, a drop-down menu to change the language and an information button to view this document with the option to print it to PDF<br>
        - When adding a new test, it is necessary to follow the structure according to existing LaTex documents, as well as to set the correct image paths according to the respective architecture used for any graphical form of the assignment!<br>'
    ],
];
?>