<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Sosial Media</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <p class="text-muted font-13 m-b-30">
          Halaman ini mengatur mengenai sosial media website.
        </p>
		<div align="right">
		<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh Data', array('class' => 'btn btn-info btn-sm' )); ?>
		</div>       
		<table id="socialmedia" class="table table-hover">
		  <thead>
		    <tr>
				<th>No.</th>
				<th>Social Name</th>
				<th>Social Value</th>
				<th>Ditampilkan</th>
				<th></th>				      
		    </tr>
		  </thead>
		</table>

      </div>
    </div>
  </div>
</div>