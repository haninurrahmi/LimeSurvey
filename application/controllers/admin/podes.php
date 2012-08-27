<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
* LimeSurvey
* Copyright (C) 2007-2011 The LimeSurvey Project Team / Carsten Schmitz
* All rights reserved.
* License: GNU/GPL License v2 or later, see LICENSE.php
* LimeSurvey is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
*/

/**
* podes
*
* @package IncubatorSurvey
* @author  Rahmat Awaludin (rahmat.awaludin@gmail.com)
* @copyright 2012
* @version $Id: podes.php 
* @access public
*/
class Podes extends Survey_Common_Action
{
    /**
    * Initiates the survey action, checks for superadmin permission
    *
    * @access public
    * @param CController $controller
    * @param string $id
    * @return void
    */
    public function __construct($controller, $id)
    {
        parent::__construct($controller, $id);
    }
    
    /**
    * This function show form to select location for podes    
	* TODO: Add Permission
	*       Add link from admin page       
    */
    function index() 
    {
		// Load podes helper function
		Yii::app()->loadHelper('admin/podes');
		$output = false;
		
        /* if (!hasGlobalPermission('USER_RIGHT_CREATE_SURVEY'))
            $this->getController()->error('No permission'); */                      		
		$model=new PotensiForm;

		// uncomment the following code to enable ajax-based validation
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='potensi-form-Index-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['PotensiForm']))
		{
			echo $model->outputtype;
            
			$model->attributes=$_POST['PotensiForm'];
			if($model->validate())
			{		
				$output = array(
					'id'=>$model->desaid,
					'kat3'=>$model->kat3,
					'kat4'=>$model->kat4,
					'kat5'=>$model->kat5,
					'kat6'=>$model->kat6,
					'kat7'=>$model->kat7,
					'kat8'=>$model->kat8,
					'kat9'=>$model->kat9,
					'kat10'=>$model->kat10,
					'kat12'=>$model->kat12,
					'outputtype'=>$model->outputtype,
				);
			}
		}
		
		// Load Podes css and JS
		$this->getController()->_css_admin_includes(Yii::app()->getConfig('adminstyleurl')."podes.css");
        $this->getController()->_js_admin_includes(Yii::app()->getConfig('adminscripts') . 'podes.js');
		//$aData['display']['menu_bars']['browse'] = "Quick statistics";        
		
        $aData['model'] = $model;
		$aData['output'] = $output;
		
        $this->_renderWrappedTemplate('podes', 'index', $aData);
    }
	
	/**
	* Compare podes data from different village
	* TODO: Add Permission
	*       Add link from podes page
	*       Add menu bar
	*/
	function compare() {
		// Load podes helper function
		Yii::app()->loadHelper('admin/podes');
		$model = new CompareForm;
		$output = false;
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='potensi-form-Index-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['CompareForm']))
		{
			$model->attributes=$_POST['CompareForm'];
			
			if($model->validate())
			{
				$desaids = array();
			
				$desaid1 = $_POST['CompareForm']['desaid1'];
				if (array_key_exists('desaid2', $_POST['CompareForm']))
					$desaid2 = $_POST['CompareForm']['desaid2'];
				if (array_key_exists('desaid3', $_POST['CompareForm']))
					$desaid3 = $_POST['CompareForm']['desaid3'];
				
				if($desaid1) {
					foreach ($desaid1 as $id)
						if ($id)
							array_push($desaids, $id);
				}
				
				if(isset($desaid2) && $desaid2) {
					foreach ($desaid2 as $id)
						if ($id)
							array_push($desaids, $id);
				}
				
				if(isset($desaid3) && $desaid3) {
					foreach ($desaid3 as $id)
						if ($id)
							array_push($desaids, $id);
				}
				
				$output = array(
					'desaids'=>$desaids,
					'kat3'=>$model->kat3,
					'kat4'=>$model->kat4,
					'kat5'=>$model->kat5,
					'kat6'=>$model->kat6,
					'kat7'=>$model->kat7,
					'kat8'=>$model->kat8,
					'kat9'=>$model->kat9,
					'kat10'=>$model->kat10,
					'kat12'=>$model->kat12,					
				);				
			}
		}

		// Load Podes css and JS
		$this->getController()->_css_admin_includes(Yii::app()->getConfig('adminstyleurl')."podes.css");
        $this->getController()->_js_admin_includes(Yii::app()->getConfig('adminscripts') . 'podes.js');
		
		$aData['model'] = $model;
		$aData['output'] = $output;
		$this->_renderWrappedTemplate('podes', 'compare', $aData);
	}
	
    /**
    * Renders template(s) wrapped in header and footer
    *
    * @param string $sAction Current action, the folder to fetch views from
    * @param string|array $aViewUrls View url(s)
    * @param array $aData Data to be passed on. Optional.
    */
    protected function _renderWrappedTemplate($sAction = 'podes', $aViewUrls = array(), $aData = array())
    {
		
        //$this->getController()->_css_admin_includes(Yii::app()->getConfig('adminstyleurl')."superfish.css");
        $aData['display']['menu_bars'] = false;
        parent::_renderWrappedTemplate($sAction, $aViewUrls, $aData);
    }
}