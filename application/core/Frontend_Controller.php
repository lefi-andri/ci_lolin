<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

    $this->load->helper('security');
        
    $this->load->library(array('ion_auth', 'cart'));

    $this->load->helper(array('url', 'form'));

    $this->load->library(array('form_validation'));
    $this->form_validation->CI =& $this;		
	}

  public function get_meta($meta_id){
    $query = $this->db->get_where('konten_halaman', array('id' => $meta_id))->row();
    return $query;
  }

  public function get_iklan($id){
    $query = $this->db->get_where('iklan', array('konten_id' => $id));
    return $query;
  }

  # Fungsi penambahan 12 bulan
  public function tambah_masa_poin($tanggal){
    date_default_timezone_get('Asia/Jakarta');
    $hasil = date('Y-m-d', strtotime('+12 month', strtotime($tanggal)));
    return $hasil;
  }

  # Fungsi cek tanggal kedaluwarsa poin
  public function cek_selisih_tanggal_kedaluwarsa($tanggal_kedaluwarsa){
    date_default_timezone_get('Asia/Jakarta');
    $start_date = new DateTime(date('Y-m-d'));
    $end_date = new DateTime($tanggal_kedaluwarsa);
    $interval = $start_date->diff($end_date);
    $hasil = $interval->days;
    return $hasil;
  }

	public function buat_email($email_to, $subjek, $email_konten, $email_template){

		$this->load->library('email');

        $ci = get_instance();        
        $config['protocol']     = "smtp";
        $config['smtp_host']    = email_host();
        $config['smtp_port']    = email_port();
        $config['smtp_user']    = email_username();
        $config['smtp_pass']    = email_password();
        $config['charset']      = "utf-8";
        $config['mailtype']     = "html";
        $config['newline']      = "\r\n";
        
        $html_konten = '';
        #$html_konten .= $this->$email_template($email_konten);
        $html_konten .= $email_konten;

        $ci->email->initialize($config);
        $ci->email->from(email_pengirim(), 'Lolin Kids Care Product');          
        $ci->email->to($email_to);
        $ci->email->subject($subjek);
        $ci->email->message($html_konten);

        if($this->email->send()){
			   return TRUE;
    		}else{
    			return FALSE;
    		}

    }

    public function template_email_pendaftaran_reseller($email_konten){
    $html_konten ='
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Lolin Kids Care</title>

      <style type="text/css">
        /* Take care of image borders and formatting, client hacks */
        img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
        a img { border: none; }
        table { border-collapse: collapse !important;}
        #outlook a { padding:0; }
        .ReadMsgBody { width: 100%; }
        .ExternalClass { width: 100%; }
        .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
        table td { border-collapse: collapse; }
        .ExternalClass * { line-height: 115%; }
        .container-for-gmail-android { min-width: 600px; }


        /* General styling */
        * {
          font-family: Helvetica, Arial, sans-serif;
        }

        body {
          -webkit-font-smoothing: antialiased;
          -webkit-text-size-adjust: none;
          width: 100% !important;
          margin: 0 !important;
          height: 100%;
          color: #676767;
        }

        td {
          font-family: Helvetica, Arial, sans-serif;
          font-size: 14px;
          color: #777777;
          text-align: center;
          line-height: 21px;
        }

        a {
          color: #676767;
          text-decoration: none !important;
        }

        .pull-left {
          text-align: left;
        }

        .pull-right {
          text-align: right;
        }

        .header-lg,
        .header-md,
        .header-sm {
          font-size: 32px;
          font-weight: 700;
          line-height: normal;
          padding: 35px 0 0;
          color: #4d4d4d;
        }

        .header-md {
          font-size: 24px;
        }

        .header-sm {
          padding: 5px 0;
          font-size: 18px;
          line-height: 1.3;
        }

        .content-padding {
          padding: 20px 0 30px;
        }

        .mobile-header-padding-right {
          width: 290px;
          text-align: right;
          padding-left: 10px;
        }

        .mobile-header-padding-left {
          width: 290px;
          text-align: left;
          padding-left: 10px;
        }

        .free-text {
          width: 100% !important;
          padding: 10px 60px 0px;
        }

        .block-rounded {
          border-radius: 5px;
          border: 1px solid #e5e5e5;
          vertical-align: top;
        }

        .button {
          padding: 30px 0;
        }

        .info-block {
          padding: 0 20px;
          width: 260px;
        }

        .block-rounded {
          width: 260px;
        }

        .info-img {
          width: 258px;
          border-radius: 5px 5px 0 0;
        }

        .force-width-gmail {
          min-width:600px;
          height: 0px !important;
          line-height: 1px !important;
          font-size: 1px !important;
        }

        .button-width {
          width: 228px;
        }

      </style>

      <style type="text/css" media="screen">
        @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
      </style>

      <style type="text/css" media="screen">
        @media screen {
          /* Thanks Outlook 2013! */
          * {
            font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
          }
        }
      </style>

      <style type="text/css" media="only screen and (max-width: 480px)">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {

          table[class*="container-for-gmail-android"] {
            min-width: 290px !important;
            width: 100% !important;
          }

          table[class="w320"] {
            width: 320px !important;
          }

          img[class="force-width-gmail"] {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
          }

          a[class="button-width"],
          a[class="button-mobile"] {
            width: 248px !important;
          }

          td[class*="mobile-header-padding-left"] {
            width: 160px !important;
            padding-left: 0 !important;
          }

          td[class*="mobile-header-padding-right"] {
            width: 160px !important;
            padding-right: 0 !important;
          }

          td[class="header-lg"] {
            font-size: 24px !important;
            padding-bottom: 5px !important;
          }

          td[class="header-md"] {
            font-size: 18px !important;
            padding-bottom: 5px !important;
          }

          td[class="content-padding"] {
            padding: 5px 0 30px !important;
          }

           td[class="button"] {
            padding: 5px !important;
          }

          td[class*="free-text"] {
            padding: 10px 18px 30px !important;
          }

          td[class="info-block"] {
            display: block !important;
            width: 280px !important;
            padding-bottom: 40px !important;
          }

          td[class="info-img"],
          img[class="info-img"] {
            width: 278px !important;
          }
        }
      </style>
    </head>

    <body bgcolor="#f7f7f7">
    <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
      <tr>
        <td align="left" valign="top" width="100%" style="background:repeat-x url(http://www.lolin.co.id/assets/images/html_template/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
          <center>
          <img src=http://www.lolin.co.id/assets/images/html_template/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background=http://www.lolin.co.id/assets/images/html_template/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
              <tr>
                <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                <!--[if gte mso 9]>
                <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                  <v:fill type="tile" src=http://www.lolin.co.id/assets/images/html_template/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                  <v:textbox inset="0,0,0,0">
                <![endif]-->
                  <center>
                    <table cellpadding="0" cellspacing="0" width="600" class="w320">
                      <tr>
                        <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                          <a href=""><img width="137" height="47" src=http://www.lolin.co.id/assets/images/html_template/0zxBZVuORSxdc9ZCqotL_logo_03.jpg" alt="logo"></a>
                        </td>
                      </tr>
                    </table>
                  </center>
                  <!--[if gte mso 9]>
                  </v:textbox>
                </v:rect>
                <![endif]-->
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
          <center>
            <table cellspacing="0" cellpadding="0" width="600" class="w320">
              <tr>
                <td class="header-lg">
                  Pendaftaran Berhasil !
                </td>
              </tr>
              <tr>
                <td class="free-text">
                  Anda baru saja mendaftarkan sebagai reseller Lolin Kids Care Product, untuk mengaktifkan akun Anda silahkan menekan tombol dibawah atau melaui tautan.
                </td>
              </tr>
              <tr>
                <td class="button">
                  <div><!--[if mso]>
                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.$email_konten.'" style="height:45px;v-text-anchor:middle;width:155px;" arcsize="15%" strokecolor="#ffffff" fillcolor="#ff6f6f">
                      <w:anchorlock/>
                      <center style="color:#ffffff;font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;">Aktivasi Akun</center>
                    </v:roundrect>
                  <![endif]--><br><a class="button-mobile" href="'.$email_konten.'"
                  style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:"Cabin", Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;">'.$email_konten.'</a></div>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
          <center>
            <table cellspacing="0" cellpadding="0" width="600" class="w320">
              <tr>
                <td style="padding: 25px 0 25px">
                  <strong>Lolin Kids Care Product</strong><br />
                   <br />
                   <br /><br />
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
    </table>
    </body>
    </html>
    ';
        return $html_konten;
    }

    public function template_email_pendaftaran_reseller_info($email_konten){
        $html_konten = $email_konten;
        return $html_konten;
    }

    public function template_email_aktivasi_registrasi_sukses($email_konten){
        $html_konten = $email_konten;
        return $html_konten;
    }

    public function template_email_kontak($email_konten){
        $html_konten = $email_konten;
        return $html_konten;
    }

    public function template_email_kontak_info($email_konten){
        $html_konten = $email_konten;
        return $html_konten;
    }

   



  public function buat_token(){
    $timeunix 	= strtotime('now');
		$token = hash('crc32', $timeunix);
		return $token;	
  }

  public function verification($key)
	{

	}

  public function get_pengaturan_email(){
      $this->db->select('pengaturanEmail');
      $query = $this->db->get('pengaturan')->row()->pengaturanEmail;

      return $query;
  }

  // KODE AREA -------------------------------------------------------------------------------------------------------------------

	# INI UNTUK BUAT KODE ID RESELLER
  public function create_reseller_code($tipe){
    if ($tipe == 'reseller_pribadi') {
        $ekstensi = 'RSP';
    } elseif($tipe == 'reseller_organisasi'){
        $ekstensi = 'RSO';
    }

    $this->db->select('MAX(meta.id) AS max_code');
    $this->db->from('meta');
    $this->db->join('users', 'users.id = meta.user_id');
    $this->db->like('meta.reseller_id', $ekstensi);
    $this->db->where('users.group_id >', '2');
    $query = $this->db->get()->row();

    $maximal_id =  $query->max_code;

    # mencari id terbesar
    $this->db->select('reseller_id');
    $this->db->select('SUBSTRING(meta.reseller_id, 1, 3) AS kode_depan');
    $this->db->select('SUBSTRING(meta.reseller_id, 5, 8) AS tanggal_dari_data_terakhir');
    $this->db->select('SUBSTRING(meta.reseller_id, 14, 4) AS nomor_urut_dari_data_terakhir');
    $this->db->from('meta');
    $this->db->join('users', 'users.id = meta.user_id');
    $this->db->where('users.group_id >', '2');
    $this->db->where('users.id', $maximal_id);
    $get_val = $this->db->get();

    date_default_timezone_set('Asia/Jakarta');
    $today = date("dmY"); // Tanpa pemisah
    $id_reseller = $get_val->row()->reseller_id;
    $kode_depan = $get_val->row()->kode_depan;
    $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
    $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

    if ($get_val->num_rows() > 0) {

        #$tanggal_dari_data_terakhir = substr($id_reseller, 4, 8); //4 kosong dari depan, 8 nilai yang diambil
        #$nomor_urut_dari_data_terakhir = substr($id_reseller, 13, 4); // 13 kosong dari depan, 4 nilai yang diambil

        if (($today == $tanggal_dari_data_terakhir) && ($kode_depan == $ekstensi)) {
            $no_urut = $nomor_urut_dari_data_terakhir;
            $no_urut++;
        }else{
            $no_urut=0;
            $no_urut++;
        }

        $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);
        
    }else{

        $no_urut=1;
        $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);

    }

    return $reseller_id;
  }

  public function buat_kode_temporary_order(){
    
    /*date_default_timezone_set('Asia/Jakarta');

    $today = date("dmY");
    $sql = "SELECT MAX(id_temporary) AS max_code FROM temporary_purchase_order";
    $query = $this->db->query($sql);

    $maximal_id =  $query->row()->max_code;

    # mencari id terbesar

    $get_val = $this->db->get_where('temporary_purchase_order', array('id_temporary' => $maximal_id));

    if ($get_val->num_rows() > 0) {

        $date_id = (int) substr($get_val->row()->kode_temporary, 4, 10);

        if ($date_id == $today) {
            $no_urut = (int) substr($get_val->row()->kode_temporary, 13, 10);
            $no_urut++;
        }else{
            $no_urut=0;
            $no_urut++;
        }

        $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);
        
    }else{

        $no_urut=1;
        $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);

    }

    return $kode_temporary;*/

    $this->db->select('MAX(id_temporary) AS max_code');
    $this->db->from('temporary_purchase_order');
    $query = $this->db->get()->row();

    # maximal_id adalah id paling akhir
    $maximal_id =  $query->max_code;

    # mencari id terbesar
    $this->db->select('kode_temporary');
    $this->db->select('SUBSTRING(kode_temporary, 1, 3) AS kode_depan');
    $this->db->select('SUBSTRING(kode_temporary, 5, 8) AS tanggal_dari_data_terakhir');
    $this->db->select('SUBSTRING(kode_temporary, 14, 4) AS nomor_urut_dari_data_terakhir');
    $this->db->from('temporary_purchase_order');
    $this->db->where('id_temporary', $maximal_id);
    $this->db->group_by('kode_temporary');
    $get_val = $this->db->get();

    date_default_timezone_set('Asia/Jakarta');
    $today = date("dmY"); // Tanpa pemisah

    if ($get_val->num_rows() > 0) {

      $kode_temporary = $get_val->row()->kode_temporary;
      $kode_depan = $get_val->row()->kode_depan;
      $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
      $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

        if ($today == $tanggal_dari_data_terakhir) {
            $no_urut = $nomor_urut_dari_data_terakhir;
            $no_urut++;
        }else{
            $no_urut=0;
            $no_urut++;
        }

        $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);
        
    }else{

        $no_urut=1;
        $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);

    }
    return $kode_temporary;
  }


  # INI UNTUK BUAT KODE ID PURCHASE ORDER NON RESELLER
    public function create_purchase_order_non_reseller_code(){

        $this->db->select('MAX(id) AS max_code');
        $this->db->from('purchase_order_non_reseller');
        $query = $this->db->get()->row();

        # maximal_id adalah id paling akhir
        $maximal_id =  $query->max_code;

        # mencari id terbesar
        $this->db->select('order_code_non_reseller');
        $this->db->select('SUBSTRING(order_code_non_reseller, 1, 3) AS kode_depan');
        $this->db->select('SUBSTRING(order_code_non_reseller, 5, 8) AS tanggal_dari_data_terakhir');
        $this->db->select('SUBSTRING(order_code_non_reseller, 14, 4) AS nomor_urut_dari_data_terakhir');
        $this->db->from('purchase_order_non_reseller');
        $this->db->where('id', $maximal_id);
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY"); // Tanpa pemisah

        if ($get_val->num_rows() > 0) {

          $id_reseller = $get_val->row()->order_code_non_reseller;
          $kode_depan = $get_val->row()->kode_depan;
          $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
          $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

            if ($today == $tanggal_dari_data_terakhir) {
                $no_urut = $nomor_urut_dari_data_terakhir;
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }
            // ONR = Order Non Reseller
            $order_code_non_reseller = 'ONR-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $order_code_non_reseller = 'ONR-'.$today."-".sprintf("%04s", $no_urut);

        }
        return $order_code_non_reseller;
    }

    # INI UNTUK BUAT KODE ID PURCHASE ORDER RESELLER
    public function create_purchase_order_reseller_code(){
        $this->db->select('MAX(id) AS max_code');
        $this->db->from('purchase_order_reseller');
        $query = $this->db->get()->row();

        # maximal_id adalah id paling akhir
        $maximal_id =  $query->max_code;

        # mencari id terbesar
        $this->db->select('order_code_reseller');
        $this->db->select('SUBSTRING(order_code_reseller, 1, 3) AS kode_depan');
        $this->db->select('SUBSTRING(order_code_reseller, 5, 8) AS tanggal_dari_data_terakhir');
        $this->db->select('SUBSTRING(order_code_reseller, 14, 4) AS nomor_urut_dari_data_terakhir');
        $this->db->from('purchase_order_reseller');
        $this->db->where('id', $maximal_id);
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY"); // Tanpa pemisah

        if ($get_val->num_rows() > 0) {

          $id_reseller = $get_val->row()->order_code_reseller;
          $kode_depan = $get_val->row()->kode_depan;
          $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
          $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

            if ($today == $tanggal_dari_data_terakhir) {
                $no_urut = $nomor_urut_dari_data_terakhir;
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }
            // ONR = Order Member Reseller
            $order_code_reseller = 'OMR-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $order_code_reseller = 'OMR-'.$today."-".sprintf("%04s", $no_urut);

        }
        return $order_code_reseller;
    }

}

/* End of file Frontend_Controller.php */
/* Location: ./application/core/Frontend_Controller.php */