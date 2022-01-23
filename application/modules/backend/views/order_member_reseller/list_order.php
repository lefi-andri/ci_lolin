<script>
function simpanbadanusaha(id)
{
    var acc_order=$("#acc_order"+id).val();
    $.ajax({
    url:"<?php echo base_url();?>backend/order_member_reseller/acc_order",
    data:"id=" + id +"&acc_order="+acc_order ,
    success: function(html)
    { 
         $("#hasil").html(html);
    }
          });  
}
</script>
<div id="hasil"></div>

<?php echo $table; ?>