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

//  mevcut aşı kayıtlarını 
$stmt = $pdo->prepare("SELECT vaccine_name, dose FROM vaccinations WHERE user_id = ? ORDER BY vaccination_date");
$stmt->execute([$_SESSION['user_id']]);
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
    $name = $_POST['name'];

    //  kullanıcı bilgilerini güncelle
    $stmt = $pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
    $stmt->execute([$name, $_SESSION['user_id']]);

    //  aşı kaydını ekle
    $stmt = $pdo->prepare("INSERT INTO vaccinations (user_id, vaccine_name, vaccination_date, next_dose_date, dose, notes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $vaccine_name, $vaccination_date, $next_dose_date, $dose, $notes]);
    
    header("Location: dashboard.php");
    exit();
}

// Kullanıcı bilgilerini
$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Aşı Kaydı - Aşı Takip Sistemi</title>
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
        .dose-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .vaccine-description {
            font-size: 0.8rem;
            color: #6c757d;
            font-style: italic;
        }
        .taken-doses {
            font-size: 0.9rem;
            color: #dc3545;
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
                        <h2 class="card-title mb-4">Yeni Aşı Kaydı</h2>
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="vaccine_name" class="form-label">Aşı Adı</label>
                                <select class="form-select" id="vaccine_name" name="vaccine_name" required>
                                    <option value="">Aşı seçiniz</option>
                                    <?php foreach ($vaccine_doses as $name => $info): ?>
                                    <option value="<?php echo htmlspecialchars($name); ?>">
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
                                <div id="doseInfo" class="dose-info mt-1"></div>
                                <div id="vaccineDescription" class="vaccine-description mt-1"></div>
                                <div id="takenDoses" class="taken-doses mt-1"></div>
                            </div>
                            <div class="mb-3">
                                <label for="vaccination_date" class="form-label">Aşı Tarihi</label>
                                <input type="date" class="form-control" id="vaccination_date" name="vaccination_date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="next_dose_date" class="form-label">Sonraki Doz Tarihi</label>
                                <input type="date" class="form-control" id="next_dose_date" name="next_dose_date">
                                <div class="form-text">Eğer başka doz varsa, sonraki doz tarihini girin.</div>
                                <div id="dateError" class="text-danger mt-1" style="display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notlar</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Aşı ile ilgili notlarınızı buraya yazabilirsiniz"></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
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
        let isRestartingVaccine = false;
        let currentVaccine = '';
        let lastTakenDose = 0;
        
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

        // Form kontrol
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validateDates()) {
                e.preventDefault();
            }
        });

        // Tarih değişikliklerini
        document.getElementById('vaccination_date').addEventListener('change', validateDates);
        document.getElementById('next_dose_date').addEventListener('change', validateDates);
        
        function updateDoseOptions(selectedVaccine) {
            const doseSelect = document.getElementById('dose');
            const doseInfo = document.getElementById('doseInfo');
            const vaccineDescription = document.getElementById('vaccineDescription');
            const takenDosesInfo = document.getElementById('takenDoses');
            
            // Doz  temizle
            doseSelect.innerHTML = '';
            
            if (selectedVaccine) {
                const vaccineInfo = vaccineDoses[selectedVaccine];
                const totalDoses = vaccineInfo.doses;
                const vaccineTakenDoses = takenDoses[selectedVaccine] || [];
                
                // Son dozu bul
                lastTakenDose = 0;
                vaccineTakenDoses.forEach(dose => {
                    const doseNumber = parseInt(dose);
                    if (doseNumber > lastTakenDose) {
                        lastTakenDose = doseNumber;
                    }
                });
                
                doseInfo.textContent = `Bu aşının toplam ${totalDoses} dozu vardır.`;
                vaccineDescription.textContent = vaccineInfo.description;
                
                //  aynı aşı yeniden başlatma 
                if (selectedVaccine === currentVaccine && isRestartingVaccine) {
                    takenDosesInfo.textContent = 'Yeni aşı serisi başlatılıyor...';
                    lastTakenDose = 0; // son doz sıfırla
                } else if (vaccineTakenDoses.length > 0) {
                    takenDosesInfo.textContent = `Daha önce alınan dozlar: ${vaccineTakenDoses.join(', ')}`;
                    
                    // tüm dozlar alınmışsa uyarı 
                    if (vaccineTakenDoses.length === totalDoses && !isRestartingVaccine) {
                        const confirmRestart = confirm(
                            'Bu aşının tüm dozları daha önce tamamlanmış. ' +
                            'Yeni bir aşı serisine başlamak istediğinizden emin misiniz?'
                        );
                        
                        if (!confirmRestart) {
                            //iptal aşı seçimini temizle
                            document.getElementById('vaccine_name').value = '';
                            updateDoseOptions('');
                            return;
                        }
                        //  onay yeniden başlat
                        isRestartingVaccine = true;
                        currentVaccine = selectedVaccine;
                        takenDosesInfo.textContent = 'Yeni aşı serisi başlatılıyor...';
                        lastTakenDose = 0; //son doz sıfırla
                    }
                } else {
                    takenDosesInfo.textContent = '';
                    isRestartingVaccine = false;
                    currentVaccine = selectedVaccine;
                }
                
                // Doz oluştur
                for (let i = 1; i <= totalDoses; i++) {
                    const doseValue = `${i}. Doz`;
                    const option = document.createElement('option');
                    option.value = doseValue;
                    option.textContent = doseValue;
                    
                    //  daha önce alınmışsa seçilemez 
                    if (vaccineTakenDoses.includes(doseValue) && !isRestartingVaccine) {
                        option.disabled = true;
                    }
                    
                    doseSelect.appendChild(option);
                }
            } else {
                doseInfo.textContent = '';
                vaccineDescription.textContent = '';
                takenDosesInfo.textContent = '';
            }
        }

        // Aşı seçildiğinde doz  güncelle
        document.getElementById('vaccine_name').addEventListener('change', function() {
            updateDoseOptions(this.value);
        });

        // Doz seçimi sonraki doz aktif/pasif yap
        document.getElementById('dose').addEventListener('change', function() {
            const nextDoseDate = document.getElementById('next_dose_date');
            const dose = this.value;
            
            // Tek doz aşılar için sonraki doz tarihini pasif bırak
            if (dose === 'Tek Doz') {
                nextDoseDate.disabled = true;
                nextDoseDate.value = ''; 
            } else {
                nextDoseDate.disabled = false;
            }
        });

        //mevcut doz seçimi sonraki doz tarih ayarla
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
