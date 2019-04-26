<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'jdf.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_user_exists.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function_waiting_items_count.php';

$response = array();
$response['error_name'] = 'nothing';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phoneNumber'];
        $token = $_POST['token'];
        
        if(userExists($conn, $phoneNumber, $token)) {
            if(waitingItemsCount($conn, $phoneNumber) < 3) {
                if(isset($_POST['title']) && isset($_POST['description'])) {
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    if(trim($title, ' ') != "" && trim($description, ' ') != "") {
                        $telegramId = isset($_POST['telegramId']) ? $_POST['telegramId'] : "";
                        $price = isset($_POST['price']) ? $_POST['price'] : "";
                        $place = isset($_POST['place']) ? $_POST['place'] : "رامسر";
                        $subcat_name = isset($_POST['subcat_name']) ? $_POST['subcat_name'] : "";
                        $subcat_id = isset($_POST['subcat_id']) ? $_POST['subcat_id'] : "";
                        $imageCount = isset($_POST['imageCount']) ? $_POST['imageCount'] : 0;
                        $insertQuery = 'INSERT INTO `items`(`phone_number`, `telegram_id`, `title`, `description`, `price`, `place`, `subcat_name`, `subcat_id`, `shamsi`, `timestamp`, `image_count`) VALUES (:phone_number, :telegramId, :title, :description, :price, :place, :subcat_name, :subcat_id, :shamsi, :timestamp, :image_count);';
                        $insertSth = $conn->prepare($insertQuery);
                        $result = $insertSth->execute([
                            ':phone_number' => $phoneNumber,
                            ':telegramId' => $telegramId,
                            ':title' => $title,
                            ':description' => $description,
                            ':price' => $price,
                            ':place' => $place,
                            ':subcat_name' => $subcat_name,
                            ':subcat_id' => $subcat_id,
                            ':shamsi' => jdate('y/m/d H:i'),
                            ':timestamp' => time(),
                            ':image_count' => $imageCount
                        ]);
                        if($result) {
                            $id = $conn->lastInsertId();
                            if($imageCount > 0) {
                                for($i = 0; $i < $imageCount; $i++) {
                                    $upload_image_path = "../images/item_" . $id . "_" . ($i+1) .".jpg";
                                    $image = $_POST['image_' . ($i+1)];
                                    file_put_contents($upload_image_path, base64_decode($image));
                                }
                                $imageThumbnail = $_POST['image_thumbnail'];
                                $upload_thumbnail_path =  "../images/item_" . $id . "_thumbnail.jpg";
                                file_put_contents($upload_thumbnail_path, base64_decode($imageThumbnail));
                            }
                            
                            $response['error'] = false;
                            $response['message'] = 'آگهی با موفقیت ثبت شد (پس از تایید نمایش داده می‌شود)';
                        } else {
                            $response['error'] = true;
                            $response['message'] = 'متأسفانه مشکلی در ثبت آگهی به وجود آمد!';
                        }
                    } else {
                        $response['error'] = true;
                        $response['message'] = 'بخش عنوان و توضیحات نمی‌توانید خالی رها شوند!';
                    }
                } else {
                    $response['error'] = true;
                    $response['message'] = 'درج عنوان و توضیحات اجباری است!';
                }
            } else {
                $response['error'] = true;
                $response['error_name'] = 'has_waiting_item';
                $response['message'] = 'نمی‌توانید همزمان بیشتر از 3 آگهی تأیید نشده داشته باشید! تا تأیید شدن آگهی‌های قبلی شکیبا باشید.';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'اطلاعات کاربری داده شده معتبر نیست!';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات کاربری داده نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);
