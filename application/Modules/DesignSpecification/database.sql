-- Adminer 4.8.0 MySQL 5.5.5-10.4.21-MariaDB-log dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `mod_specifications`;
CREATE TABLE `mod_specifications` (
  `mod_specification_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_specification_created` datetime NOT NULL,
  `mod_specification_updated` datetime NOT NULL,
  `mod_specification_creatorid` int(11) DEFAULT NULL,
  `mod_specification_client` int(11) DEFAULT NULL,
  `mod_specification_project` int(11) DEFAULT NULL,
  `mod_specification_date_issue` datetime DEFAULT NULL,
  `mod_specification_date_revision` datetime DEFAULT NULL,
  `mod_specification_item_name` varchar(100) DEFAULT NULL,
  `mod_specification_item_description` varchar(100) DEFAULT NULL,
  `mod_specification_item_dimensions` varchar(250) DEFAULT NULL,
  `mod_specification_item_note` varchar(250) DEFAULT NULL,
  `mod_specification_item_requirements` text DEFAULT NULL,
  `mod_specification_id_building_type` varchar(100) DEFAULT NULL,
  `mod_specification_id_building_id` varchar(100) DEFAULT NULL,
  `mod_specification_id_spec_type` varchar(100) DEFAULT NULL,
  `mod_specification_manufacturer` varchar(150) DEFAULT NULL,
  `mod_specification_rep_name` varchar(150) DEFAULT NULL,
  `mod_specification_rep_company` varchar(150) DEFAULT NULL,
  `mod_specification_contact_name` varchar(150) DEFAULT NULL,
  `mod_specification_contact_email` varchar(150) DEFAULT NULL,
  `mod_specification_contact_address_1` varchar(150) DEFAULT NULL,
  `mod_specification_contact_address_2` varchar(150) DEFAULT NULL,
  `mod_specification_type_finish_sample` varchar(20) DEFAULT 'no' COMMENT 'yes|no',
  `mod_specification_type_strike_off` varchar(20) DEFAULT 'no' COMMENT 'yes|no',
  `mod_specification_type_cutting` varchar(20) DEFAULT 'no' COMMENT 'yes|no',
  `mod_specification_type_shop_drawing` varchar(20) DEFAULT 'no' COMMENT 'yes|no',
  `mod_specification_type_prototype` varchar(20) DEFAULT 'no' COMMENT 'yes|no',
  `mod_specification_type_seaming_diagram` varchar(20) DEFAULT 'no' COMMENT 'yes|no',
  `mod_specification_type_cut_sheet` varchar(20) DEFAULT 'no' COMMENT 'yes|no',
  `mod_specification_type_general_notes` text DEFAULT NULL,
  `mod_specification_images_title` varchar(100) DEFAULT NULL,
  `mod_specification_image_1_directory` varchar(100) DEFAULT NULL,
  `mod_specification_image_1_filename` varchar(100) DEFAULT NULL,
  `mod_specification_image_1_notes` varchar(100) DEFAULT NULL,
  `mod_specification_image_2_directory` varchar(100) DEFAULT NULL,
  `mod_specification_image_2_filename` varchar(100) DEFAULT NULL,
  `mod_specification_image_2_notes` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`mod_specification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `email_templates`
ADD `emailtemplate_module_unique_id` varchar(150) NOT NULL FIRST,
ADD `emailtemplate_module_name` varchar(150) NOT NULL AFTER `emailtemplate_module_unique_id`;

INSERT INTO `email_templates` (`emailtemplate_module_unique_id`, `emailtemplate_module_name`, `emailtemplate_name`, `emailtemplate_lang`, `emailtemplate_type`, `emailtemplate_category`, `emailtemplate_subject`, `emailtemplate_body`, `emailtemplate_variables`, `emailtemplate_created`, `emailtemplate_updated`, `emailtemplate_status`, `emailtemplate_language`, `emailtemplate_real_template`, `emailtemplate_show_enabled`) VALUES
('61fff4cf002d28.36611450',	'Design Specification',	'New Design Specification',	'designspecification::lang.new_specification',	'everyone',	'modules',	'Product Specification',	'<!DOCTYPE html>\r\n<html>\r\n\r\n<head>\r\n\r\n    <meta charset=\"utf-8\">\r\n    <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">\r\n    <title>Email Confirmation</title>\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\r\n    <style type=\"text/css\">\r\n        @media screen {\r\n            @font-face {\r\n                font-family: \'Source Sans Pro\';\r\n                font-style: normal;\r\n                font-weight: 400;\r\n                src: local(\'Source Sans Pro Regular\'), local(\'SourceSansPro-Regular\'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format(\'woff\');\r\n            }\r\n\r\n            @font-face {\r\n                font-family: \'Source Sans Pro\';\r\n                font-style: normal;\r\n                font-weight: 700;\r\n                src: local(\'Source Sans Pro Bold\'), local(\'SourceSansPro-Bold\'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format(\'woff\');\r\n            }\r\n        }\r\n\r\n        body,\r\n        table,\r\n        td,\r\n        a {\r\n            -ms-text-size-adjust: 100%;\r\n            /* 1 */\r\n            -webkit-text-size-adjust: 100%;\r\n            /* 2 */\r\n        }\r\n\r\n        img {\r\n            -ms-interpolation-mode: bicubic;\r\n        }\r\n\r\n        a[x-apple-data-detectors] {\r\n            font-family: inherit !important;\r\n            font-size: inherit !important;\r\n            font-weight: inherit !important;\r\n            line-height: inherit !important;\r\n            color: inherit !important;\r\n            text-decoration: none !important;\r\n        }\r\n\r\n        div[style*=\"margin: 16px 0;\"] {\r\n            margin: 0 !important;\r\n        }\r\n\r\n        body {\r\n            width: 100% !important;\r\n            height: 100% !important;\r\n            padding: 0 !important;\r\n            margin: 0 !important;\r\n            padding: 24px;\r\n            font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif;\r\n            font-size: 16px;\r\n            background-color: #f9fafc;\r\n            color: #60676d;\r\n        }\r\n\r\n        table {\r\n            border-collapse: collapse !important;\r\n        }\r\n\r\n        a {\r\n            color: #1a82e2;\r\n        }\r\n\r\n        img {\r\n            height: auto;\r\n            line-height: 100%;\r\n            text-decoration: none;\r\n            border: 0;\r\n            outline: none;\r\n        }\r\n\r\n        .table-1 {\r\n            max-width: 600px;\r\n        }\r\n\r\n        .table-1 td {\r\n            padding: 36px 24px 40px;\r\n            text-align: center;\r\n        }\r\n\r\n        .table-1 h1 {\r\n            margin: 0;\r\n            font-size: 32px;\r\n            font-weight: 600;\r\n            letter-spacing: -1px;\r\n            line-height: 48px;\r\n        }\r\n\r\n        .table-2 {\r\n            max-width: 600px;\r\n        }\r\n\r\n        .table-2 td {\r\n            padding: 36px 24px 0;\r\n            border-top: 3px solid #d4dadf;\r\n            background-color: #ffffff;\r\n        }\r\n\r\n        .table-2 h1 {\r\n            margin: 0;\r\n            font-size: 20px;\r\n            font-weight: 600;\r\n            letter-spacing: -1px;\r\n            line-height: 48px;\r\n        }\r\n\r\n        .table-3 {\r\n            max-width: 600px;\r\n        }\r\n\r\n        .table-2 td {\r\n\r\n            background-color: #ffffff;\r\n        }\r\n\r\n        .td-1 {\r\n            padding: 24px;\r\n            font-size: 16px;\r\n            line-height: 24px;\r\n            background-color: #ffffff;\r\n            text-align: left;\r\n            padding-bottom: 10px;\r\n            padding-top: 0px;\r\n        }\r\n\r\n        .table-gray {\r\n            width: 100%;\r\n        }\r\n\r\n        .table-gray tr {\r\n            height: 24px;\r\n        }\r\n\r\n        .table-gray .td-1 {\r\n            background-color: #f1f3f7;\r\n            width: 30%;\r\n            border: solid 1px #e7e9ec;\r\n            padding-top: 5px;\r\n            padding-bottom: 5px;\r\n        }\r\n\r\n        .table-gray .td-2 {\r\n            background-color: #f1f3f7;\r\n            width: 70%;\r\n            border: solid 1px #e7e9ec;\r\n        }\r\n\r\n        .button, .button:active, .button:visited {\r\n            display: inline-block;\r\n            padding: 16px 36px;\r\n            font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif;\r\n            font-size: 16px;\r\n            color: #ffffff;\r\n            text-decoration: none;\r\n            border-radius: 6px;\r\n            background-color: #1a82e2;\r\n            border-radius: 6px;\r\n        }\r\n\r\n        .signature {\r\n            padding: 24px;\r\n            font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif;\r\n            font-size: 16px;\r\n            line-height: 24px;\r\n            border-bottom: 3px solid #d4dadf;\r\n            background-color: #ffffff;\r\n        }\r\n\r\n        .footer {\r\n            max-width: 600px;\r\n        }\r\n\r\n        .footer td {\r\n            padding: 12px 24px;\r\n            font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif;\r\n            font-size: 14px;\r\n            line-height: 20px;\r\n            color: #666;\r\n        }\r\n\r\n        .td-button {\r\n            padding: 12px;\r\n            background-color: #ffffff;\r\n            text-align: center;\r\n        }\r\n\r\n        .p-24 {\r\n            padding: 24px;\r\n        }\r\n    </style>\r\n\r\n</head>\r\n\r\n<body>\r\n<!-- start body -->\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><!-- start hero -->\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">\r\n<table class=\"table-1\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1>Product Specification</h1>\r\n<h4>{specification_name}</h4>\r\n<p>&nbsp;</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<!-- end hero --> <!-- start hero -->\r\n<tr>\r\n<td align=\"center\">\r\n<table class=\"table-2\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1>Hi {to_name},</h1>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<!-- end hero --> <!-- start copy block -->\r\n<tr>\r\n<td align=\"center\">\r\n<table class=\"table-3\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><!-- start copy -->\r\n<tbody>\r\n<tr>\r\n<td class=\"td-1\">\r\n<p>Please find attached our specification.<br /><br /></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td align=\"left\" bgcolor=\"#ffffff\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td class=\"signature\">\r\n<p>{email_signature}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<!-- end copy block --> <!-- start footer -->\r\n<tr>\r\n<td class=\"p-24\" align=\"center\">\r\n<table class=\"footer\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><!-- start permission -->\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">\r\n<p>{email_footer}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<!-- end footer --></tbody>\r\n</table>\r\n<!-- end body -->\r\n</body>\r\n\r\n</html>',	'{to_name}, {to_email}, {specification_name}, {specification_id}, {specification_date_issued}, , {specification_date_revised}',	'2022-04-09 16:32:50',	'2022-04-09 18:57:22',	'enabled',	'english',	'yes',	'yes');

ALTER TABLE `email_queue`
CHANGE `emailqueue_type` `emailqueue_type` varchar(150) COLLATE 'utf8_general_ci' NULL DEFAULT 'general' COMMENT 'general|pdf (used for emails that need to generate a pdf)' AFTER `emailqueue_message`;

