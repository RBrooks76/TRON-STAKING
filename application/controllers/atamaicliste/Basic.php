<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basic extends Front_Controller {
	public function index() {
		$lang_code = FS::uri()->segment(1);
		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;
		$data['title'] = "Login Page";

		$data['doc'] = @FS::Common()->getTableData(DOC, array('language' => $lang))->result();
		$data['work'] = FS::Common()->getTableData(HOW_WORK, array('language' => $lang), '', '', '', '', '', '', array('id', 'DESC'))->result();
		$data['why'] = FS::Common()->getTableData(WHYCHOOSE, array('language' => $lang), '', '', '', '', '', '', array('id', 'DESC'))->result();
		$data['review'] = FS::Common()->getTableData(REVIEWS, array('status' => '1'), '', '', '', '', '', '', array('id', 'DESC'))->result();
		
		$home_content = FS::Common()->getTableData(HOME_CONTENT)->row();

		$home_data = array(
						   'Section7_1_head' => $home_content->Section7_1_head,
						   'Section7_1_content' => $home_content->Section7_1_content,
						   
						   'Section7_2_head' => $home_content->Section7_2_head,
						   'Section7_2_content' => $home_content->Section7_2_content,

						   'Section7_3_head' => $home_content->Section7_3_head,
						   'Section7_3_content' => $home_content->Section7_3_content,

						   'Section7_4_head' => $home_content->Section7_4_head,
						   'Section7_4_content' => $home_content->Section7_4_content,						   
						);

		foreach ($home_data as $key => $value) {
			$sourceLang = 'auto'; $targetLang = $lang_code; $sourceText = $value;
			$result = FS::Translate()->convert_request($sourceLang, $targetLang, $sourceText);
			if($result) {
				$text = '';
				foreach ($result as $value) { $text .= $value[0]; }
				$home_content->$key = $text;
			}
		}

		$data['home_content'] = $home_content;
		
		$data['address'] = FS::Common()->getTableData(ADDRESS)->row();
		$data['plan'] = FS::Common()->getTableData(PLAN_B, array('status' => '1', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();
		$data['plan_A'] = FS::Common()->getTableData(PLANS, array('status' => '1'), '', '', '', '', '', '', array('id', 'ASC'))->result();
		$data['is_referrer'] = 1;
		$data['referrer_id'] = 'TQL6e8xpwj1MtT1p6E9ENmhwVTVUFsCJyR';
		$data['referrer'] = 1;
		$data['Areferrer_id'] = ADMIN_ADDR;
		$data['Areferrer'] = 1;
		$data['tree_id'] = 1;
		$siteSettings = FS::Common()->getTableData(SITE, array('id' => 1), 'site_mode,api_live_url,api_demo_url,coin_usd_value')->row();
		$sitemode = $siteSettings->site_mode;
		$data['coin_usd_value'] = $siteSettings->coin_usd_value;
		
		if ($sitemode == '1') { $data['add_url'] = $siteSettings->api_live_url; }
		else if ($sitemode == '2') { $data['add_url'] = $siteSettings->api_demo_url; }
		else { $data['add_url'] = ''; }
		
		$data['users_count'] = FS::Common()->getTableData(USERS)->num_rows();
		$data['planb'] = FS::Common()->getTableData(PLAN_B, array('plan_type' => 'B', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();
		$data['lang'] = FS::Common()->getTableData(LANG)->result();
		if (juego_id()) {
			$_aref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 1), 'contract_id,tree_id,ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();
			if (($_aref_code->one_core_status == 1 && $_aref_code->ref_status == 0) || ($_aref_code->one_core_status == 0 && $_aref_code->ref_status == 1) || ($_aref_code->one_core_status == 0 && $_aref_code->ref_status == 0)) {
				findCore7($_aref_code->contract_id, 1, $_aref_code->tree_id);
			}

			if (($_aref_code->two_core_status == 0)) {
				findCore7($_aref_code->contract_id, 2, $_aref_code->tree_id);
			}

			if (($_aref_code->three_core_status == 0)) {
				findCore7($_aref_code->contract_id, 3, $_aref_code->tree_id);
			}

			if (!empty($_aref_code)) {
				if (!empty($_aref_code->ref_status)) $__aref_code = $_aref_code->ref_code;
				else $__aref_code = 0;
			}

			$_bref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 2), 'ref_code')->row();
			if (!empty($_bref_code)) {
				$__bref_code = $_bref_code->ref_code;
			}

			if (!empty($__bref_code)) {
				$data['ref_url_b'] = base_url() . $lang_code . '/refer/planb/' . $__bref_code;
			} else {
				$data['ref_url_b'] = 0;
			}

			if (!empty($__aref_code)) {
				$data['ref_url_a'] = base_url() . $lang_code . '/refer/plana/' . $__aref_code;

				$data['core_status'] = $_aref_code->one_core_status;
			} else {
				$data['ref_url_a'] = 0;

				$data['core_status'] = 0;
			}

			if (juego_id() == ADMIN_ADDR) {
				$data['tree_data'] = @get_data(RL, array('status' => 1), 'tree_id,referral_link')->result_array();
			}

			$data['with_history'] = @get_data(TRANS, array('address' => juego_id()))->result_array();
			$data['tree_id'] = $_aref_code->tree_id;
		}

		$isValid = FS::Common()->getTableData(CMS, array('link' => 'plan', 'language' => $lang));
		$data['cms'] =$isValid->num_rows() == 0? false: $isValid->row();
		
		$this->view(strtolower(CI_MODEL) . '/index', $data);
	}

	public function tree_details($tree_id = '') {
		$tree_id = insep_decode($tree_id); 

		$tree_id_check = @get_data(RL, array('status' => 1, 'tree_id' => $tree_id), 'tree_id')->row();

		if (!empty($tree_id_check)) {
			$lang_code = FS::uri()->segment(1);

			$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;

			$data['title'] = "Login Page";

			$data['doc'] = @FS::Common()->getTableData(DOC, array('language' => $lang))->row();

			$data['work'] = FS::Common()->getTableData(HOW_WORK, array('language' => $lang), '', '', '', '', '', '', array('id', 'DESC'))->result();

			$data['why'] = FS::Common()->getTableData(WHYCHOOSE, array('language' => $lang), '', '', '', '', '', '', array('id', 'DESC'))->result();

			$data['review'] = FS::Common()->getTableData(REVIEWS, array('status' => '1'), '', '', '', '', '', '', array('id', 'DESC'))->result();

			$data['home_content'] = FS::Common()->getTableData(HOME_CONTENT, array('language' => $lang))->row();

			$data['address'] = FS::Common()->getTableData(ADDRESS)->row();

			$data['plan'] = FS::Common()->getTableData(PLAN_B, array('status' => '1', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();

			$data['plan_A'] = FS::Common()->getTableData(PLANS, array('status' => '1'), '', '', '', '', '', '', array('id', 'ASC'))->result();

			$data['is_referrer'] = 1;

			$data['referrer_id'] = 'TQL6e8xpwj1MtT1p6E9ENmhwVTVUFsCJyR';

			$data['referrer'] = 1;

			$data['Areferrer_id'] = ADMIN_ADDR;

			$data['Areferrer'] = 1;

			$data['tree_id'] = !empty($tree_id) ? $tree_id : 1;

			$siteSettings = FS::Common()->getTableData(SITE, array('id' => 1), 'site_mode,api_live_url,api_demo_url,coin_usd_value')->row();

			$sitemode = $siteSettings->site_mode;
			$data['coin_usd_value'] = $siteSettings->coin_usd_value;
			if ($sitemode == '1') {
				$data['add_url'] = $siteSettings->api_live_url;
			} else if ($sitemode == '2') {
				$data['add_url'] = $siteSettings->api_demo_url;
			} else {
				$data['add_url'] = '';
			}

			$data['users_count'] = FS::Common()->getTableData(USERS)->num_rows();

			$data['planb'] = FS::Common()->getTableData(PLAN_B, array('plan_type' => 'B', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();

			$data['lang'] = FS::Common()->getTableData(LANG)->result();

			if (juego_id()) {
				$_aref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 1), 'contract_id,tree_id,ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();

				if (($_aref_code->one_core_status == 1 && $_aref_code->ref_status == 0) || ($_aref_code->one_core_status == 0 && $_aref_code->ref_status == 1) || ($_aref_code->one_core_status == 0 && $_aref_code->ref_status == 0)) {

					findCore7($_aref_code->contract_id, 1, $_aref_code->tree_id);
				}

				if (($_aref_code->two_core_status == 0)) {
					findCore7($_aref_code->contract_id, 2, $_aref_code->tree_id);
				}

				if (($_aref_code->three_core_status == 0)) {
					findCore7($_aref_code->contract_id, 3, $_aref_code->tree_id);
				}

				if (!empty($_aref_code)) {
					if (!empty($_aref_code->ref_status)) {
						$__aref_code = $_aref_code->ref_code;
					} else {
						$__aref_code = 0;
					}

				}

				$_bref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 2), 'ref_code')->row();

				if (!empty($_bref_code)) {
					$__bref_code = $_bref_code->ref_code;
				}

				if (!empty($__bref_code)) {
					$data['ref_url_b'] = base_url() . $lang_code . '/refer/planb/' . $__bref_code;
				} else {
					$data['ref_url_b'] = 0;
				}

				if (!empty($__aref_code)) {
					$data['ref_url_a'] = base_url() . $lang_code . '/refer/plana/' . $__aref_code;

					$data['core_status'] = $_aref_code->one_core_status;
				} else {
					$data['ref_url_a'] = 0;

					$data['core_status'] = 0;
				}

				if (juego_id() == ADMIN_ADDR) {
					$data['tree_data'] = @get_data(RL, array('status' => 1), 'tree_id,referral_link')->result_array();
				}

				$data['with_history'] = @get_data(TRANS, array('address' => juego_id()))->result_array();
			}

			$this->view(strtolower(CI_MODEL) . '/index', $data);
		} else {
			FS::session()->set_userdata('InvalidRef', 'Invalid Tree ID !!! ');
			front_redirect(base_url());
		}
	}

	public function referuser($plan = '', $id = '') {

		$lang_code = FS::uri()->segment(1);

		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;
		
		$data['title'] = "Login Page";
		
		$plan_id = $plan == 'plana' ? 1 : 2;
		
		
		if ($plan == 'plana') {
			$plan_id = 1;
		} else if ($plan == 'planb') {
			$plan_id = 2;
		} else {
			$plan_id = 3;
		}
		
		if ($plan_id == 3) {
			$chkID = @get_data(RL, array('tree_id' => $plan, 'referral_link' => $id), 'ref_link_id,tree_id')->row();
		} else {
			$chkID = @get_data(USERS, array('ref_code' => $id, 'plan_id' => $plan_id), 'id,address,contract_id,tree_id')->row();
		}
		
		if (!empty($chkID)) {
			$cookie = array(
				'name' => 'refer',
				'value' => $id,
				'expire' => '300',
				'secure' => TRUE,
			);
			
			$this->input->set_cookie($cookie);
			
			$data['faq'] = FS::Common()->getTableData(FAQ, array('language' => $lang, 'status' => '1'), '', '', '', '', '', '9', array('id', 'DESC'))->result();
			
			$data['doc'] = FS::Common()->getTableData(DOC, array('language' => $lang))->row();
			
			$data['work'] = FS::Common()->getTableData(HOW_WORK, array('language' => $lang))->result();
			
			$data['why'] = FS::Common()->getTableData(WHYCHOOSE, array('language' => $lang), '', '', '', '', '', '', array('id', 'DESC'))->result();
			
			$data['review'] = FS::Common()->getTableData(REVIEWS, array('status' => '1'), '', '', '', '', '', '', array('id', 'DESC'))->result();
			
			$data['home_content'] = FS::Common()->getTableData(HOME_CONTENT, array('language' => $lang))->row();
			
			$data['address'] = FS::Common()->getTableData(ADDRESS)->row();
			
			$data['users_count'] = FS::db()->query("select COUNT(*) as total_count from " . P . USERS . "")->row()->total_count;
			
			$data['plan'] = FS::Common()->getTableData(PLAN_B, array('status' => '1', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();
			
			$data['plan_A'] = FS::Common()->getTableData(PLANS, array('status' => '1'), '', '', '', '', '', '', array('id', 'ASC'))->result(); // 'language' => $lang
			
			$data['planb'] = FS::Common()->getTableData(PLAN_B, array('plan_type' => 'B', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();
			
			$data['lang'] = FS::Common()->getTableData(LANG)->result();
			
			$_aref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 1), 'ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();
			
			if (!empty($_aref_code)) {
				if (!empty($_aref_code->ref_status)) {
					$__aref_code = $_aref_code->ref_code;
				} else {
					$__aref_code = 0;
				}
			}
			
			
			$_bref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 2), 'ref_code')->row();
			
			if (!empty($_bref_code)) {
				$__bref_code = $_bref_code->ref_code;
			}
			
			if (!empty($__bref_code)) {
				$data['ref_url_b'] = base_url() . $lang_code . '/refer/planb/' . $__bref_code;
			} else {
				$data['ref_url_b'] = 0;
			}
			
			if (!empty($__aref_code)) {
				$data['ref_url_a'] = base_url() . $lang_code . '/refer/plana/' . $__aref_code;
				
				$data['core_status'] = $_aref_code->one_core_status;
			} else {
				$data['ref_url_a'] = 0;
				
				$data['core_status'] = 0;
			}
			
			$data['is_referrer'] = 1;
			if ($plan == 'plana') {
				$data['Areferrer'] = $chkID->contract_id;

				$data['Areferrer_id'] = $chkID->address;

				$data['tree_id'] = $chkID->tree_id;
			} else if ($plan == 'planb') {
				$data['referrer'] = $chkID->id;

				$data['referrer_id'] = $chkID->address;

				$data['tree_id'] = $chkID->tree_id;
			} else {
				$data['Areferrer'] = 1;

				$data['Areferrer_id'] = ADMIN_ADDR;

				$data['tree_id'] = $chkID->tree_id;
			}

			$siteSettings = FS::Common()->getTableData(SITE, array('id' => 1), 'site_mode,api_live_url,api_demo_url,coin_usd_value')->row();

			$sitemode = $siteSettings->site_mode;

			$data['coin_usd_value'] = $siteSettings->coin_usd_value;

			if ($sitemode == '1') {
				$data['add_url'] = $siteSettings->api_live_url;
			} else if ($sitemode == '2') {
				$data['add_url'] = $siteSettings->api_demo_url;
			} else {
				$data['add_url'] = '';
			}

			$this->view(strtolower(CI_MODEL) . '/index', $data);
		} else {
			FS::session()->set_userdata('InvalidRef', 'Invalid Referral ID !!! ');

			front_redirect(base_url());
		}

	}

	public function logout() {
		FS::session()->unset_userdata('tr_juego_id');

		FS::session()->unset_userdata('id_update');

		FS::session()->unset_userdata('address');

		FS::session()->unset_userdata('user_levels');

		FS::session()->unset_userdata('curr_level');

		FS::session()->unset_userdata('login_type');

		FS::session()->unset_userdata('levelPass');

		front_redirect(base_url());
	}

	function socketTrigger($start, $end) {
		$bdata['userid'] = '1';
		$bdata['start'] = $start;
		$bdata['end'] = $end;

		trigger_socket($bdata, 'socket');
	}

	function cms($id = '') {

		$lang_code = FS::uri()->segment(1);
		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;
		$isValid = FS::Common()->getTableData(CMS, array('link' => $id, 'language' => $lang));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			front_redirect('', 'refresh');
		}
		$data['review'] = FS::Common()->getTableData(REVIEWS, array('status' => '1'), '', '', '', '', '', '', array('id', 'DESC'))->result();
		$data['users_count'] = FS::Common()->getTableData(USERS)->num_rows();
		$data['cms'] = $isValid->row();
		$data['lang'] = FS::Common()->getTableData(LANG)->result();
		$data['doc'] = @FS::Common()->getTableData(DOC, array('language' => $lang))->row();

		$data['tree_id'] = 1;
		if (juego_id()) {
			$_aref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 1), 'contract_id,tree_id,ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();
			$data['tree_id'] = $_aref_code->tree_id;
		}

		$this->view(strtolower(CI_MODEL) . '/cms', $data);
	}

	function faqView() {
		$lang_code = FS::uri()->segment(1);
		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;
		$isValid = FS::Common()->getTableData(FAQ, array('language' => $lang, "status" => 1));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			front_redirect('', 'refresh');
		}

		$data['review'] = FS::Common()->getTableData(REVIEWS, array('status' => '1'), '', '', '', '', '', '', array('id', 'DESC'))->result();
		$data['users_count'] = FS::Common()->getTableData(USERS)->num_rows();
		$data['faq'] = $isValid->result();
		$data['lang'] = FS::Common()->getTableData(LANG)->result();
		$data['doc'] = @FS::Common()->getTableData(DOC, array('language' => $lang))->row();
		$data['tree_id'] = 1;

		if (juego_id()) {
			$_aref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 1), 'contract_id,tree_id,ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();
			$data['tree_id'] = $_aref_code->tree_id;
		}

		$this->view(strtolower(CI_MODEL) . '/faq', $data);
	}

	function notFound() {
		$lang_code = FS::uri()->segment(1);

		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;

		$data['lang'] = FS::Common()->getTableData(LANG)->result();

		$this->partial(strtolower(CI_MODEL) . '/notfound', $data);
	}

	function planDetail($id, $tree_id = '', $user_addr_ = '') {
		$id = insep_decode($id);
		$check_id = @get_data(PLANS, array('id' => $id), 'id')->row();
		
		if (!empty($check_id)) {
			if ($id == 1) {
				$plan_name = 'board_one';
				$plan_aname = 'affiliate_id';
				$plan_time = 'one_create_re_timestamp';
				$board_time = 'contract_id';
			} else if ($id == 2) {
				$plan_name = 'board_two';

				$plan_aname = 'board_two_affiliate_id';

				$plan_time = 'two_create_re_timestamp';

				$board_time = 'two_create_timestamp';
			} else if ($id == 3) {
				$plan_name = 'board_three';

				$plan_aname = 'board_three_affiliate_id';

				$plan_time = 'three_create_re_timestamp';

				$board_time = 'three_create_timestamp';
			}

			$lang_code = FS::uri()->segment(1);
			
			$user_addr = juego_id();
			
			if($user_addr_ && insep_decode($user_addr_)){
				$check_result = @get_data(USERS, array('id' => insep_decode($user_addr_), 'plan_id' => 1), 'id, address')->row();
				if(isset($check_result) && $check_result->id && $check_result->address){
					$user_addr = $check_result->address;
				}
			}

			if ($user_addr) {
				$_aref_code = FS::Common()->getTableData(USERS, array('address' => $user_addr, 'plan_id' => 1), 'contract_id,tree_id,ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();
				if (!empty($__aref_code)) {
					$data['ref_url_a'] = base_url() . $lang_code . '/refer/plana/' . $__aref_code;
					
					$data['core_status'] = $_aref_code->one_core_status;
				} else {
					$data['ref_url_a'] = 0;
					
					$data['core_status'] = 0;
				}
			}			
			
			$data['lang_code__'] = $lang_code;
			$user_contract_id = @get_data(USERS, array('address' => $user_addr, 'plan_id' => 1), 'id,contract_id,tree_id,' . $plan_name . '_cid,' . $plan_name . '_prev_id,' . $plan_name . '_cu_re_id,ref_id')->row();
			
			if (!empty($user_contract_id)) {
				$cl_nme = $plan_name . '_cid';
				$pv_nme = $plan_name . '_prev_id';
				$re_nme = $plan_name . '_cu_re_id';
				$re_me = $plan_name . '_re_id';
				$re_po = $plan_name . '_re_position';
				$contract_id = $user_contract_id->$cl_nme;
				$pv_board_id = $user_contract_id->$pv_nme;

				if (!empty($user_contract_id->ref_id) && !empty($user_contract_id->$re_nme)) {
					$cu_re_id = $user_contract_id->$re_nme;
					$select_query = 1;
				} else {
					$cu_re_id = $user_contract_id->$re_nme;
					$select_query = 0;
				}

				if (empty($contract_id)) {$contract_id = $user_contract_id->contract_id;}

				if (empty($tree_id) || empty(insep_decode($tree_id))) $tree_id = $user_contract_id->tree_id;
				else $tree_id = insep_decode($tree_id);
				
				$data['current_tree_id'] = $tree_id;

				if ($contract_id > 1) {
					$main_user = @get_data(USERS, array('contract_id' => $contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, contract_id,' . $plan_aname . ',' . $plan_name . ',' . $re_nme . ', plan_id,id as children')->result_array();
				} else {
					$main_user = @get_data(USERS, array('contract_id' => $contract_id, 'plan_id' => 1, $plan_name => $id), 'CONCAT("ID: " ,contract_id) as name, contract_id,' . $plan_aname . ',' . $plan_name . ',' . $re_nme . ', plan_id,id as children')->result_array();
				}

				if (empty($select_query)) {
					$udata = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY  $board_time ASC) products_sorted, (select @pv := $contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
				} else {
					$udata = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY   $plan_time ASC) products_sorted, (select @pv := $contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
				}

				if (($contract_id != $pv_board_id) && ($contract_id > 7)) {
					if ($pv_board_id > 1) {
						$prev_main_user = @get_data(USERS, array('contract_id' => $pv_board_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();
					} else {
						$prev_main_user = @get_data(USERS, array('contract_id' => $pv_board_id, 'plan_id' => 1, $plan_name => $id), 'CONCAT("ID: " ,contract_id) as name, contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();
					}

					if (!empty($prev_main_user)) {
						$data['prv_main_user'] = $prev_main_user;
						if (empty($select_query)) {
							$prev_udata = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pv_board_id) initialisation where   find_in_set($plan_aname, @pv)  and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
						} else {
							$prev_udata = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pv_board_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
						}

						if (!empty($prev_udata)) {
							$data['prev_user_tree'] = $prev_udata;
							if (!empty(@$prev_udata[6]['contract_id'])) {
								$pre_one_contract_id = $prev_udata[6]['contract_id'];
								if (empty($select_query)) {
									$pre_one_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_one_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_one_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_one_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								}
								$data['POuser_tree'] = $pre_one_data;
							}

							if (!empty(@$prev_udata[7]['contract_id'])) {
								$pre_two_contract_id = $prev_udata[7]['contract_id'];
								if (empty($select_query)) {
									$pre_two_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_two_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_two_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_two_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								}
								$data['PTuser_tree'] = $pre_two_data;
							}

							if (!empty(@$prev_udata[8]['contract_id'])) {
								$pre_three_contract_id = $prev_udata[8]['contract_id'];

								if (empty($select_query)) {
									$pre_three_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_three_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_three_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_three_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								}
								$data['PThuser_tree'] = $pre_three_data;
							}

							if (!empty(@$prev_udata[9]['contract_id'])) {
								$pre_four_contract_id = $prev_udata[9]['contract_id'];
								if (empty($select_query)) {
									$pre_four_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_four_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_four_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_four_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								}
								$data['PFuser_tree'] = $pre_four_data;
							}

							if (!empty(@$prev_udata[10]['contract_id'])) {
								$pre_five_contract_id = $prev_udata[10]['contract_id'];
								if (empty($select_query)) {
									$pre_five_data = FS::db()->query("select  *  from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_five_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_five_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_five_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								}
								$data['PFiuser_tree'] = $pre_five_data;
							}

							if (!empty(@$prev_udata[11]['contract_id'])) {
								$pre_six_contract_id = $prev_udata[11]['contract_id'];
								if (empty($select_query)) {
									$pre_six_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_six_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_six_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_six_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								}
								$data['Psiuser_tree'] = $pre_six_data;
							}

							if (!empty(@$prev_udata[12]['contract_id'])) {
								$pre_seven_contract_id = $prev_udata[12]['contract_id'];
								if (empty($select_query)) {
									$pre_seven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_seven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_seven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_seven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array(); 
								}
								$data['Pseuser_tree'] = $pre_seven_data;
							}

							if (!empty(@$prev_udata[13]['contract_id'])) {
								$pre_eight_contract_id = $prev_udata[13]['contract_id'];
								if (empty($select_query)) {
									$pre_eight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $pre_eight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								} else {
									$pre_eight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $pre_eight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
								}
								$data['Peuser_tree'] = $pre_eight_data;
							}
						} else {
							$data['prev_user_tree'] = '';
						}
					} else {
						$data['prv_main_user'] = '';
						$data['prev_user_tree'] = '';
					}
				}

				if (!empty($udata)) {
					if (!empty(@$udata[6]['contract_id'])) {
						$one_contract_id = $udata[6]['contract_id'];

						$one_main_user = @get_data(USERS, array('contract_id' => $one_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, one_core_status,contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$one_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $one_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
						} else {
							$one_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $one_contract_id) initialisation where find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
						}

						if (!empty(@$one_data[6]['contract_id'])) {
							$Oone_contract_id = $one_data[6]['contract_id'];
							if (empty($select_query)) {
								$Oone_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Oone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Oone_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Oone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['OOuser_tree'] = $Oone_data;
						}

						if (!empty(@$one_data[7]['contract_id'])) {
							$Otwo_contract_id = $one_data[7]['contract_id'];
							if (empty($select_query)) {
								$Otwo_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Otwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Otwo_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Otwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['OTuser_tree'] = $Otwo_data;
						}

						if (!empty(@$one_data[8]['contract_id'])) {
							$Othree_contract_id = $one_data[8]['contract_id'];
							if (empty($select_query)) {
								$Othree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Othree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Othree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Othree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['OThuser_tree'] = $Othree_data;
						}

						if (!empty(@$one_data[9]['contract_id'])) {
							$Ofour_contract_id = $one_data[9]['contract_id'];
							if (empty($select_query)) {
								$Ofour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Ofour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Ofour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Ofour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['OFuser_tree'] = $Ofour_data;
						}

						if (!empty(@$one_data[10]['contract_id'])) {
							$Ofive_contract_id = $one_data[10]['contract_id'];
							if (empty($select_query)) {
								$Ofive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Ofive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Ofive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Ofive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['OFiuser_tree'] = $Ofive_data;
						}

						if (!empty(@$one_data[11]['contract_id'])) {
							$Osix_contract_id = $one_data[11]['contract_id'];
							if (empty($select_query)) {
								$Osix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Osix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Osix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Osix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['Osiuser_tree'] = $Osix_data;
						}

						if (!empty(@$one_data[12]['contract_id'])) {
							$Oseven_contract_id = $one_data[12]['contract_id'];
							if (empty($select_query)) {
								$Oseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Oseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Oseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Oseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['Oseuser_tree'] = $Oseven_data;
						}

						if (!empty(@$one_data[13]['contract_id'])) {
							$Oeight_contract_id = $one_data[13]['contract_id'];
							if (empty($select_query)) {
								$Oeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Oeight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Oeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Oeight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array(); 
							}
							$data['Oeuser_tree'] = $Oeight_data;
						}

						if (count($one_data) >= 6) {
							if (empty($one_main_user[0]['one_core_status'])) {
								$one_one_mdata['one_core_status'] = 1;
								if ($id == 1) {
									$one_one_mdata['board_one_cid'] = $one_contract_id;
								} else if ($id == 2) {
									$one_one_mdata['board_two_cid'] = $one_contract_id;
								} else if ($id == 3) {
									$one_one_mdata['board_three_cid'] = $one_contract_id;
								}

								update_data(USERS, $one_one_mdata, array('contract_id' => $one_contract_id, 'tree_id' => $tree_id));

								$one_core_data = array_slice($one_data, 0, 6);

								if (empty($one_core_data[0]['one_core_status'])) {
									$one_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$one_one_data['board_one_cid'] = $one_contract_id;
									} else if ($id == 2) {
										$one_one_data['board_two_cid'] = $one_contract_id;
									} else if ($id == 3) {
										$one_one_data['board_three_cid'] = $one_contract_id;
									}

									update_data(USERS, $one_one_data, array('contract_id' => $one_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($one_core_data[1]['one_core_status'])) {
									$one_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$one_two_data['board_one_cid'] = $one_contract_id;
									} else if ($id == 2) {
										$one_two_data['board_two_cid'] = $one_contract_id;
									} else if ($id == 3) {
										$one_two_data['board_three_cid'] = $one_contract_id;
									}

									update_data(USERS, $one_two_data, array('contract_id' => $one_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($one_core_data[2]['one_core_status'])) {
									$one_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$one_three_data['board_one_cid'] = $one_contract_id;
									} else if ($id == 2) {
										$one_three_data['board_two_cid'] = $one_contract_id;
									} else if ($id == 3) {
										$one_three_data['board_three_cid'] = $one_contract_id;
									}

									update_data(USERS, $one_three_data, array('contract_id' => $one_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($one_core_data[3]['one_core_status'])) {
									$one_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$one_four_data['board_one_cid'] = $one_contract_id;
									} else if ($id == 2) {
										$one_four_data['board_two_cid'] = $one_contract_id;
									} else if ($id == 3) {
										$one_four_data['board_three_cid'] = $one_contract_id;
									}

									update_data(USERS, $one_four_data, array('contract_id' => $one_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($one_core_data[4]['one_core_status'])) {
									$one_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$one_five_data['board_one_cid'] = $one_contract_id;
									} else if ($id == 2) {
										$one_five_data['board_two_cid'] = $one_contract_id;
									} else if ($id == 3) {
										$one_five_data['board_three_cid'] = $one_contract_id;
									}

									update_data(USERS, $one_five_data, array('contract_id' => $one_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($one_core_data[5]['one_core_status'])) {
									$one_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$one_six_data['board_one_cid'] = $one_contract_id;
									} else if ($id == 2) {
										$one_six_data['board_two_cid'] = $one_contract_id;
									} else if ($id == 3) {
										$one_six_data['board_three_cid'] = $one_contract_id;
									}

									update_data(USERS, $one_six_data, array('contract_id' => $one_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}

							}
						}

						$data['Omain_user'] = $one_main_user;
						$data['Ouser_tree'] = $one_data;
					}

					if (!empty(@$udata[7]['contract_id'])) {
						$two_contract_id = $udata[7]['contract_id'];

						$tow_main_user = @get_data(USERS, array('contract_id' => $two_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, one_core_status,contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$two_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $two_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
						} else {
							$two_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $two_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 30")->result_array();
						}

						if (!empty(@$two_data[6]['contract_id'])) {
							$Tone_contract_id = $two_data[6]['contract_id'];
							if (empty($select_query)) {
								$TOtwo_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Tone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$TOtwo_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Tone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['TOuser_tree'] = $TOtwo_data;
						}

						if (!empty(@$two_data[7]['contract_id'])) {
							$Ttwo_contract_id = $two_data[7]['contract_id'];

							if (empty($select_query)) {
								$Ttwo_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Ttwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Ttwo_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Ttwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['TTuser_tree'] = $Ttwo_data;
						}

						if (!empty(@$two_data[8]['contract_id'])) {
							$Tthree_contract_id = $two_data[8]['contract_id'];
							if (empty($select_query)) {
								$Tthree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Tthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Tthree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Tthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['TThuser_tree'] = $Tthree_data;
						}

						if (!empty(@$two_data[9]['contract_id'])) {
							$Tfour_contract_id = $two_data[9]['contract_id'];

							if (empty($select_query)) {
								$Tfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Tfour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Tfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Tfour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['TFuser_tree'] = $Tfour_data;
						}

						if (!empty(@$two_data[10]['contract_id'])) {
							$Tfive_contract_id = $two_data[10]['contract_id'];

							if (empty($select_query)) {
								$Tfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Tfive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Tfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Tfive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['TFiuser_tree'] = $Tfive_data;
						}

						if (!empty(@$two_data[11]['contract_id'])) {
							$Tsix_contract_id = $two_data[11]['contract_id'];

							if (empty($select_query)) {
								$Tsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Tsix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Tsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Tsix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['Tsiuser_tree'] = $Tsix_data;
						}

						if (!empty(@$two_data[12]['contract_id'])) {
							$Tseven_contract_id = $two_data[12]['contract_id'];
							if (empty($select_query)) {
								$Tseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Tseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Tseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Tseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['Tseuser_tree'] = $Tseven_data;
						}

						if (!empty(@$two_data[13]['contract_id'])) {
							$Teight_contract_id = $two_data[13]['contract_id'];
							if (empty($select_query)) {
								$Teight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Teight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else { 
								$Teight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Teight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['Teuser_tree'] = $Teight_data;
						}

						if (count($two_data) >= 6) {
							if (empty($tow_main_user[0]['one_core_status'])) {
								$two_one_mdata['one_core_status'] = 1;
								if ($id == 1) {
									$two_one_mdata['board_one_cid'] = $two_contract_id;
								} else if ($id == 2) {
									$two_one_mdata['board_two_cid'] = $two_contract_id;
								} else if ($id == 3) {
									$two_one_mdata['board_three_cid'] = $two_contract_id;
								}

								update_data(USERS, $two_one_mdata, array('contract_id' => $two_contract_id, 'tree_id' => $tree_id));

								$two_core_data = array_slice($two_data, 0, 6);

								if (empty($two_core_data[0]['one_core_status'])) {
									$two_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$two_one_data['board_one_cid'] = $two_contract_id;
									} else if ($id == 2) {
										$two_one_data['board_two_cid'] = $two_contract_id;
									} else if ($id == 3) {
										$two_one_data['board_three_cid'] = $two_contract_id;
									}

									update_data(USERS, $two_one_data, array('contract_id' => $two_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($two_core_data[1]['one_core_status'])) {
									$two_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$two_two_data['board_one_cid'] = $two_contract_id;
									} else if ($id == 2) {
										$two_two_data['board_two_cid'] = $two_contract_id;
									} else if ($id == 3) {
										$two_two_data['board_three_cid'] = $two_contract_id;
									}

									update_data(USERS, $two_two_data, array('contract_id' => $two_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($two_core_data[2]['one_core_status'])) {
									$two_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$two_three_data['board_one_cid'] = $two_contract_id;
									} else if ($id == 2) {
										$two_three_data['board_two_cid'] = $two_contract_id;
									} else if ($id == 3) {
										$two_three_data['board_three_cid'] = $two_contract_id;
									}

									update_data(USERS, $two_three_data, array('contract_id' => $two_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($two_core_data[3]['one_core_status'])) {
									$two_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$two_four_data['board_one_cid'] = $two_contract_id;
									} else if ($id == 2) {
										$two_four_data['board_two_cid'] = $two_contract_id;
									} else if ($id == 3) {
										$two_four_data['board_three_cid'] = $two_contract_id;
									}

									update_data(USERS, $two_four_data, array('contract_id' => $two_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($two_core_data[4]['one_core_status'])) {
									$two_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$two_five_data['board_one_cid'] = $two_contract_id;
									} else if ($id == 2) {
										$two_five_data['board_two_cid'] = $two_contract_id;
									} else if ($id == 3) {
										$two_five_data['board_three_cid'] = $two_contract_id;
									}

									update_data(USERS, $two_five_data, array('contract_id' => $two_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($two_core_data[5]['one_core_status'])) {
									$two_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$two_six_data['board_one_cid'] = $two_contract_id;
									} else if ($id == 2) {
										$two_six_data['board_two_cid'] = $two_contract_id;
									} else if ($id == 3) {
										$two_six_data['board_three_cid'] = $two_contract_id;
									}

									update_data(USERS, $two_six_data, array('contract_id' => $two_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}
							}
						}

						$data['Tmain_user'] = $tow_main_user;

						$data['Tuser_tree'] = $two_data;
					}

					if (!empty(@$udata[8]['contract_id'])) {
						$three_contract_id = $udata[8]['contract_id'];

						$three_main_user = @get_data(USERS, array('contract_id' => $three_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, one_core_status,contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$three_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $three_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();
						} else {
							$three_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $three_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();
						}

						if (!empty(@$three_data[6]['contract_id'])) {
							$Thone_contract_id = $three_data[6]['contract_id'];
							if (empty($select_query)) {
								$ThOthree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Thone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$ThOthree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Thone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['ThOuser_tree'] = $ThOthree_data;
						}

						if (!empty(@$three_data[7]['contract_id'])) {
							$ThTtwo_contract_id = $three_data[7]['contract_id'];

							if (empty($select_query)) {
								$ThTthree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $ThTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$ThTthree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $ThTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['ThTuser_tree'] = $ThTthree_data;
						}

						if (!empty(@$three_data[8]['contract_id'])) {
							$ThTthree_contract_id = $three_data[8]['contract_id'];
							if (empty($select_query)) {
								$ThTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $ThTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$ThTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $ThTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['ThThuser_tree'] = $ThTree_data;
						}

						if (!empty(@$three_data[9]['contract_id'])) {
							$Thfour_contract_id = $three_data[9]['contract_id'];

							if (empty($select_query)) {
								$Thfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Thfour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Thfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Thfour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['ThFuser_tree'] = $Thfour_data;
						}

						if (!empty(@$three_data[10]['contract_id'])) {
							$Thfive_contract_id = $three_data[10]['contract_id'];

							if (empty($select_query)) {
								$Thfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Thfive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Thfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Thfive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}
							$data['ThFiuser_tree'] = $Thfive_data;
						}

						if (!empty(@$three_data[11]['contract_id'])) {
							$Thsix_contract_id = $three_data[11]['contract_id'];

							if (empty($select_query)) {
								$Thsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Thsix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Thsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Thsix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Thsiuser_tree'] = $Thsix_data;
						}

						if (!empty(@$three_data[12]['contract_id'])) {
							$Thseven_contract_id = $three_data[12]['contract_id'];

							if (empty($select_query)) {
								$Thseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Thseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Thseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Thseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Thseuser_tree'] = $Thseven_data;
						}

						if (!empty(@$three_data[13]['contract_id'])) {
							$Theight_contract_id = $three_data[13]['contract_id'];

							if (empty($select_query)) {
								$Theight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Theight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Theight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Theight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['Theuser_tree'] = $Theight_data;
						}

						if (count($three_data) >= 6) {
							if (empty($three_main_user[0]['one_core_status'])) {
								$three_one_mdata['one_core_status'] = 1;

								if ($id == 1) {
									$three_one_mdata['board_one_cid'] = $three_contract_id;
								} else if ($id == 2) {
									$three_one_mdata['board_two_cid'] = $three_contract_id;
								} else if ($id == 3) {
									$three_one_mdata['board_three_cid'] = $three_contract_id;
								}

								update_data(USERS, $three_one_mdata, array('contract_id' => $three_contract_id, 'tree_id' => $tree_id));

								$three_core_data = array_slice($three_data, 0, 6);

								if (empty($three_core_data[0]['one_core_status'])) {
									$three_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$three_one_data['board_one_cid'] = $three_contract_id;
									} else if ($id == 2) {
										$three_one_data['board_two_cid'] = $three_contract_id;
									} else if ($id == 3) {
										$three_one_data['board_three_cid'] = $three_contract_id;
									}

									update_data(USERS, $three_one_data, array('contract_id' => $three_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($three_core_data[1]['one_core_status'])) {
									$three_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$three_two_data['board_one_cid'] = $three_contract_id;
									} else if ($id == 2) {
										$three_two_data['board_two_cid'] = $three_contract_id;
									} else if ($id == 3) {
										$three_two_data['board_three_cid'] = $three_contract_id;
									}

									update_data(USERS, $three_two_data, array('contract_id' => $three_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($three_core_data[2]['one_core_status'])) {
									$three_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$three_three_data['board_one_cid'] = $three_contract_id;
									} else if ($id == 2) {
										$three_three_data['board_two_cid'] = $three_contract_id;
									} else if ($id == 3) {
										$three_three_data['board_three_cid'] = $three_contract_id;
									}

									update_data(USERS, $three_three_data, array('contract_id' => $three_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($three_core_data[3]['one_core_status'])) {
									$three_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$three_four_data['board_one_cid'] = $three_contract_id;
									} else if ($id == 2) {
										$three_four_data['board_two_cid'] = $three_contract_id;
									} else if ($id == 3) {
										$three_four_data['board_three_cid'] = $three_contract_id;
									}

									update_data(USERS, $three_four_data, array('contract_id' => $three_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($three_core_data[4]['one_core_status'])) {
									$three_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$three_five_data['board_one_cid'] = $three_contract_id;
									} else if ($id == 2) {
										$three_five_data['board_two_cid'] = $three_contract_id;
									} else if ($id == 3) {
										$three_five_data['board_three_cid'] = $three_contract_id;
									}

									update_data(USERS, $three_five_data, array('contract_id' => $three_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($three_core_data[5]['one_core_status'])) {
									$three_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$three_six_data['board_one_cid'] = $three_contract_id;
									} else if ($id == 2) {
										$three_six_data['board_two_cid'] = $three_contract_id;
									} else if ($id == 3) {
										$three_six_data['board_three_cid'] = $three_contract_id;
									}

									update_data(USERS, $three_six_data, array('contract_id' => $three_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}
							}
						}

						$data['Thmain_user'] = $three_main_user;

						$data['Thuser_tree'] = $three_data;
					}

					if (!empty(@$udata[9]['contract_id'])) {
						$four_contract_id = $udata[9]['contract_id'];

						$four_main_user = @get_data(USERS, array('contract_id' => $four_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, one_core_status,contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$four_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $four_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

						} else {
							$four_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $four_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();
						}

						if (!empty(@$four_data[6]['contract_id'])) {
							$Fone_contract_id = $four_data[6]['contract_id'];

							if (empty($select_query)) {
								$FOfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$FOfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['FOuser_tree'] = $FOfour_data;
						}

						if (!empty(@$four_data[7]['contract_id'])) {
							$FTtwo_contract_id = $four_data[7]['contract_id'];

							if (empty($select_query)) {
								$FTfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $FTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$FTfour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $FTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FTuser_tree'] = $FTfour_data;
						}

						if (!empty(@$four_data[8]['contract_id'])) {
							$FTthree_contract_id = $four_data[8]['contract_id'];

							if (empty($select_query)) {
								$FTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $FTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$FTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $FTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FThuser_tree'] = $FTree_data;
						}

						if (!empty(@$four_data[9]['contract_id'])) {
							$Ffour_contract_id = $four_data[9]['contract_id'];

							if (empty($select_query)) {
								$Ffour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Ffour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Ffour_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Ffour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FFuser_tree'] = $Ffour_data;
						}

						if (!empty(@$four_data[10]['contract_id'])) {
							$Ffive_contract_id = $four_data[10]['contract_id'];

							if (empty($select_query)) {
								$Ffive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Ffive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Ffive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Ffive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FFiuser_tree'] = $Ffive_data;
						}

						if (!empty(@$four_data[11]['contract_id'])) {
							$Fsix_contract_id = $four_data[11]['contract_id'];

							if (empty($select_query)) {
								$Fsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fsix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Fsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fsix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Fsiuser_tree'] = $Fsix_data;
						}

						if (!empty(@$four_data[12]['contract_id'])) {
							$Fseven_contract_id = $four_data[12]['contract_id'];

							if (empty($select_query)) {
								$Fseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Fseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Fseuser_tree'] = $Fseven_data;
						}

						if (!empty(@$four_data[13]['contract_id'])) {
							$Feight_contract_id = $four_data[13]['contract_id'];

							if (empty($select_query)) {
								$Feight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Feight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Feight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Feight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['Feuser_tree'] = $Feight_data;
						}

						$data['Fmain_user'] = $four_main_user;

						$data['Fuser_tree'] = $four_data;

						if (count($four_data) >= 6) {
							if (empty($four_main_user[0]['one_core_status'])) {
								$four_one_mdata['one_core_status'] = 1;

								if ($id == 1) {
									$four_one_mdata['board_one_cid'] = $four_contract_id;
								} else if ($id == 2) {
									$four_one_mdata['board_two_cid'] = $four_contract_id;
								} else if ($id == 3) {
									$four_one_mdata['board_three_cid'] = $four_contract_id;
								}

								update_data(USERS, $four_one_mdata, array('contract_id' => $four_contract_id, 'tree_id' => $tree_id));

								$four_core_data = array_slice($four_data, 0, 6);

								if (empty($four_core_data[0]['one_core_status'])) {
									$four_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$four_one_data['board_one_cid'] = $four_contract_id;
									} else if ($id == 2) {
										$four_one_data['board_two_cid'] = $four_contract_id;
									} else if ($id == 3) {
										$four_one_data['board_three_cid'] = $four_contract_id;
									}

									update_data(USERS, $four_one_data, array('contract_id' => $four_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($four_core_data[1]['one_core_status'])) {
									$four_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$four_two_data['board_one_cid'] = $four_contract_id;
									} else if ($id == 2) {
										$four_two_data['board_two_cid'] = $four_contract_id;
									} else if ($id == 3) {
										$four_two_data['board_three_cid'] = $four_contract_id;
									}

									update_data(USERS, $four_two_data, array('contract_id' => $four_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($four_core_data[2]['one_core_status'])) {
									$four_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$four_three_data['board_one_cid'] = $four_contract_id;
									} else if ($id == 2) {
										$four_three_data['board_two_cid'] = $four_contract_id;
									} else if ($id == 3) {
										$four_three_data['board_three_cid'] = $four_contract_id;
									}

									update_data(USERS, $four_three_data, array('contract_id' => $four_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($four_core_data[3]['one_core_status'])) {
									$four_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$four_four_data['board_one_cid'] = $four_contract_id;
									} else if ($id == 2) {
										$four_four_data['board_two_cid'] = $four_contract_id;
									} else if ($id == 3) {
										$four_four_data['board_three_cid'] = $four_contract_id;
									}

									update_data(USERS, $four_four_data, array('contract_id' => $four_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($four_core_data[4]['one_core_status'])) {
									$four_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$four_five_data['board_one_cid'] = $four_contract_id;
									} else if ($id == 2) {
										$four_five_data['board_two_cid'] = $four_contract_id;
									} else if ($id == 3) {
										$four_five_data['board_three_cid'] = $four_contract_id;
									}

									update_data(USERS, $four_five_data, array('contract_id' => $four_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($four_core_data[5]['one_core_status'])) {
									$four_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$four_six_data['board_one_cid'] = $four_contract_id;
									} else if ($id == 2) {
										$four_six_data['board_two_cid'] = $four_contract_id;
									} else if ($id == 3) {
										$four_six_data['board_three_cid'] = $four_contract_id;
									}

									update_data(USERS, $four_six_data, array('contract_id' => $four_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}
							}
						}
					}

					if (!empty(@$udata[10]['contract_id'])) {
						$five_contract_id = $udata[10]['contract_id'];

						$five_main_user = @get_data(USERS, array('contract_id' => $five_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, one_core_status,contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$five_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $five_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

						} else {
							$five_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $five_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();
						}

						if (!empty(@$five_data[6]['contract_id'])) {
							$Fione_contract_id = $five_data[6]['contract_id'];

							if (empty($select_query)) {
								$FiOfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fione_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$FiOfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fione_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['FiOuser_tree'] = $FiOfive_data;
						}

						if (!empty(@$five_data[7]['contract_id'])) {
							$FiTtwo_contract_id = $five_data[7]['contract_id'];

							if (empty($select_query)) {
								$FiTfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $FiTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$FiTfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $FiTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FiTuser_tree'] = $FiTfive_data;
						}

						if (!empty(@$five_data[8]['contract_id'])) {
							$FiTthree_contract_id = $five_data[8]['contract_id'];

							if (empty($select_query)) {
								$FiTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $FiTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$FiTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $FiTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FiThuser_tree'] = $FiTree_data;
						}

						if (!empty(@$five_data[9]['contract_id'])) {
							$Fifour_contract_id = $five_data[9]['contract_id'];

							if (empty($select_query)) {
								$FiFfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fifour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$FiFfive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fifour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FiFuuser_tree'] = $FiFfive_data;
						}

						if (!empty(@$five_data[10]['contract_id'])) {
							$Fifive_contract_id = $five_data[10]['contract_id'];

							if (empty($select_query)) {
								$Fifive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fifive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Fifive_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fifive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FiFuser_tree'] = $Fifive_data;
						}

						if (!empty(@$five_data[11]['contract_id'])) {
							$Fisix_contract_id = $five_data[11]['contract_id'];

							if (empty($select_query)) {
								$Fisix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fisix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Fisix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fisix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Fisiuser_tree'] = $Fisix_data;
						}

						if (!empty(@$five_data[12]['contract_id'])) {
							$Fiseven_contract_id = $five_data[12]['contract_id'];

							if (empty($select_query)) {
								$Fiseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fiseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Fiseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fiseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Fiseuser_tree'] = $Fiseven_data;
						}

						if (!empty(@$five_data[13]['contract_id'])) {
							$Fieight_contract_id = $five_data[13]['contract_id'];

							if (empty($select_query)) {
								$Fieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Fieight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Fieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Fieight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['Fieuser_tree'] = $Fieight_data;
						}

						$data['Fimain_user'] = $five_main_user;

						$data['Fiuser_tree'] = $five_data;

						if (count($five_data) >= 6) {
							if (empty($five_main_user[0]['one_core_status'])) {
								$five_one_mdata['one_core_status'] = 1;

								if ($id == 1) {
									$five_one_mdata['board_one_cid'] = $five_contract_id;
								} else if ($id == 2) {
									$five_one_mdata['board_two_cid'] = $five_contract_id;
								} else if ($id == 3) {
									$five_one_mdata['board_three_cid'] = $five_contract_id;
								}

								update_data(USERS, $five_one_mdata, array('contract_id' => $five_contract_id, 'tree_id' => $tree_id));

								$five_core_data = array_slice($five_data, 0, 6);

								if (empty($five_core_data[0]['one_core_status'])) {
									$five_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$five_one_data['board_one_cid'] = $five_contract_id;
									} else if ($id == 2) {
										$five_one_data['board_two_cid'] = $five_contract_id;
									} else if ($id == 3) {
										$five_one_data['board_three_cid'] = $five_contract_id;
									}

									update_data(USERS, $five_one_data, array('contract_id' => $five_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($five_core_data[1]['one_core_status'])) {
									$five_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$five_two_data['board_one_cid'] = $five_contract_id;
									} else if ($id == 2) {
										$five_two_data['board_two_cid'] = $five_contract_id;
									} else if ($id == 3) {
										$five_two_data['board_three_cid'] = $five_contract_id;
									}

									update_data(USERS, $five_two_data, array('contract_id' => $five_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($five_core_data[2]['one_core_status'])) {
									$five_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$five_three_data['board_one_cid'] = $five_contract_id;
									} else if ($id == 2) {
										$five_three_data['board_two_cid'] = $five_contract_id;
									} else if ($id == 3) {
										$five_three_data['board_three_cid'] = $five_contract_id;
									}

									update_data(USERS, $five_three_data, array('contract_id' => $five_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($five_core_data[3]['one_core_status'])) {
									$five_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$five_four_data['board_one_cid'] = $five_contract_id;
									} else if ($id == 2) {
										$five_four_data['board_two_cid'] = $five_contract_id;
									} else if ($id == 3) {
										$five_four_data['board_three_cid'] = $five_contract_id;
									}

									update_data(USERS, $five_four_data, array('contract_id' => $five_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($five_core_data[4]['one_core_status'])) {
									$five_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$five_five_data['board_one_cid'] = $five_contract_id;
									} else if ($id == 2) {
										$five_five_data['board_two_cid'] = $five_contract_id;
									} else if ($id == 3) {
										$five_five_data['board_three_cid'] = $five_contract_id;
									}

									update_data(USERS, $five_five_data, array('contract_id' => $five_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($five_core_data[5]['one_core_status'])) {
									$five_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$five_six_data['board_one_cid'] = $five_contract_id;
									} else if ($id == 2) {
										$five_six_data['board_two_cid'] = $five_contract_id;
									} else if ($id == 3) {
										$five_six_data['board_three_cid'] = $five_contract_id;
									}

									update_data(USERS, $five_six_data, array('contract_id' => $five_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}
							}
						}
					}

					if (!empty(@$udata[11]['contract_id'])) {
						$six_contract_id = $udata[11]['contract_id'];

						$six_main_user = @get_data(USERS, array('contract_id' => $six_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, one_core_status,contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$six_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $six_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();
						} else {
							$six_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $six_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();
						}

						if (!empty(@$six_data[6]['contract_id'])) {
							$Sione_contract_id = $six_data[6]['contract_id'];

							if (empty($select_query)) {
								$SiOsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sione_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SiOsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sione_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['SiOuser_tree'] = $SiOsix_data;
						}

						if (!empty(@$six_data[7]['contract_id'])) {
							$SiTtwo_contract_id = $six_data[7]['contract_id'];

							if (empty($select_query)) {
								$SiTsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $SiTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SiTsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $SiTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['SiTuser_tree'] = $SiTsix_data;
						}

						if (!empty(@$six_data[8]['contract_id'])) {
							$SiTthree_contract_id = $six_data[8]['contract_id'];

							if (empty($select_query)) {
								$SiTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $SiTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SiTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $SiTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['SiThuser_tree'] = $SiTree_data;
						}

						if (!empty(@$six_data[9]['contract_id'])) {
							$Sifour_contract_id = $six_data[9]['contract_id'];

							if (empty($select_query)) {
								$SiFsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sifour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SiFsix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sifour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['SiFuuser_tree'] = $SiFsix_data;
						}

						if (!empty(@$six_data[10]['contract_id'])) {
							$Sifive_contract_id = $six_data[10]['contract_id'];

							if (empty($select_query)) {
								$SFisix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sifive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SFisix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sifive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['SiFuser_tree'] = $SFisix_data;
						}

						if (!empty(@$six_data[11]['contract_id'])) {
							$Sisix_contract_id = $six_data[11]['contract_id'];

							if (empty($select_query)) {
								$Sisix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sisix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Sisix_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sisix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Sisiuser_tree'] = $Sisix_data;
						}

						if (!empty(@$six_data[12]['contract_id'])) {
							$Siseven_contract_id = $six_data[12]['contract_id'];

							if (empty($select_query)) {
								$Siseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Siseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Siseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Siseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Siseuser_tree'] = $Siseven_data;
						}

						if (!empty(@$six_data[13]['contract_id'])) {
							$Sieight_contract_id = $six_data[13]['contract_id'];

							if (empty($select_query)) {
								$Sieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sieight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Sieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sieight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['Sieuser_tree'] = $Sieight_data;
						}

						$data['simain_user'] = $six_main_user;

						$data['siuser_tree'] = $six_data;

						if (count($six_data) >= 6) {
							if (empty($six_main_user[0]['one_core_status'])) {
								$six_one_mdata['one_core_status'] = 1;

								if ($id == 1) {
									$six_one_mdata['board_one_cid'] = $six_contract_id;
								} else if ($id == 2) {
									$six_one_mdata['board_two_cid'] = $six_contract_id;
								} else if ($id == 3) {
									$six_one_mdata['board_three_cid'] = $six_contract_id;
								}

								update_data(USERS, $six_one_mdata, array('contract_id' => $six_contract_id, 'tree_id' => $tree_id));

								$six_core_data = array_slice($six_data, 0, 6);

								if (empty($six_core_data[0]['one_core_status'])) {
									$six_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$six_one_data['board_one_cid'] = $six_contract_id;
									} else if ($id == 2) {
										$six_one_data['board_two_cid'] = $six_contract_id;
									} else if ($id == 3) {
										$six_one_data['board_three_cid'] = $six_contract_id;
									}

									update_data(USERS, $six_one_data, array('contract_id' => $six_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($six_core_data[1]['one_core_status'])) {
									$six_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$six_two_data['board_one_cid'] = $six_contract_id;
									} else if ($id == 2) {
										$six_two_data['board_two_cid'] = $six_contract_id;
									} else if ($id == 3) {
										$six_two_data['board_three_cid'] = $six_contract_id;
									}

									update_data(USERS, $six_two_data, array('contract_id' => $six_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($six_core_data[2]['one_core_status'])) {
									$six_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$six_three_data['board_one_cid'] = $six_contract_id;
									} else if ($id == 2) {
										$six_three_data['board_two_cid'] = $six_contract_id;
									} else if ($id == 3) {
										$six_three_data['board_three_cid'] = $six_contract_id;
									}

									update_data(USERS, $six_three_data, array('contract_id' => $six_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($six_core_data[3]['one_core_status'])) {
									$six_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$six_four_data['board_one_cid'] = $six_contract_id;
									} else if ($id == 2) {
										$six_four_data['board_two_cid'] = $six_contract_id;
									} else if ($id == 3) {
										$six_four_data['board_three_cid'] = $six_contract_id;
									}

									update_data(USERS, $six_four_data, array('contract_id' => $six_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($six_core_data[4]['one_core_status'])) {
									$six_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$six_five_data['board_one_cid'] = $six_contract_id;
									} else if ($id == 2) {
										$six_five_data['board_two_cid'] = $six_contract_id;
									} else if ($id == 3) {
										$six_five_data['board_three_cid'] = $six_contract_id;
									}

									update_data(USERS, $six_five_data, array('contract_id' => $six_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($six_core_data[5]['one_core_status'])) {
									$six_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$six_six_data['board_one_cid'] = $six_contract_id;
									} else if ($id == 2) {
										$six_six_data['board_two_cid'] = $six_contract_id;
									} else if ($id == 3) {
										$six_six_data['board_three_cid'] = $six_contract_id;
									}

									update_data(USERS, $six_six_data, array('contract_id' => $six_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}
							}
						}
					}

					if (!empty(@$udata[12]['contract_id'])) {
						$seven_contract_id = $udata[12]['contract_id'];

						$seven_main_user = @get_data(USERS, array('contract_id' => $seven_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$seven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $seven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

						} else {
							$seven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $seven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();
						}

						if (!empty(@$seven_data[6]['contract_id'])) {
							$Seone_contract_id = $seven_data[6]['contract_id'];

							if (empty($select_query)) {
								$SeOseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Seone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SeOseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Seone_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['SeOuser_tree'] = $SeOseven_data;
						}

						if (!empty(@$seven_data[7]['contract_id'])) {
							$SeTtwo_contract_id = $seven_data[7]['contract_id'];

							if (empty($select_query)) {
								$SeTseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $SeTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SeTseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $SeTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['SeTuser_tree'] = $SeTseven_data;
						}

						if (!empty(@$seven_data[8]['contract_id'])) {
							$SeTthree_contract_id = $seven_data[8]['contract_id'];

							if (empty($select_query)) {
								$SeTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $SeTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SeTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $SeTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['SeThuser_tree'] = $SeTree_data;
						}

						if (!empty(@$seven_data[9]['contract_id'])) {
							$Sefour_contract_id = $seven_data[9]['contract_id'];

							if (empty($select_query)) {
								$SeFseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sefour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SeFseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sefour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['FeFuuser_tree'] = $SeFseven_data;
						}

						if (!empty(@$seven_data[10]['contract_id'])) {
							$Sefive_contract_id = $seven_data[10]['contract_id'];

							if (empty($select_query)) {
								$SeFiseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sefive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$SeFiseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sefive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['SeFuser_tree'] = $SeFiseven_data;
						}

						if (!empty(@$seven_data[11]['contract_id'])) {
							$Sesix_contract_id = $seven_data[11]['contract_id'];

							if (empty($select_query)) {
								$SeSiseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Sesix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$SeSiseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Sesix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Sesiuser_tree'] = $SeSiseven_data;
						}

						if (!empty(@$seven_data[12]['contract_id'])) {
							$Seseven_contract_id = $seven_data[12]['contract_id'];

							if (empty($select_query)) {
								$Seseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Seseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Seseven_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Seseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Seseuser_tree'] = $Seseven_data;
						}

						if (!empty(@$seven_data[13]['contract_id'])) {
							$Seeight_contract_id = $seven_data[13]['contract_id'];

							if (empty($select_query)) {
								$Seeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Seeight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Seeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Seeight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['Seeuser_tree'] = $Seeight_data;
						}

						$data['semain_user'] = $seven_main_user;

						$data['seuser_tree'] = $seven_data;

						if (count($seven_data) >= 6) {
							if (empty($seven_main_user[0]['one_core_status'])) {
								$seven_one_mdata['one_core_status'] = 1;

								if ($id == 1) {
									$seven_one_mdata['board_one_cid'] = $seven_contract_id;
								} else if ($id == 2) {
									$seven_one_mdata['board_two_cid'] = $seven_contract_id;
								} else if ($id == 3) {
									$seven_one_mdata['board_three_cid'] = $seven_contract_id;
								}

								update_data(USERS, $seven_one_mdata, array('contract_id' => $seven_contract_id, 'tree_id' => $tree_id));

								$seven_core_data = array_slice($seven_data, 0, 6);

								if (empty($seven_core_data[0]['one_core_status'])) {
									$seven_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$seven_one_data['board_one_cid'] = $seven_contract_id;
									} else if ($id == 2) {
										$seven_one_data['board_two_cid'] = $seven_contract_id;
									} else if ($id == 3) {
										$seven_one_data['board_three_cid'] = $seven_contract_id;
									}

									update_data(USERS, $seven_one_data, array('contract_id' => $seven_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($seven_core_data[1]['one_core_status'])) {
									$seven_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$seven_two_data['board_one_cid'] = $seven_contract_id;
									} else if ($id == 2) {
										$seven_two_data['board_two_cid'] = $seven_contract_id;
									} else if ($id == 3) {
										$seven_two_data['board_three_cid'] = $seven_contract_id;
									}

									update_data(USERS, $seven_two_data, array('contract_id' => $seven_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($seven_core_data[2]['one_core_status'])) {
									$seven_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$seven_three_data['board_one_cid'] = $seven_contract_id;
									} else if ($id == 2) {
										$seven_three_data['board_two_cid'] = $seven_contract_id;
									} else if ($id == 3) {
										$seven_three_data['board_three_cid'] = $seven_contract_id;
									}

									update_data(USERS, $seven_three_data, array('contract_id' => $seven_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($seven_core_data[3]['one_core_status'])) {
									$seven_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$seven_four_data['board_one_cid'] = $seven_contract_id;
									} else if ($id == 2) {
										$seven_four_data['board_two_cid'] = $seven_contract_id;
									} else if ($id == 3) {
										$seven_four_data['board_three_cid'] = $seven_contract_id;
									}

									update_data(USERS, $seven_four_data, array('contract_id' => $seven_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($seven_core_data[4]['one_core_status'])) {
									$seven_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$seven_five_data['board_one_cid'] = $seven_contract_id;
									} else if ($id == 2) {
										$seven_five_data['board_two_cid'] = $seven_contract_id;
									} else if ($id == 3) {
										$seven_five_data['board_three_cid'] = $seven_contract_id;
									}

									update_data(USERS, $seven_five_data, array('contract_id' => $seven_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($seven_core_data[5]['one_core_status'])) {
									$seven_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$seven_six_data['board_one_cid'] = $seven_contract_id;
									} else if ($id == 2) {
										$seven_six_data['board_two_cid'] = $seven_contract_id;
									} else if ($id == 3) {
										$seven_six_data['board_three_cid'] = $seven_contract_id;
									}

									update_data(USERS, $seven_six_data, array('contract_id' => $seven_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}
							}
						}
					}

					if (!empty(@$udata[13]['contract_id'])) {
						$eight_contract_id = $udata[13]['contract_id'];

						$eight_main_user = @get_data(USERS, array('contract_id' => $eight_contract_id, 'plan_id' => 1, $plan_name => $id, 'tree_id' => $tree_id), 'CONCAT("ID: " ,contract_id) as name, contract_id,' . $plan_aname . ',' . $plan_name . ', plan_id,id as children')->result_array();

						if (empty($select_query)) {
							$eight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $eight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

						} else {
							$eight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $eight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

						}

						if (!empty(@$eight_data[6]['contract_id'])) {
							$eione_contract_id = $eight_data[6]['contract_id'];

							if (empty($select_query)) {
								$EiOeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $eione_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$EiOeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id,one_core_status," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $eione_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['EiOuser_tree'] = $EiOeight_data;
						}

						if (!empty(@$eight_data[7]['contract_id'])) {
							$EiTtwo_contract_id = $eight_data[7]['contract_id'];

							if (empty($select_query)) {
								$EiTeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $EiTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$EiTeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $EiTtwo_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['EiTuser_tree'] = $EiTeight_data;
						}

						if (!empty(@$eight_data[8]['contract_id'])) {
							$EiTthree_contract_id = $eight_data[8]['contract_id'];

							if (empty($select_query)) {
								$EiTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $EiTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$EiTree_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $EiTthree_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['EiThuser_tree'] = $EiTree_data;
						}

						if (!empty(@$eight_data[9]['contract_id'])) {
							$Eifour_contract_id = $eight_data[9]['contract_id'];

							if (empty($select_query)) {
								$EiFeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Eifour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$EiFeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Eifour_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['EiFuuser_tree'] = $EiFeight_data;
						}

						if (!empty(@$eight_data[10]['contract_id'])) {
							$Eifive_contract_id = $eight_data[10]['contract_id'];

							if (empty($select_query)) {
								$EiFieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Eifive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$EiFieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Eifive_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['EiFuser_tree'] = $EiFieight_data;
						}

						if (!empty(@$eight_data[11]['contract_id'])) {
							$Eisix_contract_id = $eight_data[11]['contract_id'];

							if (empty($select_query)) {
								$Eiseight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Eisix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							} else {
								$Eiseight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Eisix_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Eisiuser_tree'] = $Eiseight_data;
						}

						if (!empty(@$eight_data[12]['contract_id'])) {
							$Eiseven_contract_id = $eight_data[12]['contract_id'];

							if (empty($select_query)) {
								$Eiseeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Eiseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Eiseeight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Eiseven_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();
							}

							$data['Eiseuser_tree'] = $Eiseeight_data;
						}

						if (!empty(@$eight_data[13]['contract_id'])) {
							$Eieight_contract_id = $eight_data[13]['contract_id'];

							if (empty($select_query)) {
								$Eieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $board_time ASC) products_sorted, (select @pv := $Eieight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							} else {
								$Eieight_data = FS::db()->query("select  * from    (select CONCAT('ID: ' ,contract_id) as name,contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY $plan_time ASC) products_sorted, (select @pv := $Eieight_contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id)) LIMIT 6")->result_array();

							}

							$data['Eieuser_tree'] = $Eieight_data;
						}

						$data['emain_user'] = $eight_main_user;

						$data['euser_tree'] = $eight_data;

						if (count($eight_data) >= 6) {
							if (empty($eight_main_user[0]['one_core_status'])) {
								$eight_one_mdata['one_core_status'] = 1;

								if ($id == 1) {
									$eight_one_mdata['board_one_cid'] = $eight_contract_id;
								} else if ($id == 2) {
									$eight_one_mdata['board_two_cid'] = $eight_contract_id;
								} else if ($id == 3) {
									$eight_one_mdata['board_three_cid'] = $eight_contract_id;
								}

								update_data(USERS, $eight_one_mdata, array('contract_id' => $eight_contract_id, 'tree_id' => $tree_id));

								$eight_core_data = array_slice($eight_data, 0, 6);

								if (empty($eight_core_data[0]['one_core_status'])) {
									$eight_one_data['one_core_status'] = 1;

									if ($id == 1) {
										$eight_one_data['board_one_cid'] = $eight_contract_id;
									} else if ($id == 2) {
										$eight_one_data['board_two_cid'] = $eight_contract_id;
									} else if ($id == 3) {
										$eight_one_data['board_three_cid'] = $eight_contract_id;
									}

									update_data(USERS, $eight_one_data, array('contract_id' => $eight_core_data[0]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($eight_core_data[1]['one_core_status'])) {
									$eight_two_data['one_core_status'] = 1;

									if ($id == 1) {
										$eight_two_data['board_one_cid'] = $eight_contract_id;
									} else if ($id == 2) {
										$eight_two_data['board_two_cid'] = $eight_contract_id;
									} else if ($id == 3) {
										$eight_two_data['board_three_cid'] = $eight_contract_id;
									}

									update_data(USERS, $eight_two_data, array('contract_id' => $eight_core_data[1]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($eight_core_data[2]['one_core_status'])) {
									$eight_three_data['one_core_status'] = 1;

									if ($id == 1) {
										$eight_three_data['board_one_cid'] = $eight_contract_id;
									} else if ($id == 2) {
										$eight_three_data['board_two_cid'] = $eight_contract_id;
									} else if ($id == 3) {
										$eight_three_data['board_three_cid'] = $eight_contract_id;
									}

									update_data(USERS, $eight_three_data, array('contract_id' => $eight_core_data[2]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($eight_core_data[3]['one_core_status'])) {
									$eight_four_data['one_core_status'] = 1;

									if ($id == 1) {
										$eight_four_data['board_one_cid'] = $eight_contract_id;
									} else if ($id == 2) {
										$eight_four_data['board_two_cid'] = $eight_contract_id;
									} else if ($id == 3) {
										$eight_four_data['board_three_cid'] = $eight_contract_id;
									}

									update_data(USERS, $eight_four_data, array('contract_id' => $eight_core_data[3]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($eight_core_data[4]['one_core_status'])) {
									$eight_five_data['one_core_status'] = 1;

									if ($id == 1) {
										$eight_five_data['board_one_cid'] = $eight_contract_id;
									} else if ($id == 2) {
										$eight_five_data['board_two_cid'] = $eight_contract_id;
									} else if ($id == 3) {
										$eight_five_data['board_three_cid'] = $eight_contract_id;
									}

									update_data(USERS, $eight_five_data, array('contract_id' => $eight_core_data[4]['contract_id'], 'tree_id' => $tree_id));
								}

								if (empty($eight_core_data[5]['one_core_status'])) {
									$eight_six_data['one_core_status'] = 1;

									if ($id == 1) {
										$eight_six_data['board_one_cid'] = $eight_contract_id;
									} else if ($id == 2) {
										$eight_six_data['board_two_cid'] = $eight_contract_id;
									} else if ($id == 3) {
										$eight_six_data['board_three_cid'] = $eight_contract_id;
									}

									update_data(USERS, $eight_six_data, array('contract_id' => $eight_core_data[5]['contract_id'], 'tree_id' => $tree_id));
								}
							}
						}
					}
				}
				$data['user_info'] = $user_contract_id;
				$data['main_user'] = $main_user;
				$data['user_tree'] = $udata;
				$lang_code = FS::uri()->segment(1);
				$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;
				$data['planID'] = $id;
				$data['plan_A'] = FS::Common()->getTableData(PLANS, array('status' => '1'), '', '', '', '', '', '', array('id', 'ASC'))->result();

				$data['child_url'] = base_url() . $data['lang_code__'] . '/plandetail' . '/' . insep_encode($id) . '/' . insep_encode($tree_id) . '/';

				$this->partial(strtolower(CI_MODEL) . '/plandetail', $data);
			} else {
				$data['main_user'] = '';

				$data['user_tree'] = '';

				$lang_code = FS::uri()->segment(1);

				$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;

				$data['planID'] = $id;

				$data['plan_A'] = FS::Common()->getTableData(PLANS, array('status' => '1'), '', '', '', '', '', '', array('id', 'ASC'))->result();

				$this->partial(strtolower(CI_MODEL) . '/plandetail', $data);
			}
		} else {
			front_redirect('', 'refresh');
		}
	}

	function buildPartnerTree(array $elements, $parentId = 0) {
		$branch = array();

		foreach ($elements as $key => $element) {

			if ($element['affiliate_id'] == $parentId) {

				$children = $this->buildPartnerTree($elements, $element['contract_id']);

				if ($children) {

					$element['children'] = $children;
				}

				$branch[] = $element;
			}
		}

		return $branch;
	}
 
	function coinmarket() {
		$to = 'USD'; $from = 'TRX';
		$coinmarketapi = FS::Common()->getTableData(SITE, array('id' => '1'))->row()->coinmarketapi;

		if ($coinmarketapi) {
			$cmc_url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=" . insep_decode($coinmarketapi) . "&symbol=" . $from . "&convert=" . $to;

			// Live d0NhdEhtRW1zS1BwdnVEeDM2VG5DTlcwS1hqK0N4K095dXhtVGZUcW9oY25NQmlPa25BK2w3a09pWGFOSWVmaA==

			// Demo Z2hjOFZWdkN5a0pLTE8yQi83Y3JteVVzMlVmeFY5VFJFTjBvWXVJRkJYZXM4Q1VEL1ZOY2Y5L0RJUkhJZDMyKw==

			// Saran L1BKdkxUOHdrTVYvaVQzNmxvd1RCTlNkZFRsOWRWb0NXYndmWGxRa0ppOGpZZTVUZjMyRmV6WS9aODhtVGFEMw==

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $cmc_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$output = curl_exec($ch);
			curl_close($ch);
			$response = json_decode($output);

			if (isset($response->data) && $response->status->credit_count == 1) {

				$preres = $response->data->$from->quote->$to;
				$tocur = $preres->price;
				$updateData['coin_usd_value'] = $tocur;
				$condition = array('id' => '1');

				$update = FS::Common()->updateTableData(SITE, $condition, $updateData);
				if ($update) {
					echo json_encode(array('state'=> 1, 'price'=> $tocur));
				} else {
					echo json_encode(array('state'=> 2));
				}
			} else {
				echo json_encode(array('state'=> 3));
			}

		}

	}

	function del_logs() {
		error_reporting(-1);

		ini_set('display_errors', 1);

		$path = FCPATH . 'ajqgzgmedscuoc/socket/logs/pm2/out.log';

		$fh = fopen($path, 'w'); // Open and truncate the file

		fclose($fh);

		$paths = FCPATH . 'ajqgzgmedscuoc/socket/logs/pm2/error.log';

		$fhs = fopen($paths, 'w'); // Open and truncate the file

		fclose($fhs);
	}

	function live_trade_out() {
		$this->load->helper('file');
		//echo FCPATH;

		$string = file_get_contents(FCPATH . 'ajqgzgmedscuoc/socket/logs/pm2/out.log');
		echo '<pre>';
		print_r($string);
		echo '2 ---------------------' . '<br>';
	}

	function live_trade_error() {
		$this->load->helper('file');
		//echo FCPATH;
		$string = file_get_contents(FCPATH . 'ajqgzgmedscuoc/socket/logs/pm2/error.log');
		echo '<pre>';
		print_r($string);
		echo '1 ---------------------' . '<br>';

		/*$string = file_get_contents(FCPATH.'.pm2/pm2.pid');
			echo '<pre>';
			print_r($string);
			echo '3 ---------------------'.'<br>';

			$string = file_get_contents(FCPATH.'.pm2/dump.pm2');
			echo '<pre>';
			print_r($string);
			echo '3 ---------------------'.'<br>';

			$string = file_get_contents(FCPATH.'.pm2/pm2.log');
			echo '<pre>';
		*/
 
		echo '</pre>';die;
	}

	function findFreeRef($referred, $board, $cu_tree_id) {
		//echo 'referred referred = ' . $referred . '<br>';

		/*$check_core_status = findCore7($referred, $board, 1);

		echo 'check_core_status check_core_status = ' . $check_core_status . '<br>';die;*/

		if (($referred == 1 || $referred == 66 || $referred == 281 || $referred == 283 || $referred == 285 || $referred == 287 || $referred == 300) && $cu_tree_id == 3) {
			echo 1;die;
		}

		if ($referred > 1) {
			$chk_usr = @get_data(USERS, array('contract_id' => $referred, 'tree_id' => $cu_tree_id), 'contract_id,affiliate_id,board_two_affiliate_id,board_three_affiliate_id,tree_status,two_tree_status,three_tree_status,one_core_status,two_core_status,three_core_status,board_one_cid,board_two_cid,board_three_cid,tree_id,board_one_prev_id,board_two_prev_id,board_three_prev_id,tree_id')->row();
		} else {
			$chk_usr = @get_data(USERS, array('contract_id' => $referred), 'contract_id,affiliate_id,board_two_affiliate_id,board_three_affiliate_id,tree_status,two_tree_status,three_tree_status,one_core_status,two_core_status,three_core_status,board_one_cid,board_two_cid,board_three_cid,tree_id,board_one_prev_id,board_two_prev_id,board_three_prev_id,tree_id')->row();
		}

		if (!empty($chk_usr)) {

			if ($board == 1) {
				$board_re_id = 'board_one_cid';
				$plan_aname = 'affiliate_id';
				$tree_clumd = 'tree_status';
				$plan_name = 'board_one';
				$plan_time = 'one_create_re_timestamp';
				$board_time = 'contract_id';
				$board_cstatus = 'one_core_status';
				$board_prev_id = 'board_one_prev_id';

			} else if ($board == 2) {
				$board_re_id = 'board_two_cid';
				$plan_aname = 'board_two_affiliate_id';
				$tree_clumd = 'two_tree_status';
				$plan_name = 'board_two';
				$plan_time = 'two_create_re_timestamp';
				$board_time = 'two_create_timestamp';
				$board_cstatus = 'two_core_status';
				$board_prev_id = 'board_two_prev_id';
			} else if ($board == 3) {
				$board_re_id = 'board_three_cid';
				$plan_aname = 'board_three_affiliate_id';
				$tree_clumd = 'three_tree_status';
				$plan_name = 'board_three';
				$plan_time = 'three_create_re_timestamp';
				$board_time = 'three_create_timestamp';
				$board_cstatus = 'three_core_status';
				$board_prev_id = 'board_three_prev_id';

			}

			$re_nme = $plan_name . '_cu_re_id';

			$cl_nme = $plan_name . '_cid';

			$re_me = $plan_name . '_re_id';

			if ($referred > 1) {
				$check_core_status = CheckCore7($referred, $board, $cu_tree_id);
			} else {
				$check_core_status = 1;
			}

			//echo 'check_core_status check_core_status = ' . $check_core_status . '<br>';die;

			if (empty($check_core_status)) {

				return $this->findFreeRef($chk_usr->$plan_aname, $board, $cu_tree_id);

			} /*else {
			$referred = $chk_usr->contract_id;
		}*/

			//echo $referred;die;

			$referr_id = $chk_usr->$board_re_id;

			$bo_pre_id = $chk_usr->$board_prev_id;

			if ($referr_id > 1) {
				$user_contract_id = @get_data(USERS, array('contract_id' => $referr_id, 'plan_id' => 1, 'tree_id' => $cu_tree_id), 'id,contract_id,tree_id,' . $plan_name . '_cid,' . $plan_name . '_prev_id,' . $plan_name . '_cu_re_id,ref_id')->row();
			} else {
				$user_contract_id = @get_data(USERS, array('contract_id' => $referr_id, 'plan_id' => 1), 'id,contract_id,tree_id,' . $plan_name . '_cid,' . $plan_name . '_prev_id,' . $plan_name . '_cu_re_id,ref_id')->row();
			}

			if (!empty($user_contract_id->ref_id) && !empty($user_contract_id->$re_nme)) {
				$cu_re_id = $user_contract_id->$re_nme;

			} else {
				$cu_re_id = $user_contract_id->$re_nme;
			}

			$getDownlines_count = FS::db()->query("select  COUNT(*) as board_count from    (select contract_id,ref_id," . $plan_aname . "," . $re_me . "," . $tree_clumd . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $board . " AND tree_id = " . $cu_tree_id . " AND $board_cstatus = 1 ORDER BY  $board_time ASC) products_sorted, (select @pv := $referr_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->row_array(); // AND $board_prev_id = " . $bo_pre_id . "

			//echo FS::db()->last_query();

			if (!empty($getDownlines_count)) {
				if ($cu_tree_id == 2 && ($referr_id == 11 || $referr_id == 22 || $referr_id == 23 || $referr_id == 44 || $referr_id == 45 || $referr_id == 46 || $referr_id == 47)) {
					$getDownlines_count = ($getDownlines_count['board_count'] - 6) + 1;
				} else {
					$getDownlines_count = $getDownlines_count['board_count'];
				}
			} else {
				$getDownlines_count = 0;
			}

			if ($getDownlines_count < 62) {
				echo $referr_id;
			} else {

				if (empty($select_query)) {
					$getDownlines = FS::db()->query("select  * from    (select contract_id,ref_id," . $plan_aname . "," . $re_me . "," . $tree_clumd . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $board . " AND tree_id = " . $cu_tree_id . " AND $board_cstatus = 1 ORDER BY  $board_time ASC) products_sorted, (select @pv := $referr_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

				} else {
					$getDownlines = FS::db()->query("select  * from    (select contract_id,ref_id," . $plan_aname . "," . $re_me . "," . $tree_clumd . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $board . " AND tree_id = " . $cu_tree_id . " AND $board_cstatus = 1 ORDER BY   $plan_time ASC) products_sorted, (select @pv := $referr_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

				}

				// echo FS::db()->last_query();

				// echo '<pre>';

				// print_r($getDownlines);

				if (!empty($getDownlines)) {
					$q = $this->groupBy($getDownlines, $tree_clumd);

					if (!empty(@$q[0][0]['contract_id'])) {
						echo $q[0][0]['contract_id'];
					} else {
						echo $aff_id;
					}

				} else {
					echo $aff_id;
				}

			}
		} else {
			echo 1;
		}

		die;

		echo FS::db()->last_query();

		print_r($getDownlines_count);die;

		if ($referr_id > 1) {
			$referr_id_user = @get_data(USERS, array('contract_id' => $referr_id, "tree_id" => $cu_tree_id), 'contract_id,tree_status,two_tree_status,three_tree_status,board_one_cid')->row();
		} else {
			$referr_id_user = @get_data(USERS, array('contract_id' => $referr_id), 'contract_id,tree_status,two_tree_status,three_tree_status,board_one_cid')->row();
		}

		if ($referr_id_user->$tree_clumd == 0) {
			$count = FS::db()->select('id')->where('ref_id', $referr_id)->where('plan_id', 1)->where('tree_id', $cu_tree_id)->from(USERS)->count_all_results();

			$Acount = FS::db()->select('id')->where($plan_aname, $referr_id)->where('plan_id', 1)->where('tree_id', $cu_tree_id)->from(USERS)->count_all_results();

			if ($Acount == 0) {
				$tree_position = 0;

				$tree_id = $referr_id;
			} else if ($Acount == 1) {
				$tree_position = 1;

				$tree_id = $referr_id;
			} else {
				$tree_id = $referr_id;
			}

			if ($count == 1) {
				$updata['tree_status'] = 1;

				$updata['direct_status'] = 1;

				//update_data(USERS,$updata,array('id'=>$referr_id));
			}
		} else {

			$get_free_ref_id = @get_data(USERS, array($plan_aname => $referr_id, $tree_clumd => 0, "plan_id" => 1, "tree_id" => $cu_tree_id), 'contract_id')->row();

			if (!empty($get_free_ref_id)) {
				$referr_id = $get_free_ref_id->contract_id;
			} else {

				$referr_id = $this->getTreeID($referr_id, $board, $cu_tree_id);
			}

			$ref_count = FS::db()->select('contract_id')->where('affiliate_id', $referr_id)->where('plan_id', 1)->where('tree_id', $cu_tree_id)->from(USERS)->count_all_results();

			if ($ref_count == 0) {
				$tree_position = 0;

				$tree_id = $referr_id;
			} else if ($ref_count == 1) {
				$tree_position = 1;

				$tree_id = $referr_id;

				$re_updata['tree_status'] = 1;

				//update_data(USERS,$re_updata,array('id'=>$referr_id));
			} else {
				$tree_id = $referr_id;
			}
		}
		if (!empty($tree_id)) {
			echo $tree_id;
		} else {
			echo 0;
		}

		//return $tree_id;
	}

	function getTreeID($aff_id, $board, $cu_tree_id) {
		if ($board == 1) {
			$plan_aname = 'affiliate_id';
			$tree_clumd = 'tree_status';
			$plan_name = 'board_one';
			$plan_time = 'one_create_re_timestamp';
			$board_time = 'contract_id';
			$board_cstatus = 'one_core_status';

		} else if ($board == 2) {
			$plan_aname = 'board_two_affiliate_id';
			$tree_clumd = 'two_tree_status';
			$plan_name = 'board_two';
			$plan_time = 'two_create_re_timestamp';
			$board_time = 'two_create_timestamp';
			$board_cstatus = 'two_core_status';
		} else if ($board == 3) {
			$plan_aname = 'board_three_affiliate_id';
			$tree_clumd = 'three_tree_status';
			$plan_name = 'board_three';
			$plan_time = 'three_create_re_timestamp';
			$board_time = 'three_create_timestamp';
			$board_cstatus = 'three_core_status';

		}

		$re_nme = $plan_name . '_cu_re_id';

		$cl_nme = $plan_name . '_cid';

		$re_me = $plan_name . '_re_id';

		if ($aff_id > 1) {
			$user_contract_id = @get_data(USERS, array('contract_id' => $aff_id, 'plan_id' => 1, 'tree_id' => $cu_tree_id), 'id,contract_id,tree_id,' . $plan_name . '_cid,' . $plan_name . '_prev_id,' . $plan_name . '_cu_re_id,ref_id')->row();
		} else {
			$user_contract_id = @get_data(USERS, array('contract_id' => $aff_id, 'plan_id' => 1), 'id,contract_id,tree_id,' . $plan_name . '_cid,' . $plan_name . '_prev_id,' . $plan_name . '_cu_re_id,ref_id')->row();
		}

		$contract_id = $user_contract_id->$cl_nme;

		if (!empty($user_contract_id->ref_id) && !empty($user_contract_id->$re_nme)) {
			$cu_re_id = $user_contract_id->$re_nme;

			$select_query = 1;
		} else {
			$cu_re_id = $user_contract_id->$re_nme;

			$select_query = 0;
		}

		if (empty($contract_id)) {
			$contract_id = $user_contract_id->contract_id;
		}

		$getDownlines_count = FS::db()->query("select  COUNT(*) as board_count from    (select contract_id,ref_id," . $plan_aname . "," . $re_me . "," . $tree_clumd . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $board . " AND tree_id = " . $cu_tree_id . "  ORDER BY  $board_time ASC) products_sorted, (select @pv := $contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->row_array();

		//print_r($getDownlines_count);die;

		if (!empty($getDownlines_count)) {
			if ($cu_tree_id == 2 && ($contract_id == 11 || $contract_id == 22 || $contract_id == 23 || $contract_id == 44 || $contract_id == 45 || $contract_id == 46 || $contract_id == 47)) {
				$getDownlines_count = ($getDownlines_count['board_count'] - 6) + 1;
			} else {
				$getDownlines_count = $getDownlines_count['board_count'];
			}
		} else {
			$getDownlines_count = 0;
		}

		if ($getDownlines_count < 62) {
			return $contract_id;
		} else {

			if (empty($select_query)) {
				$getDownlines = FS::db()->query("select  * from    (select contract_id,ref_id," . $plan_aname . "," . $re_me . "," . $tree_clumd . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $board . " AND tree_id = " . $cu_tree_id . " ORDER BY  $board_time ASC) products_sorted, (select @pv := $contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

			} else {
				$getDownlines = FS::db()->query("select  * from    (select contract_id,ref_id," . $plan_aname . "," . $re_me . "," . $tree_clumd . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $board . " AND tree_id = " . $cu_tree_id . " ORDER BY   $plan_time ASC) products_sorted, (select @pv := $contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

			}

			/*$getDownlines = FS::db()->query("select * AND $board_cstatus = 1
				from    (select contract_id,affiliate_id,board_two_affiliate_id,board_three_affiliate_id,$tree_clumd from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY contract_id ASC) products_sorted,
				        (select @pv := $aff_id) initialisation
				where   find_in_set($plan_aname, @pv)
			*/

			// echo FS::db()->last_query();

			// echo '<pre>';

			// print_r($getDownlines);

			if (!empty($getDownlines)) {
				$q = $this->groupBy($getDownlines, $tree_clumd);

				/*echo '<pre>';
					print_r($q);
				*/
				if (!empty(@$q[0][0]['contract_id'])) {
					return $q[0][0]['contract_id'];
				} else {
					return $aff_id;
				}

			} else {
				return $aff_id;
			}

		}
		/*//$get_sep_board_ids						=	@get_data(USERS,array('contract_id' => $aff_id, 'plan_id' => 1, 'board_one_cu_re_id' => $reentryid),'affiliate_id,one_sep_board,board_one_cu_re_id')->row();

			$getTreeIDids						=	@get_data(USERS,array('affiliate_id' => $aff_id,'tree_status'=>0),'id,affiliate_id,tree_status')->row();

			//$ref_count 		=	FS::db()->select('id')->where('affiliate_id',$aff_id)->from(USERS)->count_all_results();

			if(!empty($getTreeIDids))
			{
				return $getTreeIDids->;
			}
			else
			{
				//return $this->getTreeID($get_sep_board_ids->affiliate_id,$get_sep_board_ids->board_one_cu_re_id);

				return $this->getTreeID($get_sep_board_ids->affiliate_id);
		*/
	}

	function groupBy($arr, $criteria): array {
		return array_reduce($arr, function ($accumulator, $item) use ($criteria) {
			$key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
			if (!array_key_exists($key, $accumulator)) {
				$accumulator[$key] = [];
			}

			array_push($accumulator[$key], $item);
			return $accumulator;
		}, []);
	}

	function getRefAddr($aff_id, $tree_id) {
		if ($aff_id > 1) {
			$user_details = @get_data(USERS, array('contract_id' => $aff_id, 'tree_id' => $tree_id), 'address')->row()->address;

		} else {
			$user_details = @get_data(USERS, array('contract_id' => $aff_id), 'address')->row()->address;
		}

		if (!empty($user_details)) {
			echo $user_details;
		} else {
			echo 0;
		}
	}

	function get_Personal_details($referred, $id) {
		if ($id == 1) {
			$plan_name = 'board_one';

			$plan_aname = 'affiliate_id';

			$plan_time = 'one_create_re_timestamp';

			$board_time = 'contract_id';
		} else if ($id == 2) {
			$plan_name = 'board_two';

			$plan_aname = 'board_two_affiliate_id';

			$plan_time = 'two_create_re_timestamp';

			$board_time = 'two_create_timestamp';
		} else if ($id == 3) {
			$plan_name = 'board_three';

			$plan_aname = 'board_three_affiliate_id';

			$plan_time = 'three_create_re_timestamp';

			$board_time = 'three_create_timestamp';
		}

		$user_contract_id = @get_data(USERS, array('contract_id' => $referred, 'plan_id' => 1), 'id,contract_id,tree_id,' . $plan_name . '_cid,' . $plan_name . '_prev_id,' . $plan_name . '_cu_re_id,ref_id')->row();

		if (!empty($user_contract_id)) {

			$cl_nme = $plan_name . '_cid';

			$pv_nme = $plan_name . '_prev_id';

			$re_nme = $plan_name . '_cu_re_id';

			$re_me = $plan_name . '_re_id';

			$re_po = $plan_name . '_re_position';

			$contract_id = $user_contract_id->$cl_nme;

			if (!empty($user_contract_id->ref_id) && !empty($user_contract_id->$re_nme)) {
				$cu_re_id = $user_contract_id->$re_nme;

				$select_query = 1;
			} else {
				$cu_re_id = $user_contract_id->$re_nme;

				$select_query = 0;
			}

			if (empty($contract_id)) {
				$contract_id = $user_contract_id->contract_id;
			}

			$tree_id = $user_contract_id->tree_id;

			$main_user = @get_data(USERS, array('contract_id' => $contract_id, 'plan_id' => 1, $plan_name => $id), 'CONCAT("ID: " ,contract_id) as name, contract_id,' . $plan_aname . ',' . $plan_name . ',' . $re_nme . ', plan_id,id as children, ref_id')->result_array();

			if (empty($select_query)) {
				$udata = FS::db()->query("select  * from    (select contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY  $board_time ASC) products_sorted, (select @pv := $contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

			} else {
				$udata = FS::db()->query("select  * from    (select contract_id," . $plan_aname . ",plan_id," . $plan_name . "," . $re_nme . "," . $re_me . " from " . P . USERS . " WHERE plan_id = 1 AND $plan_name = " . $id . " AND tree_id = " . $tree_id . " ORDER BY   $plan_time ASC) products_sorted, (select @pv := $contract_id) initialisation where   find_in_set($plan_aname, @pv) and find_in_set($cu_re_id,$re_me) and length(@pv := concat(@pv, ',', contract_id))")->result_array();

			}

			if (!empty($udata)) {
				return (json_decode(json_encode($udata), true));
			} else {
				return 0;
			}
		}

		/*$tree_position_sum	=	get_data(USERS,array('affiliate_id' => $referred,'tree_position' => $tree_position),'id,affiliate_id,ref_id')->row();

				if(!empty($tree_position_sum))
				{
					$totalinvest 	=	FS::db()->query("select  *
					from    (select affiliate_id,id,ref_id, tree_position from ".P.USERS." where tree_position ='".$tree_position."' ORDER BY contract_id ASC) products_sorted,
			        (select @pv := $tree_position_sum->id) initialisation
			where   find_in_set(affiliate_id, @pv)
			and length(@pv := concat(@pv, ',', id))")->result_array();

					if(!empty($totalinvest))
					{
						return $totalinvest;
					}
					else
					{
						return  array(json_decode(json_encode($tree_position_sum), true));
					}
				}
				else
				{
					return 0;
		*/
	}

	public function manualEntry($tree_id, $address) { 
		$lang_code = FS::uri()->segment(1);

		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;

		$data['title'] = "Login Page";

		$data['doc'] = @FS::Common()->getTableData(DOC, array('language' => $lang))->row();

		$data['work'] = FS::Common()->getTableData(HOW_WORK, array('language' => $lang), '', '', '', '', '', '', array('id', 'DESC'))->result();

		$data['why'] = FS::Common()->getTableData(WHYCHOOSE, array('language' => $lang), '', '', '', '', '', '', array('id', 'DESC'))->result();

		$data['review'] = FS::Common()->getTableData(REVIEWS, array('status' => '1'), '', '', '', '', '', '', array('id', 'DESC'))->result();

		$data['home_content'] = FS::Common()->getTableData(HOME_CONTENT, array('language' => $lang))->row();

		$data['address'] = FS::Common()->getTableData(ADDRESS)->row();

		$data['plan'] = FS::Common()->getTableData(PLAN_B, array('status' => '1', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();

		$data['plan_A'] = FS::Common()->getTableData(PLANS, array('status' => '1'), '', '', '', '', '', '', array('id', 'ASC'))->result();

		$data['is_referrer'] = 1;

		$data['referrer_id'] = 'TQsVG7JqiXMWw3wZhNUoMYMScRBDiLsuiE';

		$data['referrer'] = 1;

		$data['Areferrer_id'] = ADMIN_ADDR;

		$data['Areferrer'] = 1;

		$data['tree_id'] = 1;

		$siteSettings = FS::Common()->getTableData(SITE, array('id' => 1), 'site_mode,api_live_url,api_demo_url,coin_usd_value')->row();

		$sitemode = $siteSettings->site_mode;
		$data['coin_usd_value'] = $siteSettings->coin_usd_value;
		if ($sitemode == '1') {
			$data['add_url'] = $siteSettings->api_live_url;
		} else if ($sitemode == '2') {
			$data['add_url'] = $siteSettings->api_demo_url;
		} else {
			$data['add_url'] = '';
		}

		$data['users_count'] = FS::Common()->getTableData(USERS)->num_rows();

		$data['planb'] = FS::Common()->getTableData(PLAN_B, array('plan_type' => 'B', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();

		$data['lang'] = FS::Common()->getTableData(LANG)->result();

		if (juego_id()) {
			$_aref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 1), 'contract_id,tree_id,ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();

			if (($_aref_code->one_core_status == 1 && $_aref_code->ref_status == 0) || ($_aref_code->one_core_status == 0 && $_aref_code->ref_status == 1) || ($_aref_code->one_core_status == 0 && $_aref_code->ref_status == 0)) {

				findCore7($_aref_code->contract_id, 1, $_aref_code->tree_id);
			}

			if (($_aref_code->two_core_status == 0)) {
				findCore7($_aref_code->contract_id, 2, $_aref_code->tree_id);
			}

			if (($_aref_code->three_core_status == 0)) {
				findCore7($_aref_code->contract_id, 3, $_aref_code->tree_id);
			}

			if (!empty($_aref_code)) {
				if (!empty($_aref_code->ref_status)) {
					$__aref_code = $_aref_code->ref_code;
				} else {
					$__aref_code = 0;
				}

			}

			if (!empty($__aref_code)) {
				$data['ref_url_a'] = base_url() . $lang_code . '/refer/plana/' . $__aref_code;

				$data['core_status'] = $_aref_code->one_core_status;
			} else {
				$data['ref_url_a'] = 0;
 
				$data['core_status'] = 0;
			}
			
			if (juego_id() == ADMIN_ADDR) {
				$data['tree_data'] = @get_data(RL, array('status' => 1), 'tree_id,referral_link')->result_array();
			}
			
			if ($address == ADMIN_ADDR) {
				$data['tree_id'] = $tree_id;
			} else {
				$data['tree_id'] = $_aref_code->tree_id;
			}
		}
		
		$data['section'] = 'Manual';
		
		$data['curr_address'] = $address;

		$this->view(strtolower(CI_MODEL) . '/index', $data);
	}

	public function updateTreestatus() {
		$total_user = FS::db()->query("SELECT contract_id  FROM " . P . USERS . " WHERE `tree_id` = 1  ORDER by id ASC")->result_array();

		$total_user_count = count($total_user);
		$keys = 1;
		foreach ($total_user as $key => $data) {

			$contract_id = $data['contract_id'];

			$ref_data = FS::Common()->getTableData(USERS, array('affiliate_id' => $contract_id, 'tree_id' => 1));
			$data = $ref_data->result();
			if (count($data) == 2) {
				$updateData = array();
				$updateData['tree_status'] = '1';
				$condition = array('contract_id' => $contract_id, 'tree_id' => 1);

				$update = FS::Common()->updateTableData(USERS, $condition, $updateData);
				//$update = '1';
				if ($update) {
					echo "1=>updated" . '<br>';
				} else {
					echo "2";
				}
			} else {
				echo 'not reach count========>' . count($data) . '<br>';
			}

		}

	}

	function get_update_data() {
		$old_data_details = @get_data(USERS, array('tree_id' => 1, 'ref_id' => 0, 'contract_id !=' => 1), 'contract_id,ref_id')->result_array(); //

		if (!empty($old_data_details)) {
			$update_ref_data = array();
			foreach ($old_data_details as $old_key => $old_value) {

				$get_ref_id = @get_data(USERS_OLD, array('tree_id' => 1, 'contract_id' => $old_value['contract_id']), 'ref_id')->row()->ref_id;

				if (!empty($get_ref_id)) {
					$update_ref_data['ref_id'] = $get_ref_id;
				}
				//extract($old_value);

				echo 'contract_id = ' . $old_value['contract_id'] . ' ref_code ' . $old_value['ref_id'] . '<br>';

				// echo '<pre>';
				// print_r($update_ref_data);

				if (!empty($update_ref_data)) {
					update_data(USERS, $update_ref_data, array('contract_id' => $old_value['contract_id'], 'tree_id' => 1));

					//echo FS::db()->last_query() . '<br>';

					echo 'updated <br>';

				}

			}
		}
	}

	public function planBpage() {
		$lang_code = FS::uri()->segment(1);

		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;

		$data['title'] = "Login Page";

		$data['doc'] = @FS::Common()->getTableData(DOC, array('language' => $lang))->row();

		$data['address'] = FS::Common()->getTableData(ADDRESS)->row();

		$data['plan'] = FS::Common()->getTableData(PLAN_B, array('status' => '1', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();

		$data['is_referrer'] = 1;

		$data['referrer_id'] = 'TQsVG7JqiXMWw3wZhNUoMYMScRBDiLsuiE';

		$data['referrer'] = 1;

		$data['Areferrer_id'] = 'TXh3v9sibCxArCnKstG2y4RVYRcecozvyp';

		$data['Areferrer'] = 1;

		$data['tree_id'] = 0;

		$siteSettings = FS::Common()->getTableData(SITE, array('id' => 1), 'site_mode,api_live_url,api_demo_url,coin_usd_value')->row();

		$data['review'] = FS::Common()->getTableData(REVIEWS, array('status' => '1'), '', '', '', '', '', '', array('id', 'DESC'))->result();

		$sitemode = $siteSettings->site_mode;
		$data['coin_usd_value'] = $siteSettings->coin_usd_value;
		if ($sitemode == '1') {
			$data['add_url'] = $siteSettings->api_live_url;
		} else if ($sitemode == '2') {
			$data['add_url'] = $siteSettings->api_demo_url;
		} else {
			$data['add_url'] = '';
		}

		$data['users_count'] = FS::Common()->getTableData(USERS)->num_rows();

		$data['planb'] = FS::Common()->getTableData(PLAN_B, array('plan_type' => 'B', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();

		$data['lang'] = FS::Common()->getTableData(LANG)->result();

		if (juego_id()) {

			$data['with_history'] = @get_data(TRANS, array('address' => juego_id()))->result_array();
		}

		$data['plansection'] = 'planBpage';

		$this->view(strtolower(CI_MODEL) . '/planBpage', $data);
	}
}
?>