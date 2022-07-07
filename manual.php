<?php

/* * ********************************************************************
 * 
 * Copyright (c) DomainRegister, PERSOLVO d.o.o. -  All Rights Reserved 
 * 
 * 
 *
 *  DomainRegister        https://domainregister.international
 *  CONTACT                        ->       support@domainregister.it
 *
 *  github: https://github.com/DomainRegister
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 *      software version 1.00
 *      software release 20190718a
 * ******************************************************************** */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}




use Illuminate\Database\Capsule\Manager as Capsule;



function manual_getConfigArray() {
    $configarray = array(
     "FriendlyName" => array("Type" => "System", "Value"=>"Manual Registrar"),
     "Description" => array("Type" => "System", "Value"=>"This module can be used for any TLDs that have no integrated registrar; will create a to do item for any required operation"),
    );
    return $configarray;
}




function manual_GetNameservers($params) {
    global $CONFIG;
    $namesrv = dns_get_record($params["sld"].".".$params["tld"], DNS_NS);
    return array(
        
            'ns1' => $namesrv[0][target],
            'ns2' => $namesrv[1][target],
            'ns3' => $namesrv[2][target],
            'ns4' => $namesrv[3][target],
            'ns5' => $namesrv[4][target],
        );
}






function manual_SaveNameservers($params) {
    global $CONFIG;
    $title = "Save Nameservers ".$params["sld"].".".$params["tld"];
    $message = "Domain:".$params["sld"].$params["tld"]."\nRegistration Period: ".$params["regperiod"]."\nNameserver 1: ".$params["ns1"]."\n
Nameserver 2: ".$params["ns2"]."\n
Nameserver 3: ".$params["ns3"]."\n
Nameserver 4: ".$params["ns4"]."\n
Nameserver 5: ".$params["ns5"]."\n"
;
  
    createtodoitem($title, $message);
}




function manual_RegisterDomain($params) {
    global $CONFIG;
    $title = "Register Domain ".$params["sld"].".".$params["tld"];
    $message = "Domain: ".$params["sld"].".".$params["tld"]."\nRegistration Period: ".$params["regperiod"]."\nNameserver 1: ".$params["ns1"]."\nNameserver 2: ".$params["ns2"]."\nNameserver 3: ".$params["ns3"]."\nNameserver 4: ".$params["ns4"]."\nRegistrantFirstName: ".$params["firstname"]."\nRegistrantLastName: ".$params["lastname"]."\nRegistrantOrganizationName: ".$params["companyname"]."\nRegistrantAddress1: ".$params["address1"]."\nRegistrantAddress2: ".$params["address2"]."\nRegistrantCity: ".$params["city"]."\nRegistrantStateProvince: ".$params["state"]."\nRegistrantCountry: ".$params["country"]."\nRegistrantPostalCode: ".$params["postcode"]."\nRegistrantPhone: ".$params["phonenumber"]."\nRegistrantEmailAddress: ".$params["email"]."\nAdminFirstName: ".$params["adminfirstname"]."\nAdminLastName: ".$params["adminlastname"]."\nAdminOrganizationName: ".$params["admincompanyname"]."\nAdminAddress1: ".$params["adminaddress1"]."\nAdminAddress2: ".$params["adminaddress2"]."\nAdminCity: ".$params["admincity"]."\nAdminStateProvince: ".$params["adminstate"]."\nAdminCountry: ".$params["admincountry"]."\nAdminPostalCode: ".$params["adminpostcode"]."\nAdminPhone: ".$params["adminphonenumber"]."\nAdminEmailAddress: ".$params["adminemail"]."";
    createtodoitem($title, $message);

}





function manual_TransferDomain($params) {
    global $CONFIG; 
    $title = "Transfer Domain";
    $message = "Domain: ".$params["sld"].".".$params["tld"]."\nRegistration Period: ".$params["regperiod"]."\nTransfer Secret: ".$params["transfersecret"]."\nRegistrantFirstName: ".$params["firstname"]."\nRegistrantLastName: ".$params["lastname"]."\nRegistrantOrganizationName: ".$params["companyname"]."\nRegistrantAddress1: ".$params["address1"]."\nRegistrantAddress2: ".$params["address2"]."\nRegistrantCity: ".$params["city"]."\nRegistrantStateProvince: ".$params["state"]."\nRegistrantCountry: ".$params["country"]."\nRegistrantPostalCode: ".$params["postcode"]."\nRegistrantPhone: ".$params["phonenumber"]."\nRegistrantEmailAddress: ".$params["email"]."";
    createtodoitem($title, $message);
}




function manual_RenewDomain($params) {
    global $CONFIG;
    $title = "Renew Domain";
    $message = "Domain: ".$params["sld"].".".$params["tld"]."\nRegistration Period: ".$params["regperiod"]." needs to be renewed.\n";
    createtodoitem($title, $message);
}

function manual_TransferSync($params) {
    global $CONFIG;
    $title = "check domain transfer";
    $message = "Domain: ".$params["sld"].".".$params["tld"]."\ncheck transfer status\n";
    createtodoitem($title, $message);
}



function createtodoitem ($title, $message) {
    try {
    //key value pair.
    $insert_array = [
        "title" => $title,
        "date" => date("Y-m-d"),
        "description" => $message,
        "status" => "New",
        "duedate" => date("Y-m-d"),
    ];
    Capsule::table('tbltodolist')
        ->insert($insert_array);
} catch(\Illuminate\Database\QueryException $ex){
    echo $ex->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}

}

