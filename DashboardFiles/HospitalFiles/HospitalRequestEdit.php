<?php


require_once '../classes/hospitalrequestclass.php';
require_once '../classes/Validation.php';
require_once '../classes/hospital.php';

use classes\hospitalrequestclass;
use classes\Validation;
use classes\hospital;

$hospitalid = $user->getHospitalId();
$hospital = new hospital($hospitalid, null, null, null, null);
$hospital->GetHospitalData($hospitalid);

// Check if the 'hospitalRequestID' parameter is set in the URL
if (isset($_GET['hreqid'])) {
    // Retrieve and store the 'hospitalRequestID' value
    $id = Validation::decryptedValue($_GET['hreqid']);






?>


    <!DOCTYPE html>
    <!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
    <html>

    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>

    <body>
        <!-- nav bar start -->
     <div class="sticky-top bg-white shadownav" style="height: 50px;">
                <div class="row m-0 d-flex">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                        <div class="row align-items-center justify-content-end">
                         
                            <div class="col-6 mt-2 	d-none d-xl-block ">
                                <b><?php echo $hospital->getName();  ?></b>
                                <p style="font-size: 10px;">Hospital</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- nav bar end -->

        <!-- body start -->
        <div class="mt-5 m-4 mb-2" style="color:gray;">
            <h5>Hospital Request Edit</h5>
        </div>

        <?php
        $datAarray = hospitalrequestclass::getRequestwithHospitalusingID($id);


        ?>

        <div class="row bg-white m-3 pt-0  align-items-center justify-content-center rounded-5" style="height: 500px;">
            <div class="form-container">

                <form action="../services/editrequest.php"  method="POST">
                    <label for="BloodGroup">BloodGroup:</label>
                    <select class="form-select" name="bloodGroup" aria-laquantitybel="Default select example" required>
                        <option value="<?php echo $datAarray["bloodGroup"]; ?>" selected><?php echo $datAarray["bloodGroup"]; ?></option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>

                    <label for="ExpiryDat">Date:</label>
                    <input type="date" class="form-control" name="expiryDate" value="<?php echo $datAarray["createdDate"]; ?>" required>
                    <label for="Quantity"> Blood Quantity:</label>
                    <input type="number" class="form-control" name="bloodQuantity" value="<?php echo $datAarray["bloodQuantity"]; ?>" maxlength="3" required>
                    <label for="status">Status:</label>

                    <select class="form-select" name="requestStatus" aria-laquantitybel="Default select example" required>
                        <option value="" selected></option>
                        <option value="<?php echo $datAarray["requestStatus"]; ?>" selected><?php echo $datAarray["requestStatus"]; ?></option>
                        <option value="Available">Normal</option>
                        <option value="Given">Emergency</option>
                        <option value="Expired">Urgent</option>
                    </select><br>

                    <input type="hidden" name="token" value="<?php echo $token; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                    <input type="hidden" name="hospitalRequestID" value="<?php echo $id; ?>" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                    <div class="text-end">
                    <button class="btn btn-outline-danger"><strong>Save</strong></button>
                    </div>

                </form>
            </div>
        </div>


    <?php
} else {
    echo "ID not found in the URL.";
}
    ?>
    </body>

    </html>