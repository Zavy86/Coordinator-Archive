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
 // documents
 $nav->addItem(api_text("nav-document-list"),api_url(["scr"=>"documents_list"]));
 // operations
 if($document_obj->id && in_array(SCRIPT,array("documents_view","documents_edit"))){
  $nav->addItem(api_text("nav-operations"),null,null,"active");
  $nav->addSubItem(api_text("nav-document-operations-edit"),api_url(["scr"=>"documents_edit","idDocument"=>$document_obj->id]),(api_checkAuthorization("archive-manage")));
  $nav->addSubItem(api_text("nav-document-operations-upload"),api_url(["scr"=>"documents_view","act"=>"upload","idDocument"=>$document_obj->id]),(api_checkAuthorization("archive-manage")));
  if($document_obj->file){
   $nav->addSubSeparator();
   $nav->addSubItem(api_text("nav-document-operations-download"),api_url(["scr"=>"controller","act"=>"download","obj"=>"cArchiveDocument","idDocument"=>$document_obj->id]),true,null,null,null,null,"_blank");
  }
 }else{$nav->addItem(api_text("nav-document-add"),api_url(["scr"=>"documents_edit"]),(api_checkAuthorization("archive-manage")));}
 // settings
 $nav->addItem(api_text("nav-settings"));
 $nav->addSubItem(api_text("nav-settings-categories"),api_url(["scr"=>"categories_list"]));
 // add nav to html
 $app->addContent($nav->render(false));
?>