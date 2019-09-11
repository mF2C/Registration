package Identification;

import java.io.File;
import java.io.PrintWriter;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.ClientBuilder;
import javax.ws.rs.client.Entity;
import javax.ws.rs.client.WebTarget;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import org.json.JSONObject;

@Path("registerDevice")
public class RegisterDevice
{
    final String wsURL_Credentials = "http://dashboard.mf2c-project.eu:8000/ResourceManagement/Identification/GetDeviceID";
    final String file = "/data/IDs.f2c";
    
    @POST
    public String RegisterDevice(String input)
    {
        boolean fileExists = validateFile();
        if (fileExists)
            return "{\"status\": \"412\", \"message\": \"File with the agent IDs already exists\"}";
        else
        {
            String[] Credentials = getCredentials();
            if (Credentials[0].equals("error")|| Credentials[1].equals("error"))
                return "{\"status\": \"204\", \"message\": \"impossible to read user credentials from the environment variables\"}";
            else
            {
                if (!validateCredentials(Credentials))
                {
                    return "{\"status\": \"400\", \"message\": \"Invalid user credentials (too short)\"}";
                }
                else
                {
                    try
                    {
                        String arg = "{\"usr\":\""+Credentials[0]+"\",\"pwd\":\""+Credentials[1]+"\"}";
                        Client client = ClientBuilder.newClient();
                        WebTarget target = client.target(wsURL_Credentials);
                        Response response = target.request().post(Entity.entity(arg, MediaType.APPLICATION_JSON));
                        try
                        {
                            if (response.getStatus() != 200)
                                return "{\"status\": \"500\", \"message\": \"Failed with HTTP error code: "+response.getStatus()+"\"}";
                            else
                            {
                                JSONObject jsonObj = new JSONObject(response.readEntity(String.class));
                                String status = jsonObj.getString("status");
                                if (!status.equals("201"))
                                {
                                    String message = jsonObj.getString("message");
                                    return "{\"status\": \""+status+"\", \"message\": \"" + message + "\"}";
                                }
                                else
                                {
                                    String CIMIUsrID = jsonObj.getString("CIMIUsrID");
                                    String IDKey = jsonObj.getString("IDKey");
                                    String deviceID = jsonObj.getString("deviceID");
                                    boolean saved = saveFile(CIMIUsrID, IDKey, deviceID);
                                    if (saved)
                                        return "{\"status\": \"201\", \"message\": \"Agent IDs have been saved\"}";
                                    else
                                        return "{\"status\": \"500\", \"message\": \"Unable to save the file with the agent IDs\"}";
                                }
                            }
                        }
                        finally
                        {
                            response.close();
                            client.close();
                        }
                    }
                    catch (Exception e)
                    {
                        return "{\"status\": \"500\", \"message\": \"Error: "+e+"\"}";
                    }
                }
            }
        }
    }
    
    //Validates if the files with the IDs already exists
    private boolean validateFile()
    {
        File f = new File(file);
        if (f.exists())
            return true;
        else
            return false;
    }
    
    //Validates if the obtained credentials meets the expected format 
    private boolean validateCredentials(String[] Credentials)
    {
        if ((Credentials[0].length() <= 7) || (Credentials[1].length() <= 7))
            return false;
        else
            return true;
    }
    
    //Saves the file with the CIMIUsrID, IDKey and deviceID
    private boolean saveFile(String CIMIUsrID, String IDKey, String deviceID)
    {
        try
        {
            PrintWriter writer = new PrintWriter(file, "UTF-8");
            writer.println(CIMIUsrID);
            writer.println(IDKey);
            writer.println(deviceID);
            writer.close();
            return true;
        }
        catch (Exception e)
        {
            return false;
        }
    }
    
    //Gets the user credentials from the system environment
    private String[] getCredentials()
    {
        String[] credentials = new String[2];
        try
        {
            credentials[0] = System.getenv("usr");
            credentials[1] = System.getenv("pwd");
            if (credentials[0].equals("") || ((credentials[1].equals(""))))
                credentials[0] = credentials[1] = "error";
        }
        catch (Exception e)
        {
            credentials[0] = credentials[1] = "error";
        }
        return credentials;
    }
}
