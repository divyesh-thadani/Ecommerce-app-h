<?php 

class DB{ 
private $dbHost     = "localhost"; 
private $dbUsername = "root"; 
private $dbPassword = ""; 
private $dbName     = "ecommerceapp"; 
private $galleryTbl = "gallery"; 
private $imgTbl     = "gallery_images"; 
public function __construct(){ 
if(!isset($this->db)){ 
// Connect to the database 
$conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName); 
if($conn->connect_error){ 
die("Failed to connect with MySQL: " . $conn->connect_error); 
}else{ 
$this->db = $conn; 
} 
} 
} 

public function getRows($conditions = array()){ 
$sql = 'SELECT '; 
$sql .= '*, (SELECT file_name FROM '.$this->imgTbl.' WHERE gallery_id = '.$this->galleryTbl.'.id ORDER BY id DESC LIMIT 1) as default_image'; 
$sql .= ' FROM '.$this->galleryTbl; 
if(array_key_exists("where",$conditions)){ 
$sql .= ' WHERE '; 
$i = 0; 
foreach($conditions['where'] as $key => $value){ 
$pre = ($i > 0)?' AND ':''; 
$sql .= $pre.$key." = '".$value."'"; 
$i++; 
} 
} 
if(array_key_exists("order_by",$conditions)){ 
$sql .= ' ORDER BY '.$conditions['order_by'];  
}else{ 
$sql .= ' ORDER BY id DESC ';  
} 
if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
$sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];  
}elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
$sql .= ' LIMIT '.$conditions['limit'];  
} 
$result = $this->db->query($sql); 
if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){ 
switch($conditions['return_type']){ 
case 'count': 
$data = $result->num_rows; 
break; 
case 'single': 
$data = $result->fetch_assoc(); 
if(!empty($data)){ 
$sql = 'SELECT * FROM '.$this->imgTbl.' WHERE gallery_id = '.$data['id']; 
$result = $this->db->query($sql); 
$imgData = array(); 
if($result->num_rows > 0){ 
while($row = $result->fetch_assoc()){ 
$imgData[] = $row; 
} 
} 
$data['images'] = $imgData; 
} 
break; 
default: 
$data = ''; 
} 
}else{ 
if($result->num_rows > 0){ 
while($row = $result->fetch_assoc()){ 
$data[] = $row; 
} 
} 
} 
return !empty($data)?$data:false; 
} 
public function getImgRow($id){ 
$sql = 'SELECT * FROM '.$this->imgTbl.' WHERE id = '.$id; 
$result = $this->db->query($sql); 
return ($result->num_rows > 0)?$result->fetch_assoc():false; 
} 
/* 
* Insert data into the database 
* @param string name of the table 
* @param array the data for inserting into the table 
*/ 
public function insert($data){ 
if(!empty($data) && is_array($data)){ 
$columns = ''; 
$values  = ''; 
$i = 0; 
if(!array_key_exists('created',$data)){ 
$data['created'] = date("Y-m-d H:i:s"); 
} 
if(!array_key_exists('modified',$data)){ 
$data['modified'] = date("Y-m-d H:i:s"); 
} 
foreach($data as $key=>$val){ 
$pre = ($i > 0)?', ':''; 
$columns .= $pre.$key; 
$values  .= $pre."'".$this->db->real_escape_string($val)."'"; 
$i++; 
} 
$query = "INSERT INTO ".$this->galleryTbl." (".$columns.") VALUES (".$values.")"; 
$insert = $this->db->query($query); 
return $insert?$this->db->insert_id:false; 
}else{ 
return false; 
} 
} 
public function insertImage($data){ 
if(!empty($data) && is_array($data)){ 
$columns = ''; 
$values  = ''; 
$i = 0; 
if(!array_key_exists('uploaded_on',$data)){ 
$data['uploaded_on'] = date("Y-m-d H:i:s"); 
} 
foreach($data as $key=>$val){ 
$pre = ($i > 0)?', ':''; 
$columns .= $pre.$key; 
$values  .= $pre."'".$this->db->real_escape_string($val)."'"; 
$i++; 
} 
$query = "INSERT INTO ".$this->imgTbl." (".$columns.") VALUES (".$values.")"; 
$insert = $this->db->query($query); 
return $insert?$this->db->insert_id:false; 
}else{ 
return false; 
} 
} 
/* 
* Update data into the database 
* @param string name of the table 
* @param array the data for updating into the table 
* @param array where condition on updating data 
*/ 
public function update($data, $conditions){ 
if(!empty($data) && is_array($data)){ 
$colvalSet = ''; 
$whereSql = ''; 
$i = 0; 
if(!array_key_exists('modified',$data)){ 
$data['modified'] = date("Y-m-d H:i:s"); 
} 
foreach($data as $key=>$val){ 
$pre = ($i > 0)?', ':''; 
$colvalSet .= $pre.$key."='".$this->db->real_escape_string($val)."'"; 
$i++; 
} 
if(!empty($conditions)&& is_array($conditions)){ 
$whereSql .= ' WHERE '; 
$i = 0; 
foreach($conditions as $key => $value){ 
$pre = ($i > 0)?' AND ':''; 
$whereSql .= $pre.$key." = '".$value."'"; 
$i++; 
} 
} 
$query = "UPDATE ".$this->galleryTbl." SET ".$colvalSet.$whereSql; 
$update = $this->db->query($query); 
return $update?$this->db->affected_rows:false; 
}else{ 
return false; 
} 
} 
/* 
* Delete data from the database 
* @param string name of the table 
* @param array where condition on deleting data 
*/ 
public function delete($conditions){ 
$whereSql = ''; 
if(!empty($conditions)&& is_array($conditions)){ 
$whereSql .= ' WHERE '; 
$i = 0; 
foreach($conditions as $key => $value){ 
$pre = ($i > 0)?' AND ':''; 
$whereSql .= $pre.$key." = '".$value."'"; 
$i++; 
} 
} 
$query = "DELETE FROM ".$this->galleryTbl.$whereSql; 
$delete = $this->db->query($query); 
return $delete?true:false; 
} 
public function deleteImage($conditions){ 
$whereSql = ''; 
if(!empty($conditions)&& is_array($conditions)){ 
$whereSql .= ' WHERE '; 
$i = 0; 
foreach($conditions as $key => $value){ 
$pre = ($i > 0)?' AND ':''; 
$whereSql .= $pre.$key." = '".$value."'"; 
$i++; 
} 
} 
$query = "DELETE FROM ".$this->imgTbl.$whereSql; 
$delete = $this->db->query($query); 
return $delete?true:false; 
} 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    
</body>
</html>