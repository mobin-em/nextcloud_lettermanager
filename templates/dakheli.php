<?php
style('lettermanager', 'dakheli');
?>

<div class="lettermanager-type1-content">
    <h2>افزودن نامه جدید</h2>

    <form action="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.submitTypeForm')); ?>" method="POST" class="new-letter-form">
        <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
        
        <div class="form-field">
            <label for="letter_number" class="form-label">شماره نامه:</label>
            <input type="text" id="letter_number" name="letter_number" value="<?php echo htmlspecialchars($initialLetterNumber); ?>" readonly>
        </div>
        
        <div class="form-field title-field">
    <label class="form-label" for="title">عنوان نامه:</label>
    <input type="text" id="title" name="title">
</div>
        
        <button type="submit">افزودن نامه</button>
    </form>
</div>

<!-- فایل CSS را در اینجا لینک کنید -->
<link rel="stylesheet" href="styles.css">

<!-- اضافه کردن اسکریپت برای متحرک‌سازی متن -->
<script>
document.getElementById('title').addEventListener('input', function() {
    this.scrollLeft = this.scrollWidth;
});
</script>
