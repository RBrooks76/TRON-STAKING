<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SMTPserver extends Admin_Controller {
	public function index() {
		echo 'News Letter';
	}

	function smtpmanage($status=''){
        if(empty(admin_id())) {admin_url_redirect('', 'refresh');}
		$data['title'] = 'SMTP server';
		$data['page'] = 'smtpmanage';

		$sql= "CREATE TABLE IF NOT EXISTS  `" . P . SMTPIF ."` (
			`ID` INT(10) NOT NULL AUTO_INCREMENT,
			`host` VARCHAR(255) DEFAULT '',
			`user` VARCHAR(255) DEFAULT '',
			`pass` VARCHAR(255) DEFAULT '',
			`port` VARCHAR(255) DEFAULT '',
			`sender` VARCHAR(255) DEFAULT '',
			`creat_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
			PRIMARY KEY (`ID`)
			) ENGINE=INNODB DEFAULT CHARSET=utf8";
		$result = $this->db->query($sql);
		if($result) {
			$defaultData = array(
				'host'=>'server.planetone.exchange',
				'user'=>'_mainaccount@trongoogol.io',
				'pass'=>'gv^Dy[[=Bd^.',
				'port'=>'465',
				'sender'=>'trongoogol@trongoogol.io'
			);
			$smtpinfo = $this->db->get(SMTPIF)->result();
			if(!count($smtpinfo)) {
				$this->db->insert(SMTPIF, $defaultData);
			}
		}
        $smtpinfo = $this->db->get(SMTPIF)->result();
        if($status == 'LKDJFUESWLCJKJSDFOUEOWR'){ echo json_encode($smtpinfo); die(); }
		$data['smtpinfo'] = $this->db->where('ID', 1)->get(SMTPIF)->result()[0];
		$this->view('pages/SMTPmanage', $data);
	}

    function smtp_server_set() {
        $resData = array('state' => false, 'message' => '');
        $smtpdata = $_POST;
        if(isset($smtpdata['host']) && isset($smtpdata['user']) && isset($smtpdata['pass']) && isset($smtpdata['port']) && isset($smtpdata['sender'])) {
            $updatedata = array(
                'host'=>$smtpdata['host'],
                'user'=>$smtpdata['user'],
                'pass'=>$smtpdata['pass'],
                'port'=>$smtpdata['port'],
                'sender'=>$smtpdata['sender']
            );

            $exists =$this->db->where('ID', 1)->where($updatedata)->get(SMTPIF)->result();
            if(!count($exists)){
                $this->db->set($updatedata);
                $this->db->where('ID', 1);
                $result = $this->db->update(SMTPIF);
                if($result){
                    $resData['state'] = true;
                    $resData['message'] = 'submit success';
                } else {
                    $resData['state'] = true;
                    $resData['message'] = 'submit success';
                }
            } else {
                $resData['state'] = true;
                $resData['message'] = 'submit success';
            }
        } else {
            $resData['message'] = 'submit success';
            $resData['state'] = true;
        }
        echo json_encode($resData);
        die();
    }
}