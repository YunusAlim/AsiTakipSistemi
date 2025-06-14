<?php
require 'auth.php';
require 'db.php';

// Tüm aşılar
$stmt = $pdo->prepare("SELECT * FROM vaccinations WHERE user_id = ? ORDER BY vaccination_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$vaccines = $stmt->fetchAll();

// Yaklaşan aşılar
$stmt = $pdo->prepare("
    SELECT v.* 
    FROM vaccinations v 
    WHERE v.user_id = ? 
    AND v.next_dose_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
    AND v.next_dose_date > v.vaccination_date
    AND v.next_dose_date IS NOT NULL
    AND NOT EXISTS (
        SELECT 1 
        FROM vaccinations v2 
        WHERE v2.user_id = v.user_id 
        AND v2.vaccine_name = v.vaccine_name 
        AND v2.vaccination_date > v.vaccination_date
    )
    ORDER BY v.next_dose_date ASC
");
$stmt->execute([$_SESSION['user_id']]);
$upcomingVaccinations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aşı Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            margin-bottom: 1.5rem;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-add {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.2rem;
        }
        .upcoming-badge {
            background-color: #ffc107;
            color: #000;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-syringe me-2"></i>
                Aşı Takip Sistemi
            </a>
            <div class="d-flex">
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="admin.php" class="btn btn-outline-light me-2">
                    <i class="fas fa-user-shield me-2"></i>
                    Admin Paneli
                </a>
                <?php endif; ?>
                <a href="profile.php" class="btn btn-outline-light me-2">
                    <i class="fas fa-user me-2"></i>
                    Profil
                </a>
                <a href="logout.php" class="btn btn-outline-light">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Çıkış Yap
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <?php if (!empty($upcomingVaccinations)): ?>
        <div class="row mb-4">
            <div class="col">
                <h2 class="mb-3">Yaklaşan Aşılar</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Aşı Adı</th>
                                        <th>Sonraki Doz Tarihi</th>
                                        <th>Doz</th>
                                        <th>Notlar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($upcomingVaccinations as $v): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($v['vaccine_name']); ?></td>
                                        <td>
                                            <span class="upcoming-badge">
                                                <?php echo date('d.m.Y', strtotime($v['next_dose_date'])); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($v['dose']); ?></td>
                                        <td><?php echo htmlspecialchars($v['notes']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col">
                <h2 class="mb-0">Tüm Aşı Kayıtlarım</h2>
                <p class="text-muted">Tüm aşı kayıtlarınızı buradan yönetebilirsiniz</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Aşı Adı</th>
                                <th>Tarih</th>
                                <th>Sonraki Doz</th>
                                <th>Doz</th>
                                <th>Notlar</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vaccines as $v): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($v['vaccine_name']); ?></td>
                                <td><?php echo date('d.m.Y', strtotime($v['vaccination_date'])); ?></td>
                                <td><?php echo $v['next_dose_date'] ? date('d.m.Y', strtotime($v['next_dose_date'])) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($v['dose']); ?></td>
                                <td><?php echo htmlspecialchars($v['notes']); ?></td>
                                <td class="action-buttons">
                                    <a href="edit_vaccine.php?id=<?php echo $v['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_vaccine.php?id=<?php echo $v['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu kaydı silmek istediğinizden emin misiniz?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a href="add_vaccine.php" class="btn btn-primary btn-add">
        <i class="fas fa-plus"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
