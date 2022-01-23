<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key:ff115172b7a842920e60a6eb2d6fe34a"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $data = json_decode($response, TRUE);

  $total_hasil = count($data['rajaongkir']['results']);

  #$selected = ($nilai == $this->session->userdata('provinsi')) ? 'selected' : '';

  $dropdown[''] = 'Provinsi';
  #$dropdown = array();
  for ($i=0; $i < $total_hasil; $i++) {
    $nilai = $data['rajaongkir']['results'][$i]['province_id'].','.$data['rajaongkir']['results'][$i]['province'];
    $nilai_value = $data['rajaongkir']['results'][$i]['province'];
    $dropdown[$nilai] = $nilai_value;
  }

  #echo form_dropdown('prov', $dropdown, ($this->session->userdata('provinsi')) ? $this->session->userdata('provinsi') : '', array('class' => 'form-control', 'id' => 'prov'));
  echo form_dropdown('prov', $dropdown, '', array('class' => 'form-control', 'id' => 'prov', 'required' => 'required'));

  /*for ($i=0; $i < $total_hasil; $i++) {
    $nilai = $data['rajaongkir']['results'][$i]['province_id'].','.$data['rajaongkir']['results'][$i]['province'];
    $nilai_value = $data['rajaongkir']['results'][$i]['province'];
     echo '<option value="'.$nilai.'" '.$selected.'>'.$nilai_value.'</option>';
  }*/
}
