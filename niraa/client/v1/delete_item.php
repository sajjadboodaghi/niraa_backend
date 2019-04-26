<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phoneNumber']) && isset($_POST['token'])) {
        $phoneNumber = $_POST['phoneNumber'];
        $token = $_POST['token'];

        if(userExists($conn, $phoneNumber, $token)) {
            if(isset($_POST['itemId'])) {
                $itemId = $_POST['itemId'];

                $findItemQuery = 'SELECT * FROM `items` WHERE id = :itemId AND phone_number = :phoneNumber;';
                $findItemSth = $conn->prepare($findItemQuery);
                $findItemResult = $findItemSth->execute([
                    ':itemId' => $itemId,
                    ':phoneNumber' => $phoneNumber
                ]);

                if($findItemResult == true) {
                    $imageCount = $findItemSth->fetch(PDO::FETCH_ASSOC)['image_count'];

                    $deleteItemQuery = 'DELETE FROM `items` WHERE id = :itemId AND phone_number = :phoneNumber;';
                    $deleteItemSth = $conn->prepare($deleteItemQuery);
                    $deleteItemResult = $deleteItemSth->execute([
                        ':itemId' => $itemId,
                        ':phoneNumber' => $phoneNumber
                    ]);

                    if($deleteItemResult) {
                        if($imageCount > 0) {
                            $thumbnail_path = "../images/item_" . $itemId . "_thumbnail.jpg";
                            unlink($thumbnail_path);

                            for($i = 0; $i < $imageCount; $i++) {
                                $image_path = "../images/item_" . $itemId . "_" . ($i+1) .".jpg";
                                unlink($image_path);
                            }
                        }

                        $response['error'] = false;
                        $response['message'] = 'حذف آگهی با موفقیت انجام شد.';
                    } else {
                        $response['error'] = true;
                        $response['message'] = 'متأسفانه مشکلی در حذف آگهی به وجود آمد!';
                    }
                }   else {
                        $response['error'] = true;
                        $response['message'] = 'آگهی انتخاب شده برای حذف پیدا نشد!!';
                }
                
            } else {
                $response['error'] = true;
                $response['message'] = 'اطلاعات لازم برای حذف آگهی داده نشده است!';
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
