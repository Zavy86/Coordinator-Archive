<?php
/**
 * Archive - Template
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // build application
 $app=new strApplication();
 // build nav object
 $nav=new strNav("nav-tabs");
 // dashboard
 $nav->addItem(api_icon("fa-th-large",null,"hidden-link"),api_url(["scr"=>"dashboard"]));
 // document
 if(api_script_prefix()=="documents"){
  $nav->addItem(api_text("nav-document-list"),api_url(["scr"=>"documents_list"]));
  // operations
  if($document_obj->id && in_array(SCRIPT,array("documents_view","documents_edit"))){
   $nav->addItem(api_text("nav-operations"),null,null,"active");
   $nav->addSubItem(api_text("nav-document-operations-edit"),api_url(["scr"=>"documents_edit","idDocument"=>$document_obj->id]),(api_checkAuthorization("archive-manage")));
  }else{
   $nav->addItem(api_text("nav-document-add"),api_url(["scr"=>"documents_edit"]),(api_checkAuthorization("archive-manage")));
  }
 }
 // add nav to html
 $app->addContent($nav->render(false));
?>