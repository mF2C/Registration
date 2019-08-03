package Identification;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import javax.ws.rs.GET;
import javax.ws.rs.Path;

@Path("requestID")
public class DeviceID
{
    final String file = "/data/IDs.f2c";

    @GET
    public String DeviceID()
    {
        boolean fileExists = validateFile();
        if (fileExists)
        {
            String[] IDs = getIDs();
            if (validateID(IDs[1]) && validateID(IDs[2]))
            {
                return "{\"status\": \"200\", \"CIMIUsrID\":\""+IDs[0]+"\", \"IDKey\": \""+IDs[1]+"\", \"deviceID\": \""+IDs[2]+"\"}";
            }
            else
            {
                return "{\"status\": \"412\", \"message\": \"IDKey or DeviceID do not meet the expected format\"}";
            }
        }
        else
        {
            return "{\"status\": \"412\", \"message\": \"File with the agent IDs does not exist\"}";
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
    
    //Returns an array with [1]IDKey and [2]DeviceID
    private String[] getIDs()
    {
        String[] IDs = new String[3];
        try
        {
            IDs[0] = Files.readAllLines(Paths.get(file)).get(0);
            IDs[1] = Files.readAllLines(Paths.get(file)).get(1);
            IDs[2] = Files.readAllLines(Paths.get(file)).get(2);
        }
        catch (IOException e)
        {
            IDs[0] = IDs[1] = "error";
        }
        return IDs;
    }
    
    //Validates if the obtained id meets the expected format
    private boolean validateID(String id)
    {
        if (id.length() != 128)
        {
            return false;
        }
        else
        {
            boolean format = id.matches("\\p{XDigit}+");
            if (format)
                return true;
            else
                return false;
        }
    }
}
