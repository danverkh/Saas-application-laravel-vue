CREATE TABLE `autoranker_keywords` (
   `id` int NOT NULL AUTO_INCREMENT,
   `order_id` int NOT NULL,
   `keyword` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
   `domain` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `path_to_ranking_subpage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `country` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
   `monthly_fee` decimal(6,2) NOT NULL DEFAULT '0',
   `setup_fee` decimal(6,2) NOT NULL DEFAULT '0',
   `search_volume` int unsigned DEFAULT NULL,
   `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `start_date` date DEFAULT NULL,
   `termination_date` date DEFAULT NULL,
   `termination_confirmed` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
   `termination_executed` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
   `termination_reason_id` int DEFAULT NULL,
   `termination_recorded_date` date DEFAULT NULL,
   `setup_fee_invoiced` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
   `order_fulfillment_request_date` datetime DEFAULT CURRENT_TIMESTAMP,
   `order_fulfillment_employee_id` int NULL,
   `autoranker_experiment_id` int DEFAULT NULL,
   `recurring_month_invoiced` varchar(7) COLLATE utf8mb4_general_ci DEFAULT NULL,
   `top_ten_notification_sent` datetime DEFAULT NULL,
   `top_five_notification_sent` datetime DEFAULT NULL,
   `last_rank_reported` int DEFAULT NULL,
   `last_website_ranking` int DEFAULT NULL,
   `last_website_ranking_update_date` datetime DEFAULT NULL,
   `ranking_subpage_content` varchar(15000) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
   `ranking_subpage_content_last_fetched` datetime DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `fk_autoranker_keywords_order_id` (`order_id`),
   CONSTRAINT `fk_autoranker_keywords_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `clients` (
   `id` int NOT NULL AUTO_INCREMENT,
   `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
   `legal_person` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
   `owner` enum('hPage Ltd.','LOGOS Performance GmbH') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'hPage Ltd.',
   `bank_details_id` int DEFAULT NULL,
   `vatin` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `street` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `zip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `country` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `extra_info` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `accounting_email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
   `industry` enum('Business Consultancy', 'Business Retail', 'Consumer Goods/Services', 'Education', 'Energy', 'Event Planning', 'Finance', 'Forwarding', 'Gambling', 'Health Care', 'Human Resources', 'Information Technology', 'Insurance', 'Interior', 'Legal', 'Manufacturing', 'Marketing', 'Physical Storage', 'Printing', 'Private Investigation', 'Real Estate', 'Recycling', 'Translation', 'Travel', 'Video Production', 'OTHER') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'OTHER',
   `source` enum('Cold Call', 'Cold Mail', 'LinkedIn', 'OTHER') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'OTHER',
   `payment_due_days` int DEFAULT '14',
   `payment_method` enum('wire_transfer','direct_debit','credit_card') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'wire_transfer',
   `stripe_customer_id` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `stripe_payment_method_id` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `termination_notice_period_in_days` int DEFAULT '30',
   `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `employee_id` int NOT NULL,
   `deletion_date` datetime DEFAULT NULL,
   `send_info_emails` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'TRUE',
   `last_info_email_sent_date` datetime DEFAULT NULL,
   `retention_email_1_sent` datetime DEFAULT NULL,
   `retention_email_2_sent` datetime DEFAULT NULL,
   `retention_email_3_sent` datetime DEFAULT NULL,
   `retention_email_4_sent` datetime DEFAULT NULL,
   `not_canceled_mrr` float DEFAULT NULL,
   `autoranker_bonus_email_1_sent` datetime DEFAULT NULL,
   `accountmanager_introduction_sent` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
   PRIMARY KEY (`id`),
   UNIQUE KEY `uidx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `client_accounts` (
   `id` int NOT NULL AUTO_INCREMENT,
   `client_id` int NOT NULL,
   `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
   `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
   `gender` enum('m','f') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
   `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
   `language` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
   `contact_style` enum('formal','informal') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'formal',
   `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
   `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `deletion_date` datetime DEFAULT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `uidx_email_client_id` (`email`, `client_id`),
   KEY `fk_client_accounts_client_id` (`client_id`),
   CONSTRAINT `fk_client_accounts_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;


CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `client_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `contact_first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `contact_last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `contact_gender` enum('m','f') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `contact_language` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `contact_style` enum('formal','informal') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'formal',
  `first_upsell_email_sent` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
  `second_upsell_email_sent` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_account_created` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
  `order_confirmation_sent` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
  PRIMARY KEY (`id`),
  KEY `fk_orders_client_id` (`client_id`),
  CONSTRAINT `fk_orders_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `prospect_mail_domains` (
    `id` int NOT NULL AUTO_INCREMENT,
    `mail_domain` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `company` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
    `title` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `title_fetch_date` datetime DEFAULT NULL,
    `content_check_date` datetime DEFAULT NULL,
    `content_match` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `content_length` int DEFAULT NULL,
    `manual_review_required` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
    `do_not_mail` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
    `is_provider_domain` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
    `is_reachable` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'TRUE',
    `has_mx_entry` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'TRUE',
    `has_ssl_certificate` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `content_unsuitable` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
    `reachable_last_check_date` datetime DEFAULT NULL,
    `mx_entry_last_check_date` datetime DEFAULT NULL,
    `language` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `language_check_date` datetime DEFAULT NULL,
    `registrant_country` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `registrant_country_check_date` datetime DEFAULT NULL,
    `has_prospects` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
    `phone_number_country_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
    `phone_number` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
    `phone_number_last_check_date` datetime DEFAULT NULL,
    `phone_number_research_employee_id` int DEFAULT NULL,
    `phone_number_export_date` datetime DEFAULT NULL,
    `category_1` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `category_2` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `category_3` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `category_confidence` float DEFAULT NULL,
    `content_snippet` varchar(5000) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `language_detected` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `review_employee_id` int DEFAULT NULL,
    `manual_review_finished_date` datetime DEFAULT NULL,
    `manual_review_screenshot_fetch_date` datetime DEFAULT NULL,
    `last_hunter_io_contacts_research_date` datetime DEFAULT NULL,
    `last_minelead_io_contacts_research_date` datetime DEFAULT NULL,
    `last_snov_io_contacts_research_date` datetime DEFAULT NULL,
    `receiving_mail_server` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `last_receiving_mail_server_check_date` datetime DEFAULT NULL,
    `last_traffic_info_check_date` datetime DEFAULT NULL,
    `paid_ads_traffic` int DEFAULT NULL,
    `paid_ads_keyword_number` int DEFAULT NULL,
    `organic_traffic` int DEFAULT NULL,
    `organic_keyword_number` int DEFAULT NULL,
    `premium` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
    `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uidx_mail_domain` (`mail_domain`),
    KEY `fk_prospect_mail_domains_phone_number_research_employee_id` (`phone_number_research_employee_id`),
#     CONSTRAINT `fk_prospect_mail_domains_phone_number_research_employee_id` FOREIGN KEY (`phone_number_research_employee_id`) REFERENCES `employees` (`id`)
#     CONSTRAINT `fk_prospect_mail_domains_review_employee_id` FOREIGN KEY (`review_employee_id`) REFERENCES `employees` (`id`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `search_terms` (
    `id` int NOT NULL AUTO_INCREMENT,
    `search_term` varchar(750) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `country` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
    `detected_language` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
    `language_check_date` datetime DEFAULT NULL,
    `listing_probability` enum('low','medium', 'high') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `update_metrics_more_frequently` enum('FALSE','TRUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FALSE',
    `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_connections_check_date` datetime DEFAULT NULL,
    `last_listing_probability_check_date` datetime DEFAULT NULL,
    `last_metrics_update_date` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uidx_country_search_term` (`country`, `search_term`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `search_term_metrics` (
   `id` int NOT NULL AUTO_INCREMENT,
   `search_term_id` int NOT NULL,
   `creation_date` date NOT NULL,
   `search_volume` int DEFAULT NULL,
   `cpc` decimal(8,2) DEFAULT NULL,
   `competition` decimal(8,2) DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `fk_search_term_metrics_search_term_id` (`search_term_id`),
   CONSTRAINT `fk_search_term_metrics_search_term_id` FOREIGN KEY (`search_term_id`) REFERENCES `search_terms` (`id`),
   UNIQUE KEY `uidx_search_term_id_creation_date` (`search_term_id`,`creation_date`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `search_term_connections` (
   `id` int NOT NULL AUTO_INCREMENT,
   `origin_search_term_id` int NOT NULL,
   `destination_search_term_id` int NOT NULL,
   `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
   KEY `fk_search_term_connections_origin_search_term_id` (`origin_search_term_id`),
   CONSTRAINT `fk_search_term_connections_origin_search_term_id` FOREIGN KEY (`origin_search_term_id`) REFERENCES `search_terms` (`id`),
   KEY `fk_search_term_connections_destination_search_term_id` (`destination_search_term_id`),
   CONSTRAINT `fk_search_term_connections_destination_search_term_id` FOREIGN KEY (`destination_search_term_id`) REFERENCES `search_terms` (`id`),
   UNIQUE KEY `uidx_origin_search_term_id_destination_search_term_id` (`origin_search_term_id`,`destination_search_term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

# mysql users
# CREATE USER 'autoranker_www'@'%' IDENTIFIED BY 'password';
# GRANT SELECT ON gsqt_core.prospect_mail_domains TO 'autoranker_www'@'%';
# GRANT SELECT ON 'gsqt_core'.'autoranker_keywords_results' TO 'autoranker_www'@'%';
