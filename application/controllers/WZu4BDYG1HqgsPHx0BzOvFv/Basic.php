<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basic extends Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index() {
		if (!empty(admin_id())) {
			admin_redirect('admindashboard', 'refresh');
		}

		if ($_SERVER['HTTP_HOST'] == 'www.trongoogol.io') {
			$adminuser = 'Q<[wZTK4*Km^<`P]';
			$adminpass = 'ut%GKXjrR7<Aksag';

			// if (!isset($_SERVER['PHP_AUTH_USER']) || (isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER'] != $adminuser || $_SERVER['PHP_AUTH_PW'] != $adminpass))) {
			// 	header('WWW-Authenticate: Basic realm="Auth"');
			// 	header('HTTP/1.0 401 Unauthorized');
			// 	echo 'Authentications Failed';exit;
			// }

		}

		$data['title'] = "Login Page";

		$this->basicview('basic/login', $data);
	}
	function t_f_a() {
		if (!empty(admin_id())) {
			admin_redirect('sitesettings', 'refresh');
		}
		if ($this->input->post('tfacode')) {

			$code = escapeString(strip_tags($this->input->post('tfacode')));

			$result = FS::Common()->getTableData(SITE, array('id' => 1))->row();
			$secret = $result->secret;
			require_once 'GoogleAuthenticator.php';
			$ga = new PHPGangsta_GoogleAuthenticator();
			$validCode = $ga->verifyCode($secret, $code, $discrepancy = 2);

			$aid = escapeString(strip_tags($this->session->userdata('tloggedadmin')));

			$email = escapeString(strip_tags($this->session->userdata('email')));

			$password = escapeString(strip_tags($this->session->userdata('pass')));

			$patterncode = escapeString(strip_tags($this->session->userdata('pattern')));

			$remember = escapeString(strip_tags($this->session->userdata('remember')));

			if ($validCode == 1 && $aid == 1) {

				$login = FS::Common()->getTableData(AD, array('email_id' => encrypt_decrypt('encrypt', $email), 'password' => encrypt_decrypt('encrypt', $password), 'code' => strrev($patterncode)));

				$activitdata = array('admin_email' => encrypt_decrypt('encrypt', $email),
					'admin_id' => $aid,
					'date' => gmdate(time()),
					'ip_address' => $_SERVER['REMOTE_ADDR'],
					'activity' => 'Login Success',
					'browser_name' => $_SERVER['HTTP_USER_AGENT']);

				FS::Common()->insertTableData(ADACT, $activitdata);

				$this->load->helper('cookie');

				if (isset($remember) && !empty($remember)) {
					setcookie('admin_login_email', $email, time() + (86400 * 30), "/");
					setcookie('admin_login_password', $password, time() + (86400 * 30), "/");
					setcookie('admin_login_remember', $remember, time() + (86400 * 30), "/");
				} else {
					setcookie("admin_login_email", "", time() - 3600);
					setcookie("admin_login_password", "", time() - 3600);
					setcookie("admin_login_remember", "", time() - 3600);
				}

				$session_data = array('loggedadmin' => $login->row('id'), 'admin_type' => $login->row('type'), 'permissions' => $login->row('permissions'));

				$this->session->set_userdata($session_data);

				FS::session()->set_flashdata('success', 'You\'re logged in successfully!');

				$data['message'] = 'You\'re logged in successfully!';

				user_access();

				$user_view = $this->config->item('user_view');

				$access_id = $user_view['1'];

				$user_access = get_data(TBL_ACCESS, array('acc_id' => $access_id))->row_array();

				if (!empty(admin_id())) {
					admin_redirect('sitesettings', 'refresh');
				}
			} else {

				FS::session()->set_flashdata('error', 'Invalid TFA code');

				$data['title'] = "Login Page";

				$this->basicview('basic/login', $data);
			}
		} else {
			$data['title'] = "Login Page";

			$this->basicview('basic/tfa', $data);
		}

	}
	function login() {
		// Table Alert Start
		$TableCheck = FS::Common()->getTableData(USERS)->row();							
		if(!isset($TableCheck->email)) $this->db->query("ALTER  TABLE `" .P . USERS . "` ADD email varchar(50) DEFAULT ''");
		// Tabl Alert End email

		if (!empty(admin_id())) {
			admin_redirect('sitesettings', 'refresh');
		}

		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pattern', 'pattern code', 'trim|required|xss_clean');

		// When Post
		if ($this->input->post()) {

			if ($this->form_validation->run()) {
				// Login credentials
				$email = escapeString(strip_tags($this->input->post('email')));

				$password = escapeString(strip_tags($this->input->post('password')));

				$remember = escapeString(strip_tags($this->input->post('remember')));

				$patterncode = escapeString(strip_tags($this->input->post('pattern')));

				$login = FS::Common()->getTableData(AD, array('email_id' => encrypt_decrypt('encrypt', $email), 'password' => encrypt_decrypt('encrypt', $password), 'code' => strrev($patterncode)));

				if ($login->num_rows() == 1) {
					$uif = FS::Common()->getTableData(SITE, array('id' => 1))->row();
					if ($uif->randcode != 'disable') {

						$data['link'] = "t_f_a";

						$data['status'] = 1;

						$session_data = array('tloggedadmin' => $login->row('id'), 'tadmin_type' => $login->row('type'), 'permissions' => $login->row('tpermissions'), 'email' => $email, 'pass' => $password, 'pattern' => $patterncode, 'remember' => $remember);

						$this->session->set_userdata($session_data);

						echo json_encode($data);

					} else {
						$activitdata = array('admin_email' => $login->row()->email_id,
							'admin_id' => $login->row()->id,
							'date' => gmdate(time()),
							'ip_address' => $_SERVER['REMOTE_ADDR'],
							'activity' => 'Login Success',
							'browser_name' => $_SERVER['HTTP_USER_AGENT']);

						FS::Common()->insertTableData(ADACT, $activitdata);

						$this->load->helper('cookie');

						if (isset($remember) && !empty($remember)) {
							setcookie('admin_login_email', $email, time() + (86400 * 30), "/");
							setcookie('admin_login_password', $password, time() + (86400 * 30), "/");
							setcookie('admin_login_remember', $remember, time() + (86400 * 30), "/");
						} else {
							setcookie("admin_login_email", "", time() - 3600);
							setcookie("admin_login_password", "", time() - 3600);
							setcookie("admin_login_remember", "", time() - 3600);
						}

						$session_data = array('loggedadmin' => $login->row('id'), 'admin_type' => $login->row('type'), 'permissions' => $login->row('permissions'));

						$this->session->set_userdata($session_data);

						FS::session()->set_flashdata('success', 'You\'re logged in successfully!');

						$data['message'] = 'You\'re logged in successfully!';

						user_access();

						$user_view = $this->config->item('user_view');

						$access_id = $user_view['1'];

						$user_access = get_data(TBL_ACCESS, array('acc_id' => $access_id))->row_array();

						if (count($user_access) != 0) {

							$data['link'] = $user_access['link'];

							$data['status'] = 1;

							echo json_encode($data);

						}
					}

				} else {
					$activitdata = array('admin_email' => encrypt_decrypt('encrypt', $email),
						'admin_id' => 1,
						'date' => gmdate(time()),
						'ip_address' => $_SERVER['REMOTE_ADDR'],
						'activity' => 'Login Failed',
						'browser_name' => $_SERVER['HTTP_USER_AGENT']);

					FS::Common()->insertTableData(ADACT, $activitdata);

					$data['status'] = 0;

					$data['message'] = 'Invalid email or password or pattern!';

					echo json_encode($data);

				}
			} else {

				$data['status'] = 0;

				$data['message'] = 'Problem with your email , password & pattern!';

				echo json_encode($data);
			}
		} else {
			$data['title'] = "Login Page";

			$this->basicview('basic/login', $data);
		}

	}

	function logout() {

		$this->session->unset_userdata('loggedadmin');

		$this->session->unset_userdata('admin_type');

		$this->session->unset_userdata('permissions');

		admin_url_redirect('', 'refresh');
	}

	function manage_sitesettings() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('2', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		} else {
			if ($this->input->post()) {

				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/site';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["site_logo"]["name"] != '') {
					if (!$this->upload->do_upload('site_logo')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('sitesettings');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] . '/' . $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 200;
							$configs['height'] = 200;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] . '/' . $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->resize();
							$this->image_lib->clear();
							$updateData['site_logo'] = $d['file_name'];
						}
					}
				}
				$new_name = time() . rand(10, 100);
				$ext = pathinfo($_FILES['fav_icon']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["fav_icon"]["name"] != '') {
					if (!$this->upload->do_upload('fav_icon')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('sitesettings');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] . '/' . $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 32;
							$configs['height'] = 32;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] . '/' . $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->resize();
							$this->image_lib->clear();
							$updateData['fav_icon'] = $d['file_name'];
						}
					}
				}

				$new_name = time() . rand(10, 100);
				$ext = pathinfo($_FILES['contact_us_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["contact_us_img"]["name"] != '') {
					if (!$this->upload->do_upload('contact_us_img')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('sitesettings');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] . '/' . $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 940;
							$configs['height'] = 788;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] . '/' . $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->resize();
							$this->image_lib->clear();
							$updateData['contact_us_img'] = $d['file_name'];
						}
					}
				}

				$updateData['site_name'] = escapeString(strip_tags($this->input->post('site_name')));
				$updateData['site_email'] = escapeString(strip_tags($this->input->post('site_email')));
				$updateData['contactno'] = escapeString(strip_tags($this->input->post('contactno')));
				$updateData['altcontactno'] = escapeString(strip_tags($this->input->post('altcontactno')));
				$updateData['country'] = escapeString(strip_tags($this->input->post('country')));
				$updateData['state'] = escapeString(strip_tags($this->input->post('state')));
				$updateData['city'] = escapeString(strip_tags($this->input->post('city')));
				$updateData['address'] = escapeString(strip_tags($this->input->post('address')));
				$updateData['facebooklink'] = escapeString(strip_tags($this->input->post('facebooklink')));
				$updateData['twitterlink'] = escapeString(strip_tags($this->input->post('twitterlink')));
				$updateData['telegram_link'] = escapeString(strip_tags($this->input->post('telegramlink')));
				$updateData['youtubelink'] = escapeString(strip_tags($this->input->post('youtubelink')));
				$updateData['android_app_link'] = escapeString(strip_tags($this->input->post('android_app_link')));
				$updateData['ios_app_link'] = escapeString(strip_tags($this->input->post('ios_app_link')));
				$updateData['copy_right_text'] = escapeString(strip_tags($this->input->post('copyright')));
				$updateData['site_maintenance'] = escapeString(strip_tags($this->input->post('site_maintenance')));
				$updateData['user_htpwd'] = escapeString(strip_tags($this->input->post('user_htpwd')));
				$updateData['x_gas_limit'] = escapeString(strip_tags($this->input->post('x_gas_limit')));
				$updateData['y_gas_limit'] = escapeString(strip_tags($this->input->post('y_gas_limit')));
				$updateData['site_name_2'] = escapeString(strip_tags($this->input->post('site_name_2')));
				$updateData['how_site'] = escapeString(strip_tags($this->input->post('how_site')));
				$updateData['contact_us_title'] = escapeString(strip_tags($this->input->post('contact_us_title')));
				$updateData['contact_us_link'] = escapeString(strip_tags($this->input->post('contact_us_link')));

				$update = FS::Common()->updateTableData(SITE, array('id' => 1), $updateData);

				if ($update) {
					FS::session()->set_flashdata('success', 'Site settings updated successfully.');
					admin_redirect('sitesettings');
				} else {
					FS::session()->set_flashdata('error', 'Problem with your site settings updation.');
					admin_redirect('sitesettings', 'refresh');
				}

			}

			$data['action'] = base_url() . 'sitesettings';

			$data['siteSettings'] = FS::Common()->getTableData(SITE, array('id' => 1))->row();

			$data['title'] = 'Site Settings';

			$this->view('pages/site_settings', $data);
		}
	}

	function changepass_admin() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('3', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		} else {
			if ($this->input->post()) {

				$this->form_validation->set_rules('cpass', 'Old password', 'required|trim|xss_clean');
				$this->form_validation->set_rules('npass', 'Password', 'required|trim|xss_clean');

				if ($this->form_validation->run()) {
					$oldPassword = escapeString(strip_tags($this->input->post('cpass')));
					$password = escapeString(strip_tags($this->input->post('npass')));
					$identity = FS::Common()->getTableData(AD, array('id' => admin_id(), 'password' => encrypt_decrypt('encrypt', $oldPassword)));
					if ($identity->num_rows() > 0) {
						$array = array('password' => encrypt_decrypt('encrypt', $password));
						$change = FS::Common()->updateTableData(AD, array('id' => admin_id()), $array);
						// $sessionvar = $this->session->userdata('loggedadmin');

						if ($change) {
							FS::session()->set_flashdata('success', 'Your password has been changed successfully');
							admin_redirect('changepass', 'refresh');
						} else {
							FS::session()->set_flashdata('error', 'Error occured while changing password');
							admin_redirect('changepass', 'refresh');
						}
					} else {
						FS::session()->set_flashdata('error', 'Old Password is not valid');
						admin_redirect('changepass', 'refresh');
					}
				} else {
					FS::session()->set_flashdata('error', 'Old password and new password required.');
					admin_redirect('changepass', 'refresh');
				}

			}

			$data['action'] = base_url() . 'changepass';

			$data['title'] = 'Change Password';

			$this->view('pages/changepass', $data);
		}
	}

	function profile_admin() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('4', $user_view)) {
			admin_url_redirect('', 'refresh');
		} else {

			if ($this->input->post()) {

				print_r($_FILES["admin_img"]["name"]);
				if ($_FILES["admin_img"]["name"] != '') {
					echo "string";die;
					$new_name = time();
					$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/img_admin/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$ext = pathinfo($_FILES['admin_img']['name'], PATHINFO_EXTENSION);
					$config['file_name'] = $new_name . '.' . $ext;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('admin_img')) {

						$error = array('error' => $this->upload->display_errors());

						$this->session->set_flashdata('error', $error['error']);

						admin_redirect('profile');

					}
					// else {

					// 	$d = $this->upload->data();
					// 	if ($config['file_name']) {
					// 		$this->load->library('image_lib');
					// 		$configs['image_library'] = 'gd2';
					// 		$configs['source_image'] = $config['upload_path'] .'/'.  $config['file_name'];
					// 		$configs['maintain_ratio'] = TRUE;
					// 		$configs['width'] = 200;
					// 		$configs['height'] = 200;
					// 		$configs['overwrite'] = TRUE;
					// 		$configs['new_image'] = $config['upload_path'] .'/'.  $config['file_name'];
					// 		$this->image_lib->initialize($configs);
					// 		$this->image_lib->resize();
					// 		$this->image_lib->clear();

					// 		$updateData['profile_picture'] = $d['file_name'];
					// 	}
					// }
				}
				// else
				// {
				// 			FS::session()->set_flashdata('error', 'Problem with your profile picture');

				// 			admin_redirect('profile', 'refresh');

				//  }

				$updateData['phone'] = escapeString(strip_tags($this->input->post('phone_no')));
				$updateData['first_name'] = escapeString(strip_tags($this->input->post('fname')));
				$updateData['last_name'] = escapeString(strip_tags($this->input->post('lname')));

				$update = FS::Common()->updateTableData(AD, array('id' => 1), $updateData);

				if ($update) {
					FS::session()->set_flashdata('success', 'Profile updated successfully.');
					admin_redirect('profile');
				} else {
					FS::session()->set_flashdata('error', 'Problem with your site settings updation.');
					admin_redirect('profile', 'refresh');
				}

			}

			$data['action'] = base_url() . 'profile';

			$data['title'] = 'Admin Profile';

			$data['profile'] = FS::Common()->getTableData(AD, array('id' => 1))->row();

			$this->view('pages/profile', $data);
		}
	}

	function check_pass() {
		extract($this->input->post());
		$password = encrypt_decrypt('encrypt', $old_password);
		$admin_id = $this->session->userdata('loggedadmin');
		$data = FS::Common()->getTableData(AD, array('id' => $admin_id, 'password' => $password))->num_rows();
		if ($data == 0) {
			echo "false";
		} else {
			echo "true";
		}
	}

	function forgotpass_admin() {
		if (!empty(admin_id())) {
			admin_redirect('admindashboard', 'refresh');
		}
		$pageLabel = ($this->uri->segments[1] == 'forgotpass') ? 'Password' : 'Pattern';
		if (!empty($this->input->post())) {
			$email = escapeString(strip_tags($_POST['email']));
			$result = FS::Common()->getTableData(AD, array('email_id' => encrypt_decrypt('encrypt', $email)))->row();
 
			if (!empty($result)) {
				$rancode = AlphaNumeric(6);

				$updata['rand_code'] = $rancode;
				$url_code = encrypt_decrypt('encrypt', $rancode);
				if ($pageLabel == 'Password') {
					$link = base_url() . 'resetpass/' . $url_code;
				} else {
					$link = base_url() . 'resetpattern/' . $url_code;
				}
				$path = base_url();
				$row = $result;
				$array = array('rand_code' => $rancode);
				$copy = getcopyrightext();

				$img_url = base_url() . 'ajqgzgmedscuoc/img/site/' . getSiteLogo();
				if (FS::Common()->updateTableData(AD, array('id' => $row->id), $array)) {
					$special_vars = array(
						'###USER###' => $row->admin_name,
						'###CLINK###' => $link,
						'###SITELOGO###' => $img_url,
						'###path###' => $path,
						'###COPYRIGHT###' => $copy,
						'###TYPE###' => $pageLabel,
					); 

					$email = encrypt_decrypt('decrypt', $row->email_id);
					$send_mail = FS::Emodelo()->stuur_pos($email, '', '', 1, $special_vars);

					if ($send_mail) {
						//if ($email) {
						FS::session()->set_flashdata('success', $pageLabel . ' reset Link Sent to your mail successfully');
					} else {
						FS::session()->set_flashdata('error', 'Error occured while sending Email');
					}
				} else {

					FS::session()->set_flashdata('error', 'error occured while resetting ' . strtolower($pageLabel));
				}

				admin_redirect($this->uri->segments[1]);
			} else {

				FS::session()->set_flashdata('error', 'Email Not Found');

				admin_redirect($this->uri->segments[1]);
			}
		} else {

			$data['title'] = "Forgot Page";
			$data['pageLabel'] = $pageLabel;

			$data['action'] = base_url() . $this->uri->segments[1];

			$this->basicview('basic/forgotpass', $data);
		}
	}

	function resetpass_admin($id = '') {

		if (!empty(admin_id())) {
			admin_redirect('admindashboard', 'refresh');
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('newpass', 'Old password', 'required|trim|xss_clean');
			$this->form_validation->set_rules('confirmpass', 'Password', 'required|trim|xss_clean');

			if ($this->form_validation->run()) {
				$newPassword = escapeString(strip_tags($this->input->post('newpass')));
				$password = escapeString(strip_tags($this->input->post('confirmpass')));
				if ($newPassword == $password) {
					$rand = encrypt_decrypt('decrypt', $id);
					$identity = FS::Common()->getTableData(AD, array('rand_code' => $rand));
					if ($identity->num_rows() > 0) {
						$array = array('password' => encrypt_decrypt('encrypt', $password));
						$change = FS::Common()->updateTableData(AD, array('rand_code' => $rand), $array);

						if ($change) {
							FS::session()->set_flashdata('success', 'Your password has been changed successfully');
							admin_redirect('resetpass', 'refresh');
						} else {
							FS::session()->set_flashdata('error', 'Error occured while changing password');
							admin_redirect('resetpass', 'refresh');
						}
					} else {
						FS::session()->set_flashdata('error', 'Invalid access');
						admin_redirect('resetpass', 'refresh');
					}
				} else {
					FS::session()->set_flashdata('error', 'New password and Confirm password Should be same.');
					admin_redirect('resetpass', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Old password and new password required.');
				admin_redirect('resetpass', 'refresh');
			}

		} else {

			$data['title'] = "Reset Page";

			$data['action'] = base_url() . 'resetpass';

			$this->basicview('basic/resetpass', $data);
		}
	}

	function resetpattern_admin($id = '') {

		if (!empty(admin_id())) {
			admin_redirect('admindashboard', 'refresh');
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('newpattern', 'New Pattern', 'required|trim|xss_clean');
			$this->form_validation->set_rules('confirmpattern', 'Confirm Pattern', 'required|trim|xss_clean');

			if ($this->form_validation->run()) {
				$newpattern = escapeString(strip_tags($this->input->post('newpattern')));
				$confirmpattern = escapeString(strip_tags($this->input->post('confirmpattern')));
				if ($newpattern == $confirmpattern) {

					$rand = encrypt_decrypt('decrypt', $id);
					$identity = FS::Common()->getTableData(AD, array('rand_code' => $rand));
					if ($identity->num_rows() > 0) {
						$array = array('code' => strrev($newpattern));
						$change = FS::Common()->updateTableData(AD, array('rand_code' => $rand), $array);

						if ($change) {
							FS::session()->set_flashdata('success', 'Your pattern has been changed successfully');
							admin_redirect('forgotpattern', 'refresh');
						} else {
							FS::session()->set_flashdata('error', 'Error occured while changing password');
							admin_redirect('resetpattern/' . $id, 'refresh');
						}
					} else {
						FS::session()->set_flashdata('error', 'Invalid access');
						admin_redirect('resetpattern/' . $id, 'refresh');
					}
				} else {
					FS::session()->set_flashdata('error', 'New pattern and Confirm pattern Should be same.');
					admin_redirect('resetpattern/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'New pattern and Confirm pattern required.');
				admin_redirect('resetpattern/' . $id, 'refresh');
			}

		} else {

			$data['title'] = "Reset Page";

			$data['action'] = base_url() . 'resetpattern/' . $id;

			$this->basicview('basic/resetpattern', $data);
		}
	}

	function homecontent($langcode = "1") {
		if (empty(admin_id())) { admin_url_redirect('', 'refresh');} 
		user_access();
		$user_view = $this->config->item('user_view');

		// Table Alert Start
		$TableCheck = FS::Common()->getTableData(HOME_CONTENT)->row();
		$TableCheckKey = array();
		foreach ($TableCheck as $key => $value) {$TableCheckKey[$key] = true;}

		if(!isset($TableCheck->adv_tech_logo)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD adv_tech_logo varchar(50) DEFAULT ''"); 
		if(!isset($TableCheck->footer_content_logo)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD footer_content_logo varchar(50) DEFAULT ''");

		if(!isset($TableCheck->Section7_1_head)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_1_head varchar(50) DEFAULT ''");
		if(!isset($TableCheckKey['Section7_1_content'])) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_1_content LONGTEXT");
		if(!isset($TableCheck->Section7_1_link)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_1_link varchar(50) DEFAULT ''");
		if(!isset($TableCheck->Section7_1_logo)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_1_logo varchar(50) DEFAULT ''");

		if(!isset($TableCheck->Section7_2_head)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_2_head varchar(50) DEFAULT ''");
		if(!isset($TableCheckKey['Section7_2_content'])) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_2_content LONGTEXT");
		if(!isset($TableCheck->Section7_2_link)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_2_link varchar(50) DEFAULT ''");
		if(!isset($TableCheck->Section7_2_logo)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_2_logo varchar(50) DEFAULT ''");

		if(!isset($TableCheck->Section7_3_head)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_3_head varchar(50) DEFAULT ''");
		if(!isset($TableCheckKey['Section7_3_content'])) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_3_content LONGTEXT");
		if(!isset($TableCheck->Section7_3_link)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_3_link varchar(50) DEFAULT ''");
		if(!isset($TableCheck->Section7_3_logo)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_3_logo varchar(50) DEFAULT ''");

		if(!isset($TableCheck->Section7_4_head)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_4_head varchar(50) DEFAULT ''");
		if(!isset($TableCheckKey['Section7_4_content'])) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_4_content LONGTEXT");
		if(!isset($TableCheck->Section7_4_link)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_4_link varchar(50) DEFAULT ''");
		if(!isset($TableCheck->Section7_4_logo)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD Section7_4_logo varchar(50) DEFAULT ''");

		if(!isset($TableCheck->joinLink)) $this->db->query("ALTER  TABLE `" .P . HOME_CONTENT . "` ADD joinLink varchar(50) DEFAULT ''");
		// Tabl Alert End

		if (!in_array('8', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		} else {
			$lang = escapeString(strip_tags($this->input->post('language')));
			$langcode = '1';

			if ($this->input->post()) {
				$this->form_validation->set_rules('smart_head_one', 'smart_head_one', 'required|trim|xss_clean');
				$this->form_validation->set_rules('smart_head_two', 'smart_head_two', 'required|trim|xss_clean');
				$this->form_validation->set_rules('how_work_one', 'how_work_one', 'required|trim|xss_clean');
				$this->form_validation->set_rules('how_work_two', 'how_work_two', 'required|trim|xss_clean');

				$this->form_validation->set_rules('market_plan_one', 'market_plan_one', 'required|trim|xss_clean');
				$this->form_validation->set_rules('market_plan_two', 'market_plan_two', 'required|trim');
				$this->form_validation->set_rules('reg_page_one', 'reg_page_one', 'required|trim|xss_clean');
				$this->form_validation->set_rules('reg_page_two', 'reg_page_two', 'required|trim|xss_clean');

				$this->form_validation->set_rules('adv_tech_1', 'adv_tech_1', 'required|trim|xss_clean');
				$this->form_validation->set_rules('adv_tech_2', 'adv_tech_2', 'required|trim|xss_clean');

				$this->form_validation->set_rules('footer_content_1', 'footer_content_1', 'required|trim|xss_clean');
				$this->form_validation->set_rules('footer_content_2', 'footer_content_2', 'required|trim|xss_clean');

				$this->form_validation->set_rules('footer_link_1', 'footer_link_1', 'required|trim|xss_clean');
				$this->form_validation->set_rules('footer_link_2', 'footer_link_2', 'required|trim|xss_clean');

				$this->form_validation->set_rules('embeed_code', 'embeed_code', 'required|trim|xss_clean');
				$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

				// Table field data Start
					$upid = 1;
					$updateData['smart_contact_1'] = escapeString(strip_tags($this->input->post('smart_head_one')));
					$updateData['smart_contact_2'] = escapeString(strip_tags($this->input->post('smart_head_two')));
					$updateData['how_every_1'] = escapeString(strip_tags($this->input->post('how_work_one')));
					$updateData['how_every_2'] = escapeString(strip_tags($this->input->post('how_work_two')));
					$updateData['market_plan_1'] = escapeString(strip_tags($this->input->post('market_plan_one')));
					$updateData['market_plan_2'] = escapeString(strip_tags($this->input->post('market_plan_two')));
					$updateData['reg_page_1'] = escapeString(strip_tags($this->input->post('reg_page_one')));
					$updateData['reg_page_2'] = escapeString(strip_tags($this->input->post('reg_page_two')));
					$updateData['adv_tech_1'] = escapeString(strip_tags($this->input->post('adv_tech_1')));
					$updateData['adv_tech_2'] = escapeString(strip_tags($this->input->post('adv_tech_2')));
					
					$updateData['footer_content_1'] = escapeString(strip_tags($this->input->post('footer_content_1')));
					$updateData['footer_content_2'] = escapeString(strip_tags($this->input->post('footer_content_2')));
					
					$updateData['footer_link_1'] = escapeString(strip_tags($this->input->post('footer_link_1')));
					$updateData['footer_link_2'] = escapeString(strip_tags($this->input->post('footer_link_2')));
					$updateData['embeed_code'] = (($this->input->post('embeed_code')));
					$updateData['video_embeed_code'] = (($this->input->post('video_embeed_code')));
					$updateData['reff_embeed_code'] = (($this->input->post('reff_embeed_code')));
					$updateData['language'] = escapeString(strip_tags($this->input->post('language')));
					
					$updateData['Section7_1_head'] = escapeString(strip_tags($this->input->post('Section7_1_head')));
					$updateData['Section7_1_content'] = escapeString(strip_tags($this->input->post('Section7_1_content')));
					$updateData['Section7_1_link'] = escapeString(strip_tags($this->input->post('Section7_1_link')));
					 
					$updateData['Section7_2_head'] = escapeString(strip_tags($this->input->post('Section7_2_head')));
					$updateData['Section7_2_content'] = escapeString(strip_tags($this->input->post('Section7_2_content')));
					$updateData['Section7_2_link'] = escapeString(strip_tags($this->input->post('Section7_2_link')));
					
					$updateData['Section7_3_head'] = escapeString(strip_tags($this->input->post('Section7_3_head')));
					$updateData['Section7_3_content'] = escapeString(strip_tags($this->input->post('Section7_3_content')));
					$updateData['Section7_3_link'] = escapeString(strip_tags($this->input->post('Section7_3_link')));
					
					$updateData['Section7_4_head'] = escapeString(strip_tags($this->input->post('Section7_4_head')));
					$updateData['Section7_4_content'] = escapeString(strip_tags($this->input->post('Section7_4_content')));
					$updateData['Section7_4_link'] = escapeString(strip_tags($this->input->post('Section7_4_link')));

					$updateData['joinLink'] = escapeString(strip_tags($this->input->post('joinLink')));
				// Table field Data End
				 
				$adv_tech_logo = $_FILES["adv_tech_logo"]["tmp_name"];
				$footer_content_logo = $_FILES["footer_content_logo"]["tmp_name"];

				$Section7_1_logo = $_FILES["Section7_1_logo"]["tmp_name"];
				$Section7_2_logo = $_FILES["Section7_2_logo"]["tmp_name"];
				$Section7_3_logo = $_FILES["Section7_3_logo"]["tmp_name"];
				$Section7_4_logo = $_FILES["Section7_4_logo"]["tmp_name"];

				if ($this->form_validation->run() && isset($adv_tech_logo)  && isset($footer_content_logo) && isset($Section7_1_logo) &&  isset($Section7_2_logo) && isset($Section7_3_logo) && isset($Section7_4_logo) && !($adv_tech_logo == '' && $footer_content_logo == '' && $Section7_1_logo == '' && $Section7_2_logo == '' && $Section7_3_logo == '' && $Section7_4_logo == '')) {
					if($adv_tech_logo != '') $imgcheck1 = getimagesize($_FILES["adv_tech_logo"]["tmp_name"]);
					if($footer_content_logo != '') $imgcheck2 = getimagesize($_FILES["footer_content_logo"]["tmp_name"]);

					if($Section7_1_logo != '') $img7_check1 = getimagesize($_FILES["Section7_1_logo"]["tmp_name"]);
					if($Section7_2_logo != '') $img7_check2 = getimagesize($_FILES["Section7_2_logo"]["tmp_name"]);
					if($Section7_3_logo != '') $img7_check3 = getimagesize($_FILES["Section7_3_logo"]["tmp_name"]);
					if($Section7_4_logo != '') $img7_check4 = getimagesize($_FILES["Section7_4_logo"]["tmp_name"]);
					
					if(isset($imgcheck1) && $imgcheck1 !== false){
						$fileTmpPath_1 = $_FILES['adv_tech_logo']['tmp_name'];
						$fileNameCmps_1 = explode(".", $_FILES['adv_tech_logo']['name']);
						$fileExtension_1 = strtolower(end($fileNameCmps_1));
						$NewfileName1 = time() . '_advlogo.' . $fileExtension_1;
						$dest_path_1 = 'ajqgzgmedscuoc/img/upload/' . $NewfileName1;

						if(move_uploaded_file($fileTmpPath_1, $dest_path_1)){
							$updateData['adv_tech_logo'] = $NewfileName1;
							
							if(isset($imgcheck2) && $imgcheck2 !== false ){
								$fileTmpPath_2 = $_FILES['footer_content_logo']['tmp_name'];
								$fileNameCmps_2 = explode(".", $_FILES['footer_content_logo']['name']);
								$fileExtension_2 = strtolower(end($fileNameCmps_2));
								$NewfileName2 = time() . '_advContentlogo.' . $fileExtension_2;
								$dest_path_2 = 'ajqgzgmedscuoc/img/upload/' . $NewfileName2;
								if(move_uploaded_file($fileTmpPath_2, $dest_path_2)){
									$updateData['footer_content_logo'] = $NewfileName2;

									if(isset($img7_check1) && $img7_check1 !== false){
										$file7_TmpPath_1 = $_FILES['Section7_1_logo']['tmp_name'];
										$file7_NameCmps_1 = explode(".", $_FILES['Section7_1_logo']['name']);
										$file7_Extension_1 = strtolower(end($file7_NameCmps_1));
										$Newfile7_Name1 = time() . '_Sec7_logo1.' . $file7_Extension_1;
										$dest7_path_1 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name1;
										if(move_uploaded_file($file7_TmpPath_1, $dest7_path_1)){
											$updateData['Section7_1_logo'] = $Newfile7_Name1;

											if(isset($img7_check2) && $img7_check2 !== false){
												$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
												$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
												$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
												$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
												$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
												if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
													$updateData['Section7_2_logo'] = $Newfile7_Name2;

													if(isset($img7_check3) && $img7_check3 !== false){
														$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
														$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
														$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
														$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
														$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
														if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
															$updateData['Section7_3_logo'] = $Newfile7_Name3;

															if(isset($img7_check4) && $img7_check4 !== false){
																$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
																$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
																$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
																$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
																$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
																if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
																	$updateData['Section7_4_logo'] = $Newfile7_Name4;

																	$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
																	if ($change) {
																		FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																		admin_redirect('homecontent', 'refresh');
																	} else {
																		FS::session()->set_flashdata('error', 'Error occured while changing the data');
																		admin_redirect('homecontent', 'refresh');
																	}

																} else {
																	FS::session()->set_flashdata('error', 'Error occured while changing the data');
																	admin_redirect('homecontent', 'refresh');
																}
																
															} else {
																$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
																if ($change) {
																	FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																	admin_redirect('homecontent', 'refresh');
																} else {
																	FS::session()->set_flashdata('error', 'Error occured while changing the data');
																	admin_redirect('homecontent', 'refresh');
																}
															}
															
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													} else {
														if(isset($img7_check4) && $img7_check4 !== false){
															$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
															$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
															$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
															$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
															$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
															if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
																$updateData['Section7_4_logo'] = $Newfile7_Name4;

																$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
																if ($change) {
																	FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																	admin_redirect('homecontent', 'refresh');
																} else {
																	FS::session()->set_flashdata('error', 'Error occured while changing the data');
																	admin_redirect('homecontent', 'refresh');
																}

															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
															
														} else {
															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
														}
													}

												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											} else {
												if(isset($img7_check3) && $img7_check3 !== false){
													$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
													$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
													$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
													$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
													$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
													if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
														$updateData['Section7_3_logo'] = $Newfile7_Name3;

														if(isset($img7_check4) && $img7_check4 !== false){
															$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
															$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
															$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
															$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
															$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
															if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
																$updateData['Section7_4_logo'] = $Newfile7_Name4;

																$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
																if ($change) {
																	FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																	admin_redirect('homecontent', 'refresh');
																} else {
																	FS::session()->set_flashdata('error', 'Error occured while changing the data');
																	admin_redirect('homecontent', 'refresh');
																}

															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
															
														} else {
															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
														}
														
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												} else {
													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
												}
											}

										} else {
											FS::session()->set_flashdata('error', 'Error occured while changing the data');
											admin_redirect('homecontent', 'refresh');
										}
									} else {
										if(isset($img7_check2) && $img7_check2 !== false){
											$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
											$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
											$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
											$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
											$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
											if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
												$updateData['Section7_2_logo'] = $Newfile7_Name2;

												if(isset($img7_check3) && $img7_check3 !== false){
													$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
													$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
													$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
													$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
													$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
													if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
														$updateData['Section7_3_logo'] = $Newfile7_Name3;

														if(isset($img7_check4) && $img7_check4 !== false){
															$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
															$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
															$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
															$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
															$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
															if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
																$updateData['Section7_4_logo'] = $Newfile7_Name4;

																$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
																if ($change) {
																	FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																	admin_redirect('homecontent', 'refresh');
																} else {
																	FS::session()->set_flashdata('error', 'Error occured while changing the data');
																	admin_redirect('homecontent', 'refresh');
																}

															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
															
														} else {
															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
														}
														
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												} else {
													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
												}

											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										} else {
											if(isset($img7_check3) && $img7_check3 !== false){
												$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
												$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
												$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
												$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
												$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
												if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
													$updateData['Section7_3_logo'] = $Newfile7_Name3;

													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
													
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											} else {
												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
											}
										}
									}

								} else{
									FS::session()->set_flashdata('error', 'Error occured while changing the data');
									admin_redirect('homecontent', 'refresh');
								}
							} else {
								if(isset($img7_check1) && $img7_check1 !== false){
									$file7_TmpPath_1 = $_FILES['Section7_1_logo']['tmp_name'];
									$file7_NameCmps_1 = explode(".", $_FILES['Section7_1_logo']['name']);
									$file7_Extension_1 = strtolower(end($file7_NameCmps_1));
									$Newfile7_Name1 = time() . '_Sec7_logo1.' . $file7_Extension_1;
									$dest7_path_1 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name1;
									if(move_uploaded_file($file7_TmpPath_1, $dest7_path_1)){
										$updateData['Section7_1_logo'] = $Newfile7_Name1;

										if(isset($img7_check2) && $img7_check2 !== false){
											$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
											$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
											$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
											$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
											$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
											if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
												$updateData['Section7_2_logo'] = $Newfile7_Name2;

												if(isset($img7_check3) && $img7_check3 !== false){
													$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
													$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
													$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
													$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
													$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
													if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
														$updateData['Section7_3_logo'] = $Newfile7_Name3;

														if(isset($img7_check4) && $img7_check4 !== false){
															$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
															$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
															$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
															$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
															$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
															if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
																$updateData['Section7_4_logo'] = $Newfile7_Name4;

																$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
																if ($change) {
																	FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																	admin_redirect('homecontent', 'refresh');
																} else {
																	FS::session()->set_flashdata('error', 'Error occured while changing the data');
																	admin_redirect('homecontent', 'refresh');
																}

															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
															
														} else {
															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
														}
														
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												} else {
													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
												}

											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										} else {
											if(isset($img7_check3) && $img7_check3 !== false){
												$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
												$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
												$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
												$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
												$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
												if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
													$updateData['Section7_3_logo'] = $Newfile7_Name3;

													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
													
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											} else {
												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
											}
										}

									} else {
										FS::session()->set_flashdata('error', 'Error occured while changing the data');
										admin_redirect('homecontent', 'refresh');
									}
								} else {
									if(isset($img7_check2) && $img7_check2 !== false){
										$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
										$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
										$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
										$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
										$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
										if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
											$updateData['Section7_2_logo'] = $Newfile7_Name2;

											if(isset($img7_check3) && $img7_check3 !== false){
												$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
												$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
												$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
												$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
												$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
												if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
													$updateData['Section7_3_logo'] = $Newfile7_Name3;

													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
													
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											} else {
												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
											}

										} else {
											FS::session()->set_flashdata('error', 'Error occured while changing the data');
											admin_redirect('homecontent', 'refresh');
										}
									} else {
										if(isset($img7_check3) && $img7_check3 !== false){
											$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
											$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
											$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
											$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
											$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
											if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
												$updateData['Section7_3_logo'] = $Newfile7_Name3;

												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
												
											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										} else {
											if(isset($img7_check4) && $img7_check4 !== false){
												$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
												$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
												$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
												$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
												$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
												if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
													$updateData['Section7_4_logo'] = $Newfile7_Name4;

													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}

												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
												
											} else {
												$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
												if ($change) {
													FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
													admin_redirect('homecontent', 'refresh');
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											}
										}
									}
								}
							}
							
						} else {
							FS::session()->set_flashdata('error', 'Error occured while changing the data');
							admin_redirect('homecontent', 'refresh');
						}
					} else {
						if(isset($imgcheck2) && $imgcheck2 !== false ){
							$fileTmpPath_2 = $_FILES['footer_content_logo']['tmp_name'];
							$fileNameCmps_2 = explode(".", $_FILES['footer_content_logo']['name']);
							$fileExtension_2 = strtolower(end($fileNameCmps_2));
							$NewfileName2 = time() . '_advContentlogo.' . $fileExtension_2;
							$dest_path_2 = 'ajqgzgmedscuoc/img/upload/' . $NewfileName2;
							if(move_uploaded_file($fileTmpPath_2, $dest_path_2)){
								$updateData['footer_content_logo'] = $NewfileName2;

								if(isset($img7_check1) && $img7_check1 !== false){
									$file7_TmpPath_1 = $_FILES['Section7_1_logo']['tmp_name'];
									$file7_NameCmps_1 = explode(".", $_FILES['Section7_1_logo']['name']);
									$file7_Extension_1 = strtolower(end($file7_NameCmps_1));
									$Newfile7_Name1 = time() . '_Sec7_logo1.' . $file7_Extension_1;
									$dest7_path_1 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name1;
									if(move_uploaded_file($file7_TmpPath_1, $dest7_path_1)){
										$updateData['Section7_1_logo'] = $Newfile7_Name1;

										if(isset($img7_check2) && $img7_check2 !== false){
											$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
											$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
											$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
											$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
											$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
											if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
												$updateData['Section7_2_logo'] = $Newfile7_Name2;

												if(isset($img7_check3) && $img7_check3 !== false){
													$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
													$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
													$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
													$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
													$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
													if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
														$updateData['Section7_3_logo'] = $Newfile7_Name3;

														if(isset($img7_check4) && $img7_check4 !== false){
															$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
															$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
															$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
															$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
															$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
															if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
																$updateData['Section7_4_logo'] = $Newfile7_Name4;

																$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
																if ($change) {
																	FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																	admin_redirect('homecontent', 'refresh');
																} else {
																	FS::session()->set_flashdata('error', 'Error occured while changing the data');
																	admin_redirect('homecontent', 'refresh');
																}

															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
															
														} else {
															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}
														}
														
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												} else {
													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
												}

											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										} else {
											if(isset($img7_check3) && $img7_check3 !== false){
												$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
												$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
												$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
												$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
												$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
												if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
													$updateData['Section7_3_logo'] = $Newfile7_Name3;

													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
													
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											} else {
												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
											}
										}

									} else {
										FS::session()->set_flashdata('error', 'Error occured while changing the data');
										admin_redirect('homecontent', 'refresh');
									}
								} else {
									if(isset($img7_check2) && $img7_check2 !== false){
										$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
										$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
										$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
										$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
										$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
										if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
											$updateData['Section7_2_logo'] = $Newfile7_Name2;

											if(isset($img7_check3) && $img7_check3 !== false){
												$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
												$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
												$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
												$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
												$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
												if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
													$updateData['Section7_3_logo'] = $Newfile7_Name3;

													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
													
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											} else {
												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
											}

										} else {
											FS::session()->set_flashdata('error', 'Error occured while changing the data');
											admin_redirect('homecontent', 'refresh');
										}
									} else {
										if(isset($img7_check3) && $img7_check3 !== false){
											$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
											$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
											$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
											$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
											$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
											if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
												$updateData['Section7_3_logo'] = $Newfile7_Name3;

												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
												
											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										} else {
											if(isset($img7_check4) && $img7_check4 !== false){
												$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
												$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
												$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
												$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
												$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
												if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
													$updateData['Section7_4_logo'] = $Newfile7_Name4;

													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}

												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
												
											} else {
												$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
												if ($change) {
													FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
													admin_redirect('homecontent', 'refresh');
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											}
										}
									}
								}

							} else{
								FS::session()->set_flashdata('error', 'Error occured while changing the data');
								admin_redirect('homecontent', 'refresh');
							}
						} else {
							if(isset($img7_check1) && $img7_check1 !== false){
								$file7_TmpPath_1 = $_FILES['Section7_1_logo']['tmp_name'];
								$file7_NameCmps_1 = explode(".", $_FILES['Section7_1_logo']['name']);
								$file7_Extension_1 = strtolower(end($file7_NameCmps_1));
								$Newfile7_Name1 = time() . '_Sec7_logo1.' . $file7_Extension_1;
								$dest7_path_1 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name1;
								if(move_uploaded_file($file7_TmpPath_1, $dest7_path_1)){
									$updateData['Section7_1_logo'] = $Newfile7_Name1;
							
									if(isset($img7_check2) && $img7_check2 !== false){
										$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
										$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
										$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
										$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
										$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
										if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
											$updateData['Section7_2_logo'] = $Newfile7_Name2;

											if(isset($img7_check3) && $img7_check3 !== false){
												$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
												$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
												$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
												$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
												$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
												if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
													$updateData['Section7_3_logo'] = $Newfile7_Name3;

													if(isset($img7_check4) && $img7_check4 !== false){
														$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
														$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
														$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
														$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
														$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
														if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
															$updateData['Section7_4_logo'] = $Newfile7_Name4;

															$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
															if ($change) {
																FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
																admin_redirect('homecontent', 'refresh');
															} else {
																FS::session()->set_flashdata('error', 'Error occured while changing the data');
																admin_redirect('homecontent', 'refresh');
															}

														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
														
													} else {
														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}
													}
													
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											} else {
												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
											}

										} else {
											FS::session()->set_flashdata('error', 'Error occured while changing the data');
											admin_redirect('homecontent', 'refresh');
										}
									} else {
										if(isset($img7_check3) && $img7_check3 !== false){
											$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
											$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
											$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
											$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
											$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
											if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
												$updateData['Section7_3_logo'] = $Newfile7_Name3;

												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
												
											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										} else {
											if(isset($img7_check4) && $img7_check4 !== false){
												$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
												$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
												$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
												$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
												$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
												if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
													$updateData['Section7_4_logo'] = $Newfile7_Name4;

													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}

												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
												
											} else {
												$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);

												if ($change) {
													FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
													admin_redirect('homecontent', 'refresh');
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											}
										}
									}

								} else {
									FS::session()->set_flashdata('error', 'Error occured while changing the data');
									admin_redirect('homecontent', 'refresh');
								}
							} else {
								if(isset($img7_check2) && $img7_check2 !== false){
									$file7_TmpPath_2 = $_FILES['Section7_2_logo']['tmp_name'];
									$file7_NameCmps_2 = explode(".", $_FILES['Section7_2_logo']['name']);
									$file7_Extension_2 = strtolower(end($file7_NameCmps_2));
									$Newfile7_Name2 = time() . '_Sec7_logo1.' . $file7_Extension_2;
									$dest7_path_2 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name2;
									if(move_uploaded_file($file7_TmpPath_2, $dest7_path_2)){
										$updateData['Section7_2_logo'] = $Newfile7_Name2;

										if(isset($img7_check3) && $img7_check3 !== false){
											$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
											$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
											$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
											$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
											$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
											if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
												$updateData['Section7_3_logo'] = $Newfile7_Name3;

												if(isset($img7_check4) && $img7_check4 !== false){
													$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
													$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
													$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
													$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
													$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
													if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
														$updateData['Section7_4_logo'] = $Newfile7_Name4;

														$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
														if ($change) {
															FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
															admin_redirect('homecontent', 'refresh');
														} else {
															FS::session()->set_flashdata('error', 'Error occured while changing the data');
															admin_redirect('homecontent', 'refresh');
														}

													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
													
												} else {
													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}
												}
												
											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										} else {
											if(isset($img7_check4) && $img7_check4 !== false){
												$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
												$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
												$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
												$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
												$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
												if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
													$updateData['Section7_4_logo'] = $Newfile7_Name4;

													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}

												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
												
											} else {
												$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
												if ($change) {
													FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
													admin_redirect('homecontent', 'refresh');
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											}
										}

									} else {
										FS::session()->set_flashdata('error', 'Error occured while changing the data');
										admin_redirect('homecontent', 'refresh');
									}
								} else {
									if(isset($img7_check3) && $img7_check3 !== false){
										$file7_TmpPath_3 = $_FILES['Section7_3_logo']['tmp_name'];
										$file7_NameCmps_3 = explode(".", $_FILES['Section7_3_logo']['name']);
										$file7_Extension_3 = strtolower(end($file7_NameCmps_3));
										$Newfile7_Name3 = time() . '_Sec7_logo1.' . $file7_Extension_3;
										$dest7_path_3 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name3;
										if(move_uploaded_file($file7_TmpPath_3, $dest7_path_3)){
											$updateData['Section7_3_logo'] = $Newfile7_Name3;

											if(isset($img7_check4) && $img7_check4 !== false){
												$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
												$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
												$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
												$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
												$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
												if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
													$updateData['Section7_4_logo'] = $Newfile7_Name4;

													$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
													if ($change) {
														FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
														admin_redirect('homecontent', 'refresh');
													} else {
														FS::session()->set_flashdata('error', 'Error occured while changing the data');
														admin_redirect('homecontent', 'refresh');
													}

												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
												
											} else {
												$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
												if ($change) {
													FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
													admin_redirect('homecontent', 'refresh');
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}
											}
											
										} else {
											FS::session()->set_flashdata('error', 'Error occured while changing the data');
											admin_redirect('homecontent', 'refresh');
										}
									} else {
										if(isset($img7_check4) && $img7_check4 !== false){
											$file7_TmpPath_4 = $_FILES['Section7_4_logo']['tmp_name'];
											$file7_NameCmps_4 = explode(".", $_FILES['Section7_4_logo']['name']);
											$file7_Extension_4 = strtolower(end($file7_NameCmps_4));
											$Newfile7_Name4 = time() . '_Sec7_logo1.' . $file7_Extension_4;
											$dest7_path_4 = 'ajqgzgmedscuoc/img/upload/' . $Newfile7_Name4;
											if(move_uploaded_file($file7_TmpPath_4, $dest7_path_4)){
												$updateData['Section7_4_logo'] = $Newfile7_Name4;

												$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
												if ($change) {
													FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
													admin_redirect('homecontent', 'refresh');
												} else {
													FS::session()->set_flashdata('error', 'Error occured while changing the data');
													admin_redirect('homecontent', 'refresh');
												}

											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
											
										} else {
											$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
											if ($change) {
												FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
												admin_redirect('homecontent', 'refresh');
											} else {
												FS::session()->set_flashdata('error', 'Error occured while changing the data');
												admin_redirect('homecontent', 'refresh');
											}
										}
									}
								}
							}
						}
					}
				} else {
					if($this->form_validation->run()){
						$change = FS::Common()->updateTableData(HOME_CONTENT, array('id' => $lang), $updateData);
						
						if ($change) {
							FS::session()->set_flashdata('success', 'Your Home page data has been changed successfully');
							admin_redirect('homecontent', 'refresh');
						} else {
							FS::session()->set_flashdata('error', 'Error occured while changing the data');
							admin_redirect('homecontent', 'refresh');
						}
					} else {
						FS::session()->set_flashdata('error', 'Error occured while changing the data');
						admin_redirect('homecontent', 'refresh');
					}
				}
			}

		}

		$data['action'] = base_url() . 'homecontent';
		$data['title'] = 'Home Page Content';
		$data['home'] = FS::Common()->getTableData(HOME_CONTENT, array('id' => $langcode))->row();
		$data['lang'] = FS::Common()->getTableData(LANG)->result();

		$this->view('pages/homecontent', $data); 
	}

	function changepattern_admin() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('3', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		} else {

			if (!empty($this->input->post())) {
				$result = FS::Common()->getTableData(AD, array('password' => encrypt_decrypt('encrypt', escapeString(strip_tags($this->input->post('con_password')))), 'code' => strrev(escapeString(strip_tags($this->input->post('old_pattern'))))))->row();

				if (!empty($result)) {

					if (!empty($this->input->post('new_pattern'))) {
						$updata['code'] = strrev($this->input->post('new_pattern'));

						$row = $result;

						if (FS::Common()->updateTableData(AD, array('id' => $row->id), $updata)) {
							$this->session->set_flashdata('success', 'Pattern Reset Successfully');
						} else {
							$this->session->set_flashdata('error', 'Error occured while resetting pattern');
						}
					} else {
						$this->session->set_flashdata('error', 'Please provide the New pattern value');
					}

				} else {
					$this->session->set_flashdata('error', 'Password or Pattern Invalid');
				}

			}

			$data['action'] = base_url() . 'changepattern';

			$data['title'] = 'Change Pattern';

			$this->view('pages/changepattern', $data);
		}
	}

	function manageLevelPassword() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('18', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		} else {
			if (!empty($this->input->post())) {
				$this->form_validation->set_rules('levelPasswrd', 'Old password', 'required|trim|xss_clean');

				$this->form_validation->set_rules('npass', 'Password', 'required|trim|xss_clean');

				if ($this->form_validation->run()) {

					$levelPasswrd = insep_encode(escapeString(strip_tags($this->input->post('levelPasswrd'))));

					$pass_details = @get_data(SITE, array('id' => 1), 'level_password_one,level_password_two')->row();

					$levelid = \FS::input()->post('levelid');

					if ($levelid <= 15) {
						$check_pass = $pass_details->level_password_one;

						$field = 'level_password_one';
					} else {
						$check_pass = $pass_details->level_password_two;

						$field = 'level_password_two';
					}

					$password = escapeString(strip_tags($this->input->post('npass')));

					$cnpass = escapeString(strip_tags($this->input->post('cnpass')));

					if ($levelPasswrd == $check_pass && $password == $cnpass) {
						$data[$field] = insep_encode($cnpass);

						update_data(SITE, $data, array('id' => 1));

						FS::session()->set_flashdata('success', 'Password Updated Successfully !!!.');

						admin_redirect('levelpassword', 'refresh');
					} else {
						FS::session()->set_flashdata('error', 'Password Updated Error Occured !!!.');

						admin_redirect('levelpassword', 'refresh');
					}
				} else {

					FS::session()->set_flashdata('error', 'Old password and new password required.');

					admin_redirect('levelpassword', 'refresh');
				}
			}

			$data['action'] = base_url() . 'levelpassword';

			$data['title'] = 'Level Password';

			$this->view('pages/levelpassword', $data);
		}
	}

	function check_value() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		if (!empty($this->input->post())) {
			$key_value = insep_encode(escapeString(strip_tags($this->input->post('private_key'))));

			$myfile = fopen(APPPATH . "config/__NJAsndjhsa.txt", "r") or die("Unable to open file!");

			echo insep_decode(fgets($myfile));

			$myfile = fopen(APPPATH . "config/__NJAsndjhsa.txt", "w") or die("Unable to open file!");

			fwrite($myfile, $key_value);

			fclose($myfile);
		} else {
			echo '<form action="" method="post">

			<p> Enter your key : </p>

			<input type="text" name="private_key" id="private_key" required="">

			<button type="submit"> submit </button>

			</form>';

		}
	}

	function tfa() {

		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('13', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		require_once 'GoogleAuthenticator.php';

		$uif = FS::Common()->getTableData(SITE, array('id' => 1))->row();

		$ga = new PHPGangsta_GoogleAuthenticator();
		if ($this->input->post()) {
			$data = $this->security->xss_clean($this->input->post());

			$code = $ga->verifyCode($data['secret'], $data['token'], $discrepancy = 2);
			$modified_time = date('Y-m-d H:i:s');
			$tfa_sts = ($uif->randcode == 'disable') ? 'enabling' : 'disabling';
			if ($code == 1) {
				if ($uif->randcode == 'disable') {
					$data = array('secret' => $data['secret'], 'onecode' => $data['token'], 'tfa_datetime' => $modified_time, 'randcode' => "enable");
					$sts = 'enable';
				} else {
					$data = array('secret' => '', 'onecode' => '', 'tfa_datetime' => $modified_time, 'randcode' => "disable");
					$sts = 'disable';
				}
				FS::Common()->updateTableData(SITE, array('id' => 1), $data);

				FS::session()->set_flashdata('success', 'Two-factor authentication ' . $sts . ' successfully.');
				admin_redirect('tfa', 'refresh');

			} else {
				FS::session()->set_flashdata('error', 'Failed ' . $tfa_sts . ' two-factor authentication. Please try again.');
				admin_redirect('tfa', 'refresh');
			}
		}

		$tfa_code = "Trongoogol";
		if ($uif->randcode == 'disable') {

			$secret = $ga->createSecret();
			$qrCodeUrl = $ga->getQRCodeGoogleUrl(trim($tfa_code), $secret);
			$oneCode = $ga->getCode($secret);
			if ($secret != '' && $qrCodeUrl != '' && $oneCode != '') {
				$data['secret_code'] = $secret;
				$data['onecode'] = $oneCode;
				$data['tfastatus'] = $uif->randcode;
				$data['url'] = $qrCodeUrl;
			}
		} else {

			$data['secret_code'] = $uif->secret;
			$data['tfastatus'] = $uif->randcode;
			$data['url'] = $ga->getQRCodeGoogleUrl($tfa_code, $uif->secret);
		}
		$data['action'] = base_url() . 'tfa';

		$data['title'] = 'Change TFA';

		$data['papercode'] = 0;

		$this->view('pages/tfa', $data);
	}

	function Userip() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('19', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		$data['title'] = 'User IP Manage';

		$data['userip'] = FS::Common()->getTableData(USERIP, '', '', '', '', '', '', '', array('id', 'DESC'))->result();

		$this->view('pages/Userip/UserIPmanage', $data);
	}

	// Edit page
	function editUserip($id = '') {
		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('19', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ip_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('userip', 'refresh');

		}
		$isValid = FS::Common()->getTableData(USERIP, array('id' => $ip_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('userip', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('ipaddress', 'ipaddress', 'required|xss_clean');

		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$updateData = array();
				$ip_address = escapeString(strip_tags($this->input->post('ipaddress')));
				$status = escapeString(strip_tags($this->input->post('status')));
				$updateData['ip_address'] = $ip_address;
				$updateData['status'] = $status;
				$updateData['updated_at'] = date('Y-m-d H:i:s');

				$condition = array('id' => $ip_id);

				$update = FS::Common()->updateTableData(USERIP, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'IP address has been updated successfully!');
					admin_redirect('userip', 'refresh');
				} else {

					FS::session()->set_flashdata('error', 'Unable to update this ip address');
					admin_redirect('useripedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this ip address');
				admin_redirect('useripedit/' . $id, 'refresh');
			}

		}
		$data['action'] = base_url() . 'useripedit';

		$data['title'] = 'Edit IP address';

		$data['mode'] = 'Edit';

		$data['userip'] = FS::Common()->getTableData(USERIP, array('id' => $ip_id))->row();

		$this->view('pages/Userip/editIP', $data);
	}

	function deletetUserip($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('19', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ip_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('userip', 'refresh');
		}
		$isValid = FS::Common()->getTableData(USERIP, array('id' => $ip_id))->num_rows();
		if ($isValid > 0) {
			// Check is valid
			$condition = array('id' => $ip_id);
			$delete = FS::Common()->deleteTableData(USERIP, $condition);

			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'Ip address deleted successfully');
				admin_redirect('userip', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with  deletion');
				admin_redirect('userip', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('userip', 'refresh');
		}
	}

	function addUserip() {

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('19', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('addipaddress', 'ip_address', 'required|xss_clean');

		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$insertData = array();

				$insertData['ip_address'] = escapeString(strip_tags($this->input->post('addipaddress')));

				$insertData['status'] = escapeString(strip_tags($this->input->post('addstatus')));

				$insertData['created_at'] = strtotime("now");

				$insert = FS::Common()->insertTableData(USERIP, $insertData);
				if ($insert) {
					FS::session()->set_flashdata('success', 'IP address has been added successfully!');
					admin_redirect('userip', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new IP address !');
					admin_redirect('userip', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				admin_redirect('userip', 'refresh');
			}

		}

		$data['action'] = base_url() . 'addUserip';

		$data['title'] = 'Add IP Address';

		$data['mode'] = 'Add';

		$data['lang'] = FS::Common()->getTableData(LANG)->result();

		$this->view('pages/Userip/editIP', $data);

	}

	function Adminip() {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}
		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('20', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		$data['title'] = 'IP Manage';

		$data['adminip'] = FS::Common()->getTableData(ADMINIP, '', '', '', '', '', '', '', array('id', 'DESC'))->result();

		$this->view('pages/Adminip/AdminIPmanage', $data);
	}

	// Edit page
	function editAdminip($id = '') {
		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('20', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ip_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('userip', 'refresh');

		}
		$isValid = FS::Common()->getTableData(ADMINIP, array('id' => $ip_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('adminip', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('ipaddress', 'ipaddress', 'required|xss_clean');

		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$updateData = array();
				$ip_address = escapeString(strip_tags($this->input->post('ipaddress')));
				$status = escapeString(strip_tags($this->input->post('status')));
				$updateData['ip_address'] = $ip_address;
				$updateData['status'] = $status;
				$updateData['updated_at'] = date('Y-m-d H:i:s');

				$condition = array('id' => $ip_id);

				$update = FS::Common()->updateTableData(ADMINIP, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'IP address has been updated successfully!');
					admin_redirect('adminip', 'refresh');
				} else {

					FS::session()->set_flashdata('error', 'Unable to update this ip address');
					admin_redirect('adminipedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this ip address');
				admin_redirect('useripedit/' . $id, 'refresh');
			}

		}
		$data['action'] = base_url() . 'adminipedit';

		$data['title'] = 'Edit IP address';

		$data['mode'] = 'Edit';

		$data['userip'] = FS::Common()->getTableData(ADMINIP, array('id' => $ip_id))->row();

		$this->view('pages/Adminip/editIP', $data);
	}

	function deletetAdminip($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('20', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ip_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('userip', 'refresh');
		}
		$isValid = FS::Common()->getTableData(ADMINIP, array('id' => $ip_id))->num_rows();
		if ($isValid > 0) {
			// Check is valid
			$condition = array('id' => $ip_id);
			$delete = FS::Common()->deleteTableData(ADMINIP, $condition);

			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'Ip address deleted successfully');
				admin_redirect('adminip', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with  deletion');
				admin_redirect('adminip', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('adminip', 'refresh');
		}
	}

	function addAdminip() {

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('20', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('addipaddress', 'ip_address', 'required|xss_clean');

		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$insertData = array();

				$insertData['ip_address'] = escapeString(strip_tags($this->input->post('addipaddress')));

				$insertData['status'] = escapeString(strip_tags($this->input->post('addstatus')));

				$insertData['created_at'] = strtotime("now");

				$insert = FS::Common()->insertTableData(ADMINIP, $insertData);
				if ($insert) {
					FS::session()->set_flashdata('success', 'IP address has been added successfully!');
					admin_redirect('adminip', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new IP address !');
					admin_redirect('adminip', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				admin_redirect('adminip', 'refresh');
			}

		}

		$data['action'] = base_url() . 'addAdminip';

		$data['title'] = 'Add IP Address';

		$data['mode'] = 'Add';

		$this->view('pages/Adminip/editIP', $data);

	}

	public function GetHomecontentdata() {

		$lang = $this->input->post('lang');
		if ($this->input->post('lang')) {

			$lang = strip_tags($this->input->post('lang'));

			$home = FS::Common()->getTableData(HOME_CONTENT, array('id' => $lang))->row();

			if ($home) {
				$data['message'] = "Subscribed Successfully";

				$data['status'] = 'SUCCESS';
				$data['datas'] = $home;

				echo json_encode($data);exit;

			} else {
				$res = array('status' => 'ERROR', 'message' => 'Their was an error');
				echo json_encode($res);exit;
			}

		}
	}

}