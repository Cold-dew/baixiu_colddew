<?php 
$file=$_FILES["file"];

$fileName=time().strrchr($file['name'],".");
$bool=move_uploaded_file($file["tmp_name"],"../../static/uploads/".$fileName);

$response=["code"=>0,"msg"=>"失败"];
if($bool){
    $response["code"]=1;
    $response["msg"]="成功";
    $response['src']="/static/uploads/" . $fileName;
}
header("content-type:application/json");
echo json_encode($response);
?>