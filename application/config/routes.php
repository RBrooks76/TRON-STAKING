<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
 */
  
$route['default_controller'] = FURL . '/basic';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/sair'] = $route['default_controller'] . '/logout';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/basic'] = FURL . '/basic';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/updatestatus'] = FURL . '/basic/updateTreestatus';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/get_update_data'] = FURL . '/basic/get_update_data';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/del_logs'] = FURL . '/basic/del_logs';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/treeDetails'] = FURL . '/basic/tree_details';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/treeDetails/(:any)'] = FURL . '/basic/tree_details/$2';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/live_out'] = FURL . '/basic/live_trade_out';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/live_error'] = FURL . '/basic/live_trade_error';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/live'] = FURL . '/basic/live_trade';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/planBsection'] = FURL . '/basic/planBpage';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/socketTrigger/(:any)/(:any)'] = FURL . '/basic/socketTrigger/$2/$3';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/refer/(:any)/(:any)'] = $route['default_controller'] . '/referuser/$2/$3';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/getUser'] = FURL . '/ajax/getUser';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/LinkRequest'] = FURL . '/ajax/LinkRequest';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/register'] = FURL . '/ajax/register';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/manual'] = FURL . '/ajax/manualregister';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/updateid'] = FURL . '/ajax/updateid';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/updatetime'] = FURL . '/ajax/updatetime';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/updateWithEvents'] = FURL . '/ajax/updateWithEvents';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/checkUser'] = FURL . '/ajax/checkUser'; 
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/Usercheck'] = FURL . '/ajax/Usercheck';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/load/(:any)/(:any)/(:any)/(:any)/(:any)'] = FURL . '/ajax/loadProfile/$2/$3/$4/$5/$6';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/planUpdate'] = FURL . '/ajax/planUpdate';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/reInvestUpdate'] = FURL . '/ajax/reInvestUpdate';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/getMissingID/(:any)/(:any)'] = FURL . '/ajax/getMissingID/$2/$3';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/getTreeAddress/(:any)'] = FURL . '/ajax/getTreeAddress/$2';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/updateTreestatus'] = FURL . '/ajax/updateTreestatus';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/getAffemptyId/(:any)'] = FURL . '/ajax/getAffemptyId/$2';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/updateAffemptyId'] = FURL . '/ajax/updateAffemptyId';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/getCurrentMissingId'] = FURL . '/ajax/getCurrentMissingId';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/getNewCurrentMissingId'] = FURL . '/ajax/getNewCurrentMissingId';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/get_two_cid/(:any)/(:any)'] = FURL . '/ajax/get_two_cid/$2/$3';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/notfound'] = FURL . '/basic/notFound';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/findFreeRef/(:any)/(:any)/(:any)'] = FURL . '/basic/findFreeRef/$2/$3/$4';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/getRefAddr/(:any)/(:any)'] = FURL . '/basic/getRefAddr/$2/$3';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/plandetail/(:any)'] = FURL . '/basic/planDetail/$2';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/plandetail/(:any)/(:any)'] = FURL . '/basic/planDetail/$2/$3';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/plandetail/(:any)/(:any)/(:any)'] = FURL . '/basic/planDetail/$2/$3/$4';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/manualEntry/(:any)/(:any)'] = FURL . '/basic/manualEntry/$2/$3';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/cms/(:any)'] = $route['default_controller'] . '/cms/$2';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/faq'] = $route['default_controller'] . '/faqView';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/coinmarketcap'] = $route['default_controller'] . '/coinmarket';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/join_request'] = ADMINURL . '/Linkrequest/join_link_request';
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)/(.+)$'] = "$2";
$route['^(en|ja|hi|ve|fil|ca|ne|bn|fr|gd|ru|es|th|pt)$'] = $route['default_controller'];
$route['404_override'] = ''; 
$route['translate_uri_dashes'] = FALSE;

/* Admin Routes Start */

$route[ADMINURL] = ADMINURL . '/basic';
$route['authenticate'] = ADMINURL . '/basic/login';
$route['logout'] = ADMINURL . '/basic/logout';
$route['admindashboard'] = ADMINURL . '/basic/manage_sitesettings';
$route['forgot'] = ADMINURL . '/basic';
$route['sitesettings'] = ADMINURL . '/basic/manage_sitesettings';
$route['changepass'] = ADMINURL . '/basic/changepass_admin';
$route['levelpassword'] = ADMINURL . '/basic/manageLevelPassword';
$route['changepattern'] = ADMINURL . '/basic/changepattern_admin';
$route['check_pass'] = ADMINURL . '/basic/check_pass';
$route['profile'] = ADMINURL . '/basic/profile_admin';
$route['forgotpass'] = ADMINURL . '/basic/forgotpass_admin';
$route['forgotpattern'] = ADMINURL . '/basic/forgotpass_admin';
$route['resetpass'] = ADMINURL . '/basic/resetpass_admin';
$route['resetpass/(:any)'] = ADMINURL . '/basic/resetpass_admin/$1';
$route['resetpattern/(:any)'] = ADMINURL . '/basic/resetpattern_admin/$1';
$route['faq'] = ADMINURL . '/FAQ/faqmanage';
$route['faqedit/(:any)'] = ADMINURL . '/FAQ/editfaq/$1';
$route['faqdelete/(:any)'] = ADMINURL . '/FAQ/deletefaq/$1';
$route['faqadd'] = ADMINURL . '/FAQ/addfaq';
$route['subadmin'] = ADMINURL . '/Subadmin/subadminManage';
$route['subadminedit/(:any)'] = ADMINURL . '/Subadmin/editSubadmin/$1';
$route['subadmindelete/(:any)'] = ADMINURL . '/Subadmin/deleteSubadmin/$1';
$route['subadminadd'] = ADMINURL . '/Subadmin/addSubadmin';
$route['adduser_email_exists'] = ADMINURL . '/Subadmin/adduser_email_exists';
$route['edituser_email_exists'] = ADMINURL . '/Subadmin/edituser_email_exists';
$route['emailtemplate'] = ADMINURL . '/Emailtemplate/emailmanage';
$route['emailedit/(:any)'] = ADMINURL . '/Emailtemplate/editemail/$1';
$route['cms'] = ADMINURL . '/CMS/cmsmanage';
$route['cmsedit/(:any)'] = ADMINURL . '/CMS/editcms/$1';
$route['howitwork'] = ADMINURL . '/Howitwork/howitworks';
$route['howitworkedit/(:any)'] = ADMINURL . '/Howitwork/edithowitwork/$1';
$route['whychoose'] = ADMINURL . '/Howitwork/whychoose';
$route['whychoose/(:any)'] = ADMINURL . '/Howitwork/editWhychoose/$1';
$route['homecontent'] = ADMINURL . '/basic/homecontent'; 
$route['homecontent/(:any)'] = ADMINURL . '/basic/homecontent/$1';
$route['getHomecontentdata'] = ADMINURL . '/basic/GetHomecontentdata';
$route['address'] = ADMINURL . '/Address/addressmanage';
$route['addressedit/(:any)'] = ADMINURL . '/Address/editaddress/$1';
$route['presentation'] = ADMINURL . '/Presentation/presen_manage';
$route['presen_edit/(:any)'] = ADMINURL . '/Presentation/editpresen/$1';
$route['presen_delete/(:any)'] = ADMINURL . '/Presentation/deletepresen/$1';
$route['presen_add'] = ADMINURL . '/Presentation/addpresen';
$route['banner'] = ADMINURL . '/Banner/bannermanage';
$route['banneredit/(:any)'] = ADMINURL . '/Banner/editbanner/$1';
$route['bannerdelete/(:any)'] = ADMINURL . '/Banner/deletebanner/$1';
$route['banneradd'] = ADMINURL . '/Banner/addbanner';
$route['video'] = ADMINURL . '/Video/videomanage';
$route['videoedit/(:any)'] = ADMINURL . '/Video/editvideo/$1';
$route['videodelete/(:any)'] = ADMINURL . '/Video/deletevideo/$1';
$route['videoadd'] = ADMINURL . '/Video/addvideo';
$route['text'] = ADMINURL . '/Text/textmanage';
$route['textedit/(:any)'] = ADMINURL . '/Text/edittext/$1';
$route['textdelete/(:any)'] = ADMINURL . '/Text/deletetext/$1';
$route['textadd'] = ADMINURL . '/Text/addtext';
$route['document'] = ADMINURL . '/Document/docmanage';
$route['docadd'] = ADMINURL . '/Document/doc_add';
$route['docedit/(:any)'] = ADMINURL . '/Document/docemail/$1';
$route['docdel/(:any)'] = ADMINURL . '/Document/doc_delete/$1';
$route['useradd'] = ADMINURL . '/Manageuser/adduser';
$route['check_eth'] = ADMINURL . '/Manageuser/check_eth';
$route['user/(:any)/(:any)'] = ADMINURL . '/Manageuser/index/$1/$2';
$route['user/(:any)'] = ADMINURL . '/Manageuser/index/$1';
$route['get_users/(:any)'] = ADMINURL . '/Manageuser/get_users/$1';
$route['get_users/(:any)/(:any)'] = ADMINURL . '/Manageuser/get_users/$1/$2';
$route['language'] = ADMINURL . '/language';
$route['languageupdate/(:any)'] = ADMINURL . '/language/languageupdate/$1';
$route['updatelanguage/(:any)'] = ADMINURL . '/language/updatelanguage/$1';
$route['download/(:any)'] = ADMINURL . '/language/file_download/$1';
$route['tfa'] = ADMINURL . '/basic/tfa'; 
$route['t_f_a'] = ADMINURL . '/basic/t_f_a';
$route['userip'] = ADMINURL . '/basic/Userip';
$route['useripedit/(:any)'] = ADMINURL . '/basic/editUserip/$1';
$route['useripdelete/(:any)'] = ADMINURL . '/basic/deletetUserip/$1';
$route['useripadd'] = ADMINURL . '/basic/addUserip';
$route['adminip'] = ADMINURL . '/basic/Adminip';
$route['adminipedit/(:any)'] = ADMINURL . '/basic/editAdminip/$1';
$route['adminipdelete/(:any)'] = ADMINURL . '/basic/deletetAdminip/$1';
$route['adminipadd'] = ADMINURL . '/basic/addAdminip';
$route['review'] = ADMINURL . '/Review/reviewmanage';
$route['reviewedit/(:any)'] = ADMINURL . '/Review/editreview/$1';
$route['reviewdelete/(:any)'] = ADMINURL . '/Review/deletereview/$1';
$route['reviewadd'] = ADMINURL . '/Review/addreview';
$route['plan'] = ADMINURL . '/Plan/planmanage';
$route['planb'] = ADMINURL . '/Plan/planbmanage';
$route['planedit/(:any)/(:any)'] = ADMINURL . '/Plan/editplan/$1/$2';
$route['referral'] = ADMINURL . '/Referral'; 
$route['updateTree'] = ADMINURL . '/Referral/updateTree';
$route['linkrequest'] = ADMINURL . '/Linkrequest';
$route['updateRefStatus/(:any)'] = ADMINURL . '/Manageuser/updateRefStatus/$1';
    
$route['newsletter'] = ADMINURL . '/NewsLetter/newsmanage';
$route['newsletter/(:any)'] = ADMINURL . '/NewsLetter/newsmanage/$1';
$route['newsletter/(:any)/(:any)'] = ADMINURL . '/NewsLetter/newsmanage/$1/$2';
$route['sendNewsLetter'] = ADMINURL . '/NewsLetter/sendNewsLetter'; 
$route['smtpmanage'] = ADMINURL . '/SMTPserver/smtpmanage';
$route['smtpmanage/(:any)'] = ADMINURL . '/SMTPserver/smtpmanage/$1';
$route['smtp_server_set'] = ADMINURL . '/SMTPserver/smtp_server_set';