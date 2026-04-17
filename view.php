<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM registrations ORDER BY created_at DESC");
    $registrations = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registrations</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .container { max-width: 1000px; }
        .table-container { 
            overflow-x: auto; 
            background: white; 
            border-radius: 12px; 
            padding: 20px;
            box-shadow: var(--shadow);
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.75rem; }
        .chip { 
            padding: 4px 8px; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            font-weight: 500; 
            background: #eee;
        }
        .nav-link { 
            display: inline-block; 
            margin-bottom: 20px; 
            color: var(--primary); 
            text-decoration: none; 
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.html" class="nav-link">← Back to Registration</a>
        <div class="form-card">
            <h1>Submitted Registrations</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Dept</th>
                            <th>Gender</th>
                            <th>Hobbies</th>
                            <th>Notes</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrations as $row): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><span class="chip"><?php echo htmlspecialchars($row['gender']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['hobbies']); ?></td>
                            <td><?php echo htmlspecialchars($row['others']); ?></td>
                            <td><?php echo date('M d, H:i', strtotime($row['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($registrations)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">No registrations yet.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
