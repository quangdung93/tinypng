<?php 

@ini_set('display_errors', 1);
@ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@ini_set('max_execution_time', 600);
require_once("vendor/autoload.php");

function compressTinyPNG($image_path, $new_image_path){

	try {
		\Tinify\setKey("wOjRwv3XkefTFnX3WKVLRZHjmsHGeSY0");
		\Tinify\validate();
		$directory = $image_path;
		$images = glob($directory . "/*.{jpg,png,jpeg,JPG,PNG,JPEG}", GLOB_BRACE);
		$number = 0;
		$output = "";

		foreach($images as $image)
		{
			$number ++;
			$new_image = str_replace($image_path,$new_image_path,$image);
			$source = \Tinify\fromFile($image);
			$source->toFile($new_image);
		  	$output .= $new_image."<br>";
		}

		$compressionsThisMonth = \Tinify\compressionCount();
		$output .= "Compressed ".$number." images<br> You have total compressed ".$compressionsThisMonth." images from tinyPNG";
		return $output;

	} catch(\Tinify\AccountException $e) {
	  print("Error:Account / The error message is: " . $e.getMessage());
	  // Lỗi như không thể xác thực API key hay lỗi vượt quá hạn mức tối ưu.
	} catch(\Tinify\ClientException $e) {
		print("Error:Client / The error message is: " . $e.getMessage());
		// Lỗi này phát sinh khi không thể submit ảnh từ máy khách lên.
	} catch(\Tinify\ServerException $e) {
		print("Error:Server / The error message is: " . $e.getMessage());
	    // Lỗi phát sinh khi máy chủ API của TinyPNG đang gặp lỗi.
	} catch(\Tinify\ConnectionException $e) {
		print("Error:Connection / The error message is: " . $e.getMessage());
	    // Lỗi phát sinh khi truyền dữ liệu ảnh qua đường truyền.
	} catch(Exception $e) {
		print("Error Other / The error message is: " . $e.getMessage());
	    // Something else went wrong, unrelated to the Tinify API.
	}
}

$result = compressTinyPNG('compress','compress/output');
echo $result;





// echo "All Images Compressed, You have compressed ".$compressionsThisMonth." photos";