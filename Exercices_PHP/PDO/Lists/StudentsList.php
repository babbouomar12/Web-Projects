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

$Students = Student::fetchAll();
$userArray = $sess->getValueByKey("user");
$user = User::fromArray($userArray);
?>

<div class="container mt-3">
    <?php if(isset($AdminAuth)): ?>
        <div class="row justify-content-center">
            <div class="col-auto d-flex align-items-center gap-2">
                <p class="mb-0">Add a new Student </p>
                <button type="button" class="btn btn-warning d-flex align-items-center justify-content-center" 
                        style="width: 40px; height: 40px; margin-left : 50px"
                        data-toggle="modal" data-target="#addStudentModal">
                    <img src="../assets/person-plus-fill.svg" alt="add" style="width: 20px;" />
                </button>
            </div>
        </div>

        <?php
        $sec = new Sections();
        $sectionRepo = new Repository($sec);
        $sections = $sectionRepo->findAll();

        $body = '
        <form method="POST" action="'.$_SERVER['PHP_SELF'].'">
            <input type="hidden" name="action" value="submit_add">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Birthday</label>
                <input type="date" name="birthdate" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Img Url</label>
                <input type="text" name="imgUrl" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Section :</label>
                <select class="form-control" name="section">';
                    foreach ($sections as $sect) {
                        $designation = htmlspecialchars($sect->designation);
                        $body .= "<option value=\"{$sect->id}\">{$designation}</option>";
                    }
        $body .= '
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Student</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>';
        echo ModalComponent($body, 'Add New Student', 'addStudentModal', 'addStudentModalLabel');
        ?>
    <?php endif; ?>

    <?php
    include '../components/dataTable.php';
    ?>
</div>

<?php
if(isset($AdminAuth) && isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if ($action == 'view') {
        $student = Student::findById($id);
        $body = '
        <div class="d-flex flex-row justify-content-around">
            <div class="d-flex">
                <img src="'.$student['imgUrl'].'" alt="'.$student['name'].'" class="img-thumbnail">
            </div>
            <div class="d-flex">
                <div class="d-flex flex-column justify-content-around">
                    <h3>Student Information</h3>
                    <p><strong>ID:</strong> ' . htmlspecialchars($student['id']) . '</p>
                    <p><strong>Username:</strong> ' . htmlspecialchars($student['username']) . '</p>
                    <p><strong>Name:</strong> ' . htmlspecialchars($student['name']) . '</p>
                    <p><strong>Email:</strong> ' . htmlspecialchars($student['email']) . '</p>
                    <p><strong>Birthdate:</strong> ' . htmlspecialchars($student['birthdate']) . '</p>
                    <p><strong>Section:</strong> ' . htmlspecialchars($student['designation']) . '</p>
                    <p><strong>Role:</strong> ' . htmlspecialchars($student['role']) . '</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>';
        echo ModalComponent($body, 'Profile', 'exampleModal', 'exampleModalLabel');
        echo "<script>window.onload = function () { $('#exampleModal').modal('show'); }</script>";
    } elseif ($action == 'delete') {
        Student::removeFromDB($id); 
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    } elseif ($action == 'edit') {
        $student = Student::findById($id);
        $sec = new Sections();
        $sectionRepo = new Repository($sec);
        $sections = $sectionRepo->findAll();
        $userSec = $sectionRepo->findById($student["sec"]);

        $body = '
        <form method="POST" action="'.$_SERVER['PHP_SELF'].'">
            <input type="hidden" name="action" value="submit_edit">
            <input type="hidden" name="id" value="'.htmlspecialchars($student['id']).'">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="'.htmlspecialchars($student['name']).'" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="'.htmlspecialchars($student['email']).'" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="'.htmlspecialchars($student['username']).'" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Birthday</label>
                <input type="date" name="birthdate" value="'.htmlspecialchars($student['birthdate']).'" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Img Url</label>
                <input type="text" name="imgUrl" value="'.htmlspecialchars($student['imgUrl']).'" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Section :</label>
                <select class="form-control" name="section">';
                foreach ($sections as $sect) {
                    $selected = ($sect->id == $userSec->id) ? 'selected' : '';
                    $designation = htmlspecialchars($sect->designation);
                    $body .= "<option value=\"{$sect->id}\" {$selected}>{$designation}</option>";
                }
        $body .= '
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>';
        echo ModalComponent($body, 'Update Student', 'exampleModal', 'exampleModalLabel');
        echo "<script>window.onload = function () { $('#exampleModal').modal('show'); }</script>";
    }
}

if (isset($SessionID) && isset($AdminAuth) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? htmlspecialchars(trim($_POST['id'])) : null;
    $username = htmlspecialchars(trim($_POST['username']));
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $birthdate = htmlspecialchars(trim($_POST['birthdate']));
    $section = htmlspecialchars(trim($_POST['section']));
    $imgUrl = htmlspecialchars(trim($_POST['imgUrl']));

    $action = $_POST['action'] ?? '';
    if ($action === "submit_add") {
        $password = htmlspecialchars(trim($_POST['password']));
        $newStudent = new Student($id, $name, $birthdate, $section, $imgUrl, $username, $email, $password);
        Student::insertIntoDB($newStudent);
    } elseif ($action === "submit_edit") {
        $stud = new Student($id, $name, $birthdate, $section, $imgUrl, $username, $email);
        $stud->updateStudent($stud);
    }
    echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
}
?>

<?php include '../components/footer.php'; ?>
