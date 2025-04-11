<?php
include '../components/header.php';
require_once "../Classes/ConnectionDB.php";
require_once "../Classes/SessionManagerClass.php";
require_once "../Classes/UserClass.php";
require_once "../Classes/StudentClass.php";
require_once "../Classes/SectionClass.php";
require_once "../Classes/Repository.php";
require_once "../functions/Modal.php";

$sess = new SessionManager();
$SessionID = $sess->getValueByKey("SuccessfulLogin");
$AdminAuth = $sess->getValueByKey("AdminAuth");

if(!isset($SessionID)){
    header("Location: index.php");
    exit();
}

$sec = new Sections();
$sectionsRep = new Repository($sec);
$sections = $sectionsRep->findAll();
?>

<div class="container mt-3">
    <?php if(isset($AdminAuth)): ?>
        <div class="row justify-content-center">
            <div class="col-auto d-flex align-items-center gap-2">
                <p class="mb-0">Add a new Section </p>
                <button type="button" class="btn btn-warning d-flex align-items-center justify-content-center" 
                        style="width: 40px; height: 40px; margin-left : 50px"
                        data-toggle="modal" data-target="#addSections">
                    <img src="../assets/person-plus-fill.svg" alt="add" style="width: 20px;" />
                </button>
            </div>
        </div>

        <?php

        $body = '
        <form method="POST" action="'.$_SERVER['PHP_SELF'].'">
            <input type="hidden" name="action" value="submit_add">
            <div class="form-group">
                <label>Designation</label>
                <input type="text" name="designation" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" class="form-control" required>
            </div>
            ';
                    
        $body .= '
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Section</button>
            </div>
        </form>';
        echo ModalComponent($body, 'Add New Section', 'addSections', 'addSectionsLabel');
        ?>
    <?php endif; ?>

    <?php
    include '../components/sectionDataTable.php';
    ?>
</div>

<?php
if(isset($AdminAuth) && isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if ($action == 'view') {
        $sec = $sectionsRep->findById($id);
        $body = '
        <div class="d-flex flex-row justify-content-around">
            <div class="d-flex">
                <div class="d-flex flex-column justify-content-around">
                    <h3>Section Information</h3>
                    <p><strong>ID:</strong> ' . htmlspecialchars($sec->id) . '</p>
                    <p><strong>Designation:</strong> ' . htmlspecialchars($sec->designation) . '</p>
                    <p><strong>Description:</strong> ' . htmlspecialchars($sec->description) . '</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>';
        echo ModalComponent($body, 'Section', 'exampleModal', 'exampleModalLabel');
        echo "<script>window.onload = function () { $('#exampleModal').modal('show'); }</script>";
    } elseif ($action == 'delete') {
        Sections::removeFromDB($id); 
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    } elseif ($action == 'edit') {
        $sec = $sectionsRep->findById($id);

        $body = '
        <form method="POST" action="'.$_SERVER['PHP_SELF'].'">
            <input type="hidden" name="action" value="submit_edit">
            <input type="hidden" name="id" value="'.htmlspecialchars($sec->id).'">
            <div class="form-group">
                <label>Designation</label>
                <input type="text" name="designation" value="'.htmlspecialchars($sec->designation).'" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" value="'.htmlspecialchars($sec->description).'" class="form-control" required>
            </div>
            ';
        $body .= '
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>';
        echo ModalComponent($body, 'Update Section', 'exampleModal', 'exampleModalLabel');
        echo "<script>window.onload = function () { $('#exampleModal').modal('show'); }</script>";
    }
}

if (isset($SessionID) && isset($AdminAuth) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? htmlspecialchars(trim($_POST['id'])) : null;
    $designation = htmlspecialchars(trim($_POST['designation']));
    $description = htmlspecialchars(trim($_POST['description']));

    $action = $_POST['action'] ?? '';
    $newSection = new Sections($designation, $description);
    $newSection->id = $id;
    if ($action === "submit_add") {
        Sections::insertIntoDB($newSection);
    } elseif ($action === "submit_edit") {
        $newSection->updateSection($designation,$description);
    }
    echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
}
?>

<?php include '../components/footer.php'; ?>
