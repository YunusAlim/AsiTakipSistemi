# Aşı Takip Sistemi

Bu proje, aşı kayıtlarını ve takiplerini yönetmek için geliştirilmiş bir web uygulamasıdır. Yapılan uygulama sayesinde önceki ve yaklaşan aşı takibi ciddi manada kolaylaşmıştır. Mobil uyumlu arayüz ile uygulama mobilde de rahatlıkla kullanılabilmektedir. Boostrap kütüphanesi ile uygulama arayüzü daha kullanıcı dostu hale getirilmiştir.

## Özellikler

- Kullanıcı Yönetimi
  
  - Kayıt olma ve giriş yapma
    
    ![image](https://github.com/user-attachments/assets/9df01911-83e2-4e68-8f1c-1ef99d96af57)
    
  - Profil yönetimi
    
    ![image](https://github.com/user-attachments/assets/25ec8fb3-b769-4b63-9ac2-644ffcfe75f8)


- Aşı Kayıtları
  - Aşı bilgilerini kaydetme
    
    ![image](https://github.com/user-attachments/assets/4375c5b5-fb43-42db-a2bc-e44c9967c2ad)

  - Aşı geçmişi görüntüleme
    
    ![image](https://github.com/user-attachments/assets/3ffd4ee5-c22c-4a4f-ad3e-6a47c12d7bfa)

  - Aşı bilgilerini güncelleme
    
    ![image](https://github.com/user-attachments/assets/f8c6537f-01b1-4885-b36a-f2476b62df95)

  - Yaklaşan aşıları görüntüleme
    
    ![image](https://github.com/user-attachments/assets/822bdf62-e590-4606-b5d9-4af9d31a2ff6)

  

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

Eğer projeyi geliştirmek veya localde kullanmak istiyorsanız:

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

