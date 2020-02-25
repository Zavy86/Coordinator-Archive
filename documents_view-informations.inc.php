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
 if($document_obj->file){$informations_dl->addElement(api_text("documents_view-informations-dt-size"),api_uploads_size("archive",$document_obj->file,true));}

?>