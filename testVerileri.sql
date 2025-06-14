-- chatgpt ai  ile oluşturulan test verileri burada yer almaktadır.
--tüm kişileri ve aşı örneklerini eklemedim yeterli sayıda örnek aşağıda bulunmaktadır.

--uygulamanın çalışmasını denemek için veri gireceğim 100 farklı kişiş oluştur ve bunlara rastgele aşılar ekle sql kodunu bana ver

-- Test verileri için kullanıcılar
INSERT INTO users (first_name, last_name, email, password, role) VALUES
('Ahmet', 'Yılmaz', 'ahmet.yilmaz@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Ayşe', 'Kaya', 'ayse.kaya@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Mehmet', 'Demir', 'mehmet.demir@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Fatma', 'Çelik', 'fatma.celik@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Ali', 'Şahin', 'ali.sahin@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Zeynep', 'Öztürk', 'zeynep.ozturk@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Mustafa', 'Arslan', 'mustafa.arslan@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Elif', 'Doğan', 'elif.dogan@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Hasan', 'Kılıç', 'hasan.kilic@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Selin', 'Yıldız', 'selin.yildiz@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Emre', 'Aydın', 'emre.aydin@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Deniz', 'Özdemir', 'deniz.ozdemir@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Burak', 'Çetin', 'burak.cetin@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Ceren', 'Kurt', 'ceren.kurt@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Can', 'Koç', 'can.koc@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Ece', 'Aslan', 'ece.aslan@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Onur', 'Yılmaz', 'onur.yilmaz@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Merve', 'Kara', 'merve.kara@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Serkan', 'Özkan', 'serkan.ozkan@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Gizem', 'Şen', 'gizem.sen@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Test verileri için aşı kayıtları
INSERT INTO vaccinations (user_id, vaccine_name, vaccination_date, next_dose_date, dose, notes) VALUES
-- Ahmet Yılmaz'ın aşıları
(1, 'COVID-19', '2023-12-01', '2024-01-01', '1. Doz', 'İlk doz yapıldı'),
(1, 'COVID-19', '2024-01-01', '2024-07-01', '2. Doz', 'İkinci doz yapıldı'),
(1, 'Grip', '2023-11-15', '2024-11-15', '1. Doz', 'Yıllık grip aşısı'),

-- Ayşe Kaya'nın aşıları
(2, 'Hepatit B', '2023-10-15', '2023-12-15', '1. Doz', 'İlk doz yapıldı'),
(2, 'Hepatit B', '2023-12-15', '2024-06-15', '2. Doz', 'İkinci doz yapıldı'),
(2, 'MMR', '2023-09-01', '2024-03-01', '1. Doz', 'Kızamık aşısı'),

-- Mehmet Demir'in aşıları
(3, 'Tdap', '2023-11-01', '2033-11-01', '1. Doz', '10 yıllık koruma'),
(3, 'Grip', '2023-10-01', '2024-10-01', '1. Doz', 'Yıllık grip aşısı'),

-- Fatma Çelik'in aşıları
(4, 'HPV', '2023-09-15', '2023-11-15', '1. Doz', 'İlk doz yapıldı'),
(4, 'HPV', '2023-11-15', '2024-03-15', '2. Doz', 'İkinci doz yapıldı'),
(4, 'HPV', '2024-03-15', NULL, '3. Doz', 'Son doz yapıldı'),

-- Ali Şahin'in aşıları
(5, 'COVID-19', '2023-12-10', '2024-01-10', '1. Doz', 'İlk doz yapıldı'),
(5, 'Grip', '2023-11-20', '2024-11-20', '1. Doz', 'Yıllık grip aşısı'),

-- Zeynep Öztürk'ün aşıları
(6, 'Hepatit A', '2023-10-01', '2024-04-01', '1. Doz', 'İlk doz yapıldı'),
(6, 'Hepatit A', '2024-04-01', NULL, '2. Doz', 'Son doz yapıldı'),

-- Mustafa Arslan'ın aşıları
(7, 'COVID-19', '2023-12-05', '2024-01-05', '1. Doz', 'İlk doz yapıldı'),
(7, 'COVID-19', '2024-01-05', '2024-07-05', '2. Doz', 'İkinci doz yapıldı'),
(7, 'Grip', '2023-11-10', '2024-11-10', '1. Doz', 'Yıllık grip aşısı'),

-- Elif Doğan'ın aşıları
(8, 'MMR', '2023-09-15', '2024-03-15', '1. Doz', 'İlk doz yapıldı'),
(8, 'MMR', '2024-03-15', NULL, '2. Doz', 'Son doz yapıldı'),

-- Hasan Kılıç'ın aşıları
(9, 'Hepatit B', '2023-11-01', '2024-01-01', '1. Doz', 'İlk doz yapıldı'),
(9, 'Hepatit B', '2024-01-01', '2024-07-01', '2. Doz', 'İkinci doz yapıldı'),

-- Selin Yıldız'ın aşıları
(10, 'COVID-19', '2023-12-15', '2024-01-15', '1. Doz', 'İlk doz yapıldı'),
(10, 'Grip', '2023-11-25', '2024-11-25', '1. Doz', 'Yıllık grip aşısı'),

-- Emre Aydın'ın aşıları
(11, 'Tdap', '2023-10-15', '2033-10-15', '1. Doz', '10 yıllık koruma'),
(11, 'Grip', '2023-11-05', '2024-11-05', '1. Doz', 'Yıllık grip aşısı'),

-- Deniz Özdemir'in aşıları
(12, 'HPV', '2023-09-20', '2023-11-20', '1. Doz', 'İlk doz yapıldı'),
(12, 'HPV', '2023-11-20', '2024-03-20', '2. Doz', 'İkinci doz yapıldı'),

-- Burak Çetin'in aşıları
(13, 'COVID-19', '2023-12-20', '2024-01-20', '1. Doz', 'İlk doz yapıldı'),
(13, 'COVID-19', '2024-01-20', '2024-07-20', '2. Doz', 'İkinci doz yapıldı'),

-- Ceren Kurt'un aşıları
(14, 'Hepatit A', '2023-10-10', '2024-04-10', '1. Doz', 'İlk doz yapıldı'),
(14, 'Hepatit A', '2024-04-10', NULL, '2. Doz', 'Son doz yapıldı'),

-- Can Koç'un aşıları
(15, 'MMR', '2023-09-25', '2024-03-25', '1. Doz', 'İlk doz yapıldı'),
(15, 'MMR', '2024-03-25', NULL, '2. Doz', 'Son doz yapıldı'),

-- Ece Aslan'ın aşıları
(16, 'COVID-19', '2023-12-25', '2024-01-25', '1. Doz', 'İlk doz yapıldı'),
(16, 'Grip', '2023-11-30', '2024-11-30', '1. Doz', 'Yıllık grip aşısı'),

-- Onur Yılmaz'ın aşıları
(17, 'Hepatit B', '2023-11-10', '2024-01-10', '1. Doz', 'İlk doz yapıldı'),
(17, 'Hepatit B', '2024-01-10', '2024-07-10', '2. Doz', 'İkinci doz yapıldı'),

-- Merve Kara'nın aşıları
(18, 'Tdap', '2023-10-20', '2033-10-20', '1. Doz', '10 yıllık koruma'),
(18, 'Grip', '2023-11-15', '2024-11-15', '1. Doz', 'Yıllık grip aşısı'),

-- Serkan Özkan'ın aşıları
(19, 'HPV', '2023-09-30', '2023-11-30', '1. Doz', 'İlk doz yapıldı'),
(19, 'HPV', '2023-11-30', '2024-03-30', '2. Doz', 'İkinci doz yapıldı'),

-- Gizem Şen'in aşıları
(20, 'COVID-19', '2023-12-30', '2024-01-30', '1. Doz', 'İlk doz yapıldı'),
(20, 'COVID-19', '2024-01-30', '2024-07-30', '2. Doz', 'İkinci doz yapıldı'),
(20, 'Grip', '2023-12-01', '2024-12-01', '1. Doz', 'Yıllık grip aşısı');


