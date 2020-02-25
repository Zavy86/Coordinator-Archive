<?php
/**
 * Archive - Document
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Archive Document class
  */
 class cArchiveDocument extends cObject{

  /** Parameters */
  static protected $table="archive__documents";
  static protected $logs=true;

  /** Properties */
  protected $id;
  protected $deleted;
  protected $fkCategory;
  protected $date;
  protected $name;
  protected $description;
  protected $file;

  /**
   * Decode log properties
   *
   * {@inheritdoc}
   */
  public static function log_decode($event,$properties){
   // make return array
   $return_array=array();
   // subobject events
   if($properties['fkCategory']){$return_array[]=api_text("cArchiveDocument-property-fkCategory").": ".(new cArchiveCategory($properties['fkCategory']['previous']))->name." &rarr; ".(new cArchiveCategory($properties['fkCategory']['current']))->name;}
   if($properties['name']){$return_array[]=api_text("cArchiveDocument-property-name").": ".$properties['name']['previous']." &rarr; ".$properties['name']['current'];}
   // return
   return implode(" | ",$return_array);
  }

  /**
   * Get Category
   *
   * @return object Category object
   */
  public function getCategory(){return new cArchiveCategory($this->fkCategory);}

  /**
   * Check
   *
   * @return boolean
   * @throws Exception
   */
  protected function check(){
   // check properties
   if(!strlen(trim($this->fkCategory))){throw new Exception("Document category key is mandatory..");}
   if(!strlen(trim($this->name))){throw new Exception("Document name is mandatory..");}
   // return
   return true;
  }

  /**
   * Upload
   *
   * @param mixed[] $upload Uploaded file
   * @param boolean $versioning Maintain old versions
   * @param boolean $log Log event
   * @return boolean
   */
  public function upload($upload,$versioning=true,$log=true){
   // checks parameters
   if(!api_uploads_check($upload)){throw new Exception("Upload file is mandatory..");}
   // make file
   $file=$this->id."_".date("YmdHis").".".strtolower(end((explode(".",$upload["name"]))));
   // store uploaded file
   if(!api_uploads_store($upload,"archive",$file,true)){throw new Exception("Error uploading file..");}
   // delete previous version
   if(!$versioning){api_uploads_remove("archive",$this->file);}
   // call parent
   return parent::store(["file"=>$file],$log);
  }

  /**
   * Download
   *
   * @param boolean $force_download Force download or show inline
   * @return inline|attachment|false
   */
  public function download($force_download=false){
   // checks
   if(!$this->file){return false;}
   // make header
   header("content-type:application/pdf");
   header("content-disposition:".($force_download?"attachment":"inline").";filename=\"".$this->file."\"");
   readfile(api_uploads_read("archive",$this->file));
   // terminate script
   exit();
  }

  /**
   * Edit form
   *
   * @param string[] $additional_parameters Array of url additional parameters
   * @return object Form structure
   */
  public function form_edit(array $additional_parameters=null){
   // build form
   $form=new strForm(api_url(array_merge(["mod"=>"archive","scr"=>"controller","act"=>"store","obj"=>"cArchiveDocument","idDocument"=>$this->id],$additional_parameters)),"POST",null,null,"archive_document_edit_form");
   // fields
   $form->addField("select","fkCategory",api_text("cArchiveDocument-property-fkCategory"),$this->fkCategory,api_text("cArchiveDocument-placeholder-fkCategory"),null,null,null,"required");
   foreach(cArchiveCategory::availables(true) as $house_fobj){$form->addFieldOption($house_fobj->id,$house_fobj->getLabel(true,false));}
   $form->addField("date","date",api_text("cArchiveDocument-property-date"),$this->date,null,null,null,null,"required");
   $form->addField("text","name",api_text("cArchiveDocument-property-name"),$this->name,api_text("cArchiveDocument-placeholder-name"),null,null,null,"required");
   $form->addField("textarea","description",api_text("cArchiveDocument-property-description"),$this->description,api_text("cArchiveDocument-placeholder-description"),null,null,null,"rows='2'");
   // controls
   $form->addControl("submit",api_text("form-fc-submit"));
   // return
   return $form;
  }

  /**
   * File form
   *
   * @param string[] $additional_parameters Array of url additional parameters
   * @return object Form structure
   */
  public function form_file(array $additional_parameters=null){
   // build form
   $form=new strForm(api_url(array_merge(["mod"=>"archive","scr"=>"controller","act"=>"upload","obj"=>"cArchiveDocument","idDocument"=>$this->id],$additional_parameters)),"POST",null,null,"archive_document_file_form");
   // inputs
   $form->addField("file","file",api_text("cArchiveDocument-property-file"),null,null,null,null,null,"required accept='.pdf'");
   // controls
   $form->addControl("submit",api_text("form-fc-submit"));
   // return
   return $form;
  }

  // Disable remove function
  public function remove(){throw new Exception("Document remove function disabled by developer..");}

  // debug
  //protected function event_triggered($event){api_dump($event,static::class." event triggered");}

 }

?>