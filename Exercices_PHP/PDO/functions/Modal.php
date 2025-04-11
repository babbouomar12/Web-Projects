<?php
function ModalComponent(
    $body,
    $title,
    $id = 'exampleModal',
    $aria = 'exampleModalLabel'
) {
    $html = '
    <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $aria . '" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="' . $aria . '">' . $title . '</h5>
                    <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ' . $body . '
                </div>
            </div>
        </div>
    </div>';
    return $html;
}
?>
