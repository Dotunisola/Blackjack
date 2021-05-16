const fs = require("fs");


fs.exists("./dumb3.js", (value) => { 
    console.log(value)
})
function myDumb(x){
    if(x == 1) {
        console.log("where are you at the moment?");
    }
}

myDumb(1);


function accessBank_GetTransactionByReference($reference_no)
{
    $context = accessBank_getStreamContext();
    try{
        
        $params = array(
            "channel_code" => "PROCESSMAKER",
            "auth_key" => "EW46M@Fp03ohUv6vz&Grp!A16!",
            "reference_no" => $reference_no
        );

        $params = json_encode($params);

        $endpoint = "http://10.111.13.47:8746/AccessBankEnquiryServices/v1/GetTransactionByReference";
        $result = accessBank_restRequest("POST", $endpoint, $params, "application/json");

        return $result;

    }
    catch(Exception $e)
    {
        $returned_result = ["error" => ["status" => "Exception", "data" => $e->getMessage()]];
        return $returned_result;
    }
}
