<?php
style('lettermanager', 'dakheli');
?>

<div class="lettermanager-type1-content">
    <h2>دانلود نامه</h2>

    <p>برای دانلود فایل ورد نامه، روی لینک زیر کلیک کنید:</p>

    <a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.downloadFile', ['letter_number' => $letter_number, 'title' => $title])); ?>" class="download-link">دانلود نامه</a>
</div>
