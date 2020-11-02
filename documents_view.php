<?php
/**
 * Archive - Document View
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("archive-usage","dashboard");
 // get objects
 $document_obj=new cArchiveDocument($_REQUEST['idDocument']);
 // check objects
 if(!$document_obj->id){api_alerts_add(api_text("cArchiveDocument-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=documents_list");}
 // deleted alert
 if($document_obj->deleted){api_alerts_add(api_text("cArchiveDocument-warning-deleted"),"warning");}
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(api_text("documents_view",$document_obj->name));
 // check for tab
 if(!defined(TAB)){define("TAB","informations");}
 // build document description list
 $left_dl=new strDescriptionList("br","dl-horizontal");
 $left_dl->addElement(api_text("cArchiveDocument-property-id"),api_tag("samp",$document_obj->id));
 $left_dl->addElement(api_text("cArchiveDocument-property-name"),api_tag("strong",$document_obj->name));
 $left_dl->addElement(api_text("cArchiveDocument-property-fkRegistry"),$document_obj->getRegistry()->name);
 // build right description list
 $right_dl=new strDescriptionList("br","dl-horizontal");
 $right_dl->addElement(api_text("cArchiveDocument-property-fkCategory"),$document_obj->getCategory()->getLabel(false,true));
 if($document_obj->description){$right_dl->addElement(api_text("cArchiveDocument-property-description"),nl2br($document_obj->description));}
 // include tabs
 require_once(MODULE_PATH."documents_view-informations.inc.php");
 // build view tabs
 $tab=new strTab();
 $tab->addItem(api_icon("fa-flag-o")." ".api_text("documents_view-tab-informations"),$informations_dl->render(),("informations"==TAB?"active":null));
 $tab->addItem(api_icon("fa-file-text-o")." ".api_text("documents_view-tab-logs"),api_logs_table($document_obj->getLogs((!$_REQUEST['all_logs']?10:null)))->render(),("logs"==TAB?"active":null));
 // check for upload action
 if(ACTION=="upload" && api_checkAuthorization("archive-manage")){
  // get form
  $form=$document_obj->form_file(["return"=>["scr"=>"documents_view"]]);
  // additional controls
  $form->addControl("button",api_text("form-fc-cancel"),"#",null,null,null,"data-dismiss='modal'");
  // build modal
  $modal=new strModal(api_text("documents_view-file-modal-title",$document_obj->id),null,"documents_view-file");
  $modal->setBody($form->render(1));
  // add modal to application
  $app->addModal($modal);
  // modal scripts
  $app->addScript("$(function(){\$('#modal_documents_view-file').modal({show:true,backdrop:'static',keyboard:false});});");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($left_dl->render(),"col-xs-12 col-md-4");
 $grid->addCol($right_dl->render(),"col-xs-12 col-md-8");
 $grid->addRow();
 $grid->addCol($tab->render(),"col-xs-12");
 // add content to document
 $app->addContent($grid->render());
 // renderize document
 $app->render();
 // debug
 api_dump($document_obj,"document");
?>