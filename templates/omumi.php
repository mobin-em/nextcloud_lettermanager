<?php
style('lettermanager', 'omumi');
?>

<div class="lettermanager-type1-content">
    <h2>افزودن نامه جدید</h2>

    <form action="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.submitGeneralForm')); ?>" method="POST" class="new-letter-form">
        <input type="hidden" name="type5" value="<?php echo htmlspecialchars($type5); ?>">
        
        <div class="form-field">
            <label for="letter_number" class="form-label">شماره نامه:</label>
            <input type="text" id="letter_number" name="letter_number" value="<?php echo htmlspecialchars($GeneralLetterNumber); ?>" readonly>
        </div>
        
         <div class="form-field title-field">
    <label class="form-label" for="title">عنوان نامه:</label>
    <input type="text" id="title" name="title">
</div>
        
        <button type="submit">افزودن نامه</button>
    </form>
</div>
