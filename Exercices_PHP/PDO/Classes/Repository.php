<?php

require_once __DIR__.'/UserClass.php';

class Repository{

    private $entityClass;
    private $table;
    private $pdo;

    public function __construct(object $entity) {
        $this->entityClass = get_class($entity);
        $this->table = $this->getSimpleClassName($entity);
        $this->pdo = ConnectionDB::getInstance();
    }

    private function getSimpleClassName(object $entity): string {
        $reflection = new ReflectionClass($entity);
        return strtolower($reflection->getShortName());
    }

    public function findAll() : array{
        $stmt = $this->pdo->query(
            "SELECT * FROM {$this->table}"
        );
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entityClass);
    }

    public function findById(int $id): ?object {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entityClass);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}

/*
?>
<table>
    <thead>
        <tr>
            <th>ID</th><th>Email</th><th>Role</th>
        </tr>
    </thead>
    <tbody>
        $userRepository = new Repository(new User());

        $allUsers = $userRepository->findAll();
        $user = $userRepository->findById(1);
        $isDeleted = $userRepository->delete(2);
        print_r($allUsers)

        <?php foreach ($allUsers as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user->id) ?></td>
                <td><?= htmlspecialchars($user->email) ?></td>
                <td><?= htmlspecialchars($user->role) ?></td>
            </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>
*/