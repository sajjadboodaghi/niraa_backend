-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2019 at 10:51 PM
-- Server version: 10.2.12-MariaDB-log
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sajjadbo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'c538a4449639f123959239df8a12aee8', '3c9d76c5a5cb5c846cde7991fefee9dd');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) UNSIGNED NOT NULL,
  `item_id` int(11) UNSIGNED NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `telegram_id` varchar(32) NOT NULL,
  `title` varchar(59) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` varchar(26) DEFAULT NULL,
  `place` varchar(6) DEFAULT NULL,
  `subcat_name` varchar(50) DEFAULT NULL,
  `subcat_id` int(4) DEFAULT NULL,
  `shamsi` varchar(15) DEFAULT NULL,
  `timestamp` varchar(12) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_count` int(2) DEFAULT NULL,
  `verified` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `phone_number`, `telegram_id`, `title`, `description`, `price`, `place`, `subcat_name`, `subcat_id`, `shamsi`, `timestamp`, `created_at`, `updated_at`, `image_count`, `verified`) VALUES
(92, '09112906399', '', 'فروش زمین', 'زمین فروشی⏭\nیک قطعه زمین واقع در سلمل جواهرده به متراژ 480مترمربع دارای امتیاز آب با چشم‌اندازی بسیار عالی\nابتدای سلمل (اول جاده زورک  دیزگنه کوه سر)\nمتری 550000تومان\n«به خریدار واقعی  تخفیف داده میشود» \nتلفن تماس 09112906399', 'متری 550/000 تومان', 'رامسر', 'زمین و باغ', 1105, '۹۷/۰۵/۳۱ ۱۹:۲۶', '1534952678', '2018-09-29 16:38:30', '2018-09-29 16:39:16', 1, 1),
(95, '09186640861', '', 'باربری.اتوبار.حمل بار.تمام نقاط', 'عزت بارشمال ……………شبانه روزی\n\nمتخصص حمل وبسته بندی اثاثیه منزل وادارات به تمام نقاط تهران وکشور بصورت ۱۰۰%تضمینی وضمانتی,\n۰۹۱۹۶۳۴۷۰۹۰', 'توافقی', 'رامسر', 'اسباب کشی/حمل و نقل', 2405, '۹۷/۰۷/۰۵ ۰۰:۵۱', '1538128510', '2018-09-29 16:38:30', '2018-09-29 16:39:16', 0, 1),
(133, '09112920507', '', 'تخت کودک', 'تخت کودک سالم وتمیز دخترانه', '250 هزار تومان', 'رامسر', 'تخت خواب', 1702, '۹۷/۰۸/۲۷ ۲۳:۲۷', '1542580548', '2018-11-18 19:57:50', '2019-03-10 15:03:17', 1, 1),
(149, '09381847560', '', 'زمین تجاری مسکونی', 'زمین تجاری مسکونی در محدوده خ ش عباس مفرد جنب ساختمان پدربزرگ (چاوشیان)', '475000000', 'رامسر', 'زمین و باغ', 1105, '۹۷/۰۹/۱۹ ۱۳:۲۰', '1544435599', '2018-12-10 09:50:46', '2019-02-04 18:03:33', 1, 1),
(150, '09012865126', '', 'تدریس خصوصی', 'راهنمایی-دبیرستان- زبان انگلیسی ، عربی، ادبیات فارسی', '', 'رامسر', 'تدریس خصوصی / آموزش', 2403, '۹۷/۰۹/۱۹ ۱۳:۲۲', '1544435626', '2018-12-10 09:52:31', '2019-02-04 18:03:33', 0, 1),
(153, '09359557158', '', 'گروه کوهنوردی رعد رامسر', 'کوهنوردی٫کوهپیمایی٫طبیعت گردی٫گردشگری', '', 'رامسر', 'رویداد / همایش / مراسم', 2301, '۹۷/۰۹/۱۹ ۱۳:۵۶', '1544437898', '2018-12-10 10:26:51', '2018-12-10 10:31:38', 1, 1),
(158, '09308855430', '', 'تلفن رومیزی', 'سالم\nفقط قسمتی از صفحه نمایشش نشون نمیده\nتماس ۰۹۳۷۶۲۲۳۵۱١', '۵۰ هزارتومن', 'رامسر', 'تلفن رومیزی / فکس', 1303, '۹۷/۰۹/۲۳ ۱۴:۴۷', '1544789262', '2018-12-14 11:17:58', '2019-02-04 18:03:33', 1, 1),
(159, '09308855430', '', 'قرقره ماهیگیری', 'دو عد قرقره ماهیگیری\nسالم به همراه نخ\nتماس 09376223511', '200 هزار تومن', 'رامسر', 'تجهیزات ورزشی', 2105, '۹۷/۰۹/۲۳ ۱۴:۵۱', '1544789330', '2018-12-14 11:21:11', '2019-02-04 18:03:33', 2, 1),
(160, '09308855430', '', 'پتو مسافرتی یه نفره ژله ای', 'نو\nمارک ترولاو', 'هرکدام ۴۰ تومن', 'رامسر', 'تخت خواب / تشک / پتو', 1702, '۹۷/۰۹/۲۳ ۱۴:۵۳', '1544789351', '2018-12-14 11:23:32', '2019-02-04 18:03:33', 4, 1),
(167, '09030631053', '', 'نمایندگی فروش محصولات سلامت محور', 'کار در منزل با درآمد عالی\nبدون محدودیت سنی\nپشتیبانی و آموزش کامل تا رسیدن به درآمد', '', 'رامسر', 'فرصت شغلی (متفرقه)', 2299, '۹۷/۰۹/۲۸ ۲۳:۴۰', '1545276327', '2018-12-19 20:10:33', '2019-02-04 18:03:33', 0, 1),
(168, '09365908920', '', 'فروش حیوان خانگی', 'فروش تعدادی خوکچه هندی مو بلند نر و ماده کوچک و بالغ به صورت تک و جفت ', '', 'رامسر', 'حیوانات خانگی', 2103, '۹۷/۰۹/۲۹ ۱۱:۱۳', '1545294540', '2018-12-20 07:43:40', '2018-12-25 15:53:10', 6, 1),
(170, '09124202713', 'amard_design', 'دکوراسیون داخلی آمـارد', '\nدکوراسیون داخلی آمارد\nطراحی و اجرای دکوراسیون داخلی \n#پارکت-لمینت\n#کف پوش \n#کاغذ دیواری\n#پوستر\n#آینه کوبیسم\n#تایل پتینه\n#تایل معرق\n#کنـــــاف\n#آرمسترانگ\n#صنایع چوبی(نرده چوبی-وسایل دکوراتیو چوبی و ...)\n#نورپردازی و برقکاری ساختمان\n#بلوک شیشه ایی\n#سنگ آنتیک\n#آجر نسوز\n#بازسازی ساختمان\n#محوطه سازی\nپیمانکاری اجرای صفر تا صد ساختمان در شرق گیلان و غرب مازندران\n#رامسر#رودسر#لنگرود\n09124202713 آقاجانی\n\nt.me/amard_design', '', 'رامسر', 'خدمات ساختمانی و دکوراسیون', 2410, '۹۷/۱۰/۰۳ ۱۲:۴۴', '1545647630', '2018-12-24 09:14:07', '2019-02-02 14:01:18', 3, 1),
(183, '09138045623', '', 'مشعل گازسوز', 'سازنده انواع مشعل گازسوز، نانوائی، اجاق، زیرپاتیلی، بخاری گلخانه و کارگاه، و غیره در سایز و ابعاد مختلف', '', 'رامسر', 'تولیدکننده صنعتی', 2608, '۹۷/۱۰/۰۴ ۲۳:۳۲', '1545803948', '2018-12-25 20:02:54', '2019-02-04 18:03:33', 1, 1),
(184, '09338364542', 'hamid_akbaryan', '*¤فروش فوری¤* زمین در رامسر باقیمت مناسب', 'زمینی با کاربری مسکونی به متراژ 810 مترمربع دارای کوچه شخصی واقع در خیابان شهیدعباس مفرد جنب پیش دانشگاهی اخضری کوچه موسوی سجاد بصورت یکجا با قیمت بسیار مناسب فوری بفروش میرسد.', '360.000 تومان (هر متر)', 'رامسر', 'زمین و باغ', 1105, '۹۷/۱۰/۰۶ ۱۳:۵۵', '1545913306', '2018-12-27 10:25:51', '2019-02-04 18:03:33', 1, 1),
(185, '09385783180', '', 'کتاب های کمک درسی دبیرستان و کنکور ریاضی', 'کتاب ها اکثرا نو است ', 'توافقی', 'رامسر', 'کتاب / مجله', 2101, '۹۷/۱۰/۰۷ ۲۲:۳۲', '1546024086', '2018-12-28 19:02:43', '2019-02-04 18:03:33', 4, 1),
(186, '09118248427', 'armin_barash_mahdi', 'فروش قرقاول پاکستانی', '۱ نر\n۲ ماده\nمشتری واقعی پیام بده\nتلگرام پاسخگو هستم', '۴۵۰ هزار تومن ', 'رامسر', 'حیوانات خانگی', 2103, '۹۷/۱۰/۲۱ ۲۰:۱۸', '1547225503', '2019-01-11 16:48:05', '2019-02-04 18:03:33', 1, 1),
(187, '09118248427', 'armin_barash_mahdi', 'فروش جوجه کوشین ', '۸ تا.\nمشتری واقعی پیام بده\nتلگرام پاسخگو هستم', '۲۰۰ هزار تومن', 'رامسر', 'حیوانات خانگی', 2103, '۹۷/۱۰/۲۱ ۲۰:۲۰', '1547225777', '2019-01-11 16:50:03', '2019-02-04 18:03:33', 1, 1),
(188, '09122255070', 'mgh7755', 'اجاره خانه ویلایی در رامسر', '۵ میلیون تومن رهن، ۱میلیون و پانصد تومن اجاره ماهیانه.\nاجاره خانه ویلایی رامسر طبقه اول ، حدود 90 متر ، 2 خوابه ، دارای امکاناتِ شومینه، اِسپلیتِر،آب شهری،گاز،برق،پارکینگ\nلطفا برای اطلاعات بیشتر فقط تماس بگیرید.\n 09122255070', '۵ تومن رهن و ۱,۵۰۰ اجاره', 'رامسر', 'اجاره واحد مسکونی', 1102, '۹۷/۱۰/۲۳ ۱۲:۴۹', '1547386322', '2019-01-13 09:19:34', '2019-02-04 18:03:33', 7, 1),
(189, '09911603301', '', 'فرش ۹ متری ماشینی', 'فرش ۹ متری ماشینی فوق العاده تمیز عالی ', '۶۰۰ هزار تومان', 'رامسر', 'فرش و موکت', 1706, '۹۷/۱۰/۲۳ ۱۷:۵۹', '1547392020', '2019-01-13 14:29:55', '2019-02-24 10:30:03', 1, 1),
(212, '09116870735', '', 'درمانگاه دامپزشکی و پت شاپ', 'پت شاپ (واکسیناسیون سگ وگربه ، وانواع غذاهای پت و ملزومات...)', '', 'رامسر', 'حیوانات خانگی', 2103, '۹۷/۱۱/۰۶ ۲۳:۰۴', '1548536131', '2019-01-26 19:34:31', '2019-01-26 20:55:31', 7, 1),
(213, '09112918965', '', 'دستگاه اذانگو', 'دستگاه اذانگو تمام اتوماتیک ویژه مساجد\nدارای آنتن ماهواره ای gps برای دریافت ساعت دقیق اذان \nدارای فعال و غیر فعال کردن دعا و قرآن و تنظیم صدای اتومات صبح و ظهر', '1200000 تومان', 'رامسر', 'صوتی و تصویری (متفرقه)', 1699, '۹۷/۱۱/۱۰ ۱۱:۳۵', '1548836598', '2019-01-30 08:05:23', '2019-02-04 18:03:33', 1, 1),
(224, '09123463328', '', 'نقاشی ساختمان ونصب کاغذ دیواری', 'نقاشی نما و داخل ساختمان اجرای رنگ های داخل ونمای ساختمان با بهترین کیفیت و قیمت مناسب', '', 'رامسر', 'خدمات ساختمانی و دکوراسیون', 2410, '۹۷/۱۱/۱۳ ۱۵:۰۸', '1549116000', '2019-02-02 11:38:30', '2019-02-04 18:03:33', 2, 1),
(234, '09355585519', '', 'فروش زمین', 'یک قطعه زمین\n• به مساحت 224 متر مربع\n• سند دار\n• داخل شهرک\n• دور محصور\n• واقع در رمضانخیل\n• متری 700\nبه فروش می‌رسد', 'متری ۷۰۰ هزار تومان', 'تنکابن', 'زمین و باغ', 1105, '۹۷/۱۱/۲۵ ۰۶:۴۳', '1550126686', '2019-02-14 03:13:33', '2019-02-14 06:44:46', 0, 1),
(235, '09119929250', '', 'ویلا ۲۰۵ متری تنکابن', 'فروش ویلا\n۲۰۵ متر بنا\n۲۴۰ متر زمین\nروبروی بازار ماهی فروشان شهید کاظمی۵ ', '۵۰۰ میلیون تومان', 'تنکابن', 'فروش واحد مسکونی', 1101, '۹۷/۱۱/۲۵ ۱۹:۰۸', '1550158913', '2019-02-14 15:38:44', '2019-02-14 15:41:53', 3, 1),
(239, '09117733566', '', 'لباس مجلسی', 'یک سری لباس مجلسی زنانه و بچگانه+پالتو بچگانه', '', 'رامسر', 'لباس زنانه', 2002, '۹۷/۱۲/۱۰ ۱۳:۱۷', '1551434491', '2019-03-01 09:47:28', '2019-03-01 10:01:31', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `type` varchar(15) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `phone_number`, `type`, `message`, `created_at`) VALUES
(39, '09186640861', 'item_verified', 'آگهی شما با عنوان «باربری.اتوبار.حمل بار.تمام نقاط» تایید و منتشر شد.', '2018-11-12 16:50:11'),
(168, '09308855430', 'item_verified', 'آگهی شما با عنوان «تلفن رومیزی» تایید و منتشر شد', '2018-12-14 12:07:42'),
(169, '09308855430', 'item_verified', 'آگهی شما با عنوان «قرقره ماهیگیری» تایید و منتشر شد', '2018-12-14 12:08:50'),
(170, '09308855430', 'item_verified', 'آگهی شما با عنوان «پتو مسافرتی یه نفره ژله ای» تایید و منتشر شد', '2018-12-14 12:09:11'),
(182, '09339432358', 'item_deleted', 'آگهی شما با عنوان «تست هستیم ما » تایید نشد!\nآگهی آزمایشی بود', '2018-12-25 14:34:19'),
(198, '09122255070', 'item_verified', 'آگهی شما با عنوان «اجاره خانه ویلایی در رامسر» تایید و منتشر شد', '2019-01-13 13:32:02'),
(203, '09116870735', 'item_verified', 'آگهی شما با عنوان «درمانگاه دامپزشکی و پت شاپ» تایید و منتشر شد', '2019-01-26 20:55:31'),
(207, '09374404299', 'item_deleted', 'آگهی شما با عنوان «تست تست» تایید نشد!\nاین آگهی آزمایشی بود!', '2019-02-09 19:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reporter_number` varchar(11) NOT NULL,
  `item_id` int(10) NOT NULL,
  `description` varchar(300) NOT NULL,
  `status` varchar(6) NOT NULL DEFAULT 'unseen',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `link` varchar(500) DEFAULT '',
  `phone` varchar(11) NOT NULL DEFAULT '',
  `status` varchar(9) NOT NULL DEFAULT 'draft',
  `timestamp` varchar(12) NOT NULL,
  `visits_count` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `suggests`
--

CREATE TABLE `suggests` (
  `id` int(11) UNSIGNED NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `niraa_version` varchar(10) NOT NULL,
  `android_version` varchar(38) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(6) NOT NULL DEFAULT 'unseen',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '',
  `image_name` varchar(27) NOT NULL DEFAULT 'default.jpg',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `token` varchar(32) NOT NULL,
  `status` varchar(7) NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone_number`, `name`, `image_name`, `updated_at`, `token`, `status`) VALUES
(1, '09117450633', 'سجاد جنت بوداغی', '09117450633_1552048361.jpg', '2019-03-12 01:51:53', '6445f5ee788b61a34fd7b2799543b461', 'normal'),
(2, '09352154171', '', 'default.jpg', '2019-01-23 15:15:05', 'e94a124530853b16bb7347d2824a419b', 'normal'),
(3, '09119926487', '', 'default.jpg', '2019-01-23 15:15:05', 'ef30fa5b912b50780e7ef188907db262', 'normal'),
(4, '09025149061', '', 'default.jpg', '2019-01-23 15:15:05', 'd98a29221e2c1d4d9aea01caa56d21bd', 'normal'),
(5, '09108214495', '', 'default.jpg', '2019-01-23 15:15:05', 'ce7318b9a3ce0cfb06c1a2772ac82862', 'normal'),
(6, '09117452519', '', 'default.jpg', '2019-01-23 15:15:05', 'a0b648086c05fdcc714d0c4c5ba3ec1b', 'normal'),
(7, '09384837410', '', 'default.jpg', '2019-01-23 15:15:05', 'ab02b4fc2b5f4db2cd382d7efc9d2972', 'normal'),
(8, '09116758832', '', 'default.jpg', '2019-01-23 15:15:05', '9961ed9bf2c5152eb2abf2b358ae7bbd', 'normal'),
(9, '09152239802', '', 'default.jpg', '2019-01-23 15:15:05', '05da9a5839770daf1c96a3e3fac6e526', 'normal'),
(10, '09112906399', '', 'default.jpg', '2019-01-23 15:15:05', '38376af338a78b619654b89400777524', 'normal'),
(11, '09186640861', '', 'default.jpg', '2019-01-23 15:15:05', '74a11c79814ab28c4a5b5269cc5332f1', 'normal'),
(12, '09116147400', '', 'default.jpg', '2019-01-23 15:15:05', '6e3b168ef8c8afa12af5ce2f99c2ff81', 'normal'),
(13, '09033292214', '', 'default.jpg', '2019-01-23 15:15:05', '7db7d0a5388d1305c45df8ec14a0ef86', 'normal'),
(14, '09118460215', '', 'default.jpg', '2019-01-23 15:15:05', '1afe524d52a66c0acfc25fbfbd4cec07', 'normal'),
(15, '09112920507', '', 'default.jpg', '2019-01-23 15:15:05', '50c42d227aabc874b420be50e5a85d62', 'normal'),
(16, '09339432358', '', 'default.jpg', '2019-01-23 15:15:05', '9004856fc474a891c91e0d23a4ea79a6', 'normal'),
(17, '09012515479', '', 'default.jpg', '2019-01-23 15:15:05', '476e7e8a49384ad6c4c568b82a44acfd', 'normal'),
(18, '09028017689', '', 'default.jpg', '2019-01-23 15:15:05', '6a3731b700c839f6164495b86f747cd2', 'normal'),
(19, '09381847560', '', 'default.jpg', '2019-01-23 15:15:05', 'af9088fae37abf19fc9c1021da49c038', 'normal'),
(20, '09012865126', '', 'default.jpg', '2019-01-23 15:15:05', 'caef92f0dcee3de984a49d1d962b5c3a', 'normal'),
(21, '09911603301', '', 'default.jpg', '2019-01-23 15:15:05', '76a109dfc2dca242e8a8c410cceeae87', 'normal'),
(22, '09359557158', '', 'default.jpg', '2019-01-23 15:15:05', '4f72db44df18e2caf0abf0ddbc21144a', 'normal'),
(23, '09378640556', '', 'default.jpg', '2019-01-23 15:15:05', '73666a81a65683fd9bec52843d8821ab', 'normal'),
(24, '09367037673', '', 'default.jpg', '2019-01-23 15:15:05', '9dbbf722639118d2423b7af6d0a83004', 'normal'),
(25, '09112918965', '', 'default.jpg', '2019-01-23 15:15:05', 'a97478779f84c1fbce33cf4f93eb79c8', 'normal'),
(26, '09030631053', '', 'default.jpg', '2019-01-23 15:15:05', 'e23c9a0a123acea1ac8fcef29d6e2a26', 'normal'),
(27, '09118045931', '', 'default.jpg', '2019-01-23 15:15:05', '45bc7ac04046faa3a7a81c950fca58d4', 'normal'),
(28, '09385783180', '', 'default.jpg', '2019-01-23 15:15:05', '0c7a6bffedd583a8f9adac1a61c5d087', 'normal'),
(29, '09308855430', '', 'default.jpg', '2019-01-23 15:15:05', '6377a485e2af269b321716f88b0085a6', 'normal'),
(30, '09198267160', '', 'default.jpg', '2019-01-23 15:15:05', 'ba496b5bed3a3c552c6e70f0ddb7a4fb', 'normal'),
(31, '09104361176', '', 'default.jpg', '2019-01-23 15:15:05', '1eac1d14d0c10c1d0749b5617ca96d29', 'normal'),
(32, '09338364542', '', 'default.jpg', '2019-01-23 15:15:05', '71fc824cfa0f116b8c728eab3dcf8a09', 'normal'),
(33, '09365908920', '', 'default.jpg', '2019-01-23 15:15:05', '49ebd0f5aaa6ac58db857c60fda0bb35', 'normal'),
(34, '09906819276', '', 'default.jpg', '2019-01-23 15:15:05', '612e8bc0152a899b552d7b73f7ee5b94', 'normal'),
(35, '09124202713', '', 'default.jpg', '2019-01-23 15:15:05', 'fe0bd0b171f0453272ec638c7ad977cd', 'normal'),
(36, '09211375395', '', 'default.jpg', '2019-01-23 15:15:05', '7edac0ba914554350ca1bae52d86d2bd', 'normal'),
(37, '09118248427', '', 'default.jpg', '2019-01-23 15:15:05', '9ab31c438e97b66431d6e5465811da50', 'normal'),
(38, '09309835043', '', 'default.jpg', '2019-01-23 15:15:05', 'cf26853ca34e3dee8df78e4fdb6362c0', 'normal'),
(39, '09138045623', '', 'default.jpg', '2019-01-23 15:15:05', '9b418ee1da6c8fe95282be356331393b', 'normal'),
(40, '09907015035', '', 'default.jpg', '2019-01-23 15:15:05', '90b6aa585e1559452b67789c2a1c035c', 'normal'),
(41, '09027456413', '', 'default.jpg', '2019-01-23 15:15:05', '9878e78322b82e2d97581266bade8013', 'normal'),
(42, '09115804835', '', 'default.jpg', '2019-01-23 15:15:05', 'd8c6b2e98e553aa8ae51450804211419', 'normal'),
(43, '09122255070', '', 'default.jpg', '2019-01-23 15:15:05', 'd4dbf2ddf642bbdc7c2904d8a7cba83e', 'normal'),
(44, '09038445419', '', 'default.jpg', '2019-01-23 15:15:05', '5d173b54a228d12c1b8eae72c517bed4', 'normal'),
(45, '09363332257', '', 'default.jpg', '2019-01-23 15:15:05', '50c4c4a31295be70db0cab8972b1bb7a', 'normal'),
(46, '09117179884', '', 'default.jpg', '2019-01-23 15:15:05', 'cbfcd80c0c0bd6508885639014e0986e', 'normal'),
(47, '09116279199', '', 'default.jpg', '2019-01-23 15:15:05', '56ac3f3f829d3c35b741a0247037e444', 'normal'),
(48, '09309285303', '', 'default.jpg', '2019-01-26 14:08:47', '1fae709d0af906dc2561b995c34e9927', 'normal'),
(49, '09116870735', '', 'default.jpg', '2019-01-26 22:53:20', 'b729b3637c643ba4c9f7ded95daa6da7', 'normal'),
(50, '09370546902', '', 'default.jpg', '2019-01-29 14:44:50', '04b32ab0dda6476de43afbfd6c730c4a', 'normal'),
(51, '09123463328', '', 'default.jpg', '2019-02-02 15:03:33', '16d49d43fab6acffcc505914387ccd82', 'normal'),
(52, '09118914470', 'مصطفی بالابندی ', 'default.jpg', '2019-02-05 06:55:31', 'd26c8feec64d3aa86f4d795df6a3d633', 'normal'),
(53, '09374404299', '', 'default.jpg', '2019-02-09 22:16:04', 'f7df57506af51619de0ca7e046e5b3b8', 'normal'),
(54, '09355585519', '', 'default.jpg', '2019-02-14 06:38:59', 'dc86c63d21182d515a43a5e4a181d8c0', 'normal'),
(55, '09119929250', 'محمدصالح', 'default.jpg', '2019-02-14 18:54:29', 'a57d1fa8c569ce138d6e56855a20248c', 'normal'),
(56, '09117375301', 'Majid', 'default.jpg', '2019-02-15 23:28:33', 'c903e700d79e3315335a51bae71c6ec0', 'normal'),
(57, '09387155506', 'پژمان پورعسگری ', 'default.jpg', '2019-02-17 16:02:19', '6d5c012899686933e4efcfca0d9d4b91', 'normal'),
(58, '09393402805', 'عباس گلیج', 'default.jpg', '2019-02-18 16:08:07', '60b9c7c9ecaacadf0a566125bf9b8740', 'normal'),
(59, '09361925213', 'a__ch', '09361925213_1550925933.jpg', '2019-02-23 16:15:33', '03560c70dcbc77c88ac43c389b77ab3f', 'normal'),
(60, '09117733566', '', 'default.jpg', '2019-03-01 12:51:14', '7838d06991607429ee063be1922a7c9a', 'normal'),
(61, '09119926455', '', 'default.jpg', '2019-03-12 02:24:04', '349f62ec4ea61c4901966dbcb5803cf0', 'normal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggests`
--
ALTER TABLE `suggests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `suggests`
--
ALTER TABLE `suggests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
