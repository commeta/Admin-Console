# Система управления сайтом Admin Console
Web based CMS

![Admin Console](https://webdevops.ru/img/admin-console/Admin-Console-pages.png "Admin Console")

Система управления сайтом которая собирается из небольших программных модулей, под нужды конкретного проекта.

Admin Console содержит только базовый набор модулей и функций необходимый для работы сайта, что облегчает создание или редактирования материалов, и позволяет ускорить работу сайта для посетителей и поисковых систем.

Система управления сайтом CMS Admin Console специально разрабатывалась для высоко - нагруженных проектов, с учетом максимальной поддержки протокола HTTP/S.

В качестве Web UI интерфейса - использован форк: open-source bootstrap 3 theme [Devops v1.0](https://github.com/devoopsme/devoops)

### Пресс-релиз:
[https://webdevops.ru/admin-console.html](https://webdevops.ru/admin-console.html)

### Демо версия:
[https://admin.seo-marketing.spb.ru/](https://admin.seo-marketing.spb.ru/)

### Документация:
+ [Установка](https://github.com/commeta/admin-console/wiki/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0)
+ [Подключение шаблона](https://github.com/commeta/admin-console/wiki/%D0%9F%D0%BE%D0%B4%D0%BA%D0%BB%D1%8E%D1%87%D0%B5%D0%BD%D0%B8%D0%B5-%D1%88%D0%B0%D0%B1%D0%BB%D0%BE%D0%BD%D0%B0)
+ [Разработка модулей](https://github.com/commeta/admin-console/wiki/%D0%A0%D0%B0%D0%B7%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D0%BA%D0%B0-%D0%BC%D0%BE%D0%B4%D1%83%D0%BB%D0%B5%D0%B9)


### Минимальные системные требования:
+ PHP 7.0+
+ mysqli
+ От 1MB свободной памяти
+ От 55MB места на диске

### Результаты тестирования:
Тестовый стенд: 
+ Centos 8
+ Фронтэнд nginx
+ Бэкэнд apache2
+ 1 ядро: Intel(R) Xeon(R) CPU E5645 @ 2.40GHz
+ 1024MB RAM

```bash
$ ab -kc 10 -t 60 https://admin.seo-marketing.spb.ru/
```

```
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking admin.seo-marketing.spb.ru (be patient)

Finished 3253 requests
Server Software:        nginx/1.16.1
Server Hostname:        admin.seo-marketing.spb.ru
Server Port:            443
SSL/TLS Protocol:       TLSv1.2,ECDHE-RSA-AES128-GCM-SHA256,2048,128

Document Path:          /
Document Length:        10043 bytes

Concurrency Level:      10
Time taken for tests:   60.044 seconds
Complete requests:      3253
Failed requests:        0
Write errors:           0
Keep-Alive requests:    0
Total transferred:      33688068 bytes
HTML transferred:       32669879 bytes
Requests per second:    54.18 [#/sec] (mean)
Time per request:       184.580 [ms] (mean)
Time per request:       18.458 [ms] (mean, across all concurrent requests)
Transfer rate:          547.91 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        5   53  21.2     51     290
Processing:     9  131  36.1    125     510
Waiting:        6  129  33.7    124     424
Total:         16  184  44.7    176     571

Percentage of the requests served within a certain time (ms)
  50%    176
  66%    188
  75%    196
  80%    202
  90%    222
  95%    251
  98%    307
  99%    396
 100%    571 (longest request)
```

____
This is free open-source CMS based on bootstrap 3 theme for you.
Licensed under GPL v3 or MIT.

webdevops (info@webdevops.ru)

GIT- https://github.com/commeta/admin-console

