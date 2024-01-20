## Proje Adı

Emre Gül - Sirwiss - Backend Projesi

## Başlangıç

Projeyi çalıştırmak için aşağıdaki adımları takip edin.

## Gereksinimler

-   Docker
-   Postman

## Kurulum

Bu depoyu indirin veya klonlayın:

```bash
git clone https://github.com/emregull/sirwiss.git
```

Gerekli composer dosyalarını indirin:

```bash
composer install
```

.env dosyasını .env.example gibi düzenleyin:

```bash
.env
```

Docker container'larını başlatmak için:

```bash
cd docker
docker-compose up -d
```

Laravel projesinin ana dizinine gidin ve migration'ları çalıştırın:

```bash
cd ..
php artisan migrate
```

Laravel sunucusunu başlatın:

```bash
php artisan serve
```

Tarayıcıda http://localhost:8000 adresine gidip uygulamayı görüntüleyebilirsiniz.
(Key oluşturmanız gerekebilir laravel uyarısı ile kolayca 'generate' edip oluşturabilirsiniz.)

yada

Tarayıcıda http://localhost:8080 adresine gidip phpmyadmin'e ulaşabilirsiniz.

Kullanıcı Adı: `sirwiss`

Parola: `sirwiss`

## Postman

Gerekli Postman koleksiyonuna proje dizininden erişebilirsiniz:

```bash
Sirwiss - EmreGul.postman_collection
```
