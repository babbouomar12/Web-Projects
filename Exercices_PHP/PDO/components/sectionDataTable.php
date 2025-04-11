<div class="table-responsive">

    <div class="row justify-content-center mt-4">
        <div class="col">
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Designation</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sections as $sec): ?>
                        <tr>
                            <td><?= htmlspecialchars($sec->id) ?></td>
                            <td><?= htmlspecialchars($sec->designation) ?></td>
                            <td><?= htmlspecialchars($sec->description) ?></td>
                            <td>
                                <?php if(isset($AdminAuth)): ?>
                                    <a href="?action=view&id=<?= urlencode($sec->id) ?>">
                                        <img src="../assets/info-circle.svg" alt="info" style="width:20px" />
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#deleteModal<?= $sec->id ?>">
                                        <img src="../assets/trash.svg" alt="delete" style="width:20px" />
                                    </a>
                                    <a href="?action=edit&id=<?= urlencode($sec->id) ?>">
                                        <img src="../assets/pencil-square.svg" alt="edit" style="width:20px" />
                                    </a>
                                    <?php
                                        echo ModalComponent(
                                            '
                                            <p>Are you sure you want to delete <strong>' . htmlspecialchars($sec->designation) . '</strong>?</p>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="?action=delete&id=' . urlencode($sec->id) . '" class="btn btn-danger">Delete</a>
                                            </div>
                                            ',
                                            'Delete Section',
                                            'deleteModal' . $sec->id,
                                            'deleteModalLabel' . $sec->id
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