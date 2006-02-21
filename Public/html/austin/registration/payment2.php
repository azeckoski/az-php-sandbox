<?php  require_once('../includes/reg_header.inc'); 
                   
                   ?>
<form method="POST" action="https://payments.verisign.com/payflowlink">
<input type="hidden" name="LOGIN" value="sakaiproject">

<input type="hidden" name="PARTNER" value="verisign">
<input type="hidden" name="AMOUNT" value="395">
<input type="hidden" name="TYPE" value="S">
<input type="submit" value="Click here to pay" >
</form>

    
<?php  require_once('../includes/footer.inc'); 
?>