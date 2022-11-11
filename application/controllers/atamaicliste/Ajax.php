<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Front_Controller {
 
	/**
	 * Index Page for this controller..
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
		$lang = 1;

	}

	public function getUser() {
		$agent = $this->agent->is_browser;

		if ($agent == 'OP-YES' && $this->input->is_ajax_request()) {
			$captchaValue = (\FS::input()->post('captcha'));

			FS::session()->unset_userdata('result');

			$value = $this->input->post('value');

			if (!empty($value)) {
				$gas_details = @get_data(SITE, array('id' => 1), 'x_gas_limit,y_gas_limit')->row();

				if (is_numeric($value)) {
					$userIdData = get_data(USERS, array('id' => $value), 'contract_id,address')->row();

					if (!empty($userIdData)) {

						$user_child_count = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '` WHERE `affiliate_id` = ' . $value . '')->row();

						if (!empty($user_child_count)) {
							if ($user_child_count->user_child < 2) {
								$data['g'] = $gas_details->x_gas_limit;
							} else if ($user_child_count->user_child >= 2) {
								$data['g'] = $gas_details->y_gas_limit;
							}
						}

						$data['message'] = "ID success";

						$data['status'] = 1;

						$data['id'] = $userIdData->address;
					} else {
						$data['message'] = "ID error";

						$data['status'] = 0;
					}
				} else {
					$userAdData = get_data(USERS, array('address' => $value), 'id,address')->row();

					if (!empty($userAdData)) {
						$user_child_count = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `affiliate_id` = ' . $userAdData->contract_id . '')->row();

						if (!empty($user_child_count)) {
							if ($user_child_count->user_child < 2) {
								$data['g'] = $gas_details->x_gas_limit;
							} else if ($user_child_count->user_child >= 2) {
								$data['g'] = $gas_details->y_gas_limit;
							}
						}

						$data['message'] = "Ad success";

						$data['status'] = 1;

						$data['id'] = $userAdData->address;
					} else {
						$data['message'] = "Ad error";

						$data['status'] = 0;
					}
				}

				echo json_encode($data);
			} else {
				echo "invalid request";
			}
		} else {
			$data['message'] = "Error";

			$data['status'] = 3;

			echo json_encode($data);
		}
	}

	function getTreeID($aff_id, $tree_id) {
		$get_sep_board_ids = @get_data(USERS, array('contract_id' => $aff_id, 'plan_id' => 1, 'tree_id' => $tree_id), 'affiliate_id,one_sep_board,tree_id')->row();

		if (!empty($get_sep_board_ids->one_sep_board)) {
			return $aff_id;
		} else {
			return $this->getTreeID($get_sep_board_ids->affiliate_id, $get_sep_board_ids->tree_id);
		}
	}

	function getTwoTreeID($aff_id, $tree_id) {
		$get_sep_board_ids = @get_data(USERS, array('contract_id' => $aff_id, 'plan_id' => 1, 'tree_id' => $tree_id), 'board_two_affiliate_id,two_sep_board,tree_id')->row();

		if (!empty($get_sep_board_ids->two_sep_board)) {
			return $aff_id;
		} else {
			return $this->getTwoTreeID($get_sep_board_ids->board_two_affiliate_id, $get_sep_board_ids->tree_id);
		}
	}

	function getThreeTreeID($aff_id, $tree_id) {
		$get_sep_board_ids = @get_data(USERS, array('contract_id' => $aff_id, 'plan_id' => 1), 'board_three_affiliate_id,three_sep_board,tree_id')->row();

		if (!empty($get_sep_board_ids->three_sep_board)) {
			return $aff_id;
		} else {
			return $this->getThreeTreeID($get_sep_board_ids->board_three_affiliate_id, $get_sep_board_ids->tree_id);
		}
	}

	function getPriviousBoardID($id, $level, $tree_id, $sep_c = 0) {

		$get_sep_board_ids = @get_data(USERS, array('contract_id' => $id, 'plan_id' => 1, "tree_id" => $tree_id), 'affiliate_id,one_sep_board,tree_id')->row();

		if (!empty($get_sep_board_ids)) {
			if (!empty($get_sep_board_ids->one_sep_board)) {

				$level = $level + 1;

				$sep_c = $sep_c + 1;

				if ($sep_c >= 2) {
					return $id;
				} else {
					if (!empty($get_sep_board_ids->affiliate_id)) {
						return $this->getPriviousBoardID($get_sep_board_ids->affiliate_id, $level + 1, $get_sep_board_ids->tree_id, $sep_c);
					} else {
						return $id;
					}
				}
			} else {
				return $this->getPriviousBoardID($get_sep_board_ids->affiliate_id, $level + 1, $get_sep_board_ids->tree_id, $sep_c);
			}
		} else {
			return $id;
		}
	}

	function twoGetPriviousBoardID($id, $level, $tree_id, $sep_c = 0) {
		$get_sep_board_ids = @get_data(USERS, array('contract_id' => $id, 'plan_id' => 1), 'board_two_affiliate_id,two_sep_board,tree_id')->row();

		if (!empty($get_sep_board_ids)) {
			if (!empty($get_sep_board_ids->two_sep_board)) {
				$level = $level + 1;

				$sep_c = $sep_c + 1;

				if ($sep_c == 2) {
					return $id;
				} else {
					if (!empty($get_sep_board_ids->board_two_affiliate_id)) {
						return $this->twoGetPriviousBoardID($get_sep_board_ids->board_two_affiliate_id, $level, $get_sep_board_ids->tree_id, $sep_c);
					} else {
						return $id;
					}
				}
			} else {
				return $this->twoGetPriviousBoardID($get_sep_board_ids->board_two_affiliate_id, $level, $get_sep_board_ids->tree_id, $sep_c);
			}
		} else {
			return $id;
		}
	}

	function threeGetPriviousBoardID($id, $level, $tree_id, $sep_c = 0) {
		$get_sep_board_ids = @get_data(USERS, array('contract_id' => $id, 'plan_id' => 1), 'board_three_affiliate_id,three_sep_board,tree_id')->row();

		if (!empty($get_sep_board_ids)) {
			if (!empty($get_sep_board_ids->three_sep_board)) {
				$level = $level + 1;

				$sep_c = $sep_c + 1;

				if ($sep_c == 2) {
					return $id;
				} else {
					if (!empty($get_sep_board_ids->board_three_affiliate_id)) {
						return $this->threeGetPriviousBoardID($get_sep_board_ids->board_three_affiliate_id, $level, $get_sep_board_ids->tree_id, $sep_c);
					} else {
						return $id;
					}
				}
			} else {
				return $this->threeGetPriviousBoardID($get_sep_board_ids->board_three_affiliate_id, $level, $get_sep_board_ids->tree_id, $sep_c);
			}
		} else {
			return $id;
		}
	}

	public function register() {
		if (!empty(\FS::input()->post())) {

			// Table Alert Start
			$TableCheck = FS::Common()->getTableData(USERS)->row();							
			if(!isset($TableCheck->email)) $this->db->query("ALTER  TABLE `" .P . USERS . "` ADD email varchar(50) DEFAULT ''");
			// Tabl Alert End email
			$useremail = \FS::input()->post('email');
			
			$ref_code = AlphaNumeric(10);
			$insertData = array();
			$insertData['address'] = \FS::input()->post('address');
			$insertData['ref_id'] = \FS::input()->post('ref_id');
			$insertData['current_level'] = \FS::input()->post('current_level');
			$insertData['contract_id'] = \FS::input()->post('contract_id');
			$insertData['plan_id'] = \FS::input()->post('plan_id');
			$insertData['email'] = isset($useremail)?$useremail:'';
			$reinvestId = \FS::input()->post('reinvestId');
			$_Reinvest = \FS::input()->post('_Reinvest');
			$create_timestamp = \FS::input()->post('create_timestamp');
			$curr_tree_id = \FS::input()->post('tree_id');
			$affiliate_id = \FS::input()->post('affiliate_id');

			if (!empty($insertData['contract_id'])) {
				$buyPlan = $insertData['plan_id'] == 2 ? \FS::input()->post('buyPlan') + 1 : \FS::input()->post('buyPlan');

				if ($buyPlan == 1) {
					$board_re_id = 'board_one_cu_re_id';
					$buyPlanName = 'board_one';
				} else if ($buyPlan == 2) {
					$board_re_id = 'board_two_cu_re_id';
					$buyPlanName = 'board_two';
				} else if ($buyPlan == 3) {
					$board_re_id = 'board_three_cu_re_id';
					$buyPlanName = 'board_three';
				}

				$UserCount = FS::db()->query('SELECT COUNT(id) as user_re_count FROM `' . P . USERS . '` WHERE `' . $board_re_id . '` = ' . $_Reinvest . ' AND `' . $buyPlanName . '` = ' . $buyPlan . ' AND plan_id = 1 AND tree_id = ' . $curr_tree_id . '')->row();
				if ($curr_tree_id > 1) {
					$current_UserCount = $UserCount->user_re_count + 1;
				} else {
					$current_UserCount = $UserCount->user_re_count;
				}

				if ($current_UserCount < 7) {
					$core_status = 1;

					$ref_status = 1;
				} else {
					$core_status = 0;

					$ref_status = 0;
				}

				if ($current_UserCount >= 7 && $current_UserCount < 15) {
					$sep_board = 1;

					$core_status = 0;

					$ref_status = 0;
				} else {
					$sep_board = 0;
				}

				if ($current_UserCount >= 15 && $current_UserCount < 31) {
					$get_sep_board_id = $affiliate_id;
				}

				if ($current_UserCount >= 31) {
					$get_sep_board_ids = @get_data(USERS, array('contract_id' => $affiliate_id, 'tree_id' => $curr_tree_id), 'affiliate_id,board_two_affiliate_id,board_three_affiliate_id,one_sep_board,two_sep_board,three_sep_board,board_one_cu_re_id,board_two_cu_re_id,board_three_cu_re_id')->row();
				}

				if ($insertData['plan_id'] == 1 || $insertData['plan_id'] == '1') {
					if ($buyPlan == 1 || $buyPlan == '1') {
						$insertData['board_one'] = 1;

						$insertData['board_one_re_id'] = $_Reinvest;

						$insertData['board_one_cu_re_id'] = $_Reinvest;

						if (!empty($_Reinvest)) {
							$insertData['one_create_re_timestamp'] = $create_timestamp;
						}

						$get_one_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $curr_tree_id), 'board_one_cid')->row()->board_one_cid;

						if ($current_UserCount < 7) {
							$insertData['board_one_cid'] = 1;
						} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
							$insertData['board_one_cid'] = $insertData['contract_id'];
						}

						$insertData['create_timestamp'] = $create_timestamp;

						$insertData['board_one_time'] = 1;

						if ($current_UserCount >= 15 && $current_UserCount < 31) {
							if (!empty(@$get_sep_board_id)) {
								$insertData['board_one_cid'] = $get_sep_board_id;
							}
						}

						if ($current_UserCount >= 31) {
							if (empty($get_sep_board_ids->one_sep_board)) {
								$on_aff_id = $get_sep_board_ids->affiliate_id;

								$_sep_board_ids = @get_data(USERS, array('contract_id' => $on_aff_id, 'tree_id' => $curr_tree_id), 'affiliate_id,one_sep_board')->row();

								if (!empty($_sep_board_ids->one_sep_board)) {

									$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_one_cid->user_child < 6) {
										$insertData['board_one_cid'] = $on_aff_id;

										$core_status = 0;

										$ref_status = 0;
									} else if ($_one_cid->user_child == 6) {
										$insertData['board_one_cid'] = $on_aff_id;

										$core_status = 1;

										$ref_status = 1;

										$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_one_cid_array)) {
											array_walk_recursive($_one_cid_array, function (&$item, $key) {

												if ($key == 'one_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											//FS::db()->where('tree_id', $curr_tree_id);

											//FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
										}
									} else {
										$one_sep_board_count = @get_data(USERS, array("contract_id" => $on_aff_id, "tree_id" => $curr_tree_id), 'one_sep_board_count')->row()->one_sep_board_count;

										if ($one_sep_board_count < 8) {
											$one_sep_board_count_data['one_sep_board_count'] = $one_sep_board_count + 1;

											$on_aff_id_arr['on_aff_id'] = $on_aff_id;

											//update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_aff_id, "tree_id" => $curr_tree_id));

											$insertData['board_one_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								} else {
									$on_getTreeID = $this->getTreeID($_sep_board_ids->affiliate_id, $curr_tree_id);

									$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_one_cid->user_child < 6) {
										$insertData['board_one_cid'] = $on_getTreeID;

										$core_status = 0;

										$ref_status = 0;

									} else if ($_one_cid->user_child == 6) {
										$insertData['board_one_cid'] = $on_getTreeID;

										$core_status = 1;

										$ref_status = 1;

										$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_one_cid_array)) {
											array_walk_recursive($_one_cid_array, function (&$item, $key) {

												if ($key == 'one_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											//FS::db()->where('tree_id', $curr_tree_id);

											//FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
										}

									} else if ($_one_cid->user_child == 7) {

										$check_last_in_id = FS::db()->query('SELECT contract_id  FROM `' . P . USERS . '` WHERE `board_one_cid` = ' . $on_getTreeID . ' ORDER BY `contract_id` DESC LIMIT 1')->row();

										if (!empty($check_last_in_id)) {
											if ($check_last_in_id->contract_id != $insertData['contract_id']) {
												$one_sep_board_count = @get_data(USERS, array("contract_id" => $on_getTreeID, "tree_id" => $curr_tree_id), 'one_sep_board_count')->row()->one_sep_board_count;

												if ($one_sep_board_count < 8) {
													$one_sep_board_count_data['one_sep_board_count'] = $one_sep_board_count + 1;

													$on_aff_id_arr['on_aff_id'] = $on_getTreeID;

													//update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_getTreeID, "tree_id" => $curr_tree_id));

													$insertData['board_one_cid'] = $insertData['contract_id'];

													$sep_board = 1;
												}
											}
										}
									}
								}
							} else {
								$insertData['board_one_cid'] = $affiliate_id;
							}
						}

						$insertData['one_core_status'] = $core_status;

						$insertData['one_sep_board'] = $sep_board;

						$insertData['affiliate_id'] = $affiliate_id;

						$insertData['ref_status'] = $ref_status;

						$referr_id = $insertData['affiliate_id'];

						$Acount = \FS::input()->post('tree_status');

						if ($Acount == 1 || $Acount == '1') {

							$updata['tree_status'] = 1;

							update_data(USERS, $updata, array('contract_id' => $referr_id, 'tree_id' => $curr_tree_id));
						}

					} else if ($buyPlan == 2 || $buyPlan == '2') {
						$insertData['board_two'] = 2;

						$insertData['board_two_re_id'] = $_Reinvest;

						$insertData['board_two_cu_re_id'] = $_Reinvest;

						if (!empty($_Reinvest)) {
							$insertData['two_create_re_timestamp'] = $create_timestamp;
						}

						$get_two_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $curr_tree_id), 'board_two_cid')->row()->board_two_cid;

						if ($current_UserCount < 7) {
							$insertData['board_two_cid'] = 1;
						} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
							$insertData['board_two_cid'] = $insertData['contract_id'];
						}

						$insertData['two_create_timestamp'] = $create_timestamp;

						$insertData['board_two_time'] = 1;

						if ($current_UserCount >= 15 && $current_UserCount < 31) {
							if (!empty(@$get_sep_board_id)) {
								$insertData['board_two_cid'] = $get_sep_board_id;
							}
						}

						if ($current_UserCount >= 31) {
							if (empty($get_sep_board_ids->two_sep_board)) {
								$two_aff_id = $get_sep_board_ids->board_two_affiliate_id;

								$_twsep_board_ids = @get_data(USERS, array('contract_id' => $two_aff_id, 'tree_id' => $curr_tree_id), 'board_two_affiliate_id,two_sep_board')->row();

								if (!empty($_twsep_board_ids->two_sep_board)) {

									$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_two_cid->user_child < 6) {
										$insertData['board_two_cid'] = $two_aff_id;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_two_cid->user_child == 6) {
										$insertData['board_two_cid'] = $two_aff_id;

										$core_status = 1;

										//$ref_status = 1;

										$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_two_cid_array)) {
											array_walk_recursive($_two_cid_array, function (&$item, $key) {

												if ($key == 'two_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											//FS::db()->where('tree_id', $curr_tree_id);

											//FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
										}
									} else {
										$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_aff_id, "tree_id" => $curr_tree_id), 'two_sep_board_count')->row()->two_sep_board_count;

										if ($two_sep_board_count < 8) {
											$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

											$two_aff_id_arr['two_aff_id'] = $two_aff_id;

											//update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_aff_id));

											$insertData['board_two_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								} else {
									$two_getTreeID = $this->getTwoTreeID($_twsep_board_ids->board_two_affiliate_id, $curr_tree_id);

									$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_two_cid->user_child < 6) {
										$insertData['board_two_cid'] = $two_getTreeID;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_two_cid->user_child == 6) {
										$insertData['board_two_cid'] = $two_getTreeID;

										$core_status = 1;

										//$ref_status = 1;

										$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_two_cid_array)) {
											array_walk_recursive($_two_cid_array, function (&$item, $key) {

												if ($key == 'two_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											//FS::db()->where('tree_id', $curr_tree_id);

											//FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
										}

									} else {
										$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_getTreeID, "tree_id" => $curr_tree_id), 'two_sep_board_count')->row()->two_sep_board_count;

										if ($two_sep_board_count < 8) {
											$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

											$two_aff_id_arr['two_aff_id'] = $two_getTreeID;

											//update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_getTreeID, "tree_id" => $curr_tree_id));

											$insertData['board_two_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								}
							} else {
								$insertData['board_two_cid'] = $affiliate_id;
							}
						}

						$insertData['two_core_status'] = $core_status;

						$insertData['two_sep_board'] = $sep_board;

						$insertData['board_two_affiliate_id'] = $affiliate_id;

						$Treferr_id = $insertData['board_two_affiliate_id'];

						$ATcount = \FS::input()->post('tree_status');

						if ($ATcount == 1 || $ATcount == '1') {

							$Tupdata['two_tree_status'] = 1;

							update_data(USERS, $Tupdata, array('contract_id' => $Treferr_id, "tree_id" => $curr_tree_id));
						}

					} else if ($buyPlan == 3 || $buyPlan == '3') {
						$insertData['board_three'] = 3;

						$insertData['board_three_re_id'] = $_Reinvest;

						$insertData['board_three_cu_re_id'] = $_Reinvest;

						if (!empty($_Reinvest)) {
							$insertData['three_create_re_timestamp'] = $create_timestamp;
						}

						$get_three_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $curr_tree_id), 'board_three_cid')->row()->board_three_cid;

						if ($current_UserCount < 7) {
							$insertData['board_three_cid'] = 1;
						} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
							$insertData['board_three_cid'] = $insertData['contract_id'];
						}

						$insertData['three_create_timestamp'] = $create_timestamp;

						$insertData['board_three_time'] = 1;

						if ($current_UserCount >= 15 && $current_UserCount < 31) {
							if (!empty(@$get_sep_board_id)) {
								$insertData['board_three_cid'] = $get_sep_board_id;
							}
						}

						if ($current_UserCount >= 31) {
							if (empty($get_sep_board_ids->three_sep_board)) {
								$three_aff_id = $get_sep_board_ids->board_three_affiliate_id;

								$_tsep_board_ids = @get_data(USERS, array('contract_id' => $three_aff_id, 'tree_id' => $curr_tree_id), 'board_three_affiliate_id,three_sep_board')->row();

								if (!empty($_tsep_board_ids->three_sep_board)) {

									$_three_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_three_cid->user_child < 6) {
										$insertData['board_three_cid'] = $three_aff_id;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_three_cid->user_child == 6) {
										$insertData['board_three_cid'] = $three_aff_id;

										$core_status = 1;

										//$ref_status = 1;

										$_three_cid_array = FS::db()->query('SELECT contract_id,three_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_three_cid_array)) {
											array_walk_recursive($_three_cid_array, function (&$item, $key) {

												if ($key == 'three_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											//FS::db()->where('tree_id', $curr_tree_id);

											//FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
										}
									} else {
										$three_sep_board_count = @get_data(USERS, array("contract_id" => $three_aff_id, "tree_id" => $curr_tree_id), 'three_sep_board_count')->row()->three_sep_board_count;

										if ($three_sep_board_count < 8) {
											$three_sep_board_count_data['three_sep_board_count'] = $three_sep_board_count + 1;

											$three_aff_id_arr['three_aff_id'] = $three_aff_id;

											//update_data(USERS, $three_sep_board_count_data, array("contract_id" => $three_aff_id, "tree_id" => $curr_tree_id));

											$insertData['board_three_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								} else {
									$three_getTreeID = $this->getThreeTreeID($_tsep_board_ids->board_three_affiliate_id, $curr_tree_id);

									$_three_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_three_cid->user_child < 6) {
										$insertData['board_three_cid'] = $three_getTreeID;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_three_cid->user_child == 6) {
										$insertData['board_three_cid'] = $three_getTreeID;

										$core_status = 1;

										//$ref_status = 1;

										$_three_cid_array = FS::db()->query('SELECT contract_id,three_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_three_cid_array)) {
											array_walk_recursive($_three_cid_array, function (&$item, $key) {

												if ($key == 'three_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											//FS::db()->where('tree_id', $curr_tree_id);

											//FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
										}

									} else {
										$three_sep_board_count = @get_data(USERS, array("contract_id" => $three_getTreeID, "tree_id" => $curr_tree_id), 'three_sep_board_count')->row()->three_sep_board_count;

										if ($three_sep_board_count < 8) {
											$three_sep_board_count_data['three_sep_board_count'] = $three_sep_board_count + 1;

											$three_aff_id_arr['three_aff_id'] = $three_getTreeID;
											//update_data(USERS, $three_sep_board_count_data, array("contract_id" => $three_getTreeID, "tree_id" => $curr_tree_id));

											$insertData['board_three_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								}
							} else {
								$insertData['board_three_cid'] = $affiliate_id;
							}
						}

						$insertData['three_core_status'] = $core_status;

						$insertData['three_sep_board'] = $sep_board;

						$insertData['board_three_affiliate_id'] = $affiliate_id;

						$THreferr_id = $insertData['board_three_affiliate_id'];

						$ATHcount = \FS::input()->post('tree_status');

						if ($ATHcount == 1 || $ATHcount == '1') {

							$THupdata['three_tree_status'] = 1;

							update_data(USERS, $THupdata, array('contract_id' => $THreferr_id, "tree_id" => $curr_tree_id));
						}

					}

					$insertData['tree_id'] = $curr_tree_id;
				}
			} else {
				$insertData['affiliate_id'] = $affiliate_id;
				$buyPlan = 0;
			}

			$depAmount = \FS::input()->post('depAmount');

			$user_check = @get_data(USERS, array('address' => strtolower($insertData['address']), 'plan_id' => $insertData['plan_id'], "tree_id" => $curr_tree_id), 'id,ref_code')->row();

			if (empty($user_check)) {

				$insertData['ref_code'] = $ref_code;

				$insert = FS::Common()->insertTableData(USERS, $insertData);

				if ($insert) {

					$original_ref_id = \FS::input()->post('original_ref_id');

					if (!empty(@$original_ref_id)) {

						$ori_data['tree_id'] = $curr_tree_id;

						$ori_data['contract_id'] = $insertData['contract_id'];

						$ori_data['original_ref_id'] = $original_ref_id;

						$ori_data['placing_ref_id'] = $insertData['ref_id'];

						insert_data(ORRE, $ori_data);

					}

					if (!empty(@$_one_cid_array)) {
						FS::db()->where('tree_id', $curr_tree_id);

						FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
					}

					if (!empty(@$_two_cid_array)) {
						FS::db()->where('tree_id', $curr_tree_id);

						FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
					}

					if (!empty(@$_three_cid_array)) {
						FS::db()->where('tree_id', $curr_tree_id);

						FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
					}

					if (!empty(@$one_sep_board_count_data)) {
						update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_aff_id_arr['on_aff_id'], "tree_id" => $curr_tree_id));
					}

					if (!empty(@$two_sep_board_count_data)) {
						update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_aff_id_arr['two_aff_id'], "tree_id" => $curr_tree_id));
					}

					if (!empty(@$three_sep_board_count_data)) {
						update_data(USERS, $three_sep_board_count_data, array("contract_id" => $three_aff_id_arr['three_aff_id'], "tree_id" => $curr_tree_id));
					}

					if (!empty($insertData['contract_id'])) {
						if ($current_UserCount <= 34) {
							if ($buyPlan == 1 || $buyPlan == '1') {
								$priviousIDUpdate['board_one_prev_id'] = 1;
							}
						} else if ($current_UserCount >= 35) {
							if ($buyPlan == 1 || $buyPlan == '1') {
								$getPriviousBoardIDs = $this->getPriviousBoardID($insertData['contract_id'], 0, $curr_tree_id);

								$priviousIDUpdate['board_one_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
							}
						}

						update_data(USERS, $priviousIDUpdate, array('id' => $insert));

					}

					FS::session()->set_userdata('tr_juego_id', $insertData['address']);

					insertUserLevelHistory($insert, $buyPlan, $depAmount);

					$get_core_status_details = @get_data(USERS, array('address' => $insertData['address'], 'id' => $insert), 'one_core_status')->row()->one_core_status;

					$bdata['address'] = $insertData['address'];

					$bdata['ref_code'] = $insertData['ref_code'];

					$bdata['core_status'] = $get_core_status_details;

					trigger_socket($bdata, 'userLogin');

				} else {

					echo "failed";
				}
			} else {
				if ($buyPlan == 2 || $buyPlan == '2' || $buyPlan == 3 || $buyPlan == '3') {
					update_data(USERS, $insertData, array('id' => $user_check->id));

					if (!empty($insertData['contract_id'])) {
						if ($current_UserCount <= 34) {
							if ($buyPlan == 2 || $buyPlan == '2') {
								$priviousIDUpdate['board_two_prev_id'] = 1;
							} else if ($buyPlan == 3 || $buyPlan == '3') {
								$priviousIDUpdate['board_three_prev_id'] = 1;
							}
						} else if ($current_UserCount >= 35) {
							if ($buyPlan == 2 || $buyPlan == '2') {
								$getPriviousBoardIDs = $this->twoGetPriviousBoardID($insertData['contract_id'], 0, $curr_tree_id);

								$priviousIDUpdate['board_two_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
							} else if ($buyPlan == 3 || $buyPlan == '3') {
								$getPriviousBoardIDs = $this->threeGetPriviousBoardID($insertData['contract_id'], 0, $curr_tree_id);

								$priviousIDUpdate['board_three_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
							}
						}

						update_data(USERS, $priviousIDUpdate, array('id' => $user_check->id));

					}

					insertUserLevelHistory($user_check->id, $buyPlan, $depAmount);
				}

				$get_core_status_details = @get_data(USERS, array('address' => $insertData['address'], 'id' => $user_check->id), 'one_core_status')->row()->one_core_status;
				$bdata['address'] = $insertData['address'];
				$bdata['ref_code'] = $user_check->ref_code;
				$bdata['core_status'] = $get_core_status_details;

				trigger_socket($bdata, 'userLogin');
			}
		} else {
			echo "invalid request";die;
		}
	}

	function UpdateMissingCircle($id, $contract_id, $buyPlan, $_Reinvest, $affiliate_id, $create_timestamp, $tree_id) {
		if (!empty($contract_id)) {
			if ($buyPlan == 1) {
				$board_re_id = 'board_one_cu_re_id';

				$buyPlanName = 'board_one';
			} else if ($buyPlan == 2) {
				$board_re_id = 'board_two_cu_re_id';

				$buyPlanName = 'board_two';
			} else if ($buyPlan == 3) {
				$board_re_id = 'board_three_cu_re_id';

				$buyPlanName = 'board_three';
			}

			$UserCount = FS::db()->query('SELECT COUNT(id) as user_re_count FROM `' . P . USERS . '` WHERE `' . $board_re_id . '` = ' . $_Reinvest . ' AND `' . $buyPlanName . '` = ' . $buyPlan . ' AND plan_id = 1 AND tree_id = ' . $tree_id . '')->row();

			if ($tree_id > 1) {
				$current_UserCount = $UserCount->user_re_count + 1;
			} else {
				$current_UserCount = $UserCount->user_re_count;
			}

			if ($current_UserCount < 7) {
				$core_status = 1;

				$ref_status = 1;
			} else {
				$core_status = 0;

				$ref_status = 0;
			}

			if ($current_UserCount >= 7 && $current_UserCount < 15) {
				$sep_board = 1;

				$core_status = 1;

				$ref_status = 1;
			} else {
				$sep_board = 0;
			}

			if ($current_UserCount >= 15 && $current_UserCount < 31) {
				$get_sep_board_id = $affiliate_id;
			}

			if ($current_UserCount >= 31) {
				$get_sep_board_ids = @get_data(USERS, array('contract_id' => $affiliate_id, "tree_id" => $tree_id), 'affiliate_id,board_two_affiliate_id,board_three_affiliate_id,one_sep_board,two_sep_board,three_sep_board,board_one_cu_re_id,board_two_cu_re_id,board_three_cu_re_id')->row();
			}

			if ($buyPlan == 1 || $buyPlan == '1') {
				$insertData['board_one'] = 1;

				$insertData['board_one_re_id'] = $_Reinvest;

				$insertData['board_one_cu_re_id'] = $_Reinvest;

				if (!empty($_Reinvest)) {
					$insertData['one_create_re_timestamp'] = $create_timestamp;
				}

				$get_one_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $tree_id), 'board_one_cid')->row()->board_one_cid;

				if ($current_UserCount < 7) {
					$insertData['board_one_cid'] = 1;
				} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
					$insertData['board_one_cid'] = $contract_id;
				}

				$insertData['create_timestamp'] = $create_timestamp;

				$insertData['board_one_time'] = 1;

				if ($current_UserCount >= 15 && $current_UserCount < 31) {
					if (!empty(@$get_sep_board_id)) {
						$insertData['board_one_cid'] = $get_sep_board_id;
					}
				}

				if ($current_UserCount >= 31) {
					if (empty($get_sep_board_ids->one_sep_board)) {
						$on_aff_id = $get_sep_board_ids->affiliate_id;

						$_sep_board_ids = @get_data(USERS, array('contract_id' => $on_aff_id, 'tree_id' => $tree_id), 'affiliate_id,one_sep_board')->row();

						if (!empty($_sep_board_ids->one_sep_board)) {

							$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_aff_id . ' AND `tree_id` = ' . $tree_id . '')->row();

							if ($_one_cid->user_child < 6) {
								$insertData['board_one_cid'] = $on_aff_id;

								$core_status = 0;

								$ref_status = 0;
							} else if ($_one_cid->user_child == 6) {
								$insertData['board_one_cid'] = $on_aff_id;

								$core_status = 1;

								$ref_status = 1;

								$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_aff_id . ' AND `tree_id` = ' . $tree_id . '')->result_array();

								if (!empty($_one_cid_array)) {
									array_walk_recursive($_one_cid_array, function (&$item, $key) {

										if ($key == 'one_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									//FS::db()->where('tree_id', $tree_id);

									//FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
								}
							} else {
								$one_sep_board_count = @get_data(USERS, array("contract_id" => $on_aff_id, "tree_id" => $tree_id), 'one_sep_board_count')->row()->one_sep_board_count;

								if ($one_sep_board_count < 8) {
									$one_sep_board_count_data['one_sep_board_count'] = $one_sep_board_count + 1;

									//update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_aff_id, "tree_id" => $tree_id));

									$insertData['board_one_cid'] = $contract_id;

									$on_aff_id_arr['on_aff_id'] = $on_aff_id;

									$sep_board = 1;
								}
							}
						} else {
							$on_getTreeID = $this->getTreeID($_sep_board_ids->affiliate_id, $tree_id);

							$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID . ' AND `tree_id` = ' . $tree_id . '')->row();

							if ($_one_cid->user_child < 6) {
								$insertData['board_one_cid'] = $on_getTreeID;

								$core_status = 0;

								$ref_status = 0;

							} else if ($_one_cid->user_child == 6) {
								$insertData['board_one_cid'] = $on_getTreeID;

								$core_status = 1;

								$ref_status = 1;

								$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID . ' AND `tree_id` = ' . $tree_id . '')->result_array();

								if (!empty($_one_cid_array)) {
									array_walk_recursive($_one_cid_array, function (&$item, $key) {

										if ($key == 'one_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									//FS::db()->where('tree_id', $tree_id);

									//FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
								}

							} else {
								$one_sep_board_count = @get_data(USERS, array("contract_id" => $on_getTreeID, "tree_id" => $tree_id), 'one_sep_board_count')->row()->one_sep_board_count;

								if ($one_sep_board_count < 8) {
									$one_sep_board_count_data['one_sep_board_count'] = $one_sep_board_count + 1;

									//update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_getTreeID, "tree_id" => $tree_id));

									$insertData['board_one_cid'] = $contract_id;

									$on_aff_id_arr['on_aff_id'] = $on_getTreeID;

									$sep_board = 1;
								}
							}
						}
					} else {
						$insertData['board_one_cid'] = $affiliate_id;
					}
				}

				$insertData['one_core_status'] = $core_status;

				$insertData['one_sep_board'] = $sep_board;

				$insertData['ref_status'] = $ref_status;

			} else if ($buyPlan == 2 || $buyPlan == '2') {
				$insertData['board_two'] = 2;

				$insertData['board_two_re_id'] = $_Reinvest;

				$insertData['board_two_cu_re_id'] = $_Reinvest;

				if (!empty($_Reinvest)) {
					$insertData['two_create_re_timestamp'] = $create_timestamp;
				}

				$get_two_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $tree_id), 'board_two_cid')->row()->board_two_cid;

				if ($current_UserCount < 7) {
					$insertData['board_two_cid'] = 1;
				} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
					$insertData['board_two_cid'] = $contract_id;
				}

				$insertData['two_create_timestamp'] = $create_timestamp;

				$insertData['board_two_time'] = 1;

				if ($current_UserCount >= 15 && $current_UserCount < 31) {
					if (!empty(@$get_sep_board_id)) {
						$insertData['board_two_cid'] = $get_sep_board_id;
					}
				}

				if ($current_UserCount >= 31) {
					if (empty($get_sep_board_ids->two_sep_board)) {
						$two_aff_id = $get_sep_board_ids->board_two_affiliate_id;

						$_twsep_board_ids = @get_data(USERS, array('contract_id' => $two_aff_id, "tree_id" => $tree_id), 'board_two_affiliate_id,two_sep_board')->row();

						if (!empty($_twsep_board_ids->two_sep_board)) {

							$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . ' AND `tree_id` = ' . $tree_id . '')->row();

							if ($_two_cid->user_child < 6) {
								$insertData['board_two_cid'] = $two_aff_id;

								$core_status = 0;

								//$ref_status = 0;
							} else if ($_two_cid->user_child == 6) {
								$insertData['board_two_cid'] = $two_aff_id;

								$core_status = 1;

								//$ref_status = 1;

								$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . ' AND `tree_id` = ' . $tree_id . '')->result_array();

								if (!empty($_two_cid_array)) {
									array_walk_recursive($_two_cid_array, function (&$item, $key) {

										if ($key == 'two_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									//FS::db()->where('tree_id', $tree_id);

									//FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
								}
							} else {
								$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_aff_id, "tree_id" => $tree_id), 'two_sep_board_count')->row()->two_sep_board_count;

								if ($two_sep_board_count < 8) {
									$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

									//update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_aff_id, "tree_id" => $tree_id));

									$insertData['board_two_cid'] = $contract_id;

									$two_aff_id_arr['two_aff_id'] = $two_aff_id;

									$sep_board = 1;
								}
							}
						} else {
							$two_getTreeID = $this->getTwoTreeID($_twsep_board_ids->board_two_affiliate_id, $tree_id);

							$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . ' AND `tree_id` = ' . $tree_id . '')->row();

							if ($_two_cid->user_child < 6) {
								$insertData['board_two_cid'] = $two_getTreeID;

								$core_status = 0;

								//$ref_status = 0;
							} else if ($_two_cid->user_child == 6) {
								$insertData['board_two_cid'] = $two_getTreeID;

								$core_status = 1;

								//$ref_status = 1;

								$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . ' AND `tree_id` = ' . $tree_id . '')->result_array();

								if (!empty($_two_cid_array)) {
									array_walk_recursive($_two_cid_array, function (&$item, $key) {

										if ($key == 'two_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									//FS::db()->where('tree_id', $tree_id);

									//FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
								}

							} else {
								$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_getTreeID, "tree_id" => $tree_id), 'two_sep_board_count')->row()->two_sep_board_count;

								if ($two_sep_board_count < 8) {
									$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

									//update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_getTreeID, "tree_id" => $tree_id));

									$insertData['board_two_cid'] = $contract_id;

									$two_aff_id_arr['two_aff_id'] = $two_getTreeID;

									$sep_board = 1;
								}
							}
						}
					} else {
						$insertData['board_two_cid'] = $affiliate_id;
					}
				}

				$insertData['two_core_status'] = $core_status;

				$insertData['two_sep_board'] = $sep_board;
			} else if ($buyPlan == 3 || $buyPlan == '3') {
				$insertData['board_three'] = 3;

				$insertData['board_three_re_id'] = $_Reinvest;

				$insertData['board_three_cu_re_id'] = $_Reinvest;

				if (!empty($_Reinvest)) {
					$insertData['three_create_re_timestamp'] = $create_timestamp;
				}

				$get_three_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $tree_id), 'board_three_cid')->row()->board_three_cid;

				if ($current_UserCount < 7) {
					$insertData['board_three_cid'] = 1;
				} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
					$insertData['board_three_cid'] = $contract_id;
				}

				$insertData['three_create_timestamp'] = $create_timestamp;

				$insertData['board_three_time'] = 1;

				if ($current_UserCount >= 15 && $current_UserCount < 31) {
					if (!empty(@$get_sep_board_id)) {
						$insertData['board_three_cid'] = $get_sep_board_id;
					}
				}

				if ($current_UserCount >= 31) {
					if (empty($get_sep_board_ids->three_sep_board)) {
						$three_aff_id = $get_sep_board_ids->board_three_affiliate_id;

						$_tsep_board_ids = @get_data(USERS, array('contract_id' => $three_aff_id, "tree_id" => $tree_id), 'board_three_affiliate_id,three_sep_board')->row();

						if (!empty($_tsep_board_ids->three_sep_board)) {

							$_three_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_aff_id . ' AND `tree_id` = ' . $tree_id . '')->row();

							if ($_three_cid->user_child < 6) {
								$insertData['board_three_cid'] = $three_aff_id;

								$core_status = 0;

								//$ref_status = 0;
							} else if ($_three_cid->user_child == 6) {
								$insertData['board_three_cid'] = $three_aff_id;

								$core_status = 1;

								//$ref_status = 1;

								$_three_cid_array = FS::db()->query('SELECT contract_id,three_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_aff_id . ' AND `tree_id` = ' . $tree_id . '')->result_array();

								if (!empty($_three_cid_array)) {
									array_walk_recursive($_three_cid_array, function (&$item, $key) {

										if ($key == 'three_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									//FS::db()->where('tree_id', $tree_id);

									//FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
								}
							} else {
								$three_sep_board_count = @get_data(USERS, array("contract_id" => $three_aff_id, "tree_id" => $tree_id), 'three_sep_board_count')->row()->three_sep_board_count;

								if ($three_sep_board_count < 8) {
									$one_sep_board_count_data['three_sep_board_count'] = $three_sep_board_count + 1;

									//update_data(USERS, $one_sep_board_count_data, array("contract_id" => $three_aff_id, "tree_id" => $tree_id));

									$insertData['board_three_cid'] = $contract_id;

									$three_aff_id_arr['three_aff_id'] = $three_aff_id;

									$sep_board = 1;
								}
							}
						} else {
							$three_getTreeID = $this->getThreeTreeID($_tsep_board_ids->board_three_affiliate_id, $tree_id);

							$_three_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_getTreeID . ' AND `tree_id` = ' . $tree_id . '')->row();

							if ($_three_cid->user_child < 6) {
								$insertData['board_three_cid'] = $three_getTreeID;

								$core_status = 0;

								//$ref_status = 0;
							} else if ($_three_cid->user_child == 6) {
								$insertData['board_three_cid'] = $three_getTreeID;

								$core_status = 1;

								//$ref_status = 1;

								$_three_cid_array = FS::db()->query('SELECT contract_id,three_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_getTreeID . ' AND `tree_id` = ' . $tree_id . '')->result_array();

								if (!empty($_three_cid_array)) {
									array_walk_recursive($_three_cid_array, function (&$item, $key) {

										if ($key == 'three_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									//FS::db()->where('tree_id', $tree_id);

									//FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
								}

							} else {
								$three_sep_board_count = @get_data(USERS, array("contract_id" => $three_getTreeID, "tree_id" => $tree_id), 'three_sep_board_count')->row()->three_sep_board_count;

								if ($three_sep_board_count < 8) {
									$three_sep_board_count_data['three_sep_board_count'] = $three_sep_board_count + 1;

									//update_data(USERS, $three_sep_board_count_data, array("contract_id" => $three_getTreeID, "tree_id" => $tree_id));

									$insertData['board_three_cid'] = $contract_id;

									$three_aff_id_arr['three_aff_id'] = $three_getTreeID;

									$sep_board = 1;
								}
							}
						}
					} else {
						$insertData['board_three_cid'] = $affiliate_id;
					}
				}

				$insertData['three_core_status'] = $core_status;

				$insertData['three_sep_board'] = $sep_board;

			}

			update_data(USERS, $insertData, array('id' => $id));

			if (!empty(@$_one_cid_array)) {
				FS::db()->where('tree_id', $tree_id);

				FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
			}

			if (!empty(@$_two_cid_array)) {
				FS::db()->where('tree_id', $tree_id);

				FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
			}

			if (!empty(@$_three_cid_array)) {
				FS::db()->where('tree_id', $tree_id);

				FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
			}

			if (!empty(@$one_sep_board_count_data)) {
				update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_aff_id_arr['on_aff_id'], "tree_id" => $tree_id));
			}

			if (!empty(@$two_sep_board_count_data)) {
				update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_aff_id_arr['two_aff_id'], "tree_id" => $tree_id));
			}

			if (!empty(@$three_sep_board_count_data)) {
				update_data(USERS, $three_sep_board_count_data, array("contract_id" => $three_aff_id_arr['three_aff_id'], "tree_id" => $tree_id));
			}

			if ($current_UserCount <= 34) {
				if ($buyPlan == 1 || $buyPlan == '1') {
					$priviousIDUpdate['board_one_prev_id'] = 1;
				} else if ($buyPlan == 2 || $buyPlan == '2') {
					$priviousIDUpdate['board_two_prev_id'] = 1;
				} else if ($buyPlan == 3 || $buyPlan == '3') {
					$priviousIDUpdate['board_three_prev_id'] = 1;
				}
			} else if ($current_UserCount >= 35) {
				if ($buyPlan == 1 || $buyPlan == '1') {
					$getPriviousBoardIDs = $this->getPriviousBoardID($contract_id, 0, $tree_id);

					$priviousIDUpdate['board_one_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
				} else if ($buyPlan == 2 || $buyPlan == '2') {
					$getPriviousBoardIDs = $this->twoGetPriviousBoardID($contract_id, 0, $tree_id);

					$priviousIDUpdate['board_two_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
				} else if ($buyPlan == 3 || $buyPlan == '3') {
					$getPriviousBoardIDs = $this->threeGetPriviousBoardID($contract_id, 0, $tree_id);

					$priviousIDUpdate['board_three_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
				}
			}

			update_data(USERS, $priviousIDUpdate, array('id' => $id));
		}

		return true;
	}

	function getMissingID($curr_id, $tree_id) {

		// $array_str = "TWP5rACVpVmPGWchzTESUTuhJPkW7FANiu,TUajYoGDvfYoY4U4HpiWBcyqqcNtjjwfdw,TLiJ7XzXzxNsPaf9NXDhzeiUM8X3F7E37m,TPDBjRygdQxGME34xZ5y4VduYRukwoF8yd,TNss1RwRUrxHtr3HyRApzKKe9gBwwyUmPY";

		// $array_str = explode(',', $array_str);

		// $data['missing_arr'] = $array_str;

		// echo json_encode($array_str);

		// die;

		/*if ($tree_id >= 2) {
			$tree_id = 2;
		}*/

		if (!empty($curr_id)) {
			$get_last_id = $this->db->select('contract_id')->where('plan_id', 1)->where('tree_id', $tree_id)->order_by('contract_id', "desc")->limit(1)->get(USERS)->row();

			if (!empty(@$get_last_id)) {
				$match_id = $curr_id - 1;

				if ($get_last_id->contract_id < $match_id) {
					if ($get_last_id->contract_id != $match_id) {
						$missing_id = array($get_last_id->contract_id, $curr_id);

						$new_arr = range($missing_id[0], max($missing_id));

						$missing_arr = array_diff($new_arr, $missing_id);

						$data['missing_arr'] = $missing_arr;

						echo json_encode($missing_arr);
					} else {
						echo 0;
					}
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}

		} else {
			echo 0;
		}
	}

	public function manualregister() {
		if (!empty(\FS::input()->post())) {
			$plan_id = \FS::input()->post('plan_id');

			$__ref_code = AlphaNumeric(10);

			$insertData['address'] = \FS::input()->post('address');

			$insertData['ref_id'] = \FS::input()->post('ref_address');

			$insertData['current_level'] = \FS::input()->post('current_level');

			$insertData['contract_id'] = \FS::input()->post('contract_id');

			$insertData['plan_id'] = \FS::input()->post('plan_id');

			$create_timestamp = \FS::input()->post('create_timestamp');

			$reinvestId = \FS::input()->post('reinvestId');

			$_Reinvest = \FS::input()->post('_Reinvest');

			$curr_tree_id = \FS::input()->post('tree_id');

			$affiliate_id = \FS::input()->post('affiliate_id');

			if (!empty($insertData['contract_id'])) {
				$buyPlan = $insertData['plan_id'] == 2 ? \FS::input()->post('buyPlan') + 1 : \FS::input()->post('buyPlan');

				if ($buyPlan == 1) {
					$board_re_id = 'board_one_cu_re_id';

					$buyPlanName = 'board_one';
				} else if ($buyPlan == 2) {
					$board_re_id = 'board_two_cu_re_id';

					$buyPlanName = 'board_two';
				} else if ($buyPlan == 3) {
					$board_re_id = 'board_three_cu_re_id';

					$buyPlanName = 'board_three';
				}

				$UserCount = FS::db()->query('SELECT COUNT(id) as user_re_count FROM `' . P . USERS . '` WHERE `' . $board_re_id . '` = ' . $_Reinvest . ' AND `' . $buyPlanName . '` = ' . $buyPlan . ' AND plan_id = 1 AND tree_id = ' . $curr_tree_id . '')->row();

				if ($curr_tree_id > 1) {
					$current_UserCount = $UserCount->user_re_count + 1;
				} else {
					$current_UserCount = $UserCount->user_re_count;
				}

				if ($current_UserCount < 7) {
					$core_status = 1;

					$ref_status = 1;
				} else {
					$core_status = 0;

					$ref_status = 0;
				}

				if ($current_UserCount >= 7 && $current_UserCount < 15) {
					$sep_board = 1;

					$core_status = 0;

					$ref_status = 0;
				} else {
					$sep_board = 0;
				}

				if ($current_UserCount >= 15 && $current_UserCount < 31) {
					$get_sep_board_id = $affiliate_id;
				}

				if ($current_UserCount >= 31) {
					$get_sep_board_ids = @get_data(USERS, array('contract_id' => $affiliate_id, "tree_id" => $curr_tree_id), 'affiliate_id,board_two_affiliate_id,board_three_affiliate_id,one_sep_board,two_sep_board,three_sep_board')->row();
				}

				if ($insertData['plan_id'] == 1 || $insertData['plan_id'] == '1') {
					if ($buyPlan == 1 || $buyPlan == '1') {
						$insertData['board_one'] = 1;

						$insertData['board_one_re_id'] = $_Reinvest;

						$insertData['board_one_cu_re_id'] = $_Reinvest;

						if (!empty($_Reinvest)) {
							$insertData['one_create_re_timestamp'] = $create_timestamp;
						}

						$get_one_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $curr_tree_id), 'board_one_cid')->row()->board_one_cid;

						if ($current_UserCount < 7) {
							$insertData['board_one_cid'] = 1;
						} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
							$insertData['board_one_cid'] = $insertData['contract_id'];
						}

						$insertData['create_timestamp'] = $create_timestamp;

						$insertData['board_one_time'] = 1;

						if ($current_UserCount >= 15 && $current_UserCount < 31) {
							if (!empty(@$get_sep_board_id)) {
								$insertData['board_one_cid'] = $get_sep_board_id;
							}
						}

						if ($current_UserCount >= 31) {
							if (empty($get_sep_board_ids->one_sep_board)) {
								$on_aff_id = $get_sep_board_ids->affiliate_id;

								$_sep_board_ids = @get_data(USERS, array('contract_id' => $on_aff_id, "tree_id" => $curr_tree_id), 'affiliate_id,one_sep_board')->row();

								if (!empty($_sep_board_ids->one_sep_board)) {

									$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_one_cid->user_child < 6) {
										$insertData['board_one_cid'] = $on_aff_id;

										$core_status = 0;

										$ref_status = 0;
									} else if ($_one_cid->user_child == 6) {
										$insertData['board_one_cid'] = $on_aff_id;

										$core_status = 1;

										$ref_status = 1;

										$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_aff_id . 'AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_one_cid_array)) {
											array_walk_recursive($_one_cid_array, function (&$item, $key) {

												if ($key == 'one_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											FS::db()->where('tree_id', $curr_tree_id);

											FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
										}
									} else {
										$one_sep_board_count = @get_data(USERS, array("contract_id" => $on_aff_id, "tree_id" => $curr_tree_id), 'one_sep_board_count')->row()->one_sep_board_count;

										if ($one_sep_board_count < 8) {
											$one_sep_board_count_data['one_sep_board_count'] = $one_sep_board_count + 1;

											update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_aff_id, "tree_id" => $curr_tree_id));

											$insertData['board_one_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								} else {
									$on_getTreeID = $this->getTreeID($_sep_board_ids->affiliate_id, $curr_tree_id);

									$_one_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_one_cid->user_child < 6) {
										$insertData['board_one_cid'] = $on_getTreeID;

										$core_status = 0;

										$ref_status = 0;

									} else if ($_one_cid->user_child == 6) {
										$insertData['board_one_cid'] = $on_getTreeID;

										$core_status = 1;

										$ref_status = 1;

										$_one_cid_array = FS::db()->query('SELECT contract_id,one_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_one_cid` = ' . $on_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_one_cid_array)) {
											array_walk_recursive($_one_cid_array, function (&$item, $key) {

												if ($key == 'one_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											FS::db()->where('tree_id', $curr_tree_id);

											FS::db()->update_batch(USERS, $_one_cid_array, 'contract_id');
										}

									} else {
										$one_sep_board_count = @get_data(USERS, array("contract_id" => $on_getTreeID, "tree_id" => $curr_tree_id), 'one_sep_board_count')->row()->one_sep_board_count;

										if ($one_sep_board_count < 8) {
											$one_sep_board_count_data['one_sep_board_count'] = $one_sep_board_count + 1;

											update_data(USERS, $one_sep_board_count_data, array("contract_id" => $on_getTreeID, "tree_id" => $curr_tree_id));

											$insertData['board_one_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								}
							} else {
								$insertData['board_one_cid'] = $affiliate_id;
							}
						}

						$insertData['one_core_status'] = $core_status;

						$insertData['one_sep_board'] = $sep_board;

						$insertData['affiliate_id'] = $affiliate_id;

						$insertData['ref_status'] = $ref_status;

						$referr_id = $insertData['affiliate_id'];

						$Acount = \FS::input()->post('tree_status');

						if ($Acount == 1 || $Acount == '1') {

							$updata['tree_status'] = 1;

							update_data(USERS, $updata, array('contract_id' => $referr_id, 'tree_id' => $curr_tree_id));
						}

					} else if ($buyPlan == 2 || $buyPlan == '2') {
						$insertData['board_two'] = 2;

						$insertData['board_two_re_id'] = $_Reinvest;

						$insertData['board_two_cu_re_id'] = $_Reinvest;

						if (!empty($_Reinvest)) {
							$insertData['two_create_re_timestamp'] = $create_timestamp;
						}

						$get_two_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $curr_tree_id), 'board_two_cid')->row()->board_two_cid;

						if ($current_UserCount < 7) {
							$insertData['board_two_cid'] = 1;
						} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
							$insertData['board_two_cid'] = $insertData['contract_id'];
						}

						$insertData['two_create_timestamp'] = $create_timestamp;

						$insertData['board_two_time'] = 1;

						if ($current_UserCount >= 15 && $current_UserCount < 31) {
							if (!empty(@$get_sep_board_id)) {
								$insertData['board_two_cid'] = $get_sep_board_id;
							}
						}

						if ($current_UserCount >= 31) {
							if (empty($get_sep_board_ids->two_sep_board)) {
								$two_aff_id = $get_sep_board_ids->board_two_affiliate_id;

								$_twsep_board_ids = @get_data(USERS, array('contract_id' => $two_aff_id), 'board_two_affiliate_id,two_sep_board')->row();

								if (!empty($_twsep_board_ids->two_sep_board)) {

									$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_two_cid->user_child < 6) {
										$insertData['board_two_cid'] = $two_aff_id;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_two_cid->user_child == 6) {
										$insertData['board_two_cid'] = $two_aff_id;

										$core_status = 1;

										//$ref_status = 1;

										$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_two_cid_array)) {
											array_walk_recursive($_two_cid_array, function (&$item, $key) {

												if ($key == 'two_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											FS::db()->where('tree_id', $curr_tree_id);

											FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
										}
									} else {
										$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_aff_id, "tree_id" => $curr_tree_id), 'two_sep_board_count')->row()->two_sep_board_count;

										if ($two_sep_board_count < 8) {
											$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

											update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_aff_id, "tree_id" => $curr_tree_id));

											$insertData['board_two_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								} else {
									$two_getTreeID = $this->getTwoTreeID($_twsep_board_ids->board_two_affiliate_id, $curr_tree_id);

									$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_two_cid->user_child < 6) {
										$insertData['board_two_cid'] = $two_getTreeID;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_two_cid->user_child == 6) {
										$insertData['board_two_cid'] = $two_getTreeID;

										$core_status = 1;

										//$ref_status = 1;

										$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_two_cid_array)) {
											array_walk_recursive($_two_cid_array, function (&$item, $key) {

												if ($key == 'two_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											FS::db()->where('tree_id', $curr_tree_id);

											FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
										}

									} else {
										$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_getTreeID, "tree_id" => $curr_tree_id), 'two_sep_board_count')->row()->two_sep_board_count;

										if ($two_sep_board_count < 8) {
											$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

											update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_getTreeID, "tree_id" => $curr_tree_id));

											$insertData['board_two_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								}
							} else {
								$insertData['board_two_cid'] = $affiliate_id;
							}
						}

						$insertData['two_core_status'] = $core_status;

						$insertData['two_sep_board'] = $sep_board;

						$insertData['board_two_affiliate_id'] = $affiliate_id;

						$Treferr_id = $insertData['board_two_affiliate_id'];

						$ATcount = \FS::input()->post('tree_status');

						if ($ATcount == 1 || $ATcount == '1') {

							$Tupdata['two_tree_status'] = 1;

							update_data(USERS, $Tupdata, array('contract_id' => $Treferr_id, "tree_id" => $curr_tree_id));
						}

					} else if ($buyPlan == 3 || $buyPlan == '3') {
						$insertData['board_three'] = 3;

						$insertData['board_three_re_id'] = $_Reinvest;

						$insertData['board_three_cu_re_id'] = $_Reinvest;

						if (!empty($_Reinvest)) {
							$insertData['three_create_re_timestamp'] = $create_timestamp;
						}

						$get_three_cid = @get_data(USERS, array('contract_id' => $affiliate_id, 'plan_id' => 1, 'tree_id' => $curr_tree_id), 'board_three_cid')->row()->board_three_cid;

						if ($current_UserCount < 7) {
							$insertData['board_three_cid'] = 1;
						} else if ($current_UserCount >= 7 && $current_UserCount < 15) {
							$insertData['board_three_cid'] = $insertData['contract_id'];
						}

						$insertData['three_create_timestamp'] = $create_timestamp;

						$insertData['board_three_time'] = 1;

						if ($current_UserCount >= 15 && $current_UserCount < 31) {
							if (!empty(@$get_sep_board_id)) {
								$insertData['board_three_cid'] = $get_sep_board_id;
							}
						}

						if ($current_UserCount >= 31) {
							if (empty($get_sep_board_ids->three_sep_board)) {
								$three_aff_id = $get_sep_board_ids->board_three_affiliate_id;

								$_tsep_board_ids = @get_data(USERS, array('contract_id' => $three_aff_id, "tree_id" => $curr_tree_id), 'board_three_affiliate_id,three_sep_board')->row();

								if (!empty($_tsep_board_ids->three_sep_board)) {

									$_three_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_three_cid->user_child < 6) {
										$insertData['board_three_cid'] = $three_aff_id;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_three_cid->user_child == 6) {
										$insertData['board_three_cid'] = $three_aff_id;

										$core_status = 1;

										//$ref_status = 1;

										$_three_cid_array = FS::db()->query('SELECT contract_id,three_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_aff_id . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_three_cid_array)) {
											array_walk_recursive($_three_cid_array, function (&$item, $key) {

												if ($key == 'three_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											FS::db()->where('tree_id', $curr_tree_id);

											FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
										}
									} else {
										$three_sep_board_count = @get_data(USERS, array("contract_id" => $three_aff_id, "tree_id" => $curr_tree_id), 'three_sep_board_count')->row()->three_sep_board_count;

										if ($three_sep_board_count < 8) {
											$one_sep_board_count_data['three_sep_board_count'] = $three_sep_board_count + 1;

											update_data(USERS, $one_sep_board_count_data, array("contract_id" => $three_aff_id, "tree_id" => $curr_tree_id));

											$insertData['board_three_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								} else {
									$three_getTreeID = $this->getThreeTreeID($_tsep_board_ids->board_three_affiliate_id, $curr_tree_id);

									$_three_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->row();

									if ($_three_cid->user_child < 6) {
										$insertData['board_three_cid'] = $three_getTreeID;

										$core_status = 0;

										//$ref_status = 0;
									} else if ($_three_cid->user_child == 6) {
										$insertData['board_three_cid'] = $three_getTreeID;

										$core_status = 1;

										//$ref_status = 1;

										$_three_cid_array = FS::db()->query('SELECT contract_id,three_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_three_cid` = ' . $three_getTreeID . ' AND `tree_id` = ' . $curr_tree_id . '')->result_array();

										if (!empty($_three_cid_array)) {
											array_walk_recursive($_three_cid_array, function (&$item, $key) {

												if ($key == 'three_core_status') {

													$item = 1;
												}

												if ($key == 'ref_status') {

													$item = 1;
												}

											});

											FS::db()->where('tree_id', $curr_tree_id);

											FS::db()->update_batch(USERS, $_three_cid_array, 'contract_id');
										}

									} else {
										$three_sep_board_count = @get_data(USERS, array("contract_id" => $three_getTreeID, "tree_id" => $curr_tree_id), 'three_sep_board_count')->row()->three_sep_board_count;

										if ($three_sep_board_count < 8) {
											$three_sep_board_count_data['three_sep_board_count'] = $three_sep_board_count + 1;

											update_data(USERS, $three_sep_board_count_data, array("contract_id" => $three_getTreeID, "tree_id" => $curr_tree_id));

											$insertData['board_three_cid'] = $insertData['contract_id'];

											$sep_board = 1;
										}
									}
								}
							} else {
								$insertData['board_three_cid'] = $affiliate_id;
							}
						}

						$insertData['three_core_status'] = $core_status;

						$insertData['three_sep_board'] = $sep_board;

						$insertData['board_three_affiliate_id'] = $affiliate_id;

						$THreferr_id = $insertData['board_three_affiliate_id'];

						$ATHcount = \FS::input()->post('tree_status');

						if ($ATHcount == 1 || $ATHcount == '1') {

							$THupdata['three_tree_status'] = 1;

							update_data(USERS, $THupdata, array('contract_id' => $THreferr_id, "tree_id" => $curr_tree_id));
						}

					}

					$insertData['tree_id'] = $curr_tree_id;
				}
			} else {
				$insertData['affiliate_id'] = $affiliate_id;

				$buyPlan = 0;
			}

			$depAmount = \FS::input()->post('depAmount');

			$user_check = @get_data(USERS, array('address' => strtolower($insertData['address']), 'plan_id' => $insertData['plan_id']), 'id')->row();

			if (empty($user_check)) {

				$insertData['ref_code'] = $__ref_code;

				$insert = FS::Common()->insertTableData(USERS, $insertData);

				if ($insert) {

					if (!empty($insertData['contract_id'])) {
						if ($current_UserCount <= 34) {
							if ($buyPlan == 1 || $buyPlan == '1') {
								$priviousIDUpdate['board_one_prev_id'] = 1;
							} else if ($buyPlan == 2 || $buyPlan == '2') {
								$priviousIDUpdate['board_two_prev_id'] = 1;
							} else if ($buyPlan == 3 || $buyPlan == '3') {
								$priviousIDUpdate['board_three_prev_id'] = 1;
							}
						} else if ($current_UserCount >= 35) {
							if ($buyPlan == 1 || $buyPlan == '1') {
								$getPriviousBoardIDs = $this->getPriviousBoardID($insertData['contract_id'], 0, $curr_tree_id);

								$priviousIDUpdate['board_one_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
							} else if ($buyPlan == 2 || $buyPlan == '2') {
								$getPriviousBoardIDs = $this->twoGetPriviousBoardID($insertData['contract_id'], 0, $curr_tree_id);

								$priviousIDUpdate['board_two_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
							} else if ($buyPlan == 3 || $buyPlan == '3') {
								$getPriviousBoardIDs = $this->threeGetPriviousBoardID($insertData['contract_id'], 0, $curr_tree_id);

								$priviousIDUpdate['board_three_prev_id'] = $getPriviousBoardIDs <= 7 ? 1 : $getPriviousBoardIDs;
							}
						}

						update_data(USERS, $priviousIDUpdate, array('id' => $insert));
					}

					FS::session()->set_userdata('tr_juego_id', $insertData['address']);

					$get_core_status_details = @get_data(USERS, array('address' => $insertData['address'], 'id' => $insert), 'one_core_status')->row()->one_core_status;

					insertUserLevelHistory($insert, $buyPlan, $depAmount);

					$bdata['address'] = $insertData['address'];

					$bdata['ref_code'] = $insertData['ref_code'];

					$bdata['core_status'] = $get_core_status_details;

					trigger_socket($bdata, 'ManualuserLogin');

				} else {

					echo "failed";
				}
			}
		} else {
			echo "invalid request";die;
		}
	}

	public function checkUser() { 
		$agent = $this->agent->is_browser;

		$address = (\FS::input()->post('address'));

		$user_check = @get_data(USERS, array('address' => $address, 'plan_id' => 1), 'id,ref_id,plan_id,contract_id,id_update,board_one,board_two,board_three,board_one_time,board_two_time,board_three_time,board_one_cu_re_id,board_two_cu_re_id,board_three_cu_re_id,tree_id')->row();

		$Buser_check = @get_data(USERS, array('address' => $address, 'plan_id' => 2), 'id,ref_id,plan_id,contract_id,id_update,board_one,board_two,board_three')->row();

		if (empty($user_check) && empty($Buser_check)) {
			FS::session()->unset_userdata('tr_juego_id');

			$bdata['isExist'] = 0;

			$bdata['isSection'] = 0;

			echo json_encode($bdata);
		} else {
			if (!empty($Buser_check) && empty($user_check)) {
				FS::session()->set_userdata('tr_juego_id', $address);

				$bdata['isExist'] = 1;

				$bdata['isSection'] = 2;

				$ref_address = @get_data(USERS, array('id' => $Buser_check->ref_id), 'id,address')->row();

				$bdata['isReff'] = @$ref_address->address;

				$bdata['Reff'] = @$ref_address->id;

				echo json_encode($bdata);

			} else if (!empty($user_check) && empty($Buser_check)) {
				FS::session()->set_userdata('tr_juego_id', $address);

				$bdata['isExist'] = 1;

				$bdata['isSection'] = 1;

				$ref_address = @get_data(USERS, array('contract_id' => $user_check->ref_id), 'id,contract_id,address')->row();

				$bdata['isReff'] = @$ref_address->address;

				$bdata['Reff'] = @$ref_address->contract_id;

				$bdata['contract_id'] = @$user_check->contract_id;

				$bdata['id_update'] = $user_check->id_update;

				$bdata['board_one'] = $user_check->board_one;

				$bdata['board_two'] = $user_check->board_two;

				$bdata['board_three'] = $user_check->board_three;

				$bdata['board_one_time'] = $user_check->board_one_time;

				$bdata['board_two_time'] = $user_check->board_two_time;

				$bdata['board_three_time'] = $user_check->board_three_time;

				$bdata['board_one_cu_re_id'] = $user_check->board_one_cu_re_id;

				$bdata['board_two_cu_re_id'] = $user_check->board_two_cu_re_id;

				$bdata['board_three_cu_re_id'] = $user_check->board_three_cu_re_id;

				$bdata['reff_id_status'] = $user_check->ref_id;

				$UserCount = FS::db()->query('SELECT COUNT(id) as user_dir_count FROM `' . P . USERS . '` WHERE `ref_id` = ' . $user_check->contract_id . ' AND tree_id = ' . $user_check->tree_id . '')->row();

				if (!empty($UserCount)) {
					$bdata['direct_reff_count'] = $UserCount->user_dir_count;
				} else {
					$bdata['direct_reff_count'] = 0;
				}

				echo json_encode($bdata);
			} else if (!empty($user_check) && empty(!$Buser_check)) {
				FS::session()->set_userdata('tr_juego_id', $address);

				$bdata['isExist'] = 1;

				$bdata['isSection'] = 3;

				$Bref_address = @get_data(USERS, array('id' => $Buser_check->ref_id), 'id,address')->row();

				$Aref_address = @get_data(USERS, array('contract_id' => $user_check->ref_id), 'id,contract_id,address')->row();

				$bdata['BisReff'] = @$Bref_address->address;

				$bdata['BReff'] = @$Bref_address->id;

				$bdata['AisReff'] = $Aref_address->address;

				$bdata['AReff'] = $Aref_address->contract_id;

				$bdata['contract_id'] = $user_check->contract_id;

				$bdata['id_update'] = $user_check->id_update;

				$bdata['board_one'] = $user_check->board_one;

				$bdata['board_two'] = $user_check->board_two;

				$bdata['board_three'] = $user_check->board_three;

				$bdata['board_one_time'] = $user_check->board_one_time;

				$bdata['board_two_time'] = $user_check->board_two_time;

				$bdata['board_three_time'] = $user_check->board_three_time;

				$bdata['board_one_cu_re_id'] = $user_check->board_one_cu_re_id;

				$bdata['board_two_cu_re_id'] = $user_check->board_two_cu_re_id;

				$bdata['board_three_cu_re_id'] = $user_check->board_three_cu_re_id;

				$bdata['reff_id_status'] = $user_check->ref_id;

				$UserCount = FS::db()->query('SELECT COUNT(id) as user_dir_count FROM `' . P . USERS . '` WHERE `ref_id` = ' . $user_check->contract_id . ' AND tree_id = ' . $user_check->tree_id . '')->row();

				if (!empty($UserCount)) {
					$bdata['direct_reff_count'] = $UserCount->user_dir_count;
				} else {
					$bdata['direct_reff_count'] = 0;
				}

				echo json_encode($bdata);
			}
		}
	}

	public function loadProfile($lang_code, $aref_code = '', $bref_code = '', $core_status = '', $tree_id = '') {
		$lang = @get_data(LANG, array('lang_code' => $lang_code))->row()->id;

		$data['planb'] = FS::Common()->getTableData(PLAN_B, array('plan_type' => 'B', 'language' => $lang), '', '', '', '', '', '', array('id', 'ASC'))->result();

		$data['plan_A'] = FS::Common()->getTableData(PLANS, array('status' => '1'), '', '', '', '', '', '', array('id', 'ASC'))->result();

		if (empty($aref_code)) {
			$_aref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 1), 'ref_code,ref_status,one_core_status,two_core_status,three_core_status')->row();

			if (!empty($_aref_code)) {
				if (!empty($_aref_code->ref_status)) {
					$__aref_code = $_aref_code->ref_code;
				} else {
					$__aref_code = 0;
				}

				$core_status = $_aref_code->one_core_status;
			}
		} else {
			$__aref_code = $aref_code;

			$core_status = $core_status;
		}

		if (empty($bref_code)) {
			$_bref_code = FS::Common()->getTableData(USERS, array('address' => juego_id(), 'plan_id' => 2), 'ref_code')->row();

			if (!empty($_bref_code)) {
				$__bref_code = $_bref_code->ref_code;
			}
		} else {
			$__bref_code = $bref_code;
		}

		if (!empty($__bref_code)) {
			$data['ref_url_b'] = base_url() . $lang_code . '/refer/planb/' . $__bref_code;
		} else {
			$data['ref_url_b'] = 0;
		}

		if (!empty($__aref_code)) {
			$data['ref_url_a'] = base_url() . $lang_code . '/refer/plana/' . $__aref_code;

			$data['core_status'] = $core_status;
		} else {
			$data['ref_url_a'] = 0;

			$data['core_status'] = $core_status;
		}

		$data['tree_id'] = !empty($tree_id) ? $tree_id : 1;

		if (juego_id() == ADMIN_ADDR) {
			$data['tree_data'] = @get_data(RL, array('status' => 1), 'tree_id,referral_link')->result_array();
		}

		$this->partial(strtolower(CI_MODEL) . '/load', $data);
	}

	public function Usercheck() {
		FS::session()->unset_userdata('tr_juego_id');
	}

	function updateWithEvents() {
		$userdata = \FS::input()->post('user_data');

		$insertData = json_decode($userdata, true);

		$invest_store = FS::db()->insert_batch(TRANS, $insertData);

		if ($invest_store) {
			echo 1;
		} else {
			echo 0;
		}
	}

	function LinkRequest() {
		$userdata = \FS::input()->post('user_data');

		$insertData = json_decode($userdata, true);

		$invest_store = FS::db()->insert(LR, $insertData);

		if ($invest_store) {
			echo 1;
		} else {
			echo 0;
		}
	}

	function planUpdate() {
		$userdata = \FS::input()->post('user_data');

		$ReqData = json_decode($userdata, true);

		$user_details = @get_data(USERS, array('address' => $ReqData['address'], 'plan_id' => 1), 'id,contract_id,tree_id,affiliate_id,board_one,board_one_cu_re_id,board_two_affiliate_id,board_two,board_two_cu_re_id,board_three_affiliate_id,board_three,board_three_cu_re_id')->row();

		if (!empty($user_details)) {
			if ($user_details->board_one == 0 && $ReqData['planOne'] != 0) {
				$updateData['board_one'] = 1;
				$aaeData['affiliate_id'] = $ReqData['m_aff_id'];
				update_data(USERS, $aaeData, array('address' => $ReqData['address']));
				$this->UpdateMissingCircle($user_details->id, $user_details->contract_id, 1, $user_details->board_one_cu_re_id, $ReqData['m_aff_id'], $ReqData['create_timestamp'], $user_details->tree_id);
			}

			if ($user_details->board_two == 0 && $ReqData['planTwo'] != 0) {
				$updateData['board_two'] = 2;
				$aaeData['board_two_affiliate_id'] = $ReqData['m_two_aff_id'];
				update_data(USERS, $aaeData, array('address' => $ReqData['address']));
				$this->UpdateMissingCircle($user_details->id, $user_details->contract_id, 2, $user_details->board_two_cu_re_id, $ReqData['m_two_aff_id'], $ReqData['two_create_timestamp'], $user_details->tree_id);
				if ($user_details->tree_id > 1) {
					$bdata['address'] = $ReqData['address'];
					$bdata['tree_id'] = $user_details->tree_id;
					trigger_socket($bdata, 'countupdate');
				}
			}

			if ($user_details->board_three == 0 && $ReqData['planThree'] != 0) {
				$updateData['board_three'] = 3;
				$aaeData['board_three_affiliate_id'] = $ReqData['m_three_aff_id'];
				update_data(USERS, $aaeData, array('address' => $ReqData['address']));
				$this->UpdateMissingCircle($user_details->id, $user_details->contract_id, 3, $user_details->board_three_cu_re_id, $ReqData['m_three_aff_id'], $ReqData['three_create_timestamp'], $user_details->tree_id);
			}

			if (!empty($updateData)) {
				update_data(USERS, $updateData, array('address' => $ReqData['address']));

				echo 1;
			} else {
				echo 2;
			}
		} else {
			echo 3;
		}
	}

	public function updateid() {
		if (!empty(\FS::input()->post())) {
			if (!empty(\FS::input()->post('con_u_id'))) {
				$up_data['contract_id'] = \FS::input()->post('con_u_id');

				$up_data['id_update'] = 1;

				$address = \FS::input()->post('user_address');

				if (update_data(USERS, $up_data, array("address" => $address, 'plan_id' => 1))) {
					echo "Update Success";
				} else {
					echo "Update Error";
				}
			} else {
				echo "Update Error";
			}
		} else {
			echo "invalid Request";
		}
	}

	public function updatetime() {
		if (!empty(\FS::input()->post())) {
			$plan_id = \FS::input()->post('plan_id');

			$up_time = \FS::input()->post('con_u_id');

			$address = \FS::input()->post('user_address');

			if ($plan_id == 1) {
				$up_data['create_timestamp'] = $up_time;

				$up_data['board_one_time'] = 1;

				/*$get_core_status = @get_data(USERS, array('plan_id' => 1, "address" => $address), 'one_core_status,tree_id')->row();

					if (empty($get_core_status->one_core_status)) {
						$get_time_stamp_details = FS::db()->query("SELECT create_timestamp  FROM " . P . USERS . " WHERE plan_id = 1 and tree_id = " . $get_core_status->tree_id . " and board_one = 1  ORDER by create_timestamp ASC LIMIT 7")->result_array();

						if (!empty($get_time_stamp_details)) {
							$end_time_one = end($get_time_stamp_details);

							if ($up_time < $end_time_one['create_timestamp']) {
								$up_data['one_core_status'] = 1;
							}
						}
				*/
			} else if ($plan_id == 2) {
				$up_data['two_create_timestamp'] = $up_time;

				$up_data['board_two_time'] = 1;

				/*$get_core_status_ = @get_data(USERS, array('plan_id' => 1, "address" => $address), 'two_core_status,tree_id')->row();

					if (empty($get_core_status_->two_core_status)) {
						$get_time_stamp_details_ = FS::db()->query("SELECT two_create_timestamp  FROM " . P . USERS . " WHERE plan_id = 1 and tree_id = " . $get_core_status_->tree_id . " and board_two = 2  ORDER by two_create_timestamp ASC LIMIT 7")->result_array();

						if (!empty($get_time_stamp_details_)) {
							$end_time_two = end($get_time_stamp_details_);

							if ($up_time < $end_time_two['two_create_timestamp']) {
								$up_data['two_core_status'] = 1;
							}
						}
				*/

			} else if ($plan_id == 3) {
				$up_data['three_create_timestamp'] = $up_time;

				$up_data['board_three_time'] = 1;

				/*$get_core_status__ = @get_data(USERS, array('plan_id' => 1, "address" => $address), 'three_core_status,tree_id')->row();

					if (empty($get_core_status__->three_core_status)) {
						$get_time_stamp_details__ = FS::db()->query("SELECT three_create_timestamp  FROM " . P . USERS . " WHERE plan_id = 1 and tree_id = " . $get_core_status__->tree_id . " and board_three = 3  ORDER by three_create_timestamp ASC LIMIT 7")->result_array();

						if (!empty($get_time_stamp_details__)) {
							$end_time_three = end($get_time_stamp_details__);

							if ($up_time < $end_time_three['three_create_timestamp']) {
								$up_data['three_core_status'] = 1;
							}
						}
				*/
			}

			if (update_data(USERS, $up_data, array("address" => $address, 'plan_id' => 1))) {
				echo "Update Success";
			} else {
				echo "Update Error";
			}
		} else {
			echo "invalid Request";
		}
	}

	function reInvestUpdate() {
		if (!empty(\FS::input()->post())) {
			$re_address = \FS::input()->post('address');

			$_Reinvest = \FS::input()->post('_Reinvest');

			$reinvestId = \FS::input()->post('reinvestId');

			$boardType = \FS::input()->post('boardType');

			$reinvestTime = \FS::input()->post('reinvestTime');

			$re_user_details = @get_data(USERS, array('address' => $re_address, 'plan_id' => 1), 'id,board_one_cu_re_id,board_two_cu_re_id,board_three_cu_re_id,board_one_re_id,board_two_re_id,board_three_re_id,board_one_re_position,board_two_re_position,board_three_re_position')->row();

			if (!empty($re_user_details)) {
				if ($boardType == 1 || $boardType == "1") {
					$re_user_update_data['board_one_cu_re_id'] = $_Reinvest;

					$re_user_update_data['board_one_re_id'] = $re_user_details->board_one_re_id . ',' . $_Reinvest;

					$re_user_update_data['board_one_re_position'] = $reinvestId;

					$re_user_update_data['one_create_re_timestamp'] = $reinvestTime;

					if (update_data(USERS, $re_user_update_data, array("id" => $re_user_details->id))) {
						echo '11';
					} else {
						echo '12';
					}
				} else if ($boardType == 2 || $boardType == "2") {
					$re_user_update_data['board_two_cu_re_id'] = $_Reinvest;

					$re_user_update_data['board_two_re_id'] = $re_user_details->board_one_re_id . ',' . $_Reinvest;

					$re_user_update_data['board_two_re_position'] = $reinvestId;

					$re_user_update_data['two_create_re_timestamp'] = $reinvestTime;

					if (update_data(USERS, $re_user_update_data, array("id" => $re_user_details->id))) {
						echo '21';
					} else {
						echo '22';
					}
				} else if ($boardType == 3 || $boardType == "3") {
					$re_user_update_data['board_three_cu_re_id'] = $_Reinvest;

					$re_user_update_data['board_three_re_id'] = $re_user_details->board_one_re_id . ',' . $_Reinvest;

					$re_user_update_data['board_three_re_position'] = $reinvestId;

					$re_user_update_data['three_create_re_timestamp'] = $reinvestTime;

					if (update_data(USERS, $re_user_update_data, array("id" => $re_user_details->id))) {
						echo '31';
					} else {
						echo '32';
					}
				}
			} else {
				echo 0;
			}
		} else {
			echo "invalid Request";
		}
	}

	function getTreeAddress($boardType) {
		if ($boardType == 1 || $boardType == "1") {
			$colum = "tree_status";
		} else if ($boardType == 2 || $boardType == "2") {
			$colum = "two_tree_status";
		} else if ($boardType == 3 || $boardType == "3") {
			$colum = "three_tree_status";
		}

		$user_list = @get_data(USERS, array($colum => 0, "plan_id" => 1, "board_one" => 1), 'address')->result_array();

		//echo FS::db()->last_query();die;

		if (!empty($user_list)) {
			echo json_encode($user_list);
		} else {
			echo 0;
		}
	}

	function updateTreestatus() {
		$address = (\FS::input()->post('address'));

		$boardType = (\FS::input()->post('boardType'));

		if ($boardType == 1 || $boardType == "1") {
			$colum = "tree_status";
		} else if ($boardType == 2 || $boardType == "2") {
			$colum = "two_tree_status";
		} else if ($boardType == 3 || $boardType == "3") {
			$colum = "three_tree_status";
		}

		$update_data[$colum] = 1;

		if (update_data(USERS, $update_data, array('address' => $address))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	function getAffemptyId($boardType) {

		$user_list = @get_data(USERS, array("plan_id" => 1, "ref_id" => 0, "tree_id" => $boardType, "contract_id !=" => 1), 'address')->result_array();

		//echo FS::db()->last_query();die;

		if (!empty($user_list)) {
			echo json_encode($user_list);
		} else {
			echo 0;
		}
	}

	function updateAffemptyId() {

		$address = (\FS::input()->post('address'));

		$reff_id = (\FS::input()->post('aff_id'));

		$update_data['ref_id'] = $reff_id;

		if (update_data(USERS, $update_data, array('address' => $address, 'tree_id' => 1))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	function getCurrentMissingId() {
		$last_check_id = @get_data(SITE, array('id' => 1), 'last_check_id')->row()->last_check_id;

		if (!empty($last_check_id)) {
			$getUserIDs = get_data(USERS, array('contract_id >' => $last_check_id, 'tree_id' => 1), 'contract_id')->result_array();

			if (!empty($getUserIDs)) {

				$array = array_column($getUserIDs, 'contract_id');

				$max_id = max($array);

				$site_update_data['last_check_id'] = $max_id;

				update_data(SITE, $site_update_data, array('id' => 1));

				$new_arr = range($array[0], $max_id);

				$missing_arr = array_diff($new_arr, $array);

				if (!empty($missing_arr)) {
					$data['missing_arr'] = $missing_arr;

					echo json_encode($missing_arr);
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}

		} else {
			echo 0;
		}
	}

	function getNewCurrentMissingId() { 
		$new_last_check_id = @get_data(SITE, array('id' => 1), 'new_last_check_id')->row()->new_last_check_id;

		if (!empty($new_last_check_id)) {
			$getUserIDs = get_data(USERS, array('contract_id >' => $new_last_check_id, 'tree_id !=' => 1), 'contract_id')->result_array();
			if (!empty($getUserIDs)) {
				$array = array_column($getUserIDs, 'contract_id');
				$max_id = max($array);
				$site_update_data['new_last_check_id'] = $max_id;
				update_data(SITE, $site_update_data, array('id' => 1));
				$new_arr = range($array[0], $max_id);
				$missing_arr = array_diff($new_arr, $array);

				if (!empty($missing_arr)) {
					$data['missing_arr'] = $missing_arr;
					echo json_encode($missing_arr);
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}

		} else {
			echo 0;
		}
	}

	function get_two_cid($contract_id, $affiliate_id) {

		$get_result = FS::db()->query("SELECT id,address,affiliate_id,contract_id,board_two,board_two_affiliate_id,two_core_status,two_tree_status,two_create_timestamp,two_sep_board,two_sep_board_count,board_two_cid  FROM `tgg_gbqvyefvhehwk` WHERE `plan_id` = 1 AND `board_two` = 2
ORDER BY `tgg_gbqvyefvhehwk`.`two_create_timestamp` ASC")->result_array();

		if (!empty($get_result)) {
			echo '<pre>';
			//print_r($get_result);die;
			foreach ($get_result as $key => $value) {

				if ($key < 7) {
					//$insertData['board_two_cid'] = 1;

					$sep_board = 0;

					$core_status = 1;

				} else {
					$core_status = 0;

					$ref_status = 0;
				}

				if ($key >= 7 && $key < 15) {
					//$insertData['board_two_cid'] = $value['contract_id'];
					$core_status = 0;
					$sep_board = 1;

				} else {

					$sep_board = 0;

				}

				if ($key >= 15 && $key < 31) {
					// $get_sep_board_id = $value['board_two_affiliate_id'];

					// if (!empty(@$get_sep_board_id)) {
					// 	$insertData['board_two_cid'] = $get_sep_board_id;

					// }
					$sep_board = 0;
					$core_status = 0;

				}

				if ($key >= 31) {

					$sep_board = 0;

					$get_sep_board_ids = @get_data(USERS, array('contract_id' => $value['board_two_affiliate_id']), 'affiliate_id,board_two_affiliate_id,board_three_affiliate_id,one_sep_board,two_sep_board,three_sep_board,board_one_cu_re_id,board_two_cu_re_id,board_three_cu_re_id')->row();

					echo FS::db()->last_query() . '<br>';

					if (empty($get_sep_board_ids->two_sep_board)) {
						$two_aff_id = $get_sep_board_ids->board_two_affiliate_id;

						$_twsep_board_ids = @get_data(USERS, array('contract_id' => $two_aff_id), 'board_two_affiliate_id,two_sep_board')->row();

						if (!empty($_twsep_board_ids->two_sep_board)) {

							$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . '')->row();

							if ($_two_cid->user_child < 6) {
								$insertData['board_two_cid'] = $two_aff_id;

								$core_status = 0;

								//$ref_status = 0;
							} else if ($_two_cid->user_child == 6) {
								$insertData['board_two_cid'] = $two_aff_id;

								$core_status = 1;

								//$ref_status = 1;

								$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_aff_id . '')->result_array();

								if (!empty($_two_cid_array)) {
									array_walk_recursive($_two_cid_array, function (&$item, $key) {

										if ($key == 'two_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
								}
							} else {
								$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_aff_id), 'two_sep_board_count')->row()->two_sep_board_count;

								if ($two_sep_board_count < 8) {
									$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

									update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_aff_id));

									$insertData['board_two_cid'] = $value['contract_id'];

									$sep_board = 1;
								}
							}
						} else {

							//echo $_twsep_board_ids->board_two_affiliate_id;die;

							$two_getTreeID = $this->getTwoTreeID($_twsep_board_ids->board_two_affiliate_id);

							$_two_cid = FS::db()->query('SELECT COUNT(id) as user_child FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . '')->row();

							if ($_two_cid->user_child < 6) {
								$insertData['board_two_cid'] = $two_getTreeID;

								$core_status = 0;

								//$ref_status = 0;
							} else if ($_two_cid->user_child == 6) {
								$insertData['board_two_cid'] = $two_getTreeID;

								$core_status = 1;

								//$ref_status = 1;

								$_two_cid_array = FS::db()->query('SELECT contract_id,two_core_status,ref_status FROM `' . P . USERS . '`  WHERE `board_two_cid` = ' . $two_getTreeID . '')->result_array();

								if (!empty($_two_cid_array)) {
									array_walk_recursive($_two_cid_array, function (&$item, $key) {

										if ($key == 'two_core_status') {

											$item = 1;
										}

										if ($key == 'ref_status') {

											$item = 1;
										}

									});

									FS::db()->update_batch(USERS, $_two_cid_array, 'contract_id');
								}

							} else {
								$two_sep_board_count = @get_data(USERS, array("contract_id" => $two_getTreeID), 'two_sep_board_count')->row()->two_sep_board_count;

								if ($two_sep_board_count < 8) {
									$two_sep_board_count_data['two_sep_board_count'] = $two_sep_board_count + 1;

									update_data(USERS, $two_sep_board_count_data, array("contract_id" => $two_getTreeID));

									$insertData['board_two_cid'] = $value['contract_id'];

									$sep_board = 1;
								}
							}
						}
					} else {
						$insertData['board_two_cid'] = $value['board_two_affiliate_id'];
					}
				}

				if ($key >= 31) {
					$insertData['two_core_status'] = $core_status;

					$insertData['two_sep_board'] = $sep_board;
					print_r($insertData);

					if (!empty($insertData)) {
						if (update_data(USERS, $insertData, array('id' => $value['id']))) {
							echo $key . ' = S <br>';
						} else {
							echo $key . ' = N <br>';
						}
					}

				}

			}
		}
	}
}
?>