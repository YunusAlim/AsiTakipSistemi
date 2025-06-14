<?php
require 'auth.php';
require 'db.php';

// Aşı doz bilgileri
$vaccine_doses = [
    'BCG (Verem)' => ['doses' => 1, 'description' => 'Verem aşısı'],
    'Hepatit B' => ['doses' => 3, 'description' => 'Hepatit B aşısı'],
    'Hepatit A' => ['doses' => 2, 'description' => 'Hepatit A aşısı'],
    'DTaP' => ['doses' => 5, 'description' => 'Difteri, Tetanoz, Boğmaca aşısı'],
    'Td' => ['doses' => 1, 'description' => 'Erişkin difteri-tetanoz aşısı (10 yılda bir)'],
    'Tdap' => ['doses' => 1, 'description' => 'Erişkin difteri-tetanoz-boğmaca aşısı'],
    'IPV' => ['doses' => 4, 'description' => 'İnaktif Polio aşısı'],
    'OPV' => ['doses' => 3, 'description' => 'Oral Polio aşısı'],
    'Hib' => ['doses' => 4, 'description' => 'Haemophilus influenzae tip b aşısı'],
    'PCV13' => ['doses' => 4, 'description' => '13 valanlı Pnömokok aşısı'],
    'PPSV23' => ['doses' => 2, 'description' => '23 valanlı Pnömokok aşısı'],
    'MMR' => ['doses' => 2, 'description' => 'Kızamık, Kabakulak, Kızamıkçık aşısı'],
    'Suçiçeği' => ['doses' => 2, 'description' => 'Varicella aşısı'],
    'Rotavirüs' => ['doses' => 3, 'description' => 'Rotavirüs aşısı (RV1 veya RV5)'],
    'HPV' => ['doses' => 3, 'description' => 'İnsan papilloma virüsü aşısı'],
    'Grip' => ['doses' => 1, 'description' => 'İnfluenza aşısı (yıllık)'],
    'COVID-19' => ['doses' => 3, 'description' => 'COVID-19 aşısı (2 doz + hatırlatma)'],
    'Sarı Humma' => ['doses' => 1, 'description' => 'Sarı Humma aşısı (ömür boyu koruyucu)'],
    'Kuduz' => ['doses' => 5, 'description' => 'Kuduz aşısı (3 doz + temas sonrası 2 doz)'],
    'Kolera' => ['doses' => 2, 'description' => 'Kolera aşısı (ağızdan, kısa süreli koruma)'],
    'Tifo' => ['doses' => 3, 'description' => 'Tifo aşısı (oral veya inaktif)'],
    'Meningokok ACWY' => ['doses' => 2, 'description' => 'Meningokok ACWY aşısı'],
    'Meningokok B' => ['doses' => 3, 'description' => 'Meningokok B aşısı'],
    'Japon Ensefaliti' => ['doses' => 2, 'description' => 'Japon Ensefaliti aşısı'],
    'Tularemi' => ['doses' => 1, 'description' => 'Tularemi aşısı (deneysel/askerî)'],
    'Çiçek' => ['doses' => 1, 'description' => 'Çiçek aşısı (gerekli durumlarda)'],
    'Maymun Çiçeği' => ['doses' => 2, 'description' => 'Maymun Çiçeği aşısı (Mpox/Jynneos)'],
    'Şarbon' => ['doses' => 4, 'description' => 'Şarbon aşısı (3 doz + yıllık rapel)'],
    'Q Ateşi' => ['doses' => 1, 'description' => 'Q Ateşi aşısı (bazı ülkelerde)']
];

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$vaccine_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Aşı kaydı
$stmt = $pdo->prepare("SELECT * FROM vaccinations WHERE id = ? AND user_id = ?");
$stmt->execute([$vaccine_id, $user_id]);
$vaccine = $stmt->fetch();

if (!$vaccine) {
    header("Location: dashboard.php");
    exit();
}

// diğer aşı kayıtları
$stmt = $pdo->prepare("SELECT vaccine_name, dose FROM vaccinations WHERE user_id = ? AND id != ? ORDER BY vaccination_date");
$stmt->execute([$user_id, $vaccine_id]);
$existing_vaccines = $stmt->fetchAll(PDO::FETCH_ASSOC);

//  dozları grupla
$taken_doses = [];
foreach ($existing_vaccines as $record) {
    if (!isset($taken_doses[$record['vaccine_name']])) {
        $taken_doses[$record['vaccine_name']] = [];
    }
    $taken_doses[$record['vaccine_name']][] = $record['dose'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vaccine_name = $_POST['vaccine_name'];
    $vaccination_date = $_POST['vaccination_date'];
    $next_dose_date = $_POST['next_dose_date'] ?: null;
    $dose = $_POST['dose'];
    $notes = $_POST['notes'] ?? '';

    $stmt = $pdo->prepare("UPDATE vaccinations SET vaccine_name = ?, vaccination_date = ?, next_dose_date = ?, dose = ?, notes = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$vaccine_name, $vaccination_date, $next_dose_date, $dose, $notes, $vaccine_id, $user_id]);
    
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aşı Kaydını Düzenle - Aşı Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-control {
            padding: 0.8rem;
        }
        .btn-submit {
            padding: 0.8rem;
            font-size: 1.1rem;
        }
        .dose-info {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
        .vaccine-description {
            font-size: 0.8rem;
            color: #6c757d;
            font-style: italic;
        }
        .taken-doses {
            font-size: 0.9rem;
            color: #dc3545;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-syringe me-2"></i>
                Aşı Takip Sistemi
            </a>
            <div class="d-flex">
                <a href="dashboard.php" class="btn btn-outline-light me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Geri Dön
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-4">Aşı Kaydını Düzenle</h2>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="vaccine_name" class="form-label">Aşı Adı</label>
                                <select class="form-select" id="vaccine_name" name="vaccine_name" required>
                                    <option value="">Aşı seçiniz</option>
                                    <?php foreach ($vaccine_doses as $name => $info): ?>
                                    <option value="<?php echo htmlspecialchars($name); ?>" <?php echo $vaccine['vaccine_name'] === $name ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($name); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dose" class="form-label">Doz</label>
                                <select class="form-select" id="dose" name="dose" required>
                                    <option value="">Önce aşı seçiniz</option>
                                </select>
                                <div id="doseInfo" class="dose-info"></div>
                                <div id="vaccineDescription" class="vaccine-description"></div>
                                <div id="takenDoses" class="taken-doses"></div>
                            </div>
                            <div class="mb-3">
                                <label for="vaccination_date" class="form-label">Aşı Tarihi</label>
                                <input type="date" class="form-control" id="vaccination_date" name="vaccination_date" value="<?php echo $vaccine['vaccination_date'] ? htmlspecialchars($vaccine['vaccination_date']) : date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="next_dose_date" class="form-label">Sonraki Doz Tarihi</label>
                                <input type="date" class="form-control" id="next_dose_date" name="next_dose_date" value="<?php echo $vaccine['next_dose_date'] ? htmlspecialchars($vaccine['next_dose_date']) : ''; ?>">
                                <div class="form-text">Eğer başka doz varsa, sonraki doz tarihini girin.</div>
                                <div id="dateError" class="text-danger mt-1" style="display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notlar</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Aşı ile ilgili notlarınızı buraya yazabilirsiniz"><?php echo htmlspecialchars($vaccine['notes']); ?></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="fas fa-save me-2"></i>
                                    Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const vaccineDoses = <?php echo json_encode($vaccine_doses); ?>;
        const takenDoses = <?php echo json_encode($taken_doses); ?>;
        const currentVaccine = "<?php echo htmlspecialchars($vaccine['vaccine_name']); ?>";
        const currentDose = "<?php echo htmlspecialchars($vaccine['dose']); ?>";
        
        // Tarih kontrolü 
        function validateDates() {
            const vaccinationDate = document.getElementById('vaccination_date').value;
            const nextDoseDate = document.getElementById('next_dose_date').value;
            const dateError = document.getElementById('dateError');
            const dose = document.getElementById('dose').value;
            
            // Tek doz 
            if (dose === 'Tek Doz') {
                dateError.style.display = 'none';
                return true;
            }

            if (nextDoseDate && vaccinationDate && nextDoseDate <= vaccinationDate) {
                dateError.textContent = 'Sonraki doz tarihi, aşı tarihinden sonra olmalıdır.';
                dateError.style.display = 'block';
                return false;
            }

            dateError.style.display = 'none';
            return true;
        }

        // Form  kontrol
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validateDates()) {
                e.preventDefault();
            }
        });

        // Tarih değiş
        document.getElementById('vaccination_date').addEventListener('change', validateDates);
        document.getElementById('next_dose_date').addEventListener('change', validateDates);
        
        function updateDoseOptions(selectedVaccine) {
            const doseSelect = document.getElementById('dose');
            const doseInfo = document.getElementById('doseInfo');
            const vaccineDescription = document.getElementById('vaccineDescription');
            const takenDosesInfo = document.getElementById('takenDoses');
            
            // Doz temizle
            doseSelect.innerHTML = '';
            
            if (selectedVaccine) {
                const vaccineInfo = vaccineDoses[selectedVaccine];
                const totalDoses = vaccineInfo.doses;
                const vaccineTakenDoses = takenDoses[selectedVaccine] || [];
                
                doseInfo.textContent = `Bu aşının toplam ${totalDoses} dozu vardır.`;
                vaccineDescription.textContent = vaccineInfo.description;
                
                if (vaccineTakenDoses.length > 0) {
                    takenDosesInfo.textContent = `Daha önce alınan dozlar: ${vaccineTakenDoses.join(', ')}`;
                } else {
                    takenDosesInfo.textContent = '';
                }
                
                // Doz seçenekleri
                for (let i = 1; i <= totalDoses; i++) {
                    const doseValue = `${i}. Doz`;
                    // Doz aktif-pasif
                    const isTaken = vaccineTakenDoses.includes(doseValue) && doseValue !== currentDose;
                    
                    const option = document.createElement('option');
                    option.value = doseValue;
                    option.textContent = doseValue;
                    option.disabled = isTaken;
                    if (isTaken) {
                        option.textContent += ' (Alındı)';
                    }
                    if (currentVaccine === selectedVaccine && doseValue === currentDose) {
                        option.selected = true;
                    }
                    doseSelect.appendChild(option);
                }
            } else {
                doseInfo.textContent = '';
                vaccineDescription.textContent = '';
                takenDosesInfo.textContent = '';
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Önce aşı seçiniz';
                doseSelect.appendChild(option);
            }
        }
        
        document.getElementById('vaccine_name').addEventListener('change', function() {
            updateDoseOptions(this.value);
        });
        
        // doz güncelle
        updateDoseOptions(currentVaccine);

        //  sonraki doz tarih aktif/pasif 
        document.getElementById('dose').addEventListener('change', function() {
            const nextDoseDate = document.getElementById('next_dose_date');
            const dose = this.value;
            
            // Tek doz sonraki doz pasif
            if (dose === 'Tek Doz') {
                nextDoseDate.disabled = true;
                nextDoseDate.value = ''; 
            } else {
                nextDoseDate.disabled = false;
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            const dose = document.getElementById('dose').value;
            const nextDoseDate = document.getElementById('next_dose_date');
            
            if (dose === 'Tek Doz') {
                nextDoseDate.disabled = true;
                nextDoseDate.value = '';
            }
        });
    </script>
</body>
</html>
