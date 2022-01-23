<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pensil extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->stencil->slice(array('head', 'navbar'));
	}

	public function index()
	{
		//set title
		$this->stencil->title('Pensil');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		$this->stencil->js('bootstrap/bootstrap.min');

		//set metadata
		$this->stencil->meta(array(
            'author' => 'Sakukode Team',
            'description' => 'Sakukode adalah freelancer yang bergerak di bidang jasa pembuatan dan pengelolaan web',
            'keywords' => 'sakukode,web,freelance'
        ));

		//set data
		$data['nama'] 		= "Lefiandri";

		//set view
		$this->stencil->paint('pensil/index',$data);
	}

}

/* End of file Pensil.php */
/* Location: ./application/modules/frontend/controllers/Pensil.php */