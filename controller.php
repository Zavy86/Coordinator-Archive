<?php
/**
 * Archive - Controller
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 // debug
 api_dump($_REQUEST,"_REQUEST");
 // check if object controller function exists
 if(function_exists($_REQUEST['obj']."_controller")){
  // call object controller function
  call_user_func($_REQUEST['obj']."_controller",$_REQUEST['act']);
 }else{
  api_alerts_add(api_text("alert_controllerObjectNotFound",[MODULE,$_REQUEST['obj']."_controller"]),"danger");
  api_redirect("?mod=".MODULE);
 }

 /**
  * Category controller
  *
  * @param string $action Object action
  */
 function cArchiveCategory_controller($action){
  // check authorizations
  api_checkAuthorization("archive-manage","dashboard");
  // get object
  $category_obj=new cArchiveCategory($_REQUEST['idCategory']);
  api_dump($category_obj,"category object");
  // check object
  if($action!="store" && !$category_obj->id){api_alerts_add(api_text("cArchiveCategory-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=categories_list");}
  // execution
  try{
   switch($action){
    case "store":
     $category_obj->store($_REQUEST);
     api_alerts_add(api_text("cArchiveCategory-alert-stored"),"success");
     break;
    case "delete":
     $category_obj->delete();
     api_alerts_add(api_text("cArchiveCategory-alert-deleted"),"warning");
     break;
    case "undelete":
     $category_obj->undelete();
     api_alerts_add(api_text("cArchiveCategory-alert-undeleted"),"warning");
     break;
    case "remove":
     $category_obj->remove();
     api_alerts_add(api_text("cArchiveCategory-alert-removed"),"warning");
     break;
    default:
     throw new Exception("Category action \"".$action."\" was not defined..");
   }
   // redirect
   api_redirect(api_return_url(["scr"=>"categories_list","idCategory"=>$category_obj->id]));
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,api_url(["scr"=>"categories_list","idCategory"=>$category_obj->id]),"cArchiveCategory-alert-error");
  }
 }

 /**
  * Document controller
  *
  * @param string $action Object action
  */
 function cArchiveDocument_controller($action){
  // check authorizations
  api_checkAuthorization("archive-manage","dashboard");
  // get object
  $document_obj=new cArchiveDocument($_REQUEST['idDocument']);
  api_dump($document_obj,"document object");
  // check object
  if($action!="store" && !$document_obj->id){api_alerts_add(api_text("cArchiveDocument-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=documents_list");}
  // execution
  try{
   switch($action){
    case "store":
     $document_obj->store($_REQUEST);
     api_alerts_add(api_text("cArchiveDocument-alert-stored"),"success");
     break;
    case "upload":
     $document_obj->upload($_FILES["file"],false);
     api_alerts_add(api_text("cArchiveDocument-alert-stored"),"success"); /** @todo specific alert? */
     break;
    case "download":
     $document_obj->download($_REQUEST["file"],$_REQUEST["force"]);
     break;
    case "delete":
     $document_obj->delete();
     api_alerts_add(api_text("cArchiveDocument-alert-deleted"),"warning");
     break;
    case "undelete":
     $document_obj->undelete();
     api_alerts_add(api_text("cArchiveDocument-alert-undeleted"),"warning");
     break;
    case "remove":
     $document_obj->remove();
     api_alerts_add(api_text("cArchiveDocument-alert-removed"),"warning");
     break;
    default:
     throw new Exception("Document action \"".$action."\" was not defined..");
   }
   // redirect
   api_redirect(api_return_url(["scr"=>"documents_list","idDocument"=>$document_obj->id]));
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,api_url(["scr"=>"documents_list","idDocument"=>$document_obj->id]),"cArchiveDocument-alert-error");
  }
 }

?>