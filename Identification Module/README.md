# Identification Module

In mF2C, the identification module is the component in charge of acquiring the user and device unique identifiers (IDKey and deviceID) from the support Webservice (ws). The identification module will send the dashboard user credentials and after a sucessful validation, it will get in return both, the IDKey and the deviceID. Both IDs will be stored locally for future use.

This document describes the process to execute and use the **mF2C Identification module**.


## Requirements
The first requirement is to subscribe to the mF2C service with a service provider in the zone, it is, to *create a user account and activate it*.

The **mF2C identification module** is a component of the mF2C agent and since it depends on other components (such as [CIMI](https://github.com/mF2C/cimi) and [DataClay](https://github.com/mF2C/dataClay)), it must be executed in the order and with the parameters predefined in the docker-compose file, thus, *the docker-compose file* is another prerequirement.

> **Note:** In order to be able to execute the identification module, *the [docker CE](https://docs.docker.com/install/linux/docker-ce/ubuntu/#install-using-the-repository) and [docker-compose](https://docs.docker.com/compose/install/)* must to be previously installed in the system.

Finally, before executing the agent (or the identification module), it is necessary to create the *usr* and *pwd* environment variables. The *usr* variable should be assigned with the mF2C username and the *pwd* variable with the mF2C password value. These environment variables are created as follow:
```
export usr=mf2c_username
export pwd=mf2c_password
```

## Deployment
The identification module can be executed in coordination with the other agent modules (using the docker-compose file provided by the service provider) or, with the purpose of error debugging, in isolation. In both cases, the procedure is the same:
```
cd /path/to/docker-compose.yml
sudo docker-compose up
```
To execute the module in isolation, the content of the docker-compose file must be:
```
version: '3.1'
services:
	identification:
		image: mf2c/identification:latest
		container_name: identification
		volumes:
			- mydata:/data
		ports:
			- 46060:46060
volumes:
	mydata: {}
```

## Usage
Once the module has been initialized, two URIs will be exposed:
### API
- Endpoint `http://AGENT_ADDR:46060/api/v1/resource-management/identification/`
- POST `/registerDevice` -> acquire the IDKey and deviceID from the support Webservice. Returns operation status and error/success message
- GET `/requestID` -> returns the CIMIUsrID, IDKey and deviceID formatted as json
### Examples
#### Registering a new device
##### Query
```
POST /registerDevice
```
##### Output examples
For success
```
{
	"status":"201",
	"message":"Agent IDs have been saved"
}
```
For error
```
{
	"status*":"400",
	"message*":"Invalid user credentials (empty field)"
}
*This may vary according with the error
```
#### Request the IDKey and / or deviceID
##### Query
```
GET /requestID/
```
##### Output examples
For success
```
{
	"status":"200",
	"CIMIUsrID":"CIMI_Resource_Identifier",
	"IDKey":"User_IDKey",
	"deviceID":"Device_Identifier"
}
```
For error
```
{
	"status*":"412",
	"message*":"IDKey or DeviceID do not meet the expected format"
}
*This may vary according with the error
```