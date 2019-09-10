# Registration and Identification

The registration is the process by which a user subscribe to a service, in this case, to the **mF2C System**.  In mF2C, when talking about registration, reference is made to the creation of a user account that allows to access to the pool of resources and services offered in the whole mF2C environment. Since the registration is a requirement to join to the mF2C network, it can be said that it is the first interaction that users have with the system. 

On the other hand, the identification is the set of techniques and procedures aiming at managing the identifiers of a given set of entities. In the scope of this work, special attention is given to the management of the identities of the users and the devices they use in the mF2C network. An effective management of both sets of identifiers will allow a better management of the available network resources, for example through the implementation of machine learning algorithms aiming at predicting the offer and demand in a given period of time and zone. In the same way, a proper identification of users in system will facilitate the tasks of detecting and stopping malicious behavior in the network.


## Relationship between registration and identification in mF2C
All accounts created and activated will gain access to the dashboard. From there, users will be able to download the docker-compose file (a YAML file that defines multi-container apps). The docker-compose file includes two environment variables in the identification section: the mF2C username and password. these variables are used to read from the host computer the user credentials, thus, user should export them before executing the agent.

Using the user credentials, the identification module will acquire both, the IDKey (aka user identifier) and the deviceID the first time that the agent is executed in a new device. Both identifiers will be assigned by a support Webservice and will be made available for the other agent modules.

Figure 1 shows the sequence  diagram and the interactions between the identification module, the registration Webpage and the support Webservice.
![Sequence DIagram for the Registration and Identification Components](https://lh3.googleusercontent.com/mrsdeF3VGvqKDGopvk7wOprvjamNzOP3VYNZU_4BVhuIu-QL97Sv-qDw-ps97EamLwymRqRH3J1Hb2_LEx10MH9Kk1kr1k02Bc1iUb1rJY2izc5e4K-ky-2S-s7O190unh9VuPRje99vEN62rPyTfbGO_TuX19rzGp45-bUyhomxrffBAqiZy435WRctym2gA9fqpoTDguqRa9EzcEXo7LX8u6zD_Oi0vi5JlF60cPH4ibNM60TRGP6fqG7iIlbWLZF2LVHUPSz9eP75k14jd8Ireb2HZM8Vr2HatDGkT1GqbU3AS3HscH-l3XU5y1zHx3jyzJ-HZFAM-c34ahM_Z2NX6lXj_hBecbWpPHFYSbkgssAsgiRYykB0tO364mWIj31US_F9SO1d5C6jYIWJuTEMor74BxgVRd_oWMyLw5LwikVAwoYiMnoeGvQ0P_O5qRWz2hVIkojZS4JISGOOwknopxy7h0U4cDYMyTWTp0U4ibGFBb5Eaxj3-AP65cznWg7y0G48JH7_gOG_khW-MRMHHIhstEYKZNvw9S5sUbqrlSnX7onzBINW6M4pWTxt5QRlHAdotPsMGpn86lo7PjH1lwOSvDo8jyC2sCOhHRi18aN_3hPKJW3699BUWVjt_QwviALKZvXIO4Aw_bjDvMNMWdlT3lmVynQpBYzGY3_m8JPY2ImwwiiE11pk57RSmxUeOh7BZTCcwHHt9rwbUjiEerAkdcSB5xNHoFoABRd42JM=w1285-h897-no)


## Project content
The following links redirect to each of the three components previously described. More detailed information about the usage, inputs and outputs can be found in each of the links:
 - **[Registration Website](https://github.com/mF2C/Registration-Identification/tree/master/Registration%20Website)**.
 Dashboard from where users will create their user accounts and download the docker-compose file that will deploy the agent in their devices. 
 - **[Support Webservice](https://github.com/mF2C/Registration-Identification/tree/master/Support%20Webservice)**.
 Web service responsible for assigning unique identifiers to both users and devices.
 - **[Identification Module](https://github.com/mF2C/Registration-Identification/tree/master/Identification%20Module)**. 
Module responsible for obtaining and sharing the user and the device IDs with other modules within the agent. 
