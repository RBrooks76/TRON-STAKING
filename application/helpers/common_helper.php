<?php

function admin_url() {
	return base_url() . ADMINURL . '/';
}

function admin_url_redirect() {
	redirect(base_url() . ADMINURL);
}

function admin_redirect($url, $refresh = 'refresh') {

	redirect(base_url() . $url, $refresh);
}

function front_url() {
	return base_url();
}

function getSite() {
	$ci = &get_instance();
	$ci->db->where('id', '1');
	$query = $ci->db->get(SITE);
	if ($query->num_rows() == 1) {
		return $row = $query->row();
	} else {
		return false;
	}
}

function escapeString($val) {
	$db = &get_instance()->db->conn_id;
	$val = mysqli_real_escape_string($db, $val);
	return $val;
}

function getSetting($key) {
	$ci = &get_instance();
	$name = $ci->db->where('id', 1)->get(SITE)->row()->$key;
	if ($name) {
		return $name;
	} else {
		return FALSE;
	}
}

function getSiteName() {
	$ci = &get_instance();
	$name = $ci->db->where('id', 1)->get(SITE)->row()->site_name;
	if ($name) {
		return $name;
	} else {
		return 'No Company name';
	}
}
// Site logo
function getSiteLogo() {
	$ci = &get_instance();

	$logo = $ci->db->where('id', 1)->get(SITE)->row()->site_logo;

	if ($logo) {
		return $logo;
	} else {
		return false;
	}
}

function getSociallinks() {
	$ci = &get_instance();
	$links = $ci->db->where('id', 1)->get(SITE)->row();
	if ($links) {
		return $links;
	} else {
		return false;
	}
}

function getcopyrightext() {
	$ci = &get_instance();
	$copy = $ci->db->where('id', 1)->get(SITE)->row()->copy_right_text;
	if ($copy) {
		return $copy;
	} else {
		return false;
	}
}

function getbalance($user_id = '') {
	$ci = &get_instance();
	if (empty($user_id)) {
		$user_id = juego_id();
	} else {
		$user_id = $user_id;
	}
	$balance = get_data(BALANCE, array('user_id' => $user_id))->row();
	if (!empty($balance)) {
		return $balance->balance;
	} else {
		return 0;
	}
}
function getbonusbalance($user_id = '') {
	$ci = &get_instance();
	if (empty($user_id)) {
		$user_id = juego_id();
	} else {
		$user_id = $user_id;
	}
	$balance = get_data(BALANCE, array('user_id' => $user_id))->row();
	if (!empty($balance)) {
		return $balance->bonus_balance;
	} else {
		return 0;
	}
}

function updatebalance($userid, $balance) {
	$ci = &get_instance();
	if ($ci->db->update(BALANCE, array('balance' => $balance), array('user_id' => $userid))) {

		$bdata['new_balance'] = number_format($balance, 2);

		$bdata['userid'] = $userid;

		trigger_socket($bdata, 'update_current_balance');

		return 1;
	} else {
		return 0;
	}
}

function updatebonusbalance($userid, $balance) {
	$ci = &get_instance();
	if ($ci->db->update(BALANCE, array('bonus_balance' => $balance), array('user_id' => $userid))) {

		$bdata['new_balance'] = number_format($balance, 2);

		$bdata['userid'] = $userid;

		trigger_socket($bdata, 'update_current_balance');

		return 1;
	} else {
		return 0;
	}
}

function getpage($limit = null, $offset = NULL) {
	$ci = &get_instance();
	$ci->db->limit($limit, $offset); //=>0
	$page = get_data(NOTE, array('user_id' => juego_id(), 'match_tour_created IS NULL'))->result();

	if ($page) {
		return $page;
	} else {
		return false;
	}
}
function getnotification($user_id = '', $status = '') {
	$ci = &get_instance();
	FS::db()->order_by('notification_id', 'DESC');
	if ($status == 1) {
		FS::db()->limit(1, 0); // =>0
		$notifi = get_data(NOTE, array('user_id' => $user_id, 'status' => 1, 'match_tour_created IS NULL'))->result();
	} else {
		// =>0
		$notifi = get_data(NOTE, array('user_id' => juego_id(), 'match_tour_created IS NULL'))->result();
	}
	if ($notifi) {
		return $notifi;
	} else {
		return false;
	}
}
function getcountry() {
	$ci = &get_instance();
	$country = $ci->db->get(COUN)->result();
	if ($country) {
		return $country;
	} else {
		return false;
	}
}
function getUsername($username) {

	$username = get_data(USERS, array('id' => $username))->row();
	return $username->username;
}
function getUserProPic($userpropic) {
	$userpropic = get_data(USERS, array('id' => $userpropic))->row();
	return $userpropic->profile_picture;
}
function getCheckfollow($userid) {
	$getcheckfollow = get_data(FF, array('user_id' => juego_id(), 'ff_id' => $userid))->num_rows();
	if ($getcheckfollow) {
		return true;
	} else {
		return false;
	}

}
function getchat() {
	$ci = &get_instance();
	$widget = $ci->db->where('status', '1')->get(WIG)->result();
	if ($widget) {
		return $widget;
	} else {
		return false;
	}
}
function getreferral() {
	$ci = &get_instance();
	$referral = $ci->db->get(REF)->result();
	if ($referral) {
		return $referral;
	} else {
		return false;
	}
}
function getnotificationcount($userid = '') {
	$ci = &get_instance();
	if (!empty($userid)) {
		$userid = $userid;
	} else {
		$userid = juego_id();
	}
	$note = get_data(NOTE, array('user_id' => $userid, 'status' => 1, 'match_tour_created IS NULL'))->num_rows(); // =>0
	if ($note) {
		return $note;
	} else {
		return false;
	}
}

function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) {
		$string = array_slice($string, 0, 1);
	}

	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function encrypt_decrypt($action, $string) {

	$output = false;

	$encrypt_method = "AES-256-CBC";

	$secret_key = '20WMMLR20WMMLC';

	$secret_iv = '20WMMLC20WMMLR';
	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	if ($action == 'encrypt') {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	} else if ($action == 'decrypt') {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}

// Admin Details
function getAdminDetails($id, $key = '') {
	$ci = &get_instance();
	$name = $ci->db->where('id', $id)->get(AD)->row();

	if ($name) {
		if ($key != '') {
			return $name->$key;
		} else {
			return $name;
		}
	} else {
		return '';
	}
}

function getUserDetails($id, $key = '') {
	$ci = &get_instance();
	$name = $ci->db->where('id', $id)->get(USERS)->row();
	if ($name) {
		if ($key != '') {
			return $name->$key;
		} else {
			return $name;
		}
	} else {
		return '';
	}
}

function get_data($table, $where = FALSE, $select = FALSE, $limit = FALSE) {
	$ci = &get_instance();
	if ($where) {
		$ci->db->where($where);
	}

	if ($select) {
		$ci->db->select($select);
	}

	if ($limit) {
		$ci->db->limit($limit);
	}

	return $ci->db->get($table);
}

function update_data($table, $data, $where) {
	$ci = &get_instance();
	if ($ci->db->update($table, $data, $where)) {
		return true;
	} else {
		return false;
	}

}
function insert_data($table, $data) {
	$ci = &get_instance();
	if ($ci->db->insert($table, $data)) {
		return true;
	} else {
		return false;
	}

}
function delete_data($table, $where = '') {
	$ci = &get_instance();
	if ($where) {
		$ci->db->where($where);
	} else {
		return false;
	}

	if ($ci->db->delete($table, $where)) {
		return true;
	} else {
		return false;
	}

}

function safe_b64encode($string) {
	$data = base64_encode($string);
	$data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
	return $data;
}
function safe_b64decode($string) {
	$data = str_replace(array('-', '_'), array('+', '/'), $string);
	$mod4 = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	return base64_decode($data);
}
function insep_encode($value) {

	$output = false;

	$encrypt_method = "AES-256-CBC";

	$secret_key = 'W20R20W20C';

	$secret_iv = '20COVID20M';

	$key = hash('sha256', $secret_key);

	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$output = openssl_encrypt($value, $encrypt_method, $key, 0, $iv);

	$output = base64_encode($output);

	return $output;

}

function insep_decode($value) {

	$output = false;

	$encrypt_method = "AES-256-CBC";

	$secret_key = 'W20R20W20C';

	$secret_iv = '20COVID20M';

	$key = hash('sha256', $secret_key);

	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$output = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);

	return $output;
}

function format_filename($filename) {
	$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
	$newname = str_replace(".", "_", $withoutExt);
	$extensionss = pathinfo($filename, PATHINFO_EXTENSION);
	$filename = $newname . "." . $extensionss;
	$filename = preg_replace('/[^A-Za-z0-9\.\']/', '_', $filename);
	return $filename;
}
function max_records() {
	$max = 50;
	return $max;
}

function owner_id() {
	return 1;
}

function admin_id() {
	$ci = &get_instance();

	return $ci->session->userdata('loggedadmin');
}

function admin_type() {
	$ci = &get_instance();

	return $ci->session->userdata('admin_type');
}

function juego_id() {
	return FS::session()->userdata('tr_juego_id');
}

function m_id() {
	return 1;
}
function write_log($message, $id) {
	$path = APPPATH . "views/adminlogs/log_subadmin_" . $id . ".txt";
	if (!file_exists($path)) {
		$myfile = fopen($path, "w");
	} else {
		$myfile = fopen($path, "a");
	}
	$pathinfo1 = $path;
	$time = @date('[d/M/Y:H:i:s]');

	fwrite($myfile, "$time:: $message" . PHP_EOL . "<br/><br/>");

	fclose($myfile);
}
function write_userlog($message, $id = "") {
	if (empty($id)) {
		$path = APPPATH . "views/userlogs/" . getUsername(juego_id()) . ".txt";
	} else {
		$path = APPPATH . "views/userlogs/" . getUsername($id) . ".txt";
	}
	if (!file_exists($path)) {
		$myfile = fopen($path, "w");
	} else {
		$myfile = fopen($path, "a");
	}
	$pathinfo1 = $path;
	$time = @date('[d/M/Y:H:i:s]');

	fwrite($myfile, "$time:: $message" . PHP_EOL);

	fclose($myfile);
}
function user_access($id = '') {
	$ci = &get_instance();
	if (empty($id)) {

		$redirect_access = get_data(ASSIGN, array('owner_id' => owner_id(), 'user_id' => admin_id()))->row();
	} else {
		$redirect_access = get_data(ASSIGN, array('owner_id' => owner_id(), 'priviledge_id' => $id, 'gme_id' => gme_id()))->row();
	}
	$access = (array) json_decode($redirect_access->access);

	$user_access_view[] = '';

	$user_access_edit[] = '';

	foreach ($access as $photo_id => $photo_obj) {
		if (!empty($photo_obj)) {
			$photo = (array) $photo_obj;

			if (isset($photo['view']) != '') {
				$user_access_view[] = $photo_id;
			} else {
				$user_access_view[] = '';
			}
			if (isset($photo['edit']) != '') {
				$user_access_edit[] = $photo_id;
			} else {
				$user_access_edit[] = '';
			}
		}
	}

	$user_view = array_filter($user_access_view);

	$user_edit = array_filter($user_access_edit);

	$ci->config->set_item('user_view', $user_view);

	$ci->config->set_item('user_edit', $user_edit);
}

function is_active() {
	$ci = &get_instance();
	$active = get_data(USERS, array('id' => juego_id()))->row();
	if ($active->active != 1) {
		redirect(site_url(RURL . '/inijuego/basics/sair'));
	}
}

function _GDOM() {
	$ci = &get_instance();

	$query = get_data(DOM, '', '', '1');

	if ($query) {
		return $query->row();
	} else {
		return false;
	}
}

function obtere_m($user_id) {
	$get_users = get_data(USERS, array('id' => $user_id), 'email,' . SSLS . '')->row();

	if (!empty($get_users)) {
		$user_mail = explode('@', $get_users->email);
		$a = SSLDE;
		$v = SSLS;
		$nuser_mail = $user_mail[0] . '@' . $a($get_users->$v, SSL);
		return $nuser_mail;
	} else {
		return false;
	}
}
function getsubadminDetails($id, $key = '') {
	$ci = &get_instance();
	$name = $ci->db->where('id', $id)->get(AD)->row();
	if ($name) {
		if ($key != '') {
			return $name->$key;
		} else {
			return $name;
		}
	} else {
		return '';
	}
}
function criptografarav($encrypt, $key) {

	$encryption_key = base64_decode($key);
	// Generate an initialization vector
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	// Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
	$encrypted = openssl_encrypt($encrypt, 'aes-256-cbc', $encryption_key, 0, $iv);
	// The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
	return base64_encode($encrypted . '::' . $iv);
}
function desencriptarav($decrypt, $key) {

	// Remove the base64 encoding from our key
	$encryption_key = base64_decode($key);
	// To decrypt, split the encrypted data from our IV - our unique separator used was "::"
	list($encrypted_data, $iv) = explode('::', base64_decode($decrypt), 2);
	return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
function check_user($id) {
	$check = @get_data(USERS, array('id' => insep_decode($id)), 'id,forgotten_password_code,forgotten_password_time')->row();

	if (!empty($check)) {
		return $check;
	} else {
		return false;
	}
}
function getzonename($id) {
	$zone = get_data(ZONE, array('zone_id' => ($id)))->row();
	if ($zone) {
		return $zone->zone_name;
	} else {
		return false;
	}
}
function to_decimal($value, $places = 9) {
	$value = number_format($value, $places, '.', '');
	return $value;
}
function getzone() {
	$zone = get_data(ZONE)->result();
	if ($zone) {
		return $zone;
	} else {
		return false;
	}
}
function account_setup_status() {
	return get_data(USERS, array('id' => juego_id()), 'account_setup_status')->row()->account_setup_status;
}

function account_step_completed() {
	return get_data(USERS, array('id' => juego_id()), 'account_step_completed')->row()->account_step_completed;
}
function account_setup_status1() {
	return get_data(AD, array('id' => '1'), 'account_setup_status')->row()->account_setup_status;
}

function account_step_completed1() {
	return get_data(AD, array('id' => '1'), 'account_step_completed')->row()->account_step_completed;
}
function user_location($activity, $user_id = '') {
	$CI = &get_instance();
	$user_ip = $CI->input->ip_address();
	$datetime = strtotime(date('Y-m-d H:i:s'));
	$user_browser = $CI->agent->browser();
	if ($user_ip == '127.0.0.1') {
		$user_ip = '117.232.68.203';
	}

	$locations = '';
	$udata['date'] = $datetime;
	$udata['ip_address'] = $user_ip;
	$udata['activity'] = $activity;
	$udata['date'] = $datetime;
	if (empty($user_id)) {
		$user_id = juego_id();
	} else {
		$user_id = $user_id;
	}
	$udata['user_id'] = $user_id;
	$udata['os_name'] = @$_SERVER['HTTP_USER_AGENT'];
	$udata['browser_name'] = $user_browser;
	$udata['type'] = 'Website';
	$udata['location'] = $locations;
	$id = $user_id;

	$userna = get_data(USERS, array('id' => $id))->row();

	$ua = get_data(UA, array('user_id' => $id, 'ip_address' => $user_ip));

	$mail = GUE;

	if (insert_data(UA, $udata)) {

		return true;
	}
}

if (!function_exists('lang')) {
	function lang($line, $id = '') {
		$CI = &get_instance();
		$line = $CI->lang->line($line);

		if ($id != '') {
			$line = '<label for="' . $id . '">' . $line . "</label>";
		}

		return $line;
	}
}

function user_access_name($id) {
	$user_access_name = get_data(TBL_ACCESS, array('acc_id' => $id))->row_array();
	return $user_access_name['acc_name'];
}

function AlphaNumeric($length) {
	$chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$clen = strlen($chars) - 1;
	$id = '';

	for ($i = 0; $i < $length; $i++) {
		$id .= $chars[mt_rand(0, $clen)];
	}
	return ($id);
}

function gimg($user_id, $profile_picture, $size) {
	if ($profile_picture != 'user-img.png') {
		$img_url = base_url() . U . '/user/' . $user_id . '/' . $size . '_' . $profile_picture;
	} else {
		$img_url = base_url() . '/ajqgzgmedscuoc/images/user.png';
	}
	return $img_url;
}

function adimg($admin_id, $profile_picture, $size) {

	if (empty($profile_picture)) {
		$profile_picture = getAdminDetails($admin_id, 'profile_picture');
	}

	if ($profile_picture != 'user.png') {
		$img_url = base_url() . 'ajqgzgmedscuoc/img/admin/img_admin/' . $admin_id . '/' . $size . '_' . $profile_picture;
	} else {
		$img_url = base_url() . 'ajqgzgmedscuoc/img/admin/img_admin/' . $profile_picture;
	}
	return $img_url;
}

function ArrayReplace($Array, $Find, $Replace) {
	if (is_array($Array)) {
		foreach ($Array as $Key => $Val) {
			if (is_array($Array[$Key])) {
				$Array[$Key] = ArrayReplace($Array[$Key], $Find, $Replace);
			} else {
				if ($Key == $Find) {
					$Array[$Key] = $Replace;
				}
			}
		}
	}
	return $Array;
}

function noteInsert($data) {
	$ndata['notification_type'] = $data[0];

	$ndata['user_id'] = $data[1];

	if ($data[4] == 'tour') {
		$ndata['tour_id'] = $data[2];
	} else if ($data[4] == 'match') {
		$ndata['match_id'] = $data[2];
	} else if ($data[4] == 'team_match') {
		$ndata['match_id'] = $data[2];
	}

	$ndata['message'] = $data[3];

	FS::db()->insert(NOTE, $ndata);
}

function getlocation($latitude, $longitude) {
	$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitude . ',' . $longitude . '&sensor=false&key=AIzaSyDv3fAYIfLl5H6SmuZKJtUIx6MyNn9xDbs';
	$json = file_get_contents($url);
	$data = json_decode($json, true);
	$status = $data['status'];
	if ($status == "OK") {
		return $data['results'][0]['formatted_address'];
	} else {
		return false;
	}
}

/* Start */

function nicetime($date) {
	if (empty($date)) {
		return "No date provided";
	}
	$periods = array("sec", "min", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60", "60", "24", "7", "4.35", "12", "10");
	$now = time();
	$unix_date = strtotime($date);
	// check validity of date
	if (empty($unix_date)) {
		return "Bad date";
	}
	// is it future date or past date
	if ($now > $unix_date) {
		$difference = $now - $unix_date;
		$tense = "ago";
	} else {
		$difference = $unix_date - $now;
		$tense = "from now";
	}
	for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
		$difference /= $lengths[$j];
	}
	$difference = round($difference);
	if ($difference != 1) {
		$periods[$j] .= "s";
	}
	return $difference . ' ' . $periods[$j] . ' ' . $tense;
}

function get_post_count($cat_id = '') {
	$ci = &get_instance();
	if ($cat_id == '') {
		$count = $ci->db->select('id')->from('topics')->count_all_results();
	} else {
		$count = $ci->db->select('id')->from('topics')->
			where(array('forum_id' => $cat_id))->count_all_results();
	}
	return $count;
}

function create_useractivity($feeds) {
	FS::db()->insert(UF, $feeds);
}

function get_consolename($console_id) {
	return FS::db()->select('console_name')->where('console_id', $console_id)->get(CLE)->row()->console_name;
}
function matchrefferalamount() {
	return FS::db()->select('label1')->where('id', 1)->get(REF)->row()->label1;
}

function tournamentrefferalamount() {
	return FS::db()->select('invite_frnd_tour')->where('id', 1)->get(REF)->row()->invite_frnd_tour;
}

function previousyearcount() {
	return FS::db()->select('previousyearcount')->where('id', 1)->get(SITE)->row()->previousyearcount;
}
function widget_status($id) {
	$status = FS::db()->select('status')->where('id', $id)->get(WT)->row();

	if (!empty($status->status)) {
		return $status->status;
	} else {
		return false;
	}
}

/* End */

function getUrlData($url) {

	$result = false;

	$contents = getUrlContents($url);

	if (isset($contents) && is_string($contents)) {
		$title = null;
		$metaTags = null;

		preg_match('/<title>([^>]*)<\/title>/si', $contents, $match);

		if (isset($match) && is_array($match) && count($match) > 0) {
			$title = strip_tags($match[1]);
		}

		preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);

		if (isset($match) && is_array($match) && count($match) == 3) {
			$originals = $match[0];
			$names = $match[1];
			$values = $match[2];

			if (count($originals) == count($names) && count($names) == count($values)) {
				$metaTags = array();

				for ($i = 0, $limiti = count($names); $i < $limiti; $i++) {
					$metaTags[$names[$i]] = array(
						'html' => htmlentities($originals[$i]),
						'value' => $values[$i],
					);
				}
			}
		}

		$result = array(
			'title' => $title,
			'metaTags' => $metaTags,
		);
	}
	return $result;}

function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0) {

	$result = false;

	$contents = @file_get_contents($url);

// Check if we need to go somewhere else

	if (isset($contents) && is_string($contents)) {
		preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);

		if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1) {
			if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections) {
				return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
			}

			$result = false;
		} else {
			$result = $contents;
		}
	}

	return $contents;}

function getRealIpAddr() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function onlineStatusCount() {
	$count = FS::db()->select('id')->from(USERS)->
		where(array('online_status' => 1, 'active' => 1))->count_all_results();

	return $count;
}

function update_winner($tour_id, $match_winner, $match_runner) {
	$prize_details = @get_data(MT, array('tour_id' => $tour_id), 'first_price,second_price,prize_type')->row();

	if (!empty($prize_details) && $prize_details->prize_type == 'Cash Prize') {
		if (!empty($prize_details->first_price)) {
			$winner_id = $match_winner;

			$win_amount = getbalance($winner_id) + $prize_details->first_price;

			updatebalance($winner_id, $win_amount);

			insert_trans($winner_id, $tour_id, 'Balance Add', $prize_details->first_price, $prize_details->first_price, $win_amount, 'Completed', 'no', 'tour', '1');
		}

		if (!empty($prize_details->second_price)) {
			$runner_id = $match_runner;

			$run_amount = getbalance($runner_id) + $prize_details->second_price;

			updatebalance($runner_id, $run_amount);

			insert_trans($runner_id, $tour_id, 'Balance Add', $prize_details->second_price, $prize_details->second_price, $run_amount, 'Completed', 'no', 'tour', '2');
		}
	}
}

function getTimers($expire) {
	$time = time();
	if ($time > $expire) {
		echo $time - $expire;die;
		return getTimers($expire);
	} else {
		echo $expire;die;
		exit;
	}
}

/* End */

function checkFollow($user1, $user2) {
	$chk_exist = @get_data(FF, array('user_id' => $user1, 'ff_id' => $user2), 'id')->row()->id;

	if (!empty($chk_exist)) {
		return $chk_exist;
	} else {
		return false;
	}
}

function newgetLocation($ip = "") {
	$ci = &get_instance();

	if (!empty($ip)) {
		$data = array("ip" => $ip);

		$ch = curl_init(base_url() . 'GeoLiteCity/');

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$results = curl_exec($ch);

		$result = json_decode($results);

		return $result;
	}
}

function get_captain_id($user_id) {
	$get_captain_id = @get_data(PJ, array('players_id' => $user_id, 'players_status' => 1, 'invite_status' => 1, 'leave_status' => 0), 'gme_team_id')->row()->gme_team_id;

	if (!empty($get_captain_id)) {
		return $get_captain_id;
	} else {
		return 0;
	}
}

function trigger_socket($data, $functionname) {

	$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
	//$protocol =  'http';
	if ($_SERVER['HTTP_HOST'] == 'www.trongoogol.io' && $protocol == 'https') {
		$protocol = 'https';
		$host = 'www.trongoogol.io';

		$port = '2053'; // 2086
	} else {

		$protocol = 'https';
		$host = 'www.trongoogol.io';
		$port = '2053';
	}

	$host = $protocol . '://' . $host;

	$ch = curl_init();
	// set url
	curl_setopt($ch, CURLOPT_URL, $host . ':' . $port . '/' . $functionname);
	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_POST, 1);
	// pass in a pointer to the data - libcurl will not copy
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// $output contains the output string
	$output = curl_exec($ch);
	// close curl resource to free up system resources
	curl_close($ch);

	return $output;
}

function insertUserLevelHistory($user_id, $buyPlan, $depAmount) {

	$hdata['user_id'] = $user_id;

	$hdata['level_id'] = $buyPlan;

	$hdata['level_price'] = $depAmount;

	$hdata['start_date'] = date('Y-m-d H:i:s');

	$hdata['end_date'] = date('Y-m-d H:i:s');

	if (insert_data(UBLH, $hdata)) {
		return true;
	} else {
		return false;
	}
}

function updateuUserLevel($user_id, $current_level, $buyType) {

	$user_details = @get_data(USERS, array('id' => $user_id), 'user_levels')->row();

	$level_details = @get_data(USER_L_P, array('level' => $current_level), 'price,no_of_days')->row();

	if ($user_details) {
		$levels = unserialize($user_details->user_levels);

		$levels[$current_level]['start_date'] = date('Y-m-d H:i:s');

		if ($buyType == "restore") {

			$levels[$current_level]['end_date'] = date('Y-m-d H:i:s', strtotime("+" . $level_details->no_of_days . " days"));

			$levels[$current_level]['total_days'] = $level_details->no_of_days;
		} else {
			$levels[$current_level]['end_date'] = date('Y-m-d H:i:s', strtotime($levels[$current_level]['end_date'] . ' +' . $level_details->no_of_days . ' days'));

			$levels[$current_level]['total_days'] = $levels[$current_level]['total_days'] + $level_details->no_of_days;
		}

		$upd['user_levels'] = serialize($levels);

		if ($buyType == "buy") {
			$upd['current_level'] = $current_level;
		}

		update_data(USERS, $upd, array('id' => $user_id));

		return true;
	} else {
		return false;
	}
}

function updateuUserMissingLevel($user_id, $current_level, $buyType, $level_exp = '0') {

	if ($buyType == "buy") {
		$upd['current_level'] = $current_level;
	}

	update_data(USERS, $upd, array('contract_id' => $user_id));

	return true;

}

function countUseruplines() {
	$user_details = @get_data(USERS, array('id' => juego_id()), 'user_uplines')->row();

	if (!empty($user_details)) {
		if (!empty($user_details->user_uplines)) {
			$upline_count = unserialize($user_details->user_uplines);

			return count($upline_count);
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}

function getUserLevel($user_id) {
	$user_details = @get_data(USERS, array('contract_id' => $user_id), 'current_level')->row();

	if (!empty($user_details)) {
		return $user_details->current_level;
	} else {
		return 0;
	}
}

function getTransactionCount() {
	$TransactionCount = @get_data(SITE, array('id' => '1'), 'transaction_count')->row();

	if (!empty($TransactionCount)) {
		return $TransactionCount->transaction_count;
	} else {
		return 0;
	}
}

function getRecaptchaKeys($key) {
	if ($key == 'site') {
		$getRecaptchaKeys = @get_data(SITE, array('id' => '1'), 'google_captcha_sitekey')->row()->google_captcha_sitekey;
	} else {
		$getRecaptchaKeys = @get_data(SITE, array('id' => '1'), 'google_captcha_secretkey')->row()->google_captcha_secretkey;
	}

	return $getRecaptchaKeys;
}

function get_partner_count($user_address, $level, $matrix = '') {

	$ci = &get_instance();
	return $ci->db->query("SELECT * FROM twrn_gbqvyefvhehwk WHERE affiliate_id='$user_address' AND current_level >= $level")->num_rows();

}

function get_client_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}

function getCurrentLang($key) {
	$ci = &get_instance();

	$lang = $ci->db->where('lang_code', $key)->get(LANG)->row();

	if ($lang) {

		return $lang;
	} else {
		return false;
	}
}

function getProfileID() {
	$getProfileID = @get_data(USERS, array('address' => juego_id(), 'plan_id' => 1), 'contract_id')->row()->contract_id;

	if (!empty($getProfileID)) {
		return $getProfileID;
	} else {
		return 0;
	}
}

function findCore7($user_id, $board_id, $tree_id) {

	if ($board_id == 1 || $board_id == '1') {
		$core_clumn = 'one_core_status';

		$board_clumn = 'board_one_cid';
	} else if ($board_id == 2 || $board_id == '2') {
		$core_clumn = 'two_core_status';

		$board_clumn = 'board_two_cid';
	} else if ($board_id == 3 || $board_id == '3') {
		$core_clumn = 'three_core_status';

		$board_clumn = 'board_three_cid';
	}

	$on_getTreeID = get_data(USERS, array('contract_id' => $user_id, 'plan_id' => 1, 'tree_id' => $tree_id), '' . $core_clumn . ', ' . $board_clumn . ', ref_status')->row();

	if (!empty($on_getTreeID)) {

		if (($on_getTreeID->$core_clumn == 1 && $on_getTreeID->ref_status == 0) || ($on_getTreeID->$core_clumn == 0 && $on_getTreeID->ref_status == 1) || ($on_getTreeID->$core_clumn == 0 && $on_getTreeID->ref_status == 0)) {

			$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `' . $board_clumn . '` = ' . $on_getTreeID->$board_clumn . '')->row();

			if (!empty($_one_cid)) {

				if ($_one_cid->user_child == 7) {

					$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID->$board_clumn . '')->result_array();

					if (!empty($_one_cid_array)) {

						array_walk_recursive($_one_cid_array, function (&$item, $key) {

							if ($key == 'one_core_status') {

								$item = 1;
							}

							if ($key == 'two_core_status') {

								$item = 1;
							}

							if ($key == 'three_core_status') {

								$item = 1;
							}

							if ($key == 'ref_status') {

								$item = 1;
							}

						});

						FS::db()->where('tree_id', $tree_id);

						if (FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id')) {
							return 1;
						} else {
							return 1;
						}
					}
				} else {
					return 0;
				}
			} else {
				return 0;
			}

		} else if ($on_getTreeID->$core_clumn == 1 && $on_getTreeID->ref_status == 1) {
			return 1;
		}
	} else {
		return 1;
	}
}

function CheckCore7($user_id, $board_id, $tree_id) {
	if ($board_id == 1 || $board_id == '1') {
		$core_clumn = 'one_core_status';

		$board_clumn = 'board_one_cid';
	} else if ($board_id == 2 || $board_id == '2') {
		$core_clumn = 'two_core_status';

		$board_clumn = 'board_two_cid';
	} else if ($board_id == 3 || $board_id == '3') {
		$core_clumn = 'three_core_status';

		$board_clumn = 'board_three_cid';
	}

	$on_getTreeID = get_data(USERS, array('contract_id' => $user_id, 'plan_id' => 1, 'tree_id' => $tree_id), '' . $core_clumn . ', ' . $board_clumn . ', ref_status')->row();

	if (!empty($on_getTreeID)) {

		$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `' . $board_clumn . '` = ' . $on_getTreeID->$board_clumn . '')->row();

		if (!empty($_one_cid)) {

			if ($_one_cid->user_child == 7) {

				$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID->$board_clumn . '')->result_array();

				if (!empty($_one_cid_array)) {

					array_walk_recursive($_one_cid_array, function (&$item, $key) {

						if ($key == 'one_core_status') {

							$item = 1;
						}

						if ($key == 'two_core_status') {

							$item = 1;
						}

						if ($key == 'three_core_status') {

							$item = 1;
						}

						if ($key == 'ref_status') {

							$item = 1;
						}

					});

					FS::db()->where('tree_id', $tree_id);

					if (FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id')) {
						return 1;
					} else {
						return 1;
					}

				}
			}if ($_one_cid->user_child > 7) {

				return 1;

			} else {
				return 0;
			}
		} else {
			return 0;
		}

	}
}

?>