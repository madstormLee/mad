<?
// temporally move methods.
class MadUserController extends MadController {
	public function isEmailAction() {
		if ( ! isset($_POST['email']) ) {
			print 'illigal appoach';
			die;
		}
		$rv = '-1';
		if ( isset($_POST['email']) ) {
			$email = $_POST['email'];
			if ( IS_AJAX ) {
				$validate = MadRegex::simpleValidateEmail($email);
			} else {
				$validate = MadRegex::validateEmail($email);
			}
			if ( $validate ) { 
				$query = "select count(*) as cnt from $this->table where email like '$email' limit 1";
				$q = new Q($query);
				$row = $q->row();
				$rv =  $row['cnt'];
			}
		}
		if ( IS_AJAX ) {
			print $rv;
		} else {
			return $rv;
		}
	}

