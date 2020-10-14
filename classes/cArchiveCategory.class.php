<?php
/**
 * Archive - Category
 *
 * @package Coordinator\Modules\Archive
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Archive Category class
  */
 class cArchiveCategory extends cObject{

  /** Parameters */
  static protected $table="archive__categories";
  static protected $logs=false;

  /** Properties */
  protected $id;
  protected $deleted;
  protected $name;
  protected $title;
  protected $color;

  /**
   * Check
   *
   * @return boolean
   * @throws Exception
   */
  protected function check(){
   // check properties
   if(!strlen(trim($this->name))){throw new Exception("Category name is mandatory..");}
   if(!strlen(trim($this->color))){throw new Exception("Category color is mandatory..");}
   // return
   return true;
  }

  /**
   * Get Label
   *
   * @param boolean $dot Show colored dot
   * @return string|false Category label
   */
  public function getLabel($title=true,$dot=true){
   if(!$this->exists()){return false;}
   // make label
   $label=$this->name;
   if($dot){$label=$this->getDot()." ".$label;}
   if($title && $this->title){$label.=" (".$this->title.")";}
   // return
   return $label;
  }

  /**
   * Get Dot
   *
   * @return string|false Colored dot
   */
  public function getDot(){
   if(!$this->exists()){return false;}
   return api_tag("span",api_icon("fa-circle",$this->getLabel(true,false)),null,"color:".$this->color);
  }

  /**
   * Get Documents
   *
   * @return objects[] Documents array
   */
  public function getDocuments(){return cArchiveDocument::availables(true,["fkCategory"=>$this->id]);}

  /**
   * Edit form
   *
   * @param string[] $additional_parameters Array of url additional parameters
   * @return object Form structure
   */
  public function form_edit(array $additional_parameters=null){
   // build form
   $form=new strForm(api_url(array_merge(["mod"=>"archive","scr"=>"controller","act"=>"store","obj"=>"cArchiveCategory","idCategory"=>$this->id],$additional_parameters)),"POST",null,null,"archive_category_edit_form");
   // fields
   $form->addField("text","name",api_text("cArchiveCategory-property-name"),$this->name,api_text("cArchiveCategory-placeholder-name"),null,null,null,"required");
   $form->addField("text","title",api_text("cArchiveCategory-property-title"),$this->title,api_text("cArchiveCategory-placeholder-title"));
   $form->addField("color","color",api_text("cArchiveCategory-property-color"),($this->color?$this->color:api_random_color()),null,3,null,null,"required");
   // controls
   $form->addControl("submit",api_text("form-fc-submit"));
   // return
   return $form;
  }

  /**
   * Remove
   *
   * @return boolean|exception
   */
  public function remove(){
   // check if category is empty
   if(count($this->getDocuments())){
    // exception if not empty
    throw new Exception("Category remove function denied if not empty..");
   }else{
    // remove category
    return parent::remove();
   }
  }

  // debug
  //protected function event_triggered($event){api_dump($event,static::class." event triggered");}

 }

?>