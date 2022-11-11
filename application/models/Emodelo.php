<?php
class Emodelo extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function stuur_pos($to = '', $from_email = '', $from_name = '', $email_template = '', $special_vars = array(),$cc = '', $bcc = '', $type = 'html', $too = '') {

		$this->load->library(array('email'));
		$e_pos = FS::db()->where('id', 1)->get(SITE)->row();
		$admindetails = FS::db()->where('id', 1)->get(AD)->row();

		$sp_details = file_get_contents(FCPATH . 'application/config/VESRSDtjDSIE/TAdLPXsltP.php');
		$spdetails = explode(" || ", $sp_details);

		$gasheerh = encrypt_decrypt('decrypt', $spdetails[0]);
		$gebruikeru = encrypt_decrypt('decrypt', $spdetails[1]);
		$slaagp = encrypt_decrypt('decrypt', $spdetails[2]);
		$hawep = encrypt_decrypt('decrypt', $spdetails[3]);

		$special_vars['###COPYRIGHT###'] = $e_pos->copy_right_text;
		$special_vars['###SITENAME###'] = $e_pos->site_name;

		if ($from_email == '') {
			$from_email = encrypt_decrypt('encrypt', $admindetails->email_id);
		}

		if ($from_name == '') {
			$from_name = $admindetails->admin_name;
		}

		$em = 'em';
		$il = 'ail';
		$em = $em . $il;
		$this->$em->clear();
		$pro = 'pro';
		$tocol = 'tocol';
		$tp = 'tp';
		$ms = 'sm';
		$pt = 'tp_';
		$ho = 'ho';
		$st = 'st';
		$op = 'po';
		$tr = 'rt';
		$su = 'us';
		$re = 'er';
		$ap = 'pa';
		$ss = 'ss';
		$ma = 'ma';
		$ty = 'iltype';
		$ch = 'char';
		$se = 'set';
		$tf = 'ut';
		$f8 = 'f-8';
		$lf = 'cr';
		$cr = 'lf';
		$li = 'new';
		$ne = 'line';
		$pr = 'pri';
		$or = 'ori';
		$yt = 'ty';
		$posc = array(
			$pro . $tocol => $ms . $tp,
			$ms . $pt . $ho . $st => $gasheerh,
			$ms . $pt . $op . $tr => $hawep,
			$ms . $pt . $su . $re => trim($gebruikeru),
			$ms . $pt . $ap . $ss => trim($slaagp),
			$ma . $ty => $type,
			$ch . $se => $tf . $f8,
		);
		$posc[$lf . $cr] = "\r\n";
		$posc[$li . $ne] = "\r\n";
		$posc[$pr . $or . $yt] = 1;

		$this->$em->initialize($posc);

		if (!empty($gasheerh) && !empty($hawep) && !empty($gebruikeru) && !empty($slaagp)) {

			if (is_numeric($email_template)) {
				$emailTemplate = FS::db()->where('id', $email_template)->get(ET);
			} else {
				$emailTemplate = FS::db()->where('title', $email_template)->get(ET);
			}

			if ($emailTemplate->num_rows() > 0) {

				$emailTemplate = $emailTemplate->row();

				$subject = strtr($emailTemplate->subject, $special_vars);

				$message = strtr($emailTemplate->template, $special_vars);

				if ($to != '') {
					$this->$em->to($to);
				}

				if ($too != '') {
					$this->$em->too($too);
				}

				$this->$em->from($gebruikeru);

				if ($cc != '') {
					$this->$em->cc($cc);
				}

				if ($bcc != '') {
					$this->$em->bcc($bccc);
				}

				$this->$em->subject($subject);

				$this->$em->message($message);

				if (!$this->$em->send()) {

					$this->$em->clear();

					return false;
				} else {
					return true;

				}
				return true;

			} else {
				exit(lang('EMNC'));
			}
		} else {
			exit(lang('SMNC'));
		}
	}

	function snedNewsMail($to = '', $from_email = '', $from_name = '', $subject = '', $message, $attachInfo, $cc = '', $bcc = '', $type = 'html', $too = '') {
		$this->load->library(array('email'));
		$SMTPinfo = $this->db->where('ID', 1)->get(SMTPIF)->result();
		
		if(isset($SMTPinfo[0]) && isset($SMTPinfo[0]->host) && isset($SMTPinfo[0]->user) && isset($SMTPinfo[0]->port) && isset($SMTPinfo[0]->sender) && isset($SMTPinfo[0]->pass)){
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $SMTPinfo[0]->host;
			$config['smtp_user'] = $SMTPinfo[0]->user;
			$config['smtp_pass'] = $SMTPinfo[0]->pass;
			$config['smtp_port'] = $SMTPinfo[0]->port;
			$config['smtp_crypto']='ssl';
			$config['mailtype'] = 'html';
	
			$this->email->clear();
			$this->email->initialize($config);
			
			$this->email->from($SMTPinfo[0]->sender, 'trongoogol');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
	
			if(isset($attachInfo['full_path'])){
				$F_path = $attachInfo['full_path'];
				$F_name = $attachInfo['name'];
				$this->email->attach($F_path, 'attachment', $F_name);
			}		
	
			if (!$this->email->send()) {
				$this->email->clear();
				return false;
			} else { 
				return true; 
			}
		} else {
			return false;
		}
	}
}