<?php
//should be updated sync

//server host
define("SERVER_HOST","http://localhost/ajaxprism/");

define("SERVER_HOME","http://localhost/ajaxprism/");

define("SERVER","localhost");


//mysql host name
define("DB_HOST_NAME","localhost");

//mysql user name
define("USER_DB_USER_NAME","data_fetch");

//mysql user password
define("USER_DB_USER_PASSWORD","fire.Lock");

/**
 * static declarations
 *Note if you dont know how to handle these macros be sure you leave it unchanged
 */
//token-identifiers
define("ACTIVE_USER_NAME_IDENTIFIER","user_name");

define("ACTIVE_USER_TOKEN_IDENTIFIER","user_id");

define("HOST_MAILER_MAIL_ID","anandhumanoj282@gmail.com");

//encrypted
define("HOST_MAILER_MAIL_PASSWORD","xn4KxlTsIGehmO9lY/jfFw==");

define("SALT_PASSKEY","1234");

define("HOST_APP_NAME","Asthra 2k18");

define("EMAIL_HEADER_VERIFY","Confirm registration");
define("EMAIL_HEADER_RESET_PASSWD","Reset Password");


//userLevels

define("NAIVE_USER","PLVL01");

define("DATA_USER","PLVL02");

define("STD_USER","PLVL03");

define("ADVANCED_USER","PLVL04");

define("ADMIN_USER","PLVL05");

//data configurations

define("APP_NAME","HOST");

define("USER_DB_NAME","asthra_users");

define("RESOURCE_DB_NAME","asthra_users");

define("DATA_DB_NAME","asthra_users");

define("USER_DB_TABLE","tbl_users");

define("USER_DB_SANDBOX_TABLE","tbl_sandbox_user");

define("DATA_DB_TABLE","tbl_data");

define("DATA_DB_RESULT_TABLE","tbl_results");

define("DATA_DB_COLLEGE_TABLE","tbl_colleges");

define("DATA_DB_EVENT_TABLE","tbl_events");

define("RESOURCE_DB_MEDIA_TABLE","tbl_media");

//php files

define("FILE_PHP_CONFIG","config.php");
define("CLASS_PHP_REGISTER","Register.class.php");
define("CLASS_PHP_REGDATA","RegData.class.php");
define("CLASS_PHP_USER","User.class.php");
define("FILE_PHP_CONSTCONFIG","constantConfig.php");
define("DIR_CONFIG","config/");
define("DIR_MAILER","config/mailer");
?>
