function serviceRegistration()
{
    window.location = 'scripts/services/php/service_registration.php';
}

function registerService(){

    var name = document.getElementById("name").value;
    var description = document.getElementById("description").value;
    var exec = document.getElementById("exec").value;
    var exec_type = document.getElementById("exec_type").value;
    var exec_ports = document.getElementById("exec_ports").value;
    var cpu = document.getElementById("cpu").value;
    var memory = document.getElementById("memory").value;
    var storage = document.getElementById("storage").value;
    var inclinometer = $("#inclinometer").is(":checked");
    var temperature = $("#temperature").is(":checked");
    var jammer = $("#jammer").is(":checked");
    var location = $("#location").is(":checked");
    var battery = $("#battery").is(":checked");
    var door = $("#door").is(":checked");
    var pump = $("#pump").is(":checked");
    var accelerometer = $("#accelerometer").is(":checked");
    var humidity = $("#humidity").is(":checked");
    var pressure = $("#pressure").is(":checked");
    var ir_motion = $("#ir_motion").is(":checked");

    var serviceJson = JSON.stringify({
        name: name,
        description: description,
        exec: exec,
        exec_type: exec_type,
        exec_ports: [exec_ports],
        category :{
            cpu: cpu,
            memory: memory, 
            storage: storage,
            inclinometer: inclinometer,
            temperature: temperature,
            jammer: jammer,
            location:location,
            battery_level:battery,
            door_sensor:door,
            pump_sensor:pump,
            accelerometer:accelerometer,
            humidity:humidity,
            air_pressure:pressure,
            ir_motion:ir_motion
        }
    });

    createService(serviceJson);
}

function createService(service)
{
    try
    {
        var code = null;
        $.ajax
        ({
            data: {service : service},
            url:   "../php/cimi_register_service.php",
            type:  "POST",
            async: false, 
            success: function(ans)
            {
                code = ans;
            }
        });
        if (code==201){
        	alert("service registered correctly");
        	window.location.href = "../../../index.php";
        } else{
        	alert("Please, fill the fields correctly");
        }

        return code;
    }
    catch (e){return 0;}
}

function registerServiceCancel(){
	window.location.href = "../../../index.php";
}

window.onload=function(){
    execTypeFunction();
};

function execTypeFunction() {
    var type = document.getElementById("exec_type").value;
    if(type == "docker"){
        document.getElementById("exec_ports").disabled = false;
    } else {
        document.getElementById("exec_ports").disabled = true;
        document.getElementById("exec_ports").value = "";
    }
}


