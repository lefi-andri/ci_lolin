<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); 
if(!function_exists('active_link')) {  
	function activate_menu($controller) {   
		$CI = get_instance();   
		$class = $CI->router->fetch_class();   
		return ($class == $controller) ? 'active' : '';  
	} 
}

/*
CARA MENGGUNAKAN

$this->load->helper('menu');

<ul class="nav navbar-nav navbar-left">  
	<li class="<?php echo activate_menu('profil');?>"><a href="<?php echo base_url('profil');?>" title="About me">Profil</a></li>  
	<li class="<?php echo activate_menu('work');?>"><a href="<?php echo base_url('work');?>" title="My work">Work</a></li>  
	<li class="<?php echo activate_menu('blog');?>"><a href="<?php echo base_url('blog');?>" title="My Blog">Blog</a></li>  
	<li class="<?php echo activate_menu('contact');?>"><a href="<?php echo base_url('contact');?>" title="Contact us">Contact</a></li> 
</ul>

*/