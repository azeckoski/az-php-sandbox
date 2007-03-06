<?php
/**
* @version $Id: user.html.php,v 1.1 2005/07/22 01:54:57 eddieajau Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Users
*/
class HTML_user {
	function frontpage() {
?>
<div class="componentheading">
	<?php echo _WELCOME; ?>
</div>

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td><?php echo _WELCOME_DESC; ?></td>
		</tr>
	</table>
<?php
	}

	function userEdit($row, $option,$submitvalue)
	{
?>
	<script language="javascript" type="text/javascript">
		function submitbutton() {
			var form = document.mosUserForm;
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

			// do field validation
			if (form.name.value == "") {
				alert( "<?php echo _REGWARN_NAME;?>" );
			} else if (form.username.value == "") {
				alert( "<?php echo _REGWARN_UNAME;?>" );
			} else if (r.exec(form.username.value) || form.username.value.length < 3) {
				alert( "<?php printf( _VALID_AZ09, _PROMPT_UNAME, 4 );?>" );
			} else if (form.email.value == "") {
				alert( "<?php echo _REGWARN_MAIL;?>" );
			} else if ((form.password.value != "") && (form.password.value != form.verifyPass.value)){
				alert( "<?php echo _REGWARN_VPASS2;?>" );
			} else if (r.exec(form.password.value)) {
				alert( "<?php printf( _VALID_AZ09, _REGISTER_PASS, 4 );?>" );
			} else {
				form.submit();
			}
		}
	</script>
<form action="index.php" method="post" name="mosUserForm">
		<div class="componentheading">
			<?php echo _EDIT_TITLE; ?>
		</div>
		<table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
      <td width=85><?php echo _YOUR_NAME; ?></td>
      <td><input class="inputbox" type="text" name="name" value="<?php echo $row->name;?>" size="40" /></td>
    </tr>
    <tr>
      <td><?php echo _EMAIL; ?></td>
      <td><input class="inputbox" type="text" name="email" value="<?php echo $row->email;?>" size="40" /></td>
    <tr>
      <td><?php echo _UNAME; ?></td>
      <td><input class="inputbox" type="text" name="username" value="<?php echo $row->username;?>" size="40" /></td>
    </tr>
    <tr>
      <td><?php echo _PASS; ?></td>
      <td><input class="inputbox" type="password" name="password" value="" size="40" /></td>
    </tr>
    <tr>
      <td><?php echo _VPASS; ?></td>
      <td><input class="inputbox" type="password" name="verifyPass" size="40" /></td>
    </tr>
    <tr>
      <td colspan="2">
        <input class="button" type="button" value="<?php echo $submitvalue; ?>" onclick="submitbutton()" />
      </td>
    </tr>
  </table>
	<input type="hidden" name="id" value="<?php echo $row->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>">
	<input type="hidden" name="task" value="saveUserEdit" />
</form>
<?php
	}

	function confirmation() {
		?>
	<div class="componentheading">
		<?php echo _SUBMIT_SUCCESS; ?>
	</div>
	<table>
		<tr>
			<td><?php echo _SUBMIT_SUCCESS_DESC; ?></td>
		</tr>
	</table>
<?php
	}
}
?>