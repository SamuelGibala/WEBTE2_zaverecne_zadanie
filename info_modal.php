<?php
function add_info_modal_btn() {
    echo 
    '<button type="button" class="btn btn-secondary btn-info-modal me-3" data-bs-toggle="modal" data-bs-target="#infoModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
        </svg>
    </button>';
}

function add_info_modal() {
    echo 
    '<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="modal-header" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="infoModalTitle">
                        Návod na používanie aplikácie
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="infoModalBody">
                    <h2 class="modal-title fs-5">Študent</h2>
                    <ul>
                        <li>Po prihlásení je možné v menu vľavo vybrať medzi priradenými úlohami na vypracovanie.</li>
                        <li>Pri výbere priradených úloh sú zobrazené aktuálne dostupné úlohy.</li>
                        <li>Z nich si študent môže v prvom kroku vygenerovať úlohu v prvej časti stránky s názvom "Dostupné testy".</li>
                        <li>Pri generovaní študent môže označiť minimálne jeden súbor, z ktorého/ktorých bude úloha generovaná</li>
                        <li>Po potvrdení študent presmerovaný naspäť na stránku priradených úloh, kde môže danú vygenerovanú úlohu vypracovať v druhej časti stránky s názvom "Testy na vypracovanie"</li>
                        <li>Po kliknutí na tlačidlo "Vypracovať" je zobrazené zadanie úlohy a v časti "Tvoje riešenie" má študent možnosť zadať riešenie zadania pomocou matematického editora. Pri ňom sa po kliknutí na symbol klávesnice zobrazí virtuálna klávesnica so všetkými potrebnými matematickými operáciami a znakmi.</li>
                        <li>Po stlačení tlačidla "Odoslať" je študent presmerovaný na stránku "Vypracované úlohy", kde má možnosť prehliadať už vypracované testy spolu so získaným ohodnotením.</li>
                        <li>Po kliknutí na tlačidlo "Nahliadnuť" sa študentovi zobrazí náhľad vypracovanej úlohy spolu so zadaným a správnym riešením</li>
                        <li>V hornej časti aplikácie sa nachádza sprava tlačidlo na odhlásenie, identifikátor prihláseného používateľa, rozbaľovacie menu na zmenu jazyka a informačné tlačidlo pre zobrazenie tohto dokumentu s možnosťou tlače do PDF</li>
                    </ul>

                    <h2 class="modal-title fs-5">Učiteľ</h2>
                    <ul>
                        <li>Po prihlásení je užívateľ presmerovaný do aplikácie konkrétne do nástroja na generovanie úloh.</li>
                        <li>Tu je možné po vyplnení formulára vytvoriť úlohu pre študentov s alebo bez dátumov začiatku platnosti, s bodovým ohodnotením a z vybraných dokumentov</li>
                        <li>Po vygenerovaní je používateľ presmerovaný na zoznam vygenerovaných úloh</li>
                        <li>Ďalej má používateľ možnosť prehliadať zoznam študentov. Po kliknutí na študenta je zobrazený detail jeho profilu spolu s vypracovanými úlohami</li>
                        <li>Po kliknutí na tlačidlo "Nahliadnuť" má používateľ možnosť nahliadnuť do odovzdaného testu, kde okrem iného vidí zadaný výsledok študenta</li>
                        <li>Tabuľku študentov je možné exportovať kliknutím na tlačidlo "Stiahni ako CSV" do csv formátu</li>
                        <li>Učiteľ, ako správca aplikácie má možnosť pridať ďalšieho poúžívateľa, študednta alebo učiteľa</li>
                        <li>V hornej časti aplikácie sa nachádza sprava tlačidlo na odhlásenie, identifikátor prihláseného používateľa, rozbaľovacie menu na zmenu jazyka a informačné tlačidlo pre zobrazenie tohto dokumentu s možnosťou tlače do PDF</li>
                        <li style="color: red">Pri pridaní nového testu je potrebné dodržať štruktúru podľa už existujúcich LaTex dokumentov, rovnako ako pri prípadnej grafickej podobe zadania nastaviť správne cesty k obrázku podľa príslušnej použitej architektúry!</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" id="export_pdf_btn" class="btn btn-danger">' . get_localized('download_pdf') . '</button>
                </div>
            </div>
        </div>
    </div>';
}
?>
<!-- Študent<br>
Po prihlásení je možné v menu vľavo vybrať medzi priradenými úlohami na vypracovanie.<br>
Pri výbere priradených úloh sú zobrazené aktuálne dostupné úlohy.<br>
Z nich si študent môže v prvom kroku vygenerovať úlohu v prvej časti stránky s názvom "Dostupné testy"<br>
Pri generovaní študent môže označiť minimálne jeden súbor, z ktorého/ktorých bude úloha generovaná<br>
Po potvrdení študent presmerovaný naspäť na stránku priradených úloh, kde môže danú vygenerovanú úlohu vypracovať v druhej časti stránky s názvom "Testy na vypracovanie"<br>
Po kliknutí na tlačidlo "Vypracovať" je zobrazené zadanie úlohy a v časti "Tvoje riešenie" má študent možnosť zadať riešenie zadania pomocou matematického editora. Pri ňom sa po kliknutí na symbol klávesnice zobrazí virtuálna klávesnica so všetkými potrebnými matematickými operáciami a znakmi.<br>
Po stlačení tlačidla "Odoslať" je študent presmerovaný na stránku "Vypracované úlohy", kde má možnosť prehliadať už vypracované testy spolu so získaným ohodnotením.<br>
Po kliknutí na tlačidlo "Nahliadnuť" sa študentovi zobrazí náhľad vypracovanej úlohy spolu so zadaným a správnym riešením<br>
V hornej časti aplikácie sa nachádza sprava tlačidlo na odhlásenie, identifikátor prihláseného používateľa, rozbaľovacie menu na zmenu jazyka a informačné tlačidlo pre zobrazenie tohto dokumentu s možnosťou tlače do PDF<br>
<br>
Učiteľ<br>
Po prihlásení je užívateľ presmerovaný do aplikácie konkrétne do nástroja na generovanie úloh.<br>
Tu je možné po vyplnení formulára vytvoriť úlohu pre študentov s alebo bez dátumov začiatku platnosti, s bodovým ohodnotením a z vybraných dokumentov<br>
Po vygenerovaní je používateľ presmerovaný na zoznam vygenerovaných úloh<br>
Ďalej má používateľ možnosť prehliadať zoznam študentov. Po kliknutí na študenta je zobrazený detail jeho profilu spolu s vypracovanými úlohami<br>
Po kliknutí na tlačidlo "Nahliadnuť" má používateľ možnosť nahliadnuť do odovzdaného testu, kde okrem iného vidí zadaný výsledok študenta<br>
Tabuľku študentov je možné exportovať kliknutím na tlačidlo "Stiahni ako CSV" do csv formátu<br>
Učiteľ, ako správca aplikácie má možnosť pridať ďalšieho poúžívateľa, študednta alebo učiteľa<br>
V hornej časti aplikácie sa nachádza sprava tlačidlo na odhlásenie, identifikátor prihláseného používateľa, rozbaľovacie menu na zmenu jazyka a informačné tlačidlo pre zobrazenie tohto dokumentu s možnosťou tlače do PDF<br>
Pri pridaní nového testu je potrebné dodržať štruktúru podľa už existujúcich LaTex dokumentov, rovnako ako pri prípadnej grafickej podobe zadania nastaviť správne cesty k obrázku podľa príslušnej použitej architektúry!<br> -->