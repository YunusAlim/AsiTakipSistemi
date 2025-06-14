# Aşı Takip Sistemi

Bu proje, bireylerin aşı kayıtlarını ve aşı takiplerini yönetmek için geliştirilmiş bir web uygulamasıdır.

## Özellikler

- Kullanıcı Yönetimi
  - Kayıt olma ve giriş yapma
  - Profil yönetimi

- Aşı Kayıtları
  - Aşı bilgilerini kaydetme
  ![image](https://github.com/user-attachments/assets/4375c5b5-fb43-42db-a2bc-e44c9967c2ad)

  - Aşı geçmişi görüntüleme
  - Aşı bilgilerini güncelleme
  - Aşı dozlarını takip etme
  - Yaklaşan aşıları görüntüleme

## Teknik Detaylar

### Kullanılan Teknolojiler

- PHP 8.0+
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap 5

### Veritabanı Yapısı

Proje aşağıdaki ana tabloları içermektedir:

1. `users` - Kullanıcı bilgileri
2. `vaccinations` - Aşı kayıtları


## Kurulum

1. Projeyi bilgisayarınıza klonlayın:

2. XAMPP veya benzeri bir local server kurulumu yapın

3. MySQL veritabanını oluşturun:
   - phpMyAdmin'e giriş yapın
   - Yeni bir veritabanı oluşturun
   - `database.sql` dosyasını içe aktarın

4. Veritabanı bağlantı ayarlarını yapın:
   - `config/database.php` dosyasını düzenleyin
   - Veritabanı bilgilerinizi girin

5. Web sunucusunu başlatın ve projeyi çalıştırın

## Kullanım

1. Ana sayfadan kayıt olun veya giriş yapın
2. Profil sayfanızdan kişisel bilgilerinizi güncelleyin
3. Aşı kayıtları sayfasından yeni aşı kaydı oluşturun
4. Ana sayfadan yaklaşan aşılarınızı takip edin
   veya http://95.130.171.20/~st23360859710 adresinden kullanabilirsiniz.

## Güvenlik

- Tüm kullanıcı şifreleri güvenli bir şekilde hashlenerek saklanmaktadır
- Session yönetimi güvenli bir şekilde yapılandırılmıştır

## Video Tanıtım

Projenin video tanıtımı (https://www.youtube.com/watch?v=Ae7-gzgfKvk) adresinde yapılmıştır.

