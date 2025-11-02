## CT275: CÔNG NGHỆ WEB - LAB 4

Học kỳ 1, Năm học: 2025-2026

**Họ tên**: Nguyễn Huy Lợi

**MSSV**: B2306556

**Lớp HP**: CT27501

## Triển khai trên nginx

```
# D:/Servers/nginx/conf/nginx.conf

server {
	listen       80;
	server_name  ct275-lab4.localhost;

	root "D:/mysites/lab4/public";
	index index.php;

	charset utf-8;

	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~ \.php$ {
		fastcgi_pass   127.0.0.1:9000;
		include        fastcgi_params;
		fastcgi_param  SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
	}

	location ~ /\.(?!well-known).* {
		deny all;
	}
}
```
