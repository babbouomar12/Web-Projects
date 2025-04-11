<div class="table-responsive">

    <div class="row justify-content-center mt-4">
        <div class="col">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Username</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Birthday</th>
                        <th scope='col'>Section</th>
                        <th scope='col'>Role</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Students as $Stud): ?>
                        <tr>
                            <td><?= htmlspecialchars($Stud["id"]) ?></td>
                            <td><?= htmlspecialchars($Stud["username"]) ?></td>
                            <td><?= htmlspecialchars($Stud["name"]) ?></td>
                            <td><?= htmlspecialchars($Stud["email"]) ?></td>
                            <td><?= htmlspecialchars($Stud["birthdate"]) ?></td>
                            <td><?= htmlspecialchars($Stud["designation"]) ?></td>
                            <td><?= htmlspecialchars($Stud["role"]) ?></td>
                            <td>
                                <?php if(isset($AdminAuth)): ?>
                                    <a href="?action=view&id=<?= urlencode($Stud['id']) ?>">
                                        <img src="../assets/info-circle.svg" alt="info" style="width:20px" />
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#deleteModal<?= $Stud['id'] ?>">
                                        <img src="../assets/trash.svg" alt="delete" style="width:20px" />
                                    </a>
                                    <a href="?action=edit&id=<?= urlencode($Stud['id']) ?>">
                                        <img src="../assets/pencil-square.svg" alt="edit" style="width:20px" />
                                    </a>
                                    <?php
                                        echo ModalComponent(
                                            '
                                            <p>Are you sure you want to delete <strong>' . htmlspecialchars($Stud['name']) . '</strong>?</p>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <a href="?action=delete&id=' . urlencode($Stud['id']) . '" class="btn btn-danger">Delete</a>
                                            </div>
                                            ',
                                            'Delete Student',
                                            'deleteModal' . $Stud['id'],
                                            'deleteModalLabel' . $Stud['id']
                                        );
                                    ?>
                                <?php else: ?>
                                    <span>No actions available</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>