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
                        Návod na používanie webovej stránky
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="infoModalBody">
                    1.riadok sdnadad sdnasoidhaso sadhasodaso sdhasod sadhaod<br>
                    2.riadok gfdg sdad<br>
                    3.riadok gdfg sdasd dasd sdasd hhhhhhhhh ssdsd hhhhhhhhhhhhhhsd hhhhhhhhhhhhhsda hhhhhhhhhhhhhasd <br>
                    4.riadok dasd sdasd asdasda sdad asdaddfg<br>
                </div>
                <div class="modal-footer">
                    <button type="button" id="export_pdf_btn" class="btn btn-danger">' . get_localized('download_pdf') . '</button>
                </div>
            </div>
        </div>
    </div>';
}
?>