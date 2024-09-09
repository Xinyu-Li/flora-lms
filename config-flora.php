<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// also update file below

$CFG->TrainingCourse_ID = 3;  // HACK to customize navigation of Training Course.
$CFG->MainCourse_ID = 2;      // HACK to customize navigation of Main Course.

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'temp_dbName';     // DB Name
$CFG->dbuser    = 'temp_user';        // DB User
$CFG->dbpass    = 'temp_password';    // DB Pass
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 3306,
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->wwwroot   = 'https://floralearn.org/lms';
$CFG->dataroot  = '/data/www/lmsdata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
