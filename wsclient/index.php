<?php
require_once '../wsserver/lib/nusoap.php';

$client = new nusoap_client("http://php-basic-soap.dev/wsserver/soap/service.php?wsdl");

$error = $client->getError();

if ($error) {
    echo "<h2>Constructor Error</h2>";
    echo "<pre>{$error}</pre>";
}

function clientTestCall($soapClient, $serviceName, $paramArray) {
    $result = $soapClient->call("$serviceName", $paramArray);

    if ($soapClient->fault) {
        echo "<h2>Fault</h2>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } else {
        $error = $soapClient->getError();
        if ($error) {
            echo "<h2>Response Error</h2>";
            echo "<pre>{$error}</pre>";
        } else {
            echo "<h2>Success: Data</h2>";
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }
}

clientTestCall($client, "getAllCourses", []);
echo "<hr>";
clientTestCall($client, "getCourse", ['id' => 2]);
echo "<hr>";
clientTestCall($client, "getCourseByCode", ['code' => '01418103']);
echo "<hr>";
clientTestCall($client, "getCourseByCode", ['code' => '']);
echo "<hr>";
clientTestCall($client, "getCourseByCode", ['code' => '01418xxx']);
