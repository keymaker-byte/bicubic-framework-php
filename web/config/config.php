<?php

/**
 * Bicubic PHP Framework
 *
 * @author     Juan Rodríguez-Covili <juan@bicubic.cl>
 * @copyright  2011-2014 Bicubic Technology - http://www.bicubic.cl
 * @license    MIT
 * @version 3.0.0
 */
$config = array();
//Config
$config['maintenance'] = false;
$config['sslavailable'] = false;
//Web  
$config['web_name'] = "Bicubic PHP Framework";
$config['web_copyright'] = "©2014 Bicubic Technology - All rights reserved";
$config['web_contact_email'] = "";
$config['web_contact_name'] = "";
$config['web_time_out'] = 360000;
//Data Base values
$config['database_host'] = "localhost";
$config['database_database'] = "bicubic";
$config['database_user'] = "root";
$config['database_password'] = "root";
//Email with SMTP
$config['email_host'] = "ssl://smtp.gmail.com";
$config['email_port'] = 465;
$config['email_auth'] = true;
$config['email_user'] = "";
$config['email_password'] = "";
//Email with Mandrill
$config['email_key'] = "";
$config['email_template'] = "";
//Facebook
$config['appId'] = "";
$config['secret'] = "";
//Twitter
$config['twitterKey'] = "";
$config['twitterSecret'] = "";
//Foursquare
$config['foursquareKey'] = "";
$config['foursquareSecret'] = "";
//Instagram
$config['instagramKey'] = "";
$config['instagramSecret'] = "";
//Bitly
$config['bitlylogin'] = "";
$config['bitlyapikey'] = "";
//Google Cloud Storage
$config['gsutil'] = "gsutil";
$config['gsbucket'] = "gs://mystorage/";
$config['gsbucketprivate'] = "gs://mystorageprivate/";
$config['storage_folder'] = "http://storage.bicubic.cl/";
//Certificates for ios push notification
$config['certificate_private'] = "/.../server_certificates_bundle_sandbox.pem";
$config['certificate_auth'] = "/.../entrust_root_certification_authority.pem";

?>