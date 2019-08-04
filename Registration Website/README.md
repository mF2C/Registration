# Registration Website

The registration Website is the place where users subscribe to the mF2C service and download the docker-compose file (agent). The Website incorporates a graphical user interface (GUI) that easily and intuitively allows users to create their user account and subsequently log in to the dashboard.

This document describes the process to deploy and use the **mF2C Registration Website**.


## Requirements
The following list of packages are necessary to correctly execute all the functions in the registration Website:
 - [apache2](https://packages.ubuntu.com/xenial/apache2)
 - [php7.0](https://packages.ubuntu.com/xenial/php7.0)
 - [php7.0-mbstring](https://packages.ubuntu.com/xenial/php7.0-mbstring)
 - [libapache2-mod-php](https://packages.ubuntu.com/xenial/libapache2-mod-php)
 - [php7.0-zip](https://packages.ubuntu.com/xenial/php7.0-zip)
 - [curl](https://packages.ubuntu.com/xenial/curl)
 - [php-curl](https://packages.ubuntu.com/xenial/php-curl)

To install them, first update and upgrade the system
```
sudo apt-get update
sudo apt-get upgrade
```
Then, 
```
sudo apt-get install apache2 php7.0 php7.0-mbstring libapache2-mod-php php7.0-zip curl php-curl -y
```

## Deployment
Once the required packages have been installed, copy the content of the project to the apache folder that will host the registration Website.
> **Note:** In Ubuntu, the default path to the apache web folder is /var/www/

Then, set the [CIMI server](https://github.com/mF2C/cimi) endpoint in the endpoint.php file
```
nano /var/www/scripts/cimi/endpoint.php
```

## Usage
To validate whether the registration Website is working properly, open the web browser and visit:
```
http://localhost/main.html
*When working remotely, replace localhost with the address of the remote server
```
The web browser should load the dashboard login page. If you already have an account, enter the user credentials, otherwise, click on the corresponding link to create one.

## Screenshots
### Sign in 
![Sign in](https://lh3.googleusercontent.com/6j89uZEEUCkJoCE1oeA6KxI0U0xK1RNDRkKeFlDcmBQihw9e9M7gye-9vuSaLKyowCivMfaCuwyqqfJk-oF2NgxO0XKAVM8cBdFAgUwxD3IeG8pH6e59jljahSGQDVYzfdMBNOMO4mYEEtgZp1ouohJE0T9NpMeA4XsSz5j2Nq6GdcaEhW3uaLQZbM4lL8dtHnd1A-F2kcz8NzDYUDO1cGqZGxejJg-oY9bUlL7bUXvWv8_FBYXDiu4g9ehh-iT6I2ny9Sa1vyprQ5iMvpRayfPN1UdnvHmcJwuw8GAXuXh8MR9wcIS1tXEr6a8nLm0O_WNXxXUl__jJIciVhDEkIKgY8pKcijtAIiZo2Wdx5T-Xf1PcP_WJkx1oPPpMxntdT-mq-fxb2lXQ2H-focyZWgEG5O6_vH4Ex6pnl2akQwwts8B06cEXSCgapS_M6AgXcqk0GdHL3GZcKVkPr1lfGLlyLoftU45I9nU2gQdO-zgw6WFOlnEUhjhWGmyJeVOlVccrbbA6uH3OuhSIVmsDav-lExLUPdH2eJOmkpzXLiDoXQgo7uONSZsF6mTbjSrs9pVHjcsKXflIp5Hgq2C1UzYv_0DokNaditP7O8vsRQooxPRL6PjwL-MATkW9l-R9Qb-eHrSk6kcwsOBDBnITSNqu2DRvXI7o88J2AYzPBl2yr-Uw9T1wHVb_AVfN4raVKuhzR84KlhjF6xJE7kwmmokT=w1378-h775-no)
### Sign up 
![Sign up](https://lh3.googleusercontent.com/lhY4Q9tHwFZC2ebRuBBkf-sHCkzS7SRFYgWVfhS-3K0OrtTQDzHKYNgCaWjmJ_JhdZbjH3SOgMJ2tyOjwK1teyk75gMC6IXOhi7PflBACqNk556jpv7ZI-IMQD7nUcDAKtps6blHIkLWVJTchkpUuBAe1I5ZYe4hyWUZZTEJizIKye7w1iGYhHIdFGV3qzTIfBkBk1owSf1vOQLRRgSVnE9P006HZn_SIW6NY8kTKKw2M-tir0nzUfpUUNcU5jKF8sJXP5ekX6z4s2rju0y5PhIC1hANFDQXQBpKRTQBFc3fmVpWHqYmvMaWWmzETB2xnp8pWoqrAL12ap38-pJjVFx55Bn1CVo9AuMkoAMQ77Bas5GFVCTDX7MBqHmzDm6iyJUkQtMg9-zmWplJEapa9KEPpgrBMsoObUOQMXEDJJxXCKbUPSWk0iUmMS-oT-HX5l0J6hUiHT4uRXLkuAYu5lbN_ROTlM01_yvNowEj4NGwbSb1ZJQJAmmdPyDTPJkavkXzoNFF7qEsnzW00kMgP4ruvtckFFwmVXvNHaO5z2onTDiuLHmBi5a2ns7YHNH4snULA959V3HhrH41omr33B4GmuLw7KOt4Uqar75zvFXC2969hCqaNr_T2_nhEDPMYxn7PnljBUvlQvZbuTs0uFVhILnYukS_4fbkDYzSwOWCgXCe7m8vTS3teHxW4Y_MPiDP70y5TDNnBRYkPRdq256H=w1378-h775-no)
### Dashboard 
![Dashboard](https://lh3.googleusercontent.com/H1RTumkC6rQiW7lRFVALNhNTGCp9u933G6ZLX-TRHV3ofcWcntFqgaPpK4x8jiVrKyWHzSTVk1JYeHlvNngHBWKqwWScBBbkW9SQHBBdEZKwJoj2PfEm7w5ZIfgGHfg73OGtingK_q2O-uJdNhwDraMUXWdK8JJpVqmhC4JxZJ1IQ4mtAusdDgjlkpmQc-L-nSP9hetP1EuRqiizn_1WC_6HJkmrpxxXyOwrDNYIqbNFIl_KBINJFSy1Ek6W6PslK4_CDNWkUuCvQ73eAs41LN5KC1eGAgD6t4xQ-Dq9WcrLqqF9tO1wEzJFcaXm8btTHNj1GriM3zi1bWyDMagfFRZZKHI_SMNaUdpqa1klUName3dgnKIHqiW6EsiPqjlneaDWqJlOOXAqt9v7fseETe5EZBAyw0MTXfsh1bvPANcKn8ErNP-ZPvCkPdcLTUNl_ayQKJZs7gaBIR2s4m4WM4FxzbXiW_DbWcDG4EcMY-GZYcS4E4xQ6YPfLSmgG_pHIlJtV6pm1CUTiSTzdrhcgAQdPO76JHQKatPcFanLfH-vwnoFYbjFiie5HxgES0IQk3z5lY4xj6vne2Mp3dsKaEcepsSPnhOBRp56AfRvLATELtgZvPCT3B_yNvYwXixzuiYekYWBvva4ekJD7XZntrm0dRaoezssJyrh62rBRyxKqMnggBfsz6xrU4UvSmYTX9UpdPLnziNK6Yb1ac57nS7A=w1378-h775-no)
