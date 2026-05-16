Berikut alur paling sederhana untuk “Hello World” ELK Stack: aplikasi menulis log → Filebeat membaca log → Logstash memproses → Elasticsearch menyimpan → Kibana menampilkan.

Contoh ini cocok untuk belajar konsep dasar dulu.

## Arsitektur sederhana

```text
app.log  --> Filebeat --> Logstash --> Elasticsearch --> Kibana
```

## 1. Buat file log contoh

Buat folder project:

```bash
mkdir elk-hello
cd elk-hello
```

Buat file log:

```bash
nano app.log
```

Isi:

```text
2026-05-16 10:00:00 INFO Application started
2026-05-16 10:00:05 INFO User login success
2026-05-16 10:00:10 ERROR Database connection failed
```

---

## 2. Konfigurasi Logstash

Buat file:

```bash
nano logstash.conf
```

Isi:

```conf
input {
  beats {
    port => 5044
  }
}

filter {
  grok {
    match => {
      "message" => "%{TIMESTAMP_ISO8601:timestamp} %{LOGLEVEL:level} %{GREEDYDATA:log_message}"
    }
  }

  date {
    match => [ "timestamp", "yyyy-MM-dd HH:mm:ss" ]
  }
}

output {
  elasticsearch {
    hosts => ["http://localhost:9200"]
    index => "hello-logs"
  }

  stdout {
    codec => rubydebug
  }
}
```

Penjelasan:

* `input`: menerima log dari Filebeat
* `grok`: memecah log menjadi field
* `output`: kirim ke Elasticsearch

---

## 3. Jalankan Logstash

Masuk folder instalasi Logstash:

```bash
bin/logstash -f /path/ke/logstash.conf
```

Kalau sukses biasanya muncul:

```text
Successfully started Logstash API endpoint
```

---

## 4. Konfigurasi Filebeat

Edit:

```bash
filebeat.yml
```

Minimal:

```yaml
filebeat.inputs:
  - type: filestream
    enabled: true
    paths:
      - /path/ke/elk-hello/app.log

output.logstash:
  hosts: ["localhost:5044"]
```

---

## 5. Jalankan Filebeat

```bash
filebeat -e
```

Kalau berhasil, log akan dikirim ke Logstash lalu ke Elasticsearch.

---

## 6. Cek di Elasticsearch

Tes index:

```bash
curl localhost:9200/hello-logs/_search?pretty
```

Kalau berhasil, akan muncul dokumen JSON log.

---

## 7. Lihat di Kibana

Buka:

```text
http://localhost:5601
```

Masuk ke:

* Stack Management
* Data Views
* Create Data View

Isi:

* Name: `hello-logs`
* Index pattern: `hello-logs*`

Lalu buka:

* Discover

Log akan muncul di sana.

---

## Hasil akhir yang dipelajari

Dari project kecil ini kamu sudah belajar:

* ingestion log
* parsing log
* indexing
* searching
* observability dashboard dasar

---

## Next step setelah “Hello World”

Setelah ini biasanya lanjut ke:

### 1. Structured JSON log

Daripada text biasa:

```json
{
  "level":"INFO",
  "user":"rian",
  "action":"login"
}
```

Ini jauh lebih powerful.

---

### 2. Logging dari aplikasi nyata

Contoh:

* Node.js Express
* Laravel
* Spring Boot
* Django

---

### 3. Visualisasi Kibana

Buat:

* error chart
* login activity
* response time graph

---

### 4. Alerting

Misalnya:

* ERROR > 10 kali dalam 1 menit
* CPU tinggi
* failed login banyak

---

### 5. Centralized logging untuk server kampus/lab

ELK sangat cocok untuk:

* monitoring server
* SI akademik
* aplikasi pembelajaran
* DevOps praktikum mahasiswa

---
