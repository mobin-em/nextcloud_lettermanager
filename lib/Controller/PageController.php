<?php
declare(strict_types=1);

namespace OCA\Lettermanager\Controller;

require '/var/www/html/apps-extra/lettermanager/vendor/autoload.php';
use OCA\Lettermanager\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\FrontpageRoute;
use OCP\IRequest;
use OCP\IDBConnection;
use OCP\IURLGenerator;
use OCP\AppFramework\Http\RedirectResponse;
use PhpOffice\PhpWord\TemplateProcessor;
use OCP\ILogger;
use OCP\IUserSession;
use jDateTime;

class PageController extends Controller {
    private IDBConnection $db;
    private IURLGenerator $urlGenerator;
    private ILogger $logger;
    private IUserSession $userSession;

    public function __construct(IRequest $request, IDBConnection $db, IURLGenerator $urlGenerator, ILogger $logger, IUserSession $userSession) {
        parent::__construct(Application::APP_ID, $request);
        $this->db = $db;
        $this->urlGenerator = $urlGenerator;
        $this->logger = $logger;
        $this->userSession = $userSession;
    }

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/')]
    public function index(): TemplateResponse {
        return new TemplateResponse(Application::APP_ID, 'index');
    }

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/dakheli')]
    public function showTypeForm(string $type): TemplateResponse {
        $initialLetterNumber = $this->getNextLetterNumber($type);
        return new TemplateResponse(Application::APP_ID, 'dakheli', [
            'type' => $type,
            'initialLetterNumber' => $initialLetterNumber
        ]);
    }

    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/bazaryabi')]
    public function showMarketingForm(string $type2): TemplateResponse {
        $marketingLetterNumber = $this->getNextMarketingLetterNumber($type2);
        return new TemplateResponse(Application::APP_ID, 'bazaryabi', [
            'type2' => $type2,
            'marketingLetterNumber' => $marketingLetterNumber
        ]);
    }
	
    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/mali')]
    public function showFinanceForm(string $type3): TemplateResponse {
        $financeLetterNumber = $this->getNextFinanceLetterNumber($type3);
        return new TemplateResponse(Application::APP_ID, 'mali', [
            'type3' => $type3,
            'financeLetterNumber' => $financeLetterNumber
        ]);
    }
	
	#[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/hoquqi')]
    public function showLegalForm(string $type4): TemplateResponse {
        $LegalLetterNumber = $this->getNextLegalLetterNumber($type4);
        return new TemplateResponse(Application::APP_ID, 'hoquqi', [
            'type4' => $type4,
            'LegalLetterNumber' => $LegalLetterNumber
        ]);
    }
	
	#[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/omumi')]
    public function showGeneralForm(string $type5): TemplateResponse {
        $GeneralLetterNumber = $this->getNextGeneralLetterNumber($type5);
        return new TemplateResponse(Application::APP_ID, 'omumi', [
            'type5' => $type5,
            'GeneralLetterNumber' => $GeneralLetterNumber
        ]);
    }
	
	#[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'GET', url: '/fani')]
    public function showTechnicalForm(string $type6): TemplateResponse {
        $TechnicalLetterNumber = $this->getNextTechnicalLetterNumber($type6);
        return new TemplateResponse(Application::APP_ID, 'fani', [
            'type6' => $type6,
            'TechnicalLetterNumber' => $TechnicalLetterNumber
        ]);
    }
	
#[NoCSRFRequired]
#[NoAdminRequired]
#[FrontpageRoute(verb: 'GET', url: '/downloadFile')]
public function downloadFile(string $letter_number, string $title): void {
    try {
        // مسیر الگوی Word را تنظیم کنید
        $templatePath = __DIR__ . '/../../word/template.docx';
        
        // بررسی وجود فایل
        if (!file_exists($templatePath)) {
            throw new \Exception('فایل الگو یافت نشد');
        }

        // ساخت TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);
        // افزودن تاریخ شمسی به فایل
        $jalaliDate = jDateTime::strftime('%Y/%m/%d', time()); // گرفتن تاریخ شمسی
        $templateProcessor->setValue('jalali_date', $jalaliDate);

        // پر کردن قالب با داده‌ها
        $templateProcessor->setValue('letter_number', htmlspecialchars($letter_number, ENT_QUOTES, 'UTF-8'));
        $templateProcessor->setValue('title', htmlspecialchars($title, ENT_QUOTES, 'UTF-8'));

        // تولید نام فایل
        $fileName = 'Letter_' . $letter_number . '.docx';

        // مسیر برای ذخیره فایل موقت
        $tempFilePath = sys_get_temp_dir() . '/' . $fileName;

        // ذخیره فایل موقت در مسیر موقت
        $templateProcessor->saveAs($tempFilePath);

        // هدر‌های لازم برای دانلود فایل
        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Transfer-Encoding: binary");
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header("Content-Length: " . filesize($tempFilePath));

        // پاکسازی بافر
        ob_clean();
        flush();
        
        // خواندن فایل و ارسال به مرورگر
        readfile($tempFilePath);
        
        // حذف فایل موقت بعد از دانلود
        unlink($tempFilePath);

        // تنظیم علامت هدایت به صفحه اصلی در جلسه
        session_start();
        $_SESSION['redirect_to_home'] = true;

        // هدایت به صفحه اصلی بعد از دانلود
        header("Location: /index.php/apps/lettermanager");
        exit();

    } catch (\Exception $e) {
        // لاگ کردن خطا در صورت بروز مشکل
        $this->logger->logException($e, ['context' => 'خطا در دانلود فایل']);

        // حذف فایل موقت در صورت بروز خطا
        if (file_exists($tempFilePath)) {
            unlink($tempFilePath);
        }

        // هدایت به صفحه اصلی در صورت بروز خطا
        header("Location: " . $this->urlGenerator->linkToRoute('lettermanager.page.index'));
        exit(); // توقف اسکریپت بعد از هدایت
    }
}


    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'POST', url: '/dakheli/submit')]
    public function submitTypeForm(): RedirectResponse {
        $type = $this->request->getParam('type', '');
        $prefix = $this->getPrefixForType($type);
        $title = $this->request->getParam('title');
        $letterNumber = $this->request->getParam('letter_number');
        $author = $this->userSession->getUser()->getUID();

        try {
            $insertQuery = 'INSERT INTO dakheli (letter_number, title, date, time, author) VALUES (?, ?, CURDATE(), CURTIME(), ?)';
            $this->db->executeQuery($insertQuery, [$letterNumber, $title, $author]);
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.downloadFile', [
                'letter_number' => $letterNumber,
                'title' => $title
            ]));
        } catch (\Exception $e) {
            $this->logger->logException($e, ['context' => 'خطا در ذخیره نامه']);
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.index'));
        }
    }
	
	#[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'POST', url: '/bazaryabi/submit')]
    public function submitMarketingForm(): RedirectResponse {
        $type2 = $this->request->getParam('type2', '');
        $prefix2 = $this->getPrefixForType($type2);
        $title = $this->request->getParam('title');
        $letterNumber = $this->request->getParam('letter_number');
        $author = $this->userSession->getUser()->getUID();

        try {
            $insertQuery = 'INSERT INTO bazaryabi (letter_number, title, date, time, author) VALUES (?, ?, CURDATE(), CURTIME(), ?)';
            $this->db->executeQuery($insertQuery, [$letterNumber, $title, $author]);
			
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.downloadFile', [
                'letter_number' => $letterNumber,
                'title' => $title
            ]));
        } catch (\Exception $e) {
            $this->logger->logException($e, ['context' => 'خطا در ذخیره نامه']);
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.index'));
        }
    }
	
    #[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'POST', url: '/mali/submit')]
    public function submitFinanceForm(): RedirectResponse {
        $type3 = $this->request->getParam('type3', '');
        $prefix3 = $this->getPrefixForType($type3);
        $title = $this->request->getParam('title');
        $letterNumber = $this->request->getParam('letter_number');
        $author = $this->userSession->getUser()->getUID();

        try {
            $insertQuery = 'INSERT INTO mali (letter_number, title, date, time, author) VALUES (?, ?, CURDATE(), CURTIME(), ?)';
            $this->db->executeQuery($insertQuery, [$letterNumber, $title, $author]);

            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.downloadFile', [
                'letter_number' => $letterNumber,
                'title' => $title
            ]));
        } catch (\Exception $e) {
            $this->logger->logException($e, ['context' => 'خطا در ذخیره نامه']);
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.index'));
        }
    }
	
	#[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'POST', url: '/hoquqi/submit')]
    public function submitLegalForm(): RedirectResponse {
        $type4 = $this->request->getParam('type4', '');
        $prefix4 = $this->getPrefixForType($type4);
        $title = $this->request->getParam('title');
        $letterNumber = $this->request->getParam('letter_number');
        $author = $this->userSession->getUser()->getUID();

        try {
            $insertQuery = 'INSERT INTO hoquqi (letter_number, title, date, time, author) VALUES (?, ?, CURDATE(), CURTIME(), ?)';
            $this->db->executeQuery($insertQuery, [$letterNumber, $title, $author]);

            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.downloadFile', [
                'letter_number' => $letterNumber,
                'title' => $title
            ]));
        } catch (\Exception $e) {
            $this->logger->logException($e, ['context' => 'خطا در ذخیره نامه']);
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.index'));
        }
    }
	
	#[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'POST', url: '/omumi/submit')]
    public function submitGeneralForm(): RedirectResponse {
        $type5 = $this->request->getParam('type5', '');
        $prefix5 = $this->getPrefixForType($type5);
        $title = $this->request->getParam('title');
        $letterNumber = $this->request->getParam('letter_number');
        $author = $this->userSession->getUser()->getUID();

        try {
            $insertQuery = 'INSERT INTO omumi (letter_number, title, date, time, author) VALUES (?, ?, CURDATE(), CURTIME(), ?)';
            $this->db->executeQuery($insertQuery, [$letterNumber, $title, $author]);

            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.downloadFile', [
                'letter_number' => $letterNumber,
                'title' => $title
            ]));
        } catch (\Exception $e) {
            $this->logger->logException($e, ['context' => 'خطا در ذخیره نامه']);
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.index'));
        }
    }
	
	#[NoCSRFRequired]
    #[NoAdminRequired]
    #[FrontpageRoute(verb: 'POST', url: '/fani/submit')]
    public function submitTechnicalForm(): RedirectResponse {
        $type6 = $this->request->getParam('type6', '');
        $prefix6 = $this->getPrefixForType($type6);
        $title = $this->request->getParam('title');
        $letterNumber = $this->request->getParam('letter_number');
        $author = $this->userSession->getUser()->getUID();

        try {
            $insertQuery = 'INSERT INTO fani (letter_number, title, date, time, author) VALUES (?, ?, CURDATE(), CURTIME(), ?)';
            $this->db->executeQuery($insertQuery, [$letterNumber, $title, $author]);

            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.downloadFile', [
                'letter_number' => $letterNumber,
                'title' => $title
            ]));
        } catch (\Exception $e) {
            $this->logger->logException($e, ['context' => 'خطا در ذخیره نامه']);
            return new RedirectResponse($this->urlGenerator->linkToRoute('lettermanager.page.index'));
        }
    }

    private function getPrefixForType(string $type): string {
        return match ($type) {
            'response' => 'IR',
            'initial' => 'II',
            'follow-up' => 'IF',
            default => '',
        };
    }

    private function getPrefixForMarketingType(string $type2): string {
        return match ($type2) {
            'response2' => 'MR',
            'initial2' => 'MI',
            'follow-up2' => 'MF',
            default => '',
        };
    }
	
	 private function getPrefixForFinanceType(string $type3): string {
        return match ($type3) {
            'response3' => 'FR',
            'initial3' => 'FI',
            'follow-up3' => 'FF',
            default => '',
        };
    }
	
	 private function getPrefixForLegalType(string $type4): string {
        return match ($type4) {
            'response4' => 'LR',
            'initial4' => 'LI',
            'follow-up4' => 'LF',
            default => '',
        };
    }
	
	private function getPrefixForGeneralType(string $type5): string {
        return match ($type5) {
            'response5' => 'GR',
            'initial5' => 'GI',
            'follow-up5' => 'GF',
            default => '',
        };
    }
	
	private function getPrefixForTechnicalType(string $type6): string {
        return match ($type6) {
            'response6' => 'TR',
            'initial6' => 'TI',
            'follow-up6' => 'TF',
            default => '',
        };
    }

    private function getNextLetterNumber(string $type): string {
        $prefix = $this->getPrefixForType($type);
        $query = 'SELECT MAX(CAST(SUBSTRING(letter_number, 3) AS UNSIGNED)) AS max_number FROM dakheli WHERE letter_number LIKE ?';
        $result = $this->db->executeQuery($query, [$prefix . '%']);
        $maxNumber = $result->fetchColumn();
        $nextLetterNumber = ($maxNumber !== false) ? (int)$maxNumber + 1 : 1;
        return $prefix . $nextLetterNumber;
    }

    private function getNextMarketingLetterNumber(string $type2): string {
        $prefix = $this->getPrefixForMarketingType($type2);
        $query = 'SELECT MAX(CAST(SUBSTRING(letter_number, 3) AS UNSIGNED)) AS max_number FROM bazaryabi WHERE letter_number LIKE ?';
        $result = $this->db->executeQuery($query, [$prefix . '%']);
        $maxNumber = $result->fetchColumn();
        $nextLetterNumber = ($maxNumber !== false) ? (int)$maxNumber + 1 : 1;
        return $prefix . $nextLetterNumber;
    }
	
	 private function getNextFinanceLetterNumber(string $type3): string {
        $prefix = $this->getPrefixForFinanceType($type3);
        $query = 'SELECT MAX(CAST(SUBSTRING(letter_number, 3) AS UNSIGNED)) AS max_number FROM mali WHERE letter_number LIKE ?';
        $result = $this->db->executeQuery($query, [$prefix . '%']);
        $maxNumber = $result->fetchColumn();
        $nextLetterNumber = ($maxNumber !== false) ? (int)$maxNumber + 1 : 1;
        return $prefix . $nextLetterNumber;
    }
	
	private function getNextLegalLetterNumber(string $type4): string {
        $prefix = $this->getPrefixForLegalType($type4);
        $query = 'SELECT MAX(CAST(SUBSTRING(letter_number, 3) AS UNSIGNED)) AS max_number FROM hoquqi WHERE letter_number LIKE ?';
        $result = $this->db->executeQuery($query, [$prefix . '%']);
        $maxNumber = $result->fetchColumn();
        $nextLetterNumber = ($maxNumber !== false) ? (int)$maxNumber + 1 : 1;
        return $prefix . $nextLetterNumber;
    }
	
	private function getNextGeneralLetterNumber(string $type5): string {
        $prefix = $this->getPrefixForGeneralType($type5);
        $query = 'SELECT MAX(CAST(SUBSTRING(letter_number, 3) AS UNSIGNED)) AS max_number FROM omumi WHERE letter_number LIKE ?';
        $result = $this->db->executeQuery($query, [$prefix . '%']);
        $maxNumber = $result->fetchColumn();
        $nextLetterNumber = ($maxNumber !== false) ? (int)$maxNumber + 1 : 1;
        return $prefix . $nextLetterNumber;
    }
	
	private function getNextTechnicalLetterNumber(string $type6): string {
        $prefix = $this->getPrefixForTechnicalType($type6);
        $query = 'SELECT MAX(CAST(SUBSTRING(letter_number, 3) AS UNSIGNED)) AS max_number FROM fani WHERE letter_number LIKE ?';
        $result = $this->db->executeQuery($query, [$prefix . '%']);
        $maxNumber = $result->fetchColumn();
        $nextLetterNumber = ($maxNumber !== false) ? (int)$maxNumber + 1 : 1;
        return $prefix . $nextLetterNumber;
    }
}
