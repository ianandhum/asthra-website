<?php
//a lightweight media CDN class
//currently Media supports only Image Extensions
//svg typw is not supported
//@anandhuManoj
require_once("config.php");
class Media{
	private $IMG_DIR="asthra_login/assets/img/";
	private $dbConn=null;
	private $mediaTable=RESOURCE_DB_MEDIA_TABLE;
	public function __construct(){
		$db=new DB(RESOURCE_DB_NAME);
		$this->dbConn=$db->dbConnection();
	}
	//okk
	public function getResourceData($id) {
			if($id==null) {
				return false;	
			}
			$stmt=$this->dbConn->prepare("SELECT * FROM " .$this->mediaTable. " WHERE refId=:id ");
			try{
				$res=$stmt->execute(array(":id"=>$id));			
			}
			catch(\Exception $e){
				$res=false;				
			}
			if($res) {
				$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
				return $dataRow;  			
			}
			return false;
			
	}
	//not tried
	public function indexImages() {
		foreach (new DirectoryIterator(IMG_DIR) as $file) {
  			if ($file->isFile()) {
  				$type=FALSE;
  				if(function_exists("exif_imagetype")) {
					$type=exif_imagetype(IMG_DIR.$file->getFileName());				
  				}
   	   	if($type!=FALSE){
   	   		
   			}
  			}
		}	
	}
	//heavily buggy 
	public function getImage($id){
		$img=$this->getResourceData($id);
		if(!is_array($img)) {
			return false;		
		}
		header("Content-Type:image/jpeg");
		header("Content-Type:image/jpeg");
		readfile($img['path']);	
	}
		
};
	
?>
