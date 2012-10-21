<?php

App::import("Controller","LocalApp");

class PhrasesController extends LocalAppController {

	var $name = 'Phrases';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		
		$this->initPermissions();
		
	}
	
	public function test() {
		
		//$this->Session->delete("ControlPanel.translate_locale");
		$d = $this->Phrase->returnSection("CommonFields","chi");
		pr($d);
		$d = $this->Phrase->returnSection("CommonFields","en_gb");
		pr($d);
		$d = $this->Phrase->returnSection("CommonFields","chi");
		pr($d);
		$d = $this->Phrase->returnSection("CommonFields","en_us");
		pr($d);
	}
	
	
	function index() {
		
		$this->Phrase->recursive = 0;
		
		$phrases = $this->paginate('Phrase');
		
		$this->set('phrases', $phrases);
		
		//get the list of locales
		
		$this->loadModel("Locale");
		
		//$locales = $this->Locale->find("list",array("fields"=>array("Locale.locale","Locale.name"),"order"=>array("name"=>"ASC")));
		
		$locales = Lang::localeList();
		
		$this->set("locales",$locales);
		
		//set the incoming locale to the session
		if(!empty($this->request->data)) {
			
			if(Set::check($this->request->data,"Phrase.selectLocale")) {
				
				$this->Session->write("ControlPanel.translate_locale",$this->request->data['Phrase']['selectLocale']);
				
			}
			
		}
		
		
		//get the locale from the session
		if($this->Session->check("ControlPanel.translate_locale")) {
			
			$translate_locale = $this->Session->read("ControlPanel.translate_locale");
			
		} else {
			
			$translate_locale = 'en_us';
			$this->request->data['Phrase']['selectLocale']='en_us';
			
		}
		
		$this->request->data['Phrase']['selectLocale']=$translate_locale;
		
		$this->Phrase->setLanguage($translate_locale);
		
		//get the trnaslated phrases
		$ids = Set::extract("/Phrase/id",$phrases);
		
		//pr($this->Session->read());
		
		$locale_phrases = $this->Phrase->find('all',array("conditions"=>array("Phrase.id"=>$ids)));
		
		$this->set("locale_phrases",$locale_phrases);
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phrase'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phrase', $this->Phrase->read(null, $id));
		
		
		$this->loadModel("Locale");
		$locales = $this->Locale->find("list");
		$this->set("locales",$locales);
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Phrase->create();
			
			//lets stuff in the value for "raw_value" to retain the original intent for the translation
			$this->request->data['Phrase']['raw_value']=$this->request->data['Phrase']['value'];
			
			if ($this->Phrase->save($this->request->data)) {
				
				$this->Session->setFlash(__('The phrase has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phrase could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid phrase'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->Phrase->setLanguage($this->Session->read("ControlPanel.translate_locale"));
			
			if ($this->Phrase->save($this->request->data)) {
				
				//now lets get the en_us phase and popultat the main table with it just to keep things clean
				/*
				$this->Phrase->setLanuage('en_us');
				$en_us_p = $this->Phrase->findById($this->request->data['Phrase']['id']);
				
				$this->Phrase->id=$en_us_p['Phrase']['id'];
				
				$this->Phrase->save($en_us_p['Phrase'],false);
				*/
				$this->Session->setFlash(__('The phrase has been saved'));
				$this->redirect(array('action' => 'index'));
				
			} else {
				$this->Session->setFlash(__('The phrase could not be saved. Please, try again.'));
			}
		}
		
		$this->Phrase->setLanguage($this->request->params['named']['translate_locale']);
		
		$translate_lang = $this->Phrase->findById($id);
		
		$this->set("translate_lang",$translate_lang);
		
		
		$this->Phrase->setLanguage("en_us");
		
		$en_lang = $this->Phrase->findById($id);
	
		$this->set("en_lang",$en_lang);
		

		
		//$this->Phrase->setLanguage($this->request->params['named']['translate_locale']);
		
		if (empty($this->request->data)) {
			$this->request->data = $this->Phrase->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phrase'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Phrase->delete($id)) {
			$this->Session->setFlash(__('Phrase deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phrase was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>