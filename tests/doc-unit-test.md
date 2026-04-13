Berikut tahapan sistematis menggunakan **PHPUnit** untuk menguji fungsi perhitungan gaji THR:
1. composer install phpunit
2. buat file ThrCalculator.php
3. buat file tests/ThrCalculatorTest.php
4. jalankan ./vendor/bin/phpunit

link: https://www.youtube.com/watch?v=VY8pw9DabOw

---

## 1. Siapkan Project & Instalasi PHPUnit

Jika belum ada PHPUnit:

```bash
composer require --dev phpunit/phpunit
```

Pastikan struktur dasar:

```
project/
├── ThrCalculator.php
├── tests/
│   └── ThrCalculatorTest.php
├── vendor/
└── phpunit.xml
```

---

## 2. Buat Fungsi Perhitungan THR

Contoh sederhana (aturan umum: masa kerja ≥ 12 bulan = 1x gaji):

```php
// src/ThrCalculator.php
class ThrCalculator
{
    public function hitungThr($gajiBulanan, $masaKerjaBulan)
    {
        if ($masaKerjaBulan >= 12) {
            return $gajiBulanan;
        }
        // prorata
        return ($masaKerjaBulan / 12) * $gajiBulanan;
    }
}

// $thr = new ThrCalculator()
// $gaji = 7000000
// $besaranThr = $thr->hitungThr($gaji, 13)
// $totalGaji = $besaranThr+$gaji
```

---

## 3. Konfigurasi PHPUnit

Buat file `phpunit.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php">
    <testsuites>
        <testsuite name="Application Test">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

---

## 4. Buat Test Case

```php
// tests/ThrCalculatorTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/ThrCalculator.php';

class ThrCalculatorTest extends TestCase
{
    public function testThrFullUntukMasaKerja12Bulan()
    {
        $calc = new ThrCalculator();
        $this->assertEquals(5000000, $calc->hitungThr(5000000, 12));
    }

    public function testThrProporsionalUntukKurangDari12Bulan()
    {
        $calc = new ThrCalculator();
        $this->assertEquals(2500000, $calc->hitungThr(5000000, 6));
    }

    public function testThrNolJikaMasaKerja0()
    {
        $calc = new ThrCalculator();
        $this->assertEquals(0, $calc->hitungThr(5000000, 0));
    }
}
```

---

## 5. Jalankan PHPUnit

```bash
./vendor/bin/phpunit
```

Output yang diharapkan:

```
OK (3 tests, 3 assertions)
```

---

## 6. Tambahkan Edge Case (Best Practice)

Perluas test untuk kasus realistis:

* Masa kerja negatif
* Gaji = 0
* Input non-numeric
* Pembulatan hasil

Contoh:

```php
public function testGajiNol()
{
    $calc = new ThrCalculator();
    $this->assertEquals(0, $calc->hitungThr(0, 12));
}
```

---

## 7. Refactor dengan Confidence

Setelah test ada:

* Bebas ubah logic
* Jalankan ulang PHPUnit
* Pastikan semua test tetap hijau

---

## 8. Integrasi ke Workflow

Opsional tapi penting:

* Jalankan PHPUnit di CI/CD (GitHub Actions, GitLab CI)
* Jalankan sebelum commit (pre-commit hook)

---

## Ringkasan Alur

1. Install PHPUnit
2. Buat fungsi THR
3. Buat test class
4. Jalankan test
5. Tambah edge case
6. Gunakan test sebagai safety net

---

Jika ingin, bisa dilanjutkan ke:

* Mock data karyawan (repository pattern seperti di proyek Django-mu)
* Test berbasis database (integration test)
* Atau Playwright untuk test UI form input THR
