<?php

class IndexController extends \Phalcon\Mvc\Controller {

	public function indexAction() {
		$di = $this->getDI();

		$phalconvm = $di->getShared( 'phalconvmConfig' );
		$fields = $di->getShared( 'fieldsConfig' );

		$this->tag->setTitle( 'Phalcon VM' );

		$this->assets->addCss( '//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic', false );
		$this->assets->addCss( '//fonts.googleapis.com/icon?family=Material+Icons', false );
		$this->assets->addCss( 'css/app.css' );

		$this->assets->addInlineJs( sprintf( 'var phalconvm = %s;', json_encode( $phalconvm ) ) );
		$this->assets->addJs( 'js/app.js' );

		$phalconvm['fields'] = $fields;
		$this->view->phalconvm = $phalconvm;
	}

	public function saveEnvAction() {
		if ( ! $this->request->isPost() ) {
			$this->response->redirect( '/', false );
		} else {
			$postdata = trim( file_get_contents( "php://input" ) );
			file_put_contents( BASE_PATH . '/data/settings.json', $postdata );
		}

		return false;
	}

	public function saveSiteAction() {
		if ( ! $this->request->isPost() ) {
			$this->response->redirect( '/', false );
		} else {
			$postdata = trim( file_get_contents( "php://input" ) );
			$json = json_decode( $postdata );
			if ( ! empty( $json->directory ) ) {
				$filename = sprintf( '%s/data/sites/%s.json', BASE_PATH, $json->directory );
				file_put_contents( $filename, $postdata );
			}
		}

		return false;
	}

}
