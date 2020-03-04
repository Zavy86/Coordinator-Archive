<?php
/**
 * Archive - Document List
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("archive-usage","dashboard");
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // definitions
 $users_array=array();
 // set application title
 $app->setTitle(api_text("documents_list"));
 // definitions
 $categories_array=array();
 // get categories
 foreach(cArchiveCategory::availables(true) as $category_fobj){$categories_array[$category_fobj->id]=$category_fobj->name;}
 // build filter
 $filter=new strFilter();
 $filter->addSearch(["id","name","description"]);
 $filter->addItem(api_text("documents_list-filter-categories"),$categories_array,"fkCategory",null,"categories");
 // build query object
 $query=new cQuery("archive__documents",$filter->getQueryWhere());
 $query->addQueryOrderField("date","desc");
 $query->addQueryOrderField("id","desc");
 // build pagination object
 $pagination=new strPagination($query->getRecordsCount());
 // cycle all results
 foreach($query->getRecords($pagination->getQueryLimits()) as $result_f){$documents_array[$result_f->id]=new cArchiveDocument($result_f);}
 // build table
 $table=new strTable(api_text("documents_list-tr-unvalued"));
 $table->addHeader($filter->link(api_icon("fa-filter",api_text("filters-modal-link"),"hidden-link")),"text-center",16);
 $table->addHeader(api_text("cArchiveDocument-property-id"),"nowrap");
 $table->addHeader("&nbsp;",null,16);
 $table->addHeader(api_text("cArchiveDocument-property-date"),"nowrap");
 $table->addHeader(api_text("cArchiveDocument-property-name"),null,"100%");
 $table->addHeader("&nbsp;",null,16);
 // cycle all documents
 foreach($documents_array as $document_fobj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement(api_url(["scr"=>"documents_edit","idDocument"=>$document_fobj->id,"return"=>["scr"=>"documents_list"]]),"fa-pencil",api_text("table-td-edit"),(api_checkAuthorization("archive-manage")));
  if($document_fobj->deleted){$ob->addElement(api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cArchiveDocument","idDocument"=>$document_fobj->id,"return"=>["scr"=>"documents_list"]]),"fa-trash-o",api_text("table-td-undelete"),(api_checkAuthorization("archive-manage")),api_text("cArchiveDocument-confirm-undelete"));}
  else{$ob->addElement(api_url(["scr"=>"controller","act"=>"delete","obj"=>"cArchiveDocument","idDocument"=>$document_fobj->id,"return"=>["scr"=>"documents_list"]]),"fa-trash",api_text("table-td-delete"),(api_checkAuthorization("archive-manage")),api_text("cArchiveDocument-confirm-delete"));}
  // make table row class
  $tr_class_array=array();
  if($document_fobj->id==$_REQUEST['idDocument']){$tr_class_array[]="currentrow";}
  if($document_fobj->deleted){$tr_class_array[]="deleted";}
  // make row
  $table->addRow(implode(" ",$tr_class_array));
  $table->addRowFieldAction(api_url(["scr"=>"documents_view","idDocument"=>$document_fobj->id]),"fa-search",api_text("table-td-view"));
  $table->addRowField(api_tag("samp",$document_fobj->id),"nowrap");
  $table->addRowField($document_fobj->getCategory()->getDot(),"nowrap text-center");
  $table->addRowField(api_date_format($document_fobj->date,api_text("date")),"nowrap");
  $table->addRowField($document_fobj->name,"truncate-ellipsis");
  $table->addRowField($ob->render(),"nowrap text-right");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($filter->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($table->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($pagination->render(),"col-xs-12");
 // add content to document
 $app->addContent($grid->render());
 // renderize document
 $app->render();
 // debug
 api_dump($query,"query");
?>