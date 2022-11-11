<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
 */ 
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
defined('ADMINTITLE') OR define('ADMINTITLE', 'Admin');
defined('ADMINURL') OR define('ADMINURL', 'WZu4BDYG1HqgsPHx0BzOvFv');
defined('FURL') OR define('FURL', 'atamaicliste');
defined('SITE') OR define('SITE', 'site_settings');
defined('AD') OR define('AD', 'dxwtjgwnkzfiy');
defined('ADACT') OR define('ADACT', 'eqyyqwrpertup');
defined('TBL_ACCESS') OR define('TBL_ACCESS', 'user_access');
defined('ASSIGN') OR define('ASSIGN', 'assign_priviledge');
defined('ET') OR define('ET', 'email_templates');
defined('FAQ') OR define('FAQ', 'faq');
defined('CMS') OR define('CMS', 'cms');
defined('LANG') OR define('LANG', 'language');
defined('USER_L_P') OR define('USER_L_P', 'user_level_price');
defined('HOME_CONTENT') OR define('HOME_CONTENT', 'homepagecontent');
defined('HOW_WORK') OR define('HOW_WORK', 'how_it_works');
defined('ADDRESS') OR define('ADDRESS', 'address');
defined('USERS') OR define('USERS', 'gbqvyefvhehwk');
defined('USERS_OLD') OR define('USERS_OLD', 'gbqvyefvhehwk_old');
defined('TRANS') OR define('TRANS', 'trasfdrefddf');
defined('UBLH') OR define('UBLH', 'user_buylevel_history');
defined('PRESEN') OR define('PRESEN', 'presentation');
defined('TEXT') OR define('TEXT', 'text');
defined('BANNER') OR define('BANNER', 'banner');
defined('VIDEO') OR define('VIDEO', 'video');
defined('DOC') OR define('DOC', 'document');
defined('P') OR define('P', 'tgg_');
defined('MESSAGE') OR define('MESSAGE', 'message');
defined('UC') OR define('UC', 'user_config');
defined('USERIP') OR define('USERIP', 'block_ip');
defined('ADMINIP') OR define('ADMINIP', 'admin_access_ip');
defined('WHYCHOOSE') OR define('WHYCHOOSE', 'why_choose');
defined('REVIEWS') OR define('REVIEWS', 'reviews');
defined('PLANS') OR define('PLANS', 'plan_A_manage');
defined('PLAN_B') OR define('PLAN_B', 'plan_B_manage');
defined('RL') OR define('RL', 'referral_link');
defined('LR') OR define('LR', 'link_request');
defined('ORRE') OR define('ORRE', 'original_ref');
defined('SMTPIF') OR define('SMTPIF', 'smtpconnectinfo');

defined('ADMIN_ADDR') OR define('ADMIN_ADDR', 'TEe543qxXh5GwhKNd3QSbvuwiT1MeA3oTj');