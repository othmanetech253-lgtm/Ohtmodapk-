<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uploads_dir = __DIR__ . '/uploads/';
    $images_dir = __DIR__ . '/images/';

    if (!file_exists($uploads_dir)) mkdir($uploads_dir, 0777, true);
    if (!file_exists($images_dir)) mkdir($images_dir, 0777, true);

    $icon = $_FILES['appIcon'] ?? null;
    $apk = $_FILES['appApk'] ?? null;
    $app_name = $_POST['app_name'] ?? 'New App';
    $app_desc = $_POST['app_desc'] ?? '';

    if ($icon && $apk) {
        $icon_file = $images_dir . basename($icon['name']);
        $apk_file = $uploads_dir . basename($apk['name']);

        if (move_uploaded_file($icon['tmp_name'], $icon_file) &&
            move_uploaded_file($apk['tmp_name'], $apk_file)) {

            $new_app = array(
                "name" => $app_name,
                "category" => "modded",
                "desc" => $app_desc,
                "icon" => 'images/' . basename($icon['name']),
                "apk" => 'uploads/' . basename($apk['name']),
                "uploaded_at" => date("c")
            );

            $line = json_encode($new_app, JSON_UNESCAPED_UNICODE);
            file_put_contents("apps.json", $line . "\n", FILE_APPEND | LOCK_EX);

            echo "تم رفع التطبيق بنجاح!";
        } else {
            echo "حدث خطأ أثناء رفع الملفات.";
        }
    } else {
        echo "لم يتم اختيار الملفات!";
    }
} else {
    echo "الرجاء استخدام POST لرفع التطبيق.";
}
?>