<?php
style('lettermanager', 'type1');
?>

<div class="lettermanager-type1-content">
    <h2>نامه‌های نوع ۱</h2>
    
    <!-- فرم برای افزودن نامه جدید -->
    <div class="new-letter-form">
        <form method="post" action="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.submitType1Form')); ?>">
            <div class="form-field">
                <label for="letter_number" class="form-label">شماره نامه:</label>
                <input type="text" id="letter_number" name="letter_number" value="<?php p($nextLetterNumber); ?>" readonly>
            </div>
            <div class="form-field">
                <label for="title" class="form-label">عنوان:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <button type="submit">افزودن نامه</button>
        </form>
    </div>

    <!-- جدول برای نمایش لیست نامه‌ها -->
    <table>
        <tr>
            <th>شماره نامه</th>
            <th>عنوان</th>
        </tr>
        <?php foreach ($letters as $letter): ?>
            <tr>
                <td><?php p($letter['letter_number']); ?></td>
                <td><?php p($letter['title']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
