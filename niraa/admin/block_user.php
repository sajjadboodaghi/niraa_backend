<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'requirements.php';
$response = array();

// check if the request method is POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // check if phoneNumber value is sent
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['phone_number'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phone_number'];
    
        if(!isAdmin($conn, $username, $password)) {   
            $response['error'] = true;
            $response['message'] = "اطلاعات کاربری وارد شده معتبر نیست!";
        } else {

            // change selected user status
            $updateQuery = 'UPDATE users SET status = :status WHERE phone_number = :phone_number;';
            $updateSth = $conn->prepare($updateQuery);
            $updateResult = $updateSth->execute([
                        ':status' => "blocked",
                        ':phone_number' => $phoneNumber,
                    ]);

            // if change was successful
            if($updateResult) {

                // first delete images
                $selectUserItemsQuery = 'SELECT * FROM `items` WHERE phone_number = :phoneNumber;';
                $selectUserItemsSth = $conn->prepare($selectUserItemsQuery);
                $selectUserItemsResult = $selectUserItemsSth->execute([
                    ':phoneNumber' => $phoneNumber
                ]);

                // get all user items
                $items = $selectUserItemsSth->fetchAll(PDO::FETCH_ASSOC);
                foreach ($items as $item) {
                    // for each item get image count value
                    $imageCount = $item['image_count'];
                    $itemId = $item['id'];

                    if($imageCount > 0) {
                        // delete item thumbnail
                        $thumbnail_path = "../client/images/item_" . $itemId . "_thumbnail.jpg";
                        unlink($thumbnail_path);

                        // delete item images
                        for($i = 0; $i < $imageCount; $i++) {
                            $image_path = "../client/images/item_" . $itemId . "_" . ($i+1) .".jpg";
                            unlink($image_path);
                        }
                    }
                }

                // then delete raws
                $deleteQuery = 'DELETE FROM `items` WHERE phone_number = :phone_number;';
                $deleteSth = $conn->prepare($deleteQuery);
                $deleteResult = $deleteSth->execute([
                            ':phone_number' => $phoneNumber
                        ]);

                if($deleteResult) {
                    $response['error'] = false;
                    $response['message'] = "حساب کاربری با موفقیت مسدود شد.";
                } else {
                    $response['error'] = true;
                    $response['message'] = "مشکلی در مسدود کردن حساب کاربری به وجود آمده است!";    
                }
            } else {
                $response['error'] = true;
                $response['message'] = "مشکلی در مسدود کردن حساب کاربری به وجود آمده است!";
            }
            
        }

    } else {
        $response['error'] = true;
        $response['message'] = "اطلاعات مورد نیاز ارسال نشده است!";
    }

} else {
    $response['error'] = true;
    $response['message'] = "درخواست نامعتبر است!";
}

$conn = null;

echo json_encode($response);
