<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_elements extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		//set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//set model
	}

	public function index()
	{
		//set title
		$this->stencil->title('Artikel');
		//set layout
		$this->stencil->layout('backend_layout');
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
		$this->stencil->paint('form_elements/index',$data);
	}

}

/* End of file Form_elements.php */
/* Location: ./application/modules/backend/controllers/Form_elements.php */