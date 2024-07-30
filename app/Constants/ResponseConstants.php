<?php 

namespace App\Constants;


class ResponseConstants {
    // Failure response constants
    const FAILURE_MESSAGE = 'Operation failed';
    const FAILURE_STATUS_CODE = 400;
    const FAILURE_STATUS=false;

    // Success response constants
    const SUCCESS_MESSAGE = 'Operation successful';
    const SUCCESS_STATUS_CODE = 200;
    const SUCCESS_STATUS=true;
    const SUCCESSUPDATE_STATUS_CODE = 201;

    const PUBLIC_PATH='uploads';


}

?>