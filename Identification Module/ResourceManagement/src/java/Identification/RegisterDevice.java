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
    final String wsURL_CIMIUsrID = "http://dashboard.mf2c-project.eu:8000/ResourceManagement/Identification/RegisterDevice/";
    final String wsURL_Credentials = "http://dashboard.mf2c-project.eu:8000/ResourceManagement/Identification/GetDeviceID";
    final String file = "/data/IDs.f2c";
    
    @POST
    public String RegisterDevice(String input)
    {   
        try
        {
            //Try to process the json input
            //If something fails, it means that there is not json input
            //convert input String to JSON
            JSONObject obj = new JSONObject(input);
            //Get the user and password values
            String usr = obj.getString("usr").replaceAll("\\s+","");
            String pwd = obj.getString("pwd").replaceAll("\\s+","");
            boolean fileExists = validateFile();
            if (fileExists)
                return "{\"status\": \"412\", \"message\": \"File with the agent IDs already exists\"}";
            else
            {
                //Validate the obtained user and password
                if ((usr.equals("")) || (pwd.equals("")))
                    return "{\"status\": \"400\", \"message\": \"Invalid user credentials (empty field)\"}";
                else
                {
                    if ((usr.length() < 8) || (pwd.length() < 8))
                        return "{\"status\": \"400\", \"message\": \"Invalid user credentials (too short)\"}";
                    else
                    {
                        try
                        {
                            String arg = "{\"usr\":\""+usr+"\",\"pwd\":\""+pwd+"\"}";
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
                            //return "{\"status\": \"500\", \"message\": \"An unexpected error has occurred\"}";
                            return "{\"status\": \"500\", \"message\": \"Error: "+e+"\"}";
                        }
                    }
                }
            }
        }
        catch(org.json.JSONException jsonException)
        {
            //execute this when the code fails to read the json input
            //That means there is no input and therefore, the CIMIUsrID will be used to register the device
            boolean fileExists = validateFile();
            if (fileExists)
                return "{\"status\": \"412\", \"message\": \"File with the agent IDs already exists\"}";
            else
            {
                String CIMIUsrID = getCIMIUsrID();
                if (CIMIUsrID.equals("error"))
                    return "{\"status\": \"204\", \"message\": \"impossible to read env variable CIMIUsrID\"}";
                else
                {
                    boolean CIMIUsrIDValid = validateCIMIUsrID(CIMIUsrID);
                    if (!CIMIUsrIDValid)
                        return "{\"status\": \"412\", \"message\": \"The CIMIUsrID does not meet the expected format\"}";
                    else
                    {
                        try
                        {
                            Client client = ClientBuilder.newClient();
                            WebTarget target = client.target(wsURL_CIMIUsrID + CIMIUsrID);
                            String ans = target.request(MediaType.APPLICATION_JSON).get(String.class);
                            JSONObject jsonObj = new JSONObject(ans);
                            String status = jsonObj.getString("status");
                            if (!status.equals("201"))
                            {
                                String message = jsonObj.getString("message");
                                return "{\"status\": \""+status+"\", \"message\": \"" + message + "\"}";
                            }
                            else
                            {
                                String IDKey = jsonObj.getString("IDKey");
                                String deviceID = jsonObj.getString("deviceID");
                                boolean saved = saveFile(CIMIUsrID, IDKey, deviceID);
                                if (saved)
                                    return "{\"status\": \"201\", \"message\": \"Agent IDs have been saved\"}";
                                else
                                    return "{\"status\": \"500\", \"message\": \"Unable to save the file with the agent IDs\"}";
                            }
                        }
                        catch (Exception e)
                        {
                            return "{\"status\": \"500\", \"message\": \"An unexpected error has occurred\"}";
                        }
                    }
                }
            }
        }
        catch (Exception e)
        {
            //Other exceptions
            return "{\"status\": \"400\", \"message\": \"Unknown exception. Please contact the system administrator\"}";
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
    
    //Validates if the obtained CIMIUsrID meets the expected format 
    private boolean validateCIMIUsrID(String CIMIUsrID)
    {
        if (CIMIUsrID.length() <= 7)
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
    
    //Gets the CIMIUsrID from the system environment
    private String getCIMIUsrID()
    {
        String CIMIUsrID = "";
        try
        {
            CIMIUsrID = System.getenv("CIMIUsrID");
            if (CIMIUsrID.equals(null))
                CIMIUsrID = "error";
        }
        catch (Exception e)
        {
            CIMIUsrID = "error";
        }
        return CIMIUsrID;
    }
}
