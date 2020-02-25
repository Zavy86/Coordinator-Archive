<?php
/**
 * Archive - Document Edit
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("archive-manage","dashboard");
 // get objects
 $document_obj=new cArchiveDocument($_REQUEST['idDocument']);
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(($document_obj->id?api_text("documents_edit",$document_obj->name):api_text("documents_edit-add")));
 // get form
 $form=$document_obj->form_edit(["return"=>api_return(["scr"=>"documents_view"])]);
 // additional controls
 if($document_obj->id){
  $form->addControl("button",api_text("form-fc-cancel"),api_return_url(["scr"=>"documents_view","idDocument"=>$document_obj->id]));
  if(!$document_obj->deleted){
   $form->addControl("button",api_text("form-fc-delete"),api_url(["scr"=>"controller","act"=>"delete","obj"=>"cArchiveDocument","idDocument"=>$document_obj->id]),"btn-danger",api_text("cArchiveDocument-confirm-delete"));
  }else{
   $form->addControl("button",api_text("form-fc-undelete"),api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cArchiveDocument","idDocument"=>$document_obj->id,"return"=>["scr"=>"documents_view"]]),"btn-warning");
   $form->addControl("button",api_text("form-fc-remove"),api_url(["scr"=>"controller","act"=>"remove","obj"=>"cArchiveDocument","idDocument"=>$document_obj->id]),"btn-danger",api_text("cArchiveDocument-confirm-remove"));
  }
 }else{$form->addControl("button",api_text("form-fc-cancel"),api_url(["scr"=>"documents_list"]));}
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($form->render(),"col-xs-12");
 // add content to document
 $app->addContent($grid->render());
 // renderize document
 $app->render();
 // debug
 api_dump($document_obj,"document");
?>