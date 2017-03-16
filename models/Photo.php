<?php 
	class Photo{
		const SHOW_BY_DEFAULT = 2;
		const MAX_SIZE = 2000000;
		const UPLOAD_DIR = './photos';

		public static function getPhotoList($page = 1){

			$page = intval($page);

			$offset = ($page - 1)*self::SHOW_BY_DEFAULT;

			$db = Db::getConnection();
			$photos = array();

			$result = $db->query('
				SELECT* FROM photos
				LIMIT '.self::SHOW_BY_DEFAULT.'
				OFFSET '.$offset
			);

			$i = 0;
			while($row = $result->fetch()){
				$photos[$i]['id'] = $row['id'];
				$photos[$i]['name'] = $row['name'];
				$photos[$i]['size'] = $row['size'];
				$photos[$i]['width'] = $row['width'];
				$photos[$i]['height'] = $row['height'];
				$photos[$i]['widthS'] = $row['widthS'];
				$photos[$i]['heightS'] = $row['heightS'];
				$photos[$i]['date'] = $row['date'];
				$photos[$i]['description'] = $row['description'];
				++$i;
			}
			return $photos;

		}

		public static function calcCount($array){
			$count = 0;
			foreach ($array as $key => $value) {
				$count++;
			}
			return $count;
		}

		public static function addPhotoInDB($photoData){
			if(is_array($photoData)){
				$db = Db::getConnection();

				$result = $db->query("
					INSERT INTO photos SET
					`name` = '".$photoData['path']."',
					`description` = '".$photoData['description']."',
					`width` = '".$photoData['width']."',
					`height` = '".$photoData['height']."',
					`widthS` = '".$photoData['widthS']."',
					`heightS` = '".$photoData['heightS']."',
					`size` = '".$photoData['size']."',
					`date` = NOW()

				");
				return $db->lastInsertId();
			}
		}

		public static function editDescription($id, $description){
			$db = Db::getConnection();

			$sql = 'UPDATE photos SET description ='.$db->quote($description).' WHERE id = :id';

			$result = $db->prepare($sql);
			$result->bindParam(':id', $id, PDO::PARAM_INT);

			return $result->execute();
		}

		public static function getTotalPhotos(){
			$db = Db::getConnection();
			$result = $db->query('SELECT count(id) AS count FROM photos');
			$row = $result->fetch();
			
			return $row['count'];
		}

		public static function checkErrorPhoto($error){
			if($error == 0){
				return true;
			}
			return false;
		}

		public static function checkSizePhoto($size, $maxSize = self::MAX_SIZE){
			if($size <= $maxSize){
				return true;
			}
			return false;
		}

		public static function checkExpension($expensionArray, $expension){
			foreach ($expensionArray as $k => $v) {
				if($v == $expension){
					return true;
				}
			}
			return false;
		}

		public static function resizeImage($width = 200,$height = 200,$w_orig,$h_orig){
			if($w_orig > $h_orig){
				$height = ($h_orig*$width)/$w_orig;
			}elseif($h_orig > $w_orig){
				$width = ($w_orig * $height)/$h_orig;
			}
			$newSize = array('width' => $width,'height' => $height);
			return $newSize;
		}

		public static function convertInMb($byte){
			return round(($byte/1000000), 2);
		}

		public static function deletePhoto($id){
			$db = Db::getConnection();

			$sql = 'DELETE FROM photos WHERE id = :id';

			$result = $db->prepare($sql);
			$result->bindParam(':id', $id, PDO::PARAM_INT);

			return $result->execute();
		}
	}
?>