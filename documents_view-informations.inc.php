<?php
/**
 * Archive - Archive View (Informations)
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 // build informations description list
 $informations_dl=new strDescriptionList("br","dl-horizontal");
 $informations_dl->addElement(api_text("cArchiveDocument-property-date"),api_date_format($document_obj->date,api_text("date")));
 if($document_obj->file){$informations_dl->addElement(api_text("cArchiveDocument-property-file"),api_link(api_url(["scr"=>"controller","act"=>"download","obj"=>"cArchiveDocument","idDocument"=>$document_obj->id]),strtoupper(substr(strrchr($document_obj->file,"."),1)),null,null,true,null,null,null,"_blank")." (".api_uploads_size("archive",$document_obj->file,true).")");}

?>