# Support Webservice

In mF2C, the support Webservice aims at providing an API that allows (i) to new devices to acquire both, the IDKey (also called user ID) and the deviceID and (ii) to validate whether a given IDKey is valid or not. Therefore, when a device executes the m2C agent for the first time, the local [Identification module](https://github.com/mF2C/Registration-Identification/tree/master/Identification%20Module), should contact the support Webservice and send the dashboard user credentials. Once this information is validated, the support Webservice will respond with the user IDKey and a deviceID that is unique in the scope of the mF2C network.

This document describes the process to deploy and use the **mF2C Support Webservice**.


## Requirements
The following list of packages are necessary to correctly execute all the functions in the support Webservice:
 - [apache2](https://packages.ubuntu.com/xenial/apache2)
 - [php7.0](https://packages.ubuntu.com/xenial/php7.0)
 - [php7.0-mbstring](https://packages.ubuntu.com/xenial/php7.0-mbstring)
 - [libapache2-mod-php](https://packages.ubuntu.com/xenial/libapache2-mod-php)
 - [curl](https://packages.ubuntu.com/xenial/curl)
 - [php-curl](https://packages.ubuntu.com/xenial/php-curl)

To install them, first update and upgrade the system
```
sudo apt-get update
sudo apt-get upgrade
```
Then, 
```
sudo apt-get install apache2 php7.0 php7.0-mbstring libapache2-mod-php curl php-curl -y
```
The support Webserver also makes uses of the [Composer](https://getcomposer.org/) reference manager for PHP. To install it, follow the indications detailed [here](https://getcomposer.org/download/). 

With composer installed, navigate to the folder that will host the Webserver and install the [Slim Framework](http://www.slimframework.com/).
> **Note:** In Ubuntu, the default path to the apache web folder is /var/www/. 
```
composer require slim/slim "^3.0"
```
Then, setup the [htaccess file](https://httpd.apache.org/docs/2.4/en/howto/htaccess.html) placed in the root of the Webserver files like this:
```
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule . index.php [L]
```
Finally, enable the rewrite mod and restart the apache Web server
```
sudo a2enmod rewrite
sudo service apache2 restart
```
> **Note:** If the support Webservice is installed on the same server as the registration Website, it is recommended to use a different port for the Webservice. See [here](https://httpd.apache.org/docs/2.4/vhosts/) for more information about how to configure more than one site in apache server.

## Deployment
Once the required packages have been installed, copy the "cimi" and "scripts" folders and the index.php file to the apache folder that will host the registration Website.
> **Note:** The Slim Framework files should be in the same folder. 

Then, set the [CIMI server](https://github.com/mF2C/cimi) endpoint in the endpoint.php file
```
nano /var/www/cimi/endpoint.php
```

## Usage
The support Webservice will expose two URIs:
### API
- Endpoint `http://CloudAgent_Addr:Port/ResouceManagement/Identification/`
- POST `/GetDeviceID`, DATA -> registers a new device using the dashboard user credentials and returns the CIMIUsrID, IDKey and deviceID formatted as json.
- POST `/validateIDKey`, DATA -> validates whether an IDKey is authorized or not and  returns operation status and error/success message formatted as json. 
### Examples
#### Registering a new device using the dashboard user credentials
##### Query
```
POST /GetDeviceID
DATA*:
	{
		"usr": "user_username",
		"pwd": "user_password"
	}
```
##### Output examples
For success
```
{
	"status":"201",
	"CIMIUsrID":"CIMI_Resource_Identifier",
	"IDKey":"User_IDKey",
	"deviceID":"Device_Identifier"
}
```
For error
```
{
	"status*":"412",
	"message*":"Invalid user credentials"
}
*This may vary according with the error
```
#### Validate a given IDKey
##### Query
```
POST /validateIDKey
DATA*:
	{
		"CIMIUsrID": "user_CIMIUsrID",
		"IDKey": "user_IDKey"
	}
```
##### Output examples
For success
```
{
	"status*":"202",
	"message*":"User is authorized"
}
```
For error
```
{
	"status*":"401",
	"message*":"User is unauthorized"
}
*This may vary according with the error
```
