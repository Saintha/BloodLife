<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace classes;

require_once '../classes/Campaign.php';
require_once  '../classes/district.php';
require_once  '../classes/User.php';
require_once  '../classes/Validation.php';

use classes\district;
use classes\campaign;
use classes\User;
use classes\Validation;


$status;
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset(
        $_POST["Title"],
        $_POST["address"],
        $_POST["startDate"],
        $_POST["endDate"],
        $_POST["district"],
        $_POST["division"],
        $_POST["status"],
        $_POST["token"],
        $_POST["campaignId"]
    )) {

        //empty value check
        if (
            !empty($_POST["Title"]) && ($_POST["address"]) && ($_POST["startDate"]) &&
            ($_POST["endDate"])  &&
            ($_POST["district"]) && ($_POST["division"]) && ($_POST["token"]) && ($_POST["status"]) && ($_POST["campaignId"])
        ) {

            // sanitizing the inputs

            $Title = filter_var($_POST['Title'], FILTER_SANITIZE_STRING);
            $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
            $startDate = filter_var($_POST['startDate'], FILTER_SANITIZE_STRING);
            $endDate = filter_var($_POST['endDate'], FILTER_SANITIZE_STRING);
            $district = filter_var($_POST['district'], FILTER_SANITIZE_STRING);
            $division = filter_var($_POST['division'], FILTER_SANITIZE_STRING);
            $Camstatus = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
            $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);
            $campaignId = filter_var($_POST['campaignId'], FILTER_SANITIZE_STRING);



            //create user object with token
            $user = new User(null, null, null, null, $token, null, null, null, null);

            //validations
            $validateName = Validation::validateLettersLength($Title, 6);
            $validateAddress = Validation::validateLettersLength($address, 6);
            $validateDates = Validation::validateChamDate($startDate, $endDate);
            $districtId = district::getDistrictIDDD($district, $division);

            $validateToken = $user->validateToken();
            $bloodBankId = $user->getBloodBankId();
            //$campaignId = $campaign->getcampaignId();
            
            //token and bloodbank id checking
            if ($validateToken && $bloodBankId != null) {


                //email,phonenumber,nic,dob,bloodgroup valitaion check
                if ($validateDates   && $validateName &&   $validateAddress) {


                    //create Campign object
                    $campaign  = new campaign($campaignId, $Title, $address, $startDate, $endDate, null, $Camstatus, $districtId, $bloodBankId);
                    $status = $campaign->EditCampaign() ? 1 : "An error occurred while Editing the campaign. Please Try again later.";
                    // echo $campaign->getAddress();        

                } else {
                    //check status for valitations
                    $status = !$validateDates ? "Invalid date format. Please use a valid date format.": (!$validateName ? "Invalid campaign name format. Please check the name." : (!$validateAddress ? "Invalid address format. Please check the address." : "Unknown validation error."));
                }
            } else {
                //status for not valid token
                $status = "Unauthorzied Activity! ";
            }
        } else {
            //status for empty value
            $status = "All Fields need to be Filled!";
        }
    } else {
        //status for isset value
        $status = "All Fields need to be Filled!";
    }
} else {

    echo "Invalid request method";
}

$encrptedmessage=validation::encryptedValue($status);
header("Location: ../Dashboards/BloodBankDashboard.php?status=$encrptedmessage");




