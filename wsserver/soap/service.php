<?php
require_once '../lib/nusoap.php';
include_once '../models/Courses.php';



function getCourse($id=false) {
    $courses = new Courses();
    $data = $courses->getCourses($id);
    if (!is_null($data)) {
        return $data;
    } else {
        return new soap_fault('404', 'Server', 'Data not found.', "There is no data for '{$id}'.");
    }
}

function getAllCourses() {
    $courses = new Courses();
    $data = $courses->getCourses();
    if (!is_null($data)) {
        return $data;
    } else {
        return new soap_fault('404', 'Server', 'Data not found.', 'There is no data in database.');
    }
}

function getCourseByCode($code) {
    $courses = new Courses();
    if (!$code) {
        return new soap_fault('400', 'Client', 'Put your code!', 'Missing required parameters');
    } else {
        $data = $courses->getCourseByCode($code);
        if (!is_null($data)) {
            return $data;
        } else {
            return new soap_fault('404', 'Server', 'Data not found.', "There is no data for '{$code}'.");
        }
    }
}

$server = new soap_server();
$namespace = 'http://php-basic-soap.dev/wsserver/soap/service.php?wsdl';
$server->configureWSDL('GRADS_SOAP_Service', $namespace);
$server->wsdl->addComplexType(
    'Course',
    'complexType',
    'struct',
    'all',
    '',
    [
        'id' => ['name' => 'id', 'type' => 'xsd:int'],
        'code' => ['name' => 'code', 'type' => 'xsd:string'],
        'name' => ['name' => 'name', 'type' => 'xsd:string']
    ]
);

$server->wsdl->addComplexType(
    'CourseArray',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    [],
    [
        [
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:Course[]'
        ],
    ],
    'tns:Course'
);

$server->register("getCourse",
    ['id' => 'xsd:string', 'minOccurs' => 0],
    ['return' => 'tns:Course']
);
$server->register("getAllCourses",
    [],
    ['return' => 'tns:CourseArray']
);
$server->register("getCourseByCode",
    ['code' => 'xsd:string'],
    ['return' => 'tns:Course']
);
if (!isset($HTTP_RAW_POST_DATA))
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
$server->service($HTTP_RAW_POST_DATA);
exit();
