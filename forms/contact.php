<?php

require 'vendor/autoload.php'; // Include the MongoDB PHP Library

$receiving_email_address = 'contact@example.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

// MongoDB connection settings
$mongoClient = new MongoDB\Client("mongodb+srv://rddsdhanu:rddsdhanu@ecosaver.lk73zkm.mongodb.net/?retryWrites=true&w=majority");
$mongoDatabase = $mongoClient->selectDatabase('EcoSaver');
$mongoCollection = $mongoDatabase->selectCollection('users');

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'];
$contact->from_email = $_POST['email'];
$contact->subject = $_POST['subject'];

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
/*
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

// Add data to MongoDB collection
$data = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'subject' => $_POST['subject'],
    'message' => $_POST['message'],
];

$result = $mongoCollection->insertOne($data);

// Output the result (you may want to handle this differently based on your needs)
echo $result ? 'success' : 'error';
