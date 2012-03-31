<?php
/**
 * "Signup" page.
 *
 * @since 0.1.0
 * @package TestSwarm
 */

class SignupPage extends Page {

	public function execute() {
		$action = SignupAction::newFromContext( $this->getContext() );
		$action->doAction();
		$error = $action->getError();
		if ( !$error ) {
			$data = $action->getData();
			if ( $data["status"] === "logged-in" ) {
				$this->redirect( swarmpath( "user/" . $data["username"] ) );
			}
		}

		$this->setAction( $action );
		$this->content = $this->initContent();
	}

	protected function initContent() {
		$request = $this->getContext()->getRequest();

		$this->setTitle( "Signup" );

		$html = '<form action="' . swarmpath( "signup" ) . '" method="post">'
			. '<fieldset>'
			. '<legend>Signup</legend>';

		$error = $this->getAction()->getError();

		if ( $request->wasPosted() && $error ) {
			$html .= html_tag( 'div', array( 'class' => 'errorbox' ), $error['info'] );
		}

		$html .= '<p>Signup to use TestSwarm. If you already have an account you may <a href="' . swarmpath( "login" )
			. '">Login Here</a>.</p>'
			. '<label>Username: <input type="text" name="username"/></label><br/>'
			. '<label>Password: <input type="password" name="password"/></label><br/>'
			. '<input type="submit" value="Signup"/>'
			. '</fieldset></form>';

		return $html;
	}
}