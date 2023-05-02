-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 04 2022 г., 11:48
-- Версия сервера: 10.4.12-MariaDB
-- Версия PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ishtapp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_08_11_073824_create_menus_wp_table', 1),
(4, '2017_08_11_074006_create_menu_items_wp_table', 1),
(5, '2019_12_15_182330_create_main_table', 1),
(6, '2021_02_11_163002_create_regions', 1),
(7, '2021_02_11_181433_create_some_tables', 1),
(8, '2021_02_12_125121_create_vacancy', 1),
(9, '2021_02_17_174359_create_permissions_table', 1),
(10, '2021_02_17_174614_create_roles_table', 1),
(11, '2021_02_17_175353_create_users_permissions_table', 1),
(12, '2021_02_17_175501_create_users_roles_table', 1),
(13, '2021_02_17_175626_create_roles_permissions_table', 1),
(14, '2021_02_21_093845_create_user_vacancy_table', 1),
(15, '2021_03_03_143549_create_user_cvs_table', 1),
(16, '2021_03_03_190141_create_education_type_table', 1),
(17, '2021_03_03_190333_create_user_educations_table', 1),
(18, '2021_03_04_143616_create_user_experiences_table', 1),
(19, '2021_03_04_143641_create_user_courses_table', 1),
(20, '2021_03_12_174344_create_user_email_codes_table', 1),
(21, '2021_03_14_205850_update_user_vacancy_table', 1),
(22, '2021_03_24_210324_create_chats_table', 2),
(23, '2021_03_24_210557_create_messages_table', 2),
(24, '2021_05_14_161822_add_is_migrant_field', 3),
(25, '2021_05_14_162115_add_is_for_disability_person_column', 3),
(26, '2021_10_18_132639_create_currencies_table', 4),
(27, '2021_10_18_140915_alter_vacancies_add_currency_and_salary_columns', 5),
(28, '2021_10_12_151932_alter_users_add_gender_region_columns', 6),
(29, '2021_10_13_173135_alter_users_add_filters_columns', 7),
(30, '2021_10_12_151932_alter_users_add_gender_region_columns', 7),
(31, '2021_10_14_202619_alter_users_add_district_column', 7),
(32, '2021_10_18_115915_alter_users_add_job_type_column', 7),
(33, '2021_10_15_001806_alter_users_add_filter_district_column', 7),
(34, '2022_01_28_051636_alter_add_fields_vacancies', 7),
(35, '2022_01_28_142500_create_job_spheres_table', 8),
(36, '2022_01_28_142729_add_job_sphere_id_to_departments_table', 8),
(37, '2022_01_28_152208_add_product_lab_columns_to_users_table', 9),
(38, '2022_01_28_181819_add_is_product_lab_user_to_users_table', 10),
(39, '2021_02_03_153654_create_vacancy_types_table', 1),
(43, '2022_02_03_145428_create_departments_table', 1),
(44, '2022_02_03_150218_create_districts_table', 1),
(45, '2022_02_03_151001_create_intership_languages_table', 1),
(46, '2022_02_03_151338_create_job_types_table', 1),
(47, '2022_02_03_151630_create_opportunities_table', 1),
(48, '2022_02_03_151920_create_opportunity_durations_table', 1),
(49, '2022_02_03_152003_create_opportunity_types_table', 1),
(50, '2022_02_03_152315_create_recommendation_letter_types_table', 1),
(51, '2022_02_03_152640_create_rural_areas_table', 1),
(52, '2022_02_03_153122_create_bussynesses_table', 1),
(53, '2022_02_03_153245_create_schedules_table', 1),
(54, '2022_02_03_153752_create_social_orientations_table', 1),
(55, '2022_02_03_154526_create_villages_table', 1),
(56, '2022_02_03_172116_create_ter_objects_table', 1),
(57, '2022_02_03_173841_create_streets_table', 1),
(58, '2022_02_12_125121_create_vacancy', 1),
(59, '2022_02_21_093845_create_user_vacancy_table', 1),
(61, '2022_01_28_171128_create_skillset_categories_table', 11),
(62, '2022_01_28_181128_create_skillsets_table', 11),
(63, '2022_01_28_181201_create_user_skills_table', 11),
(64, '2022_02_04_144407_create_vacancy_skills_table', 11);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
