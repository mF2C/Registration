# Registration and Identification

The registration is the process by which a user subscribe to a service, in this case, to the **mF2C System**.  In mF2C, when talking about registration, reference is made to the creation of a user account that allows to access to the pool of resources and services offered in the whole mF2C environment. Since the registration is a requirement to join to the mF2C network, it can be said that it is the first interaction that users have with the system. 

On the other hand, the identification is the set of techniques and procedures aiming at managing the identifiers of a given set of entities. In the scope of this work, special attention is given to the management of the identities of the users and the devices they use in the mF2C network. An effective management of both sets of identifiers will allow a better management of the available network resources, for example through the implementation of machine learning algorithms aiming at predicting the offer and demand in a given period of time and zone. In the same way, a proper identification of users in system will facilitate the tasks of detecting and stopping malicious behavior in the network.


## Relationship between registration and identification in mF2C
All accounts created and activated will gain access to the dashboard. From there, users will be able to download the docker-compose file (a YAML file that defines multi-container apps). The docker-compose file includes two environment variables in the identification section: the mF2C username and password. these variables are used to read from the host computer the user credentials, thus, user should export them before executing the agent.

Using the user credentials, the identification module will acquire both, the IDKey (aka user identifier) and the deviceID the first time that the agent is executed in a new device. Both identifiers will be assigned by a support Webservice and will be made available for the other agent modules.

Figure 1 shows the sequence  diagram and the interactions between the identification module, the registration Webpage and the support Webservice.
![Sequence DIagram for the Registration and Identification Components](https://lh3.googleusercontent.com/oUHPofFS3tLpYjc_sZNz_-9Rr4R_atqklZEOHkgSL8SGm-AiNKtXCHl8nQgDLx2sMnwSxwMs-_VJuezpn_FGYfwoKK_naaq96KYLts_CeTPfm707EgyiECFDJNlPpzR_QuJSKLR5drbeESUldy0HpiCY6Q5dIzhEdW0VbZ8fub_LFg4e6ZoMT0o5lj1agilptta0fzOwps9Ec5Ouyo8nVWSK2_C8t-qOIJ2heoKQO-ZkyGdJLi5H8neIWdtJOzO1EjxGC0wGDTEm9B1fB2y4OoxQwu66pwabvbnN4ADeKY9DI2E7Z7-dzanLCaW-rDYlqoPka9bAR1sNWIBzmOoKJ7fP-fEe9SbKxLSNajmtCup6O0MbRlLedZ9JSrEszok0RDMoAg8TklahBTbldjzb3Yq1sHc1SKMrku5JDIQYGNRZruqyVu3j6EGzKWaX50f_oYlinFbLKgBDmBP0mN3FXlGAB8XIC5Jzbj02G1AhZwH8jDc4kM9RpX2xUM6kTj4nJH6ZnxaRHVaqPH9fXH0uSBmTwkpHIY0ZqAioFkqUoaobS6ejJOm6ni_jJUvczJaIEvpyAfHc6pnhXxN2oaLEUFpIQi6wJpMwPkgTZionbzHOCEJPMFwmpnNt9RZ03sVTXWEAIgLMYfyTR52WVJZ48QQcrF7VfJURLsHvbzEXgKOI7tRjUO1Dz-b4HxdozJBMsIFNUJFRFl86tv4vzK4huHLa=w942-h657-no)


## Project content
The following links redirect to each of the three components previously described. More detailed information about the usage, inputs and outputs can be found in each of the links:
 - **[Registration Website](https://github.com/mF2C/Registration-Identification/tree/master/Registration%20Website)**.
 Dashboard from where users will create their user accounts and download the docker-compose file that will deploy the agent in their devices. 
 - **[Support Webservice](https://github.com/mF2C/Registration-Identification/tree/master/Support%20Webservice)**.
 Web service responsible for assigning unique identifiers to both users and devices.
 - **[Identification Module](https://github.com/mF2C/Registration-Identification/tree/master/Identification%20Module)**. 
Module responsible for obtaining and sharing the user and the device IDs with other modules within the agent. 
