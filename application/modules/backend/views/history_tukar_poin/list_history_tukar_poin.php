<div id="hasil"></div>
<div align="right">
	<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh Data', array('class' => 'btn btn-info btn-sm' )); ?>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading">Member Lolin</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						<?php echo $table; ?>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<script>