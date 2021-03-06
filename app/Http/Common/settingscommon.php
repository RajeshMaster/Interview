<?php
namespace App\Http\Common;
	class settingscommon {
		public static function getDbFieldsforProcess() {
			// User Designation		
			return array('sysdesignationtypes'=>array('labels'=>
											   array('heading'=>trans('messages.lbl_userdesignation'),
												 	'field1lbl'=>trans('messages.lbl_userdesignationinenglish'),
													'field2lbl'=>trans('messages.lbl_userdesignationinjapanese')),
			    	  							 	'selectfields'=>array('id','DesignationNM',
			    	  							 		'DesignationNMJP','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','DesignationNM',
		 										 		'DesignationNMJP','DelFlg','Order_id'),
		 										 	'insertfields'=>array('DesignationNM',
		 										 		'DesignationNMJP','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','DesignationCD'),
		 										 	'updatefields'=>array('DesignationNM',
		 										 		'DesignationNMJP','Upd_DT','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),
						//Unfix reason
						'sysunfixedreason'=>array('labels'=>
												array('heading'=>trans('messages.lbl_Unfixed_reason'),
												 	'field1lbl'=>trans('messages.lbl_reason')),
			    	  							 	'selectfields'=>array('id','Reason','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','Reason','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('Reason','DelFlg','Ins_DT','UpDT','CreatedBy','UpdatedBy','Order_id'),
		 										 	'updatefields'=>array('Reason','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),
						//Role
						'emp_roletypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_roletype'),
												 	'field1lbl'=>trans('messages.lbl_RoleTypeEN'),
													'field2lbl'=>trans('messages.lbl_RoleTypeJP')),
			    	  							 	'selectfields'=>array('id','RoleTypeNM','RoleTypeNM_JP','Ins_DT','Delflg','orderId'),
		 										 	'displayfields'=>array('id','RoleTypeNM','RoleTypeNM_JP','Ins_DT','Delflg','orderId'),
		 										 	'insertfields'=>array('RoleTypeNM','RoleTypeNM_JP','Delflg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','orderId','RoleTypeCD'),
		 										 	'updatefields'=>array('RoleTypeNM','RoleTypeNM_JP','Upd_DT','UpdatedBy'),
												 	'usenotusefields'=>array('Delflg'),
		 										 	'commitfields'=>array('orderId')),
						//Programming Language
						'emp_sysprogramlangtypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_sysprogramlangtypes'),
												 	'field1lbl'=>trans('messages.lbl_PLTypeNM')),
			    	  							 	'selectfields'=>array('id','ProgramLangTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','ProgramLangTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('ProgramLangTypeNM','DelFlg','Ins_DT','Upd_DT','createdBy','updatedBy','Order_id','ProgramLangTypeCD'),
		 										 	'updatefields'=>array('ProgramLangTypeNM','updatedBy'),
												 	'usenotusefields'=>array('Delflg'),
		 										 	'commitfields'=>array('Order_id')),
						//Database
						'emp_sysdbtypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_sysdbtypes'),
												 	'field1lbl'=>trans('messages.lbl_DBTypeNM')),
			    	  							 	'selectfields'=>array('id','DBType','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','DBType','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('DBType','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','DBTypeCD'),
		 										 	'updatefields'=>array('DBType','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),

						//Tool
						'emp_systooltypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_systooltypes'),
												 	'field1lbl'=>trans('messages.lbl_ToolTypeNM')),
			    	  							 	'selectfields'=>array('id','ToolTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','ToolTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('ToolTypeNM','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','ToolTypeCD'),
		 										 	'updatefields'=>array('ToolTypeNM','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),
						//GUI
						'emp_sysguitypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_sysguitypes'),
												 	'field1lbl'=>trans('messages.lbl_GUITypeNM')),
			    	  							 	'selectfields'=>array('id','GUITypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','GUITypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('GUITypeNM','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','GUITypeCD'),
		 										 	'updatefields'=>array('GUITypeNM','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),
						//WebServer
						'emp_syswebservertypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_syswebservertypes'),
												 	'field1lbl'=>trans('messages.lbl_WSTypeNM')),
			    	  							 	'selectfields'=>array('id','WSTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','WSTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('WSTypeNM','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','WSTypeCD'),
		 										 	'updatefields'=>array('WSTypeNM','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),

						//MiddleWare
						'emp_sysmiddlewaretypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_sysmiddlewaretypes'),
												 	'field1lbl'=>trans('messages.lbl_MWTypeNM')),
			    	  							 	'selectfields'=>array('id','MWTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','MWTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('MWTypeNM','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','MWTypeCD'),
		 										 	'updatefields'=>array('MWTypeNM','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),

						//WebTools
						'emp_syswebtooltypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_syswebtooltypes'),
												 	'field1lbl'=>trans('messages.lbl_WTTypeNM')),
			    	  							 	'selectfields'=>array('id','WTTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','WTTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('WTTypeNM','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','WTTypeCD'),
		 										 	'updatefields'=>array('WTTypeNM','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),

						//OS
						'emp_sysostypes'=>array('labels'=>
												array('heading'=>trans('messages.lbl_sysostypes'),
												 	'field1lbl'=>trans('messages.lbl_OSTypeNM')),
			    	  							 	'selectfields'=>array('id','OSTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','OSTypeNM','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('OSTypeNM','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id','OSTypeCD'),
		 										 	'updatefields'=>array('OSTypeNM','UpdatedBy'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),
						// Requirement
						'requirmentsetting'=>array('labels'=>
											   array('heading'=>trans('Requirments'),
												 	'field1lbl'=>trans('Skill Name'),
													'field2lbl'=>trans('Common Show')),
			    	  							 	'selectfields'=>array('id','Requirment',
			    	  							 		'commShow','Ins_DT','delFlg','Order_id'),
		 										 	'displayfields'=>array('id','Requirment',
		 										 		'commShow','delFlg','Order_id'),
		 										 	'insertfields'=>array('Requirment',
		 										 		'commShow','delFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id'),
		 										 	'updatefields'=>array('Requirment',
		 										 		'commShow','Upd_DT','UpdatedBy'),
												 	'usenotusefields'=>array('delFlg'),
		 										 	'commitfields'=>array('Order_id')),

						//Japanese Skills
						'jplanguage_skill'=>array('labels'=>
												array('heading'=>trans('messages.lbl_japanese'),
												 	'field1lbl'=>trans('messages.lbl_skillname')),
			    	  							 	'selectfields'=>array('id','skillName','Ins_DT','DelFlg','Order_id'),
		 										 	'displayfields'=>array('id','skillName','Ins_DT','DelFlg','Order_id'),
		 										 	'insertfields'=>array('skillName','DelFlg','Ins_DT','Upd_DT','CreatedBy','UpdatedBy','Order_id'),
		 										 	'updatefields'=>array('skillName','UpdatedBy','Upd_DT'),
												 	'usenotusefields'=>array('DelFlg'),
		 										 	'commitfields'=>array('Order_id')),
			    );
		}
	}
?>