unset(@@__ERROR__);
function clean($value){
 $title = str_replace( array( '\'', '/','<','!','&','|','$','*',';','^','%','-','#','@','=','~',']','[','{','}','','"','>','_' ), '', $value);
 
return $title;
 }
$field_72 = @@additional_field;
//trim field 72 to 35 lenght
$field_lenght = strlen(@@additional_field);
if($field_lenght > '35'){
$field_72 = substr(@@additional_field,0,35);
$field_721 = substr(@@additional_field,35);
}

$routing_no = '';
//to get routing number
if(@@sort_code != ''){
$routing_no = "//SC".@@sort_code;
}else if(@@beneficiary_aba != ''){
$routing_no = @@beneficiary_aba;
}else if (@@bank_routing_no != ''){
$routing_no = "//FW".@@bank_routing_no;
}

//Trim length of beneficiary name 
$beneficiary_name = @@beneficiary_name;
$length = strlen($beneficiary_name);
if ($length > 35){
$beneficiary_name = substr(@@beneficiary_name,0 ,35);
$beneficiary_name1 = substr(@@beneficiary_name,35);
}

//Trim beneficiary address
//beneficiary_address
$beneficiary_address = @@beneficiary_address;
$length = strlen($beneficiary_address);
if ($length > 35){
$beneficiary_address = substr(@@beneficiary_address,0 ,35);
}


$year = substr(accessBank_getCurrentYear(),2);
$current_month=substr(accessBank_getCurrentMonth(), 0, 2);
$day = substr(accessBank_getCurrentDay(),0,2);
$nostro_account = @@nostro_account;
//@@transfer_purpose = substr(@@transfer_purpose,0,35);
if(strlen(@@transfer_purpose) > 105){
$transferp1 = substr(@@transfer_purpose,0,35);
$transferp2 = substr(@@transfer_purpose,35,35);
$transferp3 = substr(@@transfer_purpose,70,35);
$transferp4 = substr(@@transfer_purpose,105,35);
}
else if (strlen(@@transfer_purpose) > 70){
$transferp1 = substr(@@transfer_purpose,0,35);
$transferp2 = substr(@@transfer_purpose,35,35);
$transferp3 = substr(@@transfer_purpose,70,35);
}
else if (strlen(@@transfer_purpose) > 35){
$transferp1 = substr(@@transfer_purpose,0,35);
$transferp2 = substr(@@transfer_purpose,35,35);
}
else if (strlen(@@transfer_purpose) <= 35){
$transferp1 = @@transfer_purpose;
}
$date = $year.$current_month.$day;
$transfer_amount = str_replace('.', ',', @@transfer_amount,$count);

    if ($count == 0) {
        $transfer_amount = @@transfer_amount.",00";
    }

$offshore_charge=@@offshore_charge;

if($offshore_charge == '0') {
$charges = 'OUR';
} 
else {
   $charges = 'SHA';
}
//To get Bic code and mirror account;
$query = "SELECT * FROM PMT_NOSTRO_OFFSHORE_ACCTS_NEW WHERE ACCOUNT_NUMBER ='$nostro_account'";
$result=executeQuery($query) or die("Error in query: $query");


$bic_code = @@bic_code = $result[1]['SWIFT_CODE'];
$mirror_account = $result[1]['NOSTRO_ACCOUNT'];
//$mirror_account = $result[1]['NOSTRO_ACCOUNT'];
$telex_msg= "";
$telex_msg = $telex_msg."{1:F01ABNGNGLAAXXX1111111111}";
$telex_msg = $telex_msg."{2:I103".$bic_code."XXXXN}";
$telex_msg = $telex_msg."{4:\n";
//$telex_msg = $telex_msg."To Institution CITIUS33XXXX\n";
//$telex_msg = $telex_msg.@@nostro_account_label."\n";
//$telex_msg = $telex_msg.@@customer_category_label." N\n:20:";
$telex_msg = $telex_msg.":20:".@@reference."\n";
$telex_msg = $telex_msg.":23B:CRED\n";
$telex_msg = $telex_msg.":32A:";
$telex_msg = $telex_msg.$date.@@customer_currency;
$telex_msg = $telex_msg.$transfer_amount;
$telex_msg = $telex_msg."\n:50K:";
$telex_msg = $telex_msg."/".@@account_number."\n";
$telex_msg = $telex_msg.clean(@@customer_name)."\n";
$telex_msg = $telex_msg.trim(clean(@@address))."\nNIGERIA\n:53B:/";
$telex_msg = $telex_msg.$mirror_account."\n";
if (@@intermediary_check_label == 'true'){
$telex_msg = $telex_msg.":56A:".@@intermediary_swiftcode."\n";
}
if (@@swift_code != ''){
$telex_msg = $telex_msg.":57A:";
	if($routing_no != ''){
	$telex_msg = $telex_msg.trim($routing_no)."\n";
	}
$telex_msg = $telex_msg.trim(@@swift_code)."\n";
}else{
	$telex_msg = $telex_msg.":57D:";
	if($routing_no != ''){
	$telex_msg = $telex_msg.trim($routing_no)."\n";
	}
$telex_msg = $telex_msg.clean(@@beneficiary_bank)."\n";
}
$telex_msg = $telex_msg.":59:";
if(@@beneficiary_account != ''){
$telex_msg = $telex_msg."/".trim(@@beneficiary_account)."\n";
}else{
$telex_msg = $telex_msg."/".trim(@@iban_number)."\n";
}
if($beneficiary_name1 == ''){
$telex_msg = $telex_msg.clean($beneficiary_name)."\n";
}else{
$telex_msg = $telex_msg.clean($beneficiary_name)."\n";
$telex_msg = $telex_msg.clean($beneficiary_name1)."\n";
}
if ($beneficiary_address != ''){
$telex_msg = $telex_msg.clean($beneficiary_address)."\n";
}
$telex_msg = $telex_msg.":70:";
if($transferp2 == ''){
$telex_msg = $telex_msg.clean($transferp1)."\n";
}
else if ($transferp3 == ''){
$telex_msg = $telex_msg.clean($transferp1)."\n";
$telex_msg = $telex_msg.clean($transferp2)."\n";
}
else if ($transferp4 == ''){
$telex_msg = $telex_msg.clean($transferp1)."\n";
$telex_msg = $telex_msg.clean($transferp2)."\n";
$telex_msg = $telex_msg.clean($transferp3)."\n";
}
else{
$telex_msg = $telex_msg.clean($transferp1)."\n";
$telex_msg = $telex_msg.clean($transferp2)."\n";
$telex_msg = $telex_msg.clean($transferp3)."\n";
$telex_msg = $telex_msg.clean($transferp4)."\n";
}
//$telex_msg = $telex_msg.clean(@@transfer_purpose)."\n";
$telex_msg = $telex_msg.":71A:";
$telex_msg = $telex_msg.$charges."\n";
if($field_72 != ''){
$telex_msg = $telex_msg.":72:";
if($field_721 == ''){
$telex_msg = $telex_msg."//".clean($field_72)."\n";
}else{
$telex_msg = $telex_msg."//".clean($field_72)."\n";
$telex_msg = $telex_msg."/".clean($field_721)."\n";
}
}
$telex_msg = $telex_msg."-}";
@@telex_msg = $telex_msg;