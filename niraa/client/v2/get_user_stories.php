<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'connect_to_db.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'user_exists.php';

$response = array();


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['phone_number']) && isset($_POST['token']) && isset($_POST['status'])) {
        $phoneNumber = $_POST['phone_number'];
        $token = $_POST['token'];
        $status = $_POST['status'];
    
        if(userExists($conn, $phoneNumber, $token)) {
            $selectStoriesQuery = "SELECT id, phone_number FROM stories WHERE phone_number = :phone_number AND status = :status ORDER BY timestamp DESC";
            $selectStoriesSth = $conn->prepare($selectStoriesQuery);
            $selectStoriesSth->execute([
                ":phone_number" => $phoneNumber,
                ":status" => $status
            ]);
            $userStories = $selectStoriesSth->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;
            
            $response['error'] = false;
            $response[$status . '_user_stories'] = $userStories;
            $response['rules'] = "شرایط و قوانین\n۱- هر تبلیغ از یک تصویر کوچک و یک تصویر بزرگ تشکیل شده است که تصویر کوچک در بالای صفحه (تنها در حالت عمودی) ظاهر می‌شود و با لمس آن، تصویر بزرگ نمایش داده خواهد شد.\n۲- مدت نمایش تبلیغ و همین‌طور هزینه‌ی درج آن ثابت نیست و در آینده ممکن است تغییر کند اما در حال حاضر هر تبلیغ به مدت 24 ساعت نمایش داده می‌شود و هزینه‌ی انتشار آن 10 هزار تومان است.\n۳- تبلیغ‌های جدید جلوتر از تبلیغ‌های قدیمی قرار می‌گیرند و تبلیغ‌های قدیمی با پر شدن فضا، از دید خارج می‌شوند که البته در این صورت، با پیمایش بخش تبلیغات به سمت راست، می‌توان دوباره آن‌ها را مشاهده کرد.\n۴- انتشار تبلیغ به تأیید ما نیاز ندارد اما نیرا اجازه دارد که تبلیغ‌هایی را که از نظر قانونی یا اخلاقی نامناسب تشخیص می‌دهد، بدون اطلاع درج کننده‌ی آن و بدون عودت هزینه تبلیغ، حذف نماید.";

        } else {
            $response['error'] = true;
            $response['message'] = 'اطلاعات کاربری داده شده معتبر نیست!';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'اطلاعات لازم داده نشده است!';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'درخواست ارسال شده معتبر نیست!';
}

$conn = null;

echo json_encode($response);
