Itu berarti Logstash sudah terinstall sebagai service systemd, tetapi binary `logstash` tidak masuk ke PATH shell.

Normal di installasi Debian/Ubuntu.

Coba jalankan langsung binary-nya:

```bash
/usr/share/logstash/bin/logstash --version
```

Kalau muncul versi, berarti aman.

Untuk menjalankan config manual:

```bash
sudo /usr/share/logstash/bin/logstash -f /path/ke/logstash.conf
```

Contoh:

```bash
sudo /usr/share/logstash/bin/logstash -f ~/spmb/uho-pbplatform/elk-hello/logstash.conf
```

---

Karena service `logstash.service` sudah aktif, sebenarnya ada 2 mode:

## Mode 1 — Service systemd (lebih production-like)

Config diletakkan di:

```text
/etc/logstash/conf.d/
```

Misalnya:

```bash
sudo nano /etc/logstash/conf.d/hello.conf
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

Lalu restart:

```bash
sudo systemctl restart logstash
```

Cek log:

```bash
sudo journalctl -u logstash -f
```

---

## Mode 2 — Manual testing mode (lebih enak belajar)

Stop service dulu:

```bash
sudo systemctl stop logstash
```

Lalu jalankan manual:

```bash
sudo /usr/share/logstash/bin/logstash -f ~/spmb/uho-pbplatform/elk-hello/logstash.conf
```

Ini enak karena output parsing langsung terlihat di terminal.

---

## Cek apakah Elasticsearch sudah hidup

```bash
curl localhost:9600
```

Kalau sehat, ada response JSON seperti:

```json
{
  "name" : "...",
  "cluster_name" : "elasticsearch",
  ...
}
```

---

## Cek Kibana

```bash
sudo systemctl status kibana
```

Kalau belum aktif:

```bash
sudo systemctl start kibana
```

Buka:

```text
http://localhost:5601
```

---

## Shortcut penting ELK di Ubuntu/Debian

### Elasticsearch

```bash
sudo systemctl status elasticsearch
```

### Logstash

```bash
sudo systemctl status logstash
```

### Kibana

```bash
sudo systemctl status kibana
```

---

## Workflow belajar yang paling nyaman

Saya sarankan urutannya:

1. Elasticsearch hidup
2. Kibana hidup
3. Logstash manual mode
4. Test input sederhana dulu
5. Baru Filebeat
6. Baru aplikasi nyata

---

Untuk test paling sederhana tanpa Filebeat dulu, coba ini:

Buat config:

```conf
input {
  stdin {}
}

output {
  stdout { codec => rubydebug }
}
```

Jalankan:

```bash
sudo /usr/share/logstash/bin/logstash -f test.conf
```

Lalu ketik:

```text
hello world
```

Kalau muncul output JSON parsing, berarti Logstash sudah benar-benar jalan.
