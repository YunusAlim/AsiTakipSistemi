<?php
require 'db.php';
session_start();

// Admin kontrolü
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Tüm  aşı kayıtlarını getir
$stmt = $pdo->query("
    SELECT 
        v.*,
        u.name as user_name,
        u.email as user_email
    FROM vaccinations v
    INNER JOIN users u ON v.user_id = u.id
    ORDER BY v.vaccination_date DESC
");
$vaccinations = $stmt->fetchAll();

// İstatistik
$totalVaccinations = $pdo->query("SELECT COUNT(*) FROM vaccinations")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$latestVaccination = $pdo->query("SELECT MAX(vaccination_date) FROM vaccinations")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Aşı Takip Sistemi</title>
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
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stats-card {
            background: linear-gradient(45deg, #0d6efd, #0a58ca);
            color: white;
        }
        .stats-card i {
            font-size: 2rem;
            opacity: 0.8;
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
        .search-box {
            max-width: 300px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-shield me-2"></i>
                Admin Paneli
            </a>
            <div class="d-flex">
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
        <!-- İstatistik -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Toplam Aşı Kaydı</h6>
                                <h2 class="mt-2 mb-0"><?php echo $totalVaccinations; ?></h2>
                            </div>
                            <i class="fas fa-syringe"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Toplam Kullanıcı</h6>
                                <h2 class="mt-2 mb-0"><?php echo $totalUsers; ?></h2>
                            </div>
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Son Aşı Tarihi</h6>
                                <h2 class="mt-2 mb-0"><?php echo date('d.m.Y', strtotime($latestVaccination)); ?></h2>
                            </div>
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arama ve Filtreleme -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group search-box">
                            <input type="text" class="form-control" id="searchInput" placeholder="Ara...">
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-success" onclick="exportToExcel()">
                            <i class="fas fa-file-excel me-2"></i>
                            Excel'e Aktar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aşı Kayıtları -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="vaccinationsTable">
                        <thead>
                            <tr>
                                <th>Kullanıcı</th>
                                <th>E-posta</th>
                                <th>Aşı Adı</th>
                                <th>Tarih</th>
                                <th>Doz</th>
                                <th>Notlar</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vaccinations as $v): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($v['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($v['user_email']); ?></td>
                                <td><?php echo htmlspecialchars($v['vaccine_name']); ?></td>
                                <td><?php echo date('d.m.Y', strtotime($v['vaccination_date'])); ?></td>
                                <td><?php echo htmlspecialchars($v['dose']); ?></td>
                                <td><?php echo htmlspecialchars($v['notes']); ?></td>
                                <td class="action-buttons">
                                    <a href="delete_vaccine.php?id=<?php echo $v['id']; ?>&from_admin=true" class="btn btn-sm btn-danger" title="Sil" onclick="return confirm('Bu kaydı silmek istediğinizden emin misiniz?')">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Arama fonksiyon
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.getElementById('vaccinationsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().indexOf(searchText) > -1) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        });

        // Excel fonksiyonu
        function exportToExcel() {
            const table = document.getElementById('vaccinationsTable');
            const html = table.outerHTML;
            const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            const link = document.createElement('a');
            link.download = 'asi-kayitlari.xls';
            link.href = url;
            link.click();
        }
    </script>
</body>
</html> 