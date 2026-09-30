-- =====================================================================
-- संयोजन विश्लेषण — expanded combination knowledge tables
-- Structured data tables for every supported combination family.
-- Rows are seeded separately (empty tables = combination "being prepared").
-- Re-runnable: CREATE TABLE IF NOT EXISTS only, no destructive statements.
-- =====================================================================

USE vedic_astrology_learn;

-- Graha + Bhava + Rashi (three-factor combination)
CREATE TABLE IF NOT EXISTS `graha_bhava_rashi` (
  `graha_id` tinyint(3) unsigned NOT NULL,
  `bhava_id` tinyint(3) unsigned NOT NULL,
  `rashi_id` tinyint(3) unsigned NOT NULL,
  `interpretation_np` mediumtext NOT NULL,
  `interpretation_en` mediumtext DEFAULT NULL,
  `positive_effects` mediumtext DEFAULT NULL,
  `challenges` mediumtext DEFAULT NULL,
  `career_indication` mediumtext DEFAULT NULL,
  `financial_indication` mediumtext DEFAULT NULL,
  `relationship_indication` mediumtext DEFAULT NULL,
  `classical_interpretation` text DEFAULT NULL,
  `sanskrit_reference` varchar(255) DEFAULT NULL,
  `remedies` mediumtext DEFAULT NULL,
  PRIMARY KEY (`graha_id`,`bhava_id`,`rashi_id`),
  KEY `idx_gbr_bhava` (`bhava_id`),
  KEY `idx_gbr_rashi` (`rashi_id`),
  CONSTRAINT `fk_gbr_graha` FOREIGN KEY (`graha_id`) REFERENCES `grahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gbr_bhava` FOREIGN KEY (`bhava_id`) REFERENCES `bhavas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gbr_rashi` FOREIGN KEY (`rashi_id`) REFERENCES `rashis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Graha + Nakshatra (nakshatras are stored as topics of category "nakshatra")
CREATE TABLE IF NOT EXISTS `graha_nakshatra` (
  `graha_id` tinyint(3) unsigned NOT NULL,
  `nakshatra_id` smallint(5) unsigned NOT NULL,
  `interpretation_np` mediumtext NOT NULL,
  `interpretation_en` mediumtext DEFAULT NULL,
  `positive_effects` mediumtext DEFAULT NULL,
  `challenges` mediumtext DEFAULT NULL,
  `career_indication` mediumtext DEFAULT NULL,
  `financial_indication` mediumtext DEFAULT NULL,
  `relationship_indication` mediumtext DEFAULT NULL,
  `classical_interpretation` text DEFAULT NULL,
  `sanskrit_reference` varchar(255) DEFAULT NULL,
  `remedies` mediumtext DEFAULT NULL,
  PRIMARY KEY (`graha_id`,`nakshatra_id`),
  KEY `idx_gn_nakshatra` (`nakshatra_id`),
  CONSTRAINT `fk_gn_graha` FOREIGN KEY (`graha_id`) REFERENCES `grahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gn_nakshatra` FOREIGN KEY (`nakshatra_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Graha + Graha (two planets aspecting / operating together)
CREATE TABLE IF NOT EXISTS `graha_graha` (
  `graha_id` tinyint(3) unsigned NOT NULL,
  `graha2_id` tinyint(3) unsigned NOT NULL,
  `interpretation_np` mediumtext NOT NULL,
  `interpretation_en` mediumtext DEFAULT NULL,
  `positive_effects` mediumtext DEFAULT NULL,
  `challenges` mediumtext DEFAULT NULL,
  `career_indication` mediumtext DEFAULT NULL,
  `financial_indication` mediumtext DEFAULT NULL,
  `relationship_indication` mediumtext DEFAULT NULL,
  `classical_interpretation` text DEFAULT NULL,
  `sanskrit_reference` varchar(255) DEFAULT NULL,
  `remedies` mediumtext DEFAULT NULL,
  PRIMARY KEY (`graha_id`,`graha2_id`),
  KEY `idx_gg_graha2` (`graha2_id`),
  CONSTRAINT `fk_gg_graha1` FOREIGN KEY (`graha_id`) REFERENCES `grahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gg_graha2` FOREIGN KEY (`graha2_id`) REFERENCES `grahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dasha: Mahadasha + Antardasha + Pratyantardasha
CREATE TABLE IF NOT EXISTS `dasha_faladesh` (
  `maha_id` tinyint(3) unsigned NOT NULL,
  `antar_id` tinyint(3) unsigned NOT NULL,
  `praty_id` tinyint(3) unsigned NOT NULL,
  `interpretation_np` mediumtext NOT NULL,
  `interpretation_en` mediumtext DEFAULT NULL,
  `positive_effects` mediumtext DEFAULT NULL,
  `challenges` mediumtext DEFAULT NULL,
  `career_indication` mediumtext DEFAULT NULL,
  `financial_indication` mediumtext DEFAULT NULL,
  `relationship_indication` mediumtext DEFAULT NULL,
  `classical_interpretation` text DEFAULT NULL,
  `sanskrit_reference` varchar(255) DEFAULT NULL,
  `remedies` mediumtext DEFAULT NULL,
  PRIMARY KEY (`maha_id`,`antar_id`,`praty_id`),
  KEY `idx_df_antar` (`antar_id`),
  KEY `idx_df_praty` (`praty_id`),
  CONSTRAINT `fk_df_maha` FOREIGN KEY (`maha_id`) REFERENCES `grahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_df_antar` FOREIGN KEY (`antar_id`) REFERENCES `grahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_df_praty` FOREIGN KEY (`praty_id`) REFERENCES `grahas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
