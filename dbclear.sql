TRUNCATE TABLE `watch`;
TRUNCATE TABLE `video_questions`;
TRUNCATE TABLE `video_answers`;
TRUNCATE TABLE `users_job`;
TRUNCATE TABLE `terms_jobs`;
TRUNCATE TABLE `admins`;
TRUNCATE TABLE `section_jobs`;
TRUNCATE TABLE `reference_request`;
TRUNCATE TABLE `qualification_checks`;
TRUNCATE TABLE `media`;
TRUNCATE TABLE `jobs_statuses`;
TRUNCATE TABLE `interviews`;
TRUNCATE TABLE `id_checks`;
TRUNCATE TABLE `history_employment`;
TRUNCATE TABLE `history_education`;
TRUNCATE TABLE `histories_jobs`;
TRUNCATE TABLE `histories_complete`;
TRUNCATE TABLE `form_user_jobs`;
TRUNCATE TABLE `form_jobs`;
TRUNCATE TABLE `forms`;
TRUNCATE TABLE `address`;
TRUNCATE TABLE `extrachecks`;
TRUNCATE TABLE `employers`;
TRUNCATE TABLE `employer_job_tracker`;
TRUNCATE TABLE `employers_tests`;
TRUNCATE TABLE `cv`;
TRUNCATE TABLE `checkabl_filters`;
TRUNCATE TABLE `applicant_share`;
TRUNCATE TABLE `applicant_disclosure_data`;
TRUNCATE TABLE `applicant_disclosures`;
TRUNCATE TABLE `jobs`;
TRUNCATE TABLE `terms_agreed`;
TRUNCATE TABLE `accepted_terms`;
TRUNCATE TABLE `applicant_disclosure_verification`;
TRUNCATE TABLE `credit`;
TRUNCATE TABLE `cv_check`;
TRUNCATE TABLE `css_schemes`;
TRUNCATE TABLE `dashboard_config`;
TRUNCATE TABLE `devphone`;
TRUNCATE TABLE `director_checks`;
TRUNCATE TABLE `driving_data`;
TRUNCATE TABLE `email_verification`;
TRUNCATE TABLE `excel_tests`;
TRUNCATE TABLE `excel_tests_jobs`;
TRUNCATE TABLE `excel_test_allocation`;
TRUNCATE TABLE `excel_test_results`;
TRUNCATE TABLE `facecompare_checks`;
TRUNCATE TABLE `forms`;
TRUNCATE TABLE `form_answers`;
TRUNCATE TABLE `form_completed`;
TRUNCATE TABLE `form_questions`;
TRUNCATE TABLE `form_type`;
TRUNCATE TABLE `histories_defaults`;
TRUNCATE TABLE `last_action`;
TRUNCATE TABLE `master_user`;
TRUNCATE TABLE `pools`;
TRUNCATE TABLE `pool_questions`;
TRUNCATE TABLE `section_defaults`;
TRUNCATE TABLE `skills`;
TRUNCATE TABLE `skills_employer`;
TRUNCATE TABLE `sms_verification`;
TRUNCATE TABLE `source_by_employers`;
TRUNCATE TABLE `terms`;
TRUNCATE TABLE `test_allocation`;
TRUNCATE TABLE `text_value`;
TRUNCATE TABLE `users_roles`;
TRUNCATE TABLE `users`;
TRUNCATE TABLE `terms_agreed`;
TRUNCATE TABLE `aml_data`;
TRUNCATE TABLE `passport_data`;
TRUNCATE TABLE `applicantdata_applicantaddress`;
TRUNCATE TABLE `applicant_prev_address`;
TRUNCATE TABLE `driving_data`;
TRUNCATE TABLE `dev_phone`;





INSERT INTO `master_user` (`id`, `user_id`, `employer_id`) VALUES ('1', '1', '1');

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `surname`, `hometel`, `mobiletel`, `emailaddress`, `last_logged_in`, `employer_id`, `token`, `expiry`, `redirect`, `temp_password`, `retention`) VALUES (NULL, 'admin', '$2y$10$KfkTStdsezr1/9ZZ2EbQzukCl5e7nAxcq75JeXwkKC95kaarBrhTu', 'Matt', 'David', '+99 8111 2222', '+99 07123 123456', 'admin@dev.dev', NULL, '1', NULL, NULL, NULL, '0', '0');

INSERT INTO `address` (`id`, `userid`, `line1`, `line2`, `line3`, `town`, `county`, `postcode`) VALUES (NULL, '1', '1 Any Road', NULL, NULL, 'Anytown', 'London', 'EC1 1AB');

INSERT INTO `admins` (`id`, `user_id`, `created_on`, `disabled`) VALUES (NULL, '1', NOW(), '0');

INSERT INTO `employers` (`id`, `company`, `cameratag_app_id`, `gbg_organisation_id`, `web_hook_url`) VALUES ('1', 'Hireabl', NULL, NULL, NULL);

INSERT INTO `users_roles` (`users_id`, `role_id`) VALUES ('1', '1'), ('1', '2'), ('1', '4');


INSERT INTO `css_schemes` (`id`, `employer_id`, `domain`, `company_name`, `header_background`, `header_logo`, `footer_background`, `footer_logo`, `footer_co_name`, `header_logo_admin`, `header_background_admin`, `footer_background_admin`, `footer_logo_admin`, `contact_number`, `email_from`) VALUES (NULL, '1', 'hireabl.co.uk', 'HIreabl', '#d91919', '', '', '#d91919', 'Hireabl Ltd', '', '#d91919', '#d91919', '', '0800 123 1234', 'info@hireabl.com');

