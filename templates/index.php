<?php
style('lettermanager', 'style');
?>

<div class="lettermanager-content">
    <h1>مدیریت نامه‌ها</h1>
	
    <div class="letter-types">
        <h2>داخلی</h2>
        <ul class="button-group">
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showTypeForm', ['type' => 'response'])); ?>">پاسخ</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showTypeForm', ['type' => 'initial'])); ?>">آغازین</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showTypeForm', ['type' => 'follow-up'])); ?>">پیگیری</a></li>
        </ul>
    </div>

    <div class="letter-types">
        <h2>بازاریابی</h2>
        <ul class="button-group">
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showMarketingForm', ['type2' => 'response2'])); ?>">پاسخ</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showMarketingForm', ['type2' => 'initial2'])); ?>">آغازین</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showMarketingForm', ['type2' => 'follow-up2'])); ?>">پیگیری</a></li>
        </ul>
    </div>
	
	<div class="letter-types">
        <h2>مالی</h2>
        <ul class="button-group">
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showFinanceForm', ['type3' => 'response3'])); ?>">پاسخ</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showFinanceForm', ['type3' => 'initial3'])); ?>">آغازین</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showFinanceForm', ['type3' => 'follow-up3'])); ?>">پیگیری</a></li>
        </ul>
    </div>
	
	<div class="letter-types">
        <h2>حقوقی</h2>
        <ul class="button-group">
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showLegalForm', ['type4' => 'response4'])); ?>">پاسخ</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showLegalForm', ['type4' => 'initial4'])); ?>">آغازین</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showLegalForm', ['type4' => 'follow-up4'])); ?>">پیگیری</a></li>
        </ul>
    </div>
	
	<div class="letter-types">
        <h2>عمومی</h2>
        <ul class="button-group">
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showGeneralForm', ['type5' => 'response5'])); ?>">پاسخ</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showGeneralForm', ['type5' => 'initial5'])); ?>">آغازین</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showGeneralForm', ['type5' => 'follow-up5'])); ?>">پیگیری</a></li>
        </ul>
    </div>
	
	<div class="letter-types">
        <h2>فنی</h2>
        <ul class="button-group">
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showTechnicalForm', ['type6' => 'response6'])); ?>">پاسخ</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showTechnicalForm', ['type6' => 'initial6'])); ?>">آغازین</a></li>
            <li><a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('lettermanager.page.showTechnicalForm', ['type6' => 'follow-up6'])); ?>">پیگیری</a></li>
        </ul>
    </div>
</div>