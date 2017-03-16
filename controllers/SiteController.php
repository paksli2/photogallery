<?php
	
	class SiteController{

		public function actionIndex($page = 1){

			$photos = array();
			$photos = Photo::getPhotoList($page);
			$total = Photo::getTotalPhotos();
			$pagination = new Pagination($total, $page, Photo::SHOW_BY_DEFAULT, 'page-');
			require_once(ROOT.'/views/site/index.php');
			return true;
		}

		public function actionPaginate($page = 1){

			$photos = array();
			$photos = Photo::getPhotoList($page);
			$total = Photo::getTotalPhotos();
			$pagination = new Pagination($total, $page, Photo::SHOW_BY_DEFAULT, 'page-');
			$toJS = $photos;
			$toJS['paginator'] = $pagination->get();
			$toJS['count'] = Photo::calcCount($photos);
			echo json_encode($toJS);
			return true;
		}

		public function actionAddPhoto(){
			if(isset($_POST['description'], $_FILES['file']['name'])){
				$expensions = array('image/gif','image/jpeg','image/png','image/jpg');
				$error = false;
				$imgInfo = getimagesize($_FILES['file']['tmp_name']);//Get size(width , height) and type of image*******
				$expension = basename($imgInfo['mime']);
				$path = Photo::UPLOAD_DIR.'/'.date('Ymd-His').'img'.rand(1000,999999).'.'.$expension;
				if(!Photo::checkErrorPhoto($_FILES['file']['error'])){
					$error[] = 'Error in upload photo';
				}

				if(!Photo::checkExpension($expensions, $imgInfo['mime'])){
					$error[] = 'Invalid expension '.$imgInfo['mime'].' Choise expensions(jpg,png,gif) and try again';
				}

				if(!Photo::checkSizePhoto($_FILES['file']['size'])){
					$error[] = 'File is too large(max size) '.Photo::MAX_SIZE.' bytes';
				}

				

				if($error == false){
					if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
					// get small size for view small photo
						$newSize = Photo::resizeImage(200, 200, $imgInfo[0], $imgInfo[1]);

						// write valid photo data in array
						$photoData = array();
						$photoData['description'] = $_POST['description'];
						$photoData['expension'] = $expension;
						$photoData['size'] = Photo::convertInMb($_FILES['file']['size']);
						$photoData['width'] = $imgInfo[0];
						$photoData['height'] = $imgInfo[1];
						$photoData['widthS'] = $newSize['width'];
						$photoData['heightS'] = $newSize['height'];
						$photoData['text'] = 'Photo has been added';
						$photoData['date'] = time();
						$photoData['path'] = $path;
						$photoData['error'] = 0;
						$id = Photo::addPhotoInDB($photoData);
						$photoData['id'] = $id;
					}
				}else{
					$photoData = array();
					$photoData = $error;
				}

				echo json_encode($photoData);
			}
			return true;
		}

		public function actionDeletePhoto($id){
			$id = intval($id);
			if($id && isset($_POST['path'])){
				$delete = unlink($_POST['path']);
				if(Photo::deletePhoto($id) && $delete){
					$message = 'Photo deleted';
					echo $message;
				}

			}

			return true;
		}

		public function actionEditDescription($id){
			$id = intval($id);
			if($id && isset($_POST['desc'])){
				if(Photo::editDescription($id, $_POST['desc'])){
					$message = 'Description updated!';
					echo $message;
				}
			}

			return true;
		}


	}


?>