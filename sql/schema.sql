-- ============================================================================
--  Vedic Astrology Learn - Database Schema
--  Project : BCA 4th Semester
--  Engine  : MySQL 8.0+ / MariaDB 10.5+
--  Charset : utf8mb4  (required for Nepali Devanagari + Sanskrit text)
--  File    : sql/schema.sql
-- ============================================================================

DROP DATABASE IF EXISTS vedic_astrology_learn;
CREATE DATABASE vedic_astrology_learn
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE vedic_astrology_learn;

-- ============================================================================
-- SECTION 1 : USER MANAGEMENT
-- ============================================================================

CREATE TABLE users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100)  NOT NULL,
    email         VARCHAR(150)  NOT NULL,
    phone_np      VARCHAR(20)   DEFAULT NULL,
    password_hash VARCHAR(255)  NOT NULL,
    role          ENUM('student','admin') NOT NULL DEFAULT 'student',
    is_active     TINYINT(1)    NOT NULL DEFAULT 1,
    created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_users_email (email),
    KEY idx_users_role (role)
) ENGINE=InnoDB;

-- Password must be stored via PHP password_hash(). Never plain text.

-- ============================================================================
-- SECTION 2 : REFERENCE / CONTENT TABLES
-- ============================================================================

-- 2.1 Categories : bhava, rashi, graha, nakshatra, tithi, yoga, karana, vara
CREATE TABLE categories (
    id         TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code       VARCHAR(20)  NOT NULL,
    name_en    VARCHAR(80)  NOT NULL,
    name_np    VARCHAR(80)  NOT NULL,
    sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,

    UNIQUE KEY uq_categories_code (code)
) ENGINE=InnoDB;

-- 2.2 Topics : one row per studyable concept
CREATE TABLE topics (
    id            SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id   TINYINT UNSIGNED  NOT NULL,
    slug          VARCHAR(120)      NOT NULL,
    sanskrit_name VARCHAR(100)      DEFAULT NULL,
    name_en       VARCHAR(150)      NOT NULL,
    name_np       VARCHAR(150)      NOT NULL,
    sort_order    SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    is_published  TINYINT(1)        NOT NULL DEFAULT 1,
    created_at    TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_topics_slug (slug),
    KEY idx_topics_category (category_id),
    CONSTRAINT fk_topics_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 2.3 Topic content : 1-to-1 split so `topics` stays lean for listing/search
CREATE TABLE topic_content (
    topic_id             SMALLINT UNSIGNED PRIMARY KEY,
    summary_np           MEDIUMTEXT     NOT NULL,
    summary_en           MEDIUMTEXT     DEFAULT NULL,
    characteristics      MEDIUMTEXT     DEFAULT NULL,
    effects              MEDIUMTEXT     DEFAULT NULL,
    classical_reference  VARCHAR(255)   DEFAULT NULL,
    sanskrit_term        VARCHAR(150)   DEFAULT NULL,
    sanskrit_meaning     TEXT           DEFAULT NULL,

    CONSTRAINT fk_topic_content_topic
        FOREIGN KEY (topic_id) REFERENCES topics(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 2.4 Remedies : 1-to-many (a topic can have many remedies)
CREATE TABLE topic_remedies (
    id        SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    topic_id  SMALLINT UNSIGNED NOT NULL,
    remedy_np VARCHAR(500)      NOT NULL,
    remedy_en VARCHAR(500)      DEFAULT NULL,
    sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,

    KEY idx_remedies_topic (topic_id),
    CONSTRAINT fk_remedies_topic
        FOREIGN KEY (topic_id) REFERENCES topics(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 2.5 Related topics : reflexive many-to-many (self join)
CREATE TABLE related_topics (
    topic_id         SMALLINT UNSIGNED NOT NULL,
    related_topic_id SMALLINT UNSIGNED NOT NULL,

    PRIMARY KEY (topic_id, related_topic_id),
    KEY idx_related_rev (related_topic_id),
    CONSTRAINT fk_related_topic
        FOREIGN KEY (topic_id) REFERENCES topics(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_related_topic_rev
        FOREIGN KEY (related_topic_id) REFERENCES topics(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT chk_not_self CHECK (topic_id <> related_topic_id)
) ENGINE=InnoDB;

-- ============================================================================
-- SECTION 3 : CANONICAL ENTITY TABLES
--  These hold the *reference lists*. The generic `topics` table above also
--  stores bhava/rashi/graha as studyable lessons. Both views are needed:
--  `bhavas`/`grahas`/`rashis` = fixed lookup for combination engine,
--  `topics` = the free-form educational content shown to learners.
-- ============================================================================

CREATE TABLE grahas (
    id            TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanskrit_name VARCHAR(40)  NOT NULL,
    name_en       VARCHAR(40)  NOT NULL,
    name_np       VARCHAR(40)  NOT NULL,
    symbol        VARCHAR(10)  DEFAULT NULL,
    sort_order    TINYINT UNSIGNED NOT NULL DEFAULT 0,

    UNIQUE KEY uq_grahas_sanskrit (sanskrit_name)
) ENGINE=InnoDB;

CREATE TABLE bhavas (
    id            TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    house_number  TINYINT UNSIGNED NOT NULL,
    sanskrit_name VARCHAR(40)  NOT NULL,
    name_en       VARCHAR(60)  NOT NULL,
    name_np       VARCHAR(60)  NOT NULL,
    sort_order    TINYINT UNSIGNED NOT NULL DEFAULT 0,

    UNIQUE KEY uq_bhavas_house (house_number),
    UNIQUE KEY uq_bhavas_sanskrit (sanskrit_name)
) ENGINE=InnoDB;

CREATE TABLE rashis (
    id            TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sanskrit_name VARCHAR(40)      NOT NULL,
    name_en       VARCHAR(40)      NOT NULL,
    name_np       VARCHAR(40)      NOT NULL,
    symbol        VARCHAR(20)      NOT NULL,
    element       ENUM('fire','earth','air','water') NOT NULL,
    ruler_graha_id TINYINT UNSIGNED DEFAULT NULL,
    sort_order    TINYINT UNSIGNED NOT NULL DEFAULT 0,

    UNIQUE KEY uq_rashis_sanskrit (sanskrit_name),
    KEY idx_rashis_ruler (ruler_graha_id),
    CONSTRAINT fk_rashis_ruler
        FOREIGN KEY (ruler_graha_id) REFERENCES grahas(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================================
-- SECTION 4 : COMBINATION ANALYSIS  (junction tables with attributes)
--  Composite PK = full normalization. Every non-key column depends on the
--  *whole* composite key, so 3NF holds.
--  Capacity: 9 grahas x 12 bhavas = 108 rows
--            9 grahas x 12 rashis = 108 rows
-- ============================================================================

CREATE TABLE graha_bhava (
    graha_id               TINYINT UNSIGNED NOT NULL,
    bhava_id               TINYINT UNSIGNED NOT NULL,
    interpretation_np      MEDIUMTEXT NOT NULL,
    interpretation_en      MEDIUMTEXT DEFAULT NULL,
    positive_effects       MEDIUMTEXT DEFAULT NULL,
    challenges             MEDIUMTEXT DEFAULT NULL,
    career_indication      MEDIUMTEXT DEFAULT NULL,
    financial_indication   MEDIUMTEXT DEFAULT NULL,
    relationship_indication MEDIUMTEXT DEFAULT NULL,
    classical_interpretation TEXT      DEFAULT NULL,
    sanskrit_reference     VARCHAR(255)   DEFAULT NULL,
    remedies               MEDIUMTEXT     DEFAULT NULL,

    PRIMARY KEY (graha_id, bhava_id),
    KEY idx_gb_bhava (bhava_id),
    CONSTRAINT fk_gb_graha FOREIGN KEY (graha_id)
        REFERENCES grahas(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_gb_bhava FOREIGN KEY (bhava_id)
        REFERENCES bhavas(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE graha_rashi (
    graha_id                TINYINT UNSIGNED NOT NULL,
    rashi_id                TINYINT UNSIGNED NOT NULL,
    interpretation_np       MEDIUMTEXT NOT NULL,
    interpretation_en       MEDIUMTEXT DEFAULT NULL,
    positive_effects        MEDIUMTEXT DEFAULT NULL,
    challenges              MEDIUMTEXT DEFAULT NULL,
    career_indication       MEDIUMTEXT DEFAULT NULL,
    financial_indication    MEDIUMTEXT DEFAULT NULL,
    relationship_indication MEDIUMTEXT DEFAULT NULL,
    classical_interpretation TEXT      DEFAULT NULL,
    sanskrit_reference      VARCHAR(255)   DEFAULT NULL,
    remedies                MEDIUMTEXT     DEFAULT NULL,

    PRIMARY KEY (graha_id, rashi_id),
    KEY idx_gr_rashi (rashi_id),
    CONSTRAINT fk_gr_graha FOREIGN KEY (graha_id)
        REFERENCES grahas(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_gr_rashi FOREIGN KEY (rashi_id)
        REFERENCES rashis(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================================
-- SECTION 5 : LMS  (courses, lessons, quiz, progress)
-- ============================================================================

CREATE TABLE courses (
    id            SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug          VARCHAR(120) NOT NULL,
    title_np      VARCHAR(200) NOT NULL,
    title_en      VARCHAR(200) DEFAULT NULL,
    description   TEXT         DEFAULT NULL,
    is_published  TINYINT(1)   NOT NULL DEFAULT 0,
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_courses_slug (slug)
) ENGINE=InnoDB;

CREATE TABLE lessons (
    id          SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id   SMALLINT UNSIGNED NOT NULL,
    slug        VARCHAR(120)      NOT NULL,
    title_np    VARCHAR(200)      NOT NULL,
    title_en    VARCHAR(200)      DEFAULT NULL,
    content_np  MEDIUMTEXT        NOT NULL,
    content_en  MEDIUMTEXT        DEFAULT NULL,
    sort_order  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    is_published TINYINT(1)       NOT NULL DEFAULT 1,

    UNIQUE KEY uq_lessons_slug (slug),
    KEY idx_lessons_course (course_id),
    CONSTRAINT fk_lessons_course FOREIGN KEY (course_id)
        REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 1 quiz = 1 question (single-question quizzes keep attempt logic trivial)
CREATE TABLE quizzes (
    id            SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lesson_id     SMALLINT UNSIGNED NOT NULL,
    question_np   VARCHAR(500)     NOT NULL,
    question_en   VARCHAR(500)     DEFAULT NULL,
    option_a      VARCHAR(255)     NOT NULL,
    option_b      VARCHAR(255)     NOT NULL,
    option_c      VARCHAR(255)     NOT NULL,
    option_d      VARCHAR(255)     NOT NULL,
    correct_option ENUM('a','b','c','d') NOT NULL,
    explanation_np TEXT            DEFAULT NULL,

    UNIQUE KEY uq_quiz_lesson (lesson_id),
    CONSTRAINT fk_quiz_lesson FOREIGN KEY (lesson_id)
        REFERENCES lessons(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE enrollments (
    id           SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id      INT UNSIGNED      NOT NULL,
    course_id    SMALLINT UNSIGNED NOT NULL,
    enrolled_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP     NULL DEFAULT NULL,

    UNIQUE KEY uq_enroll (user_id, course_id),
    CONSTRAINT fk_enroll_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_enroll_course FOREIGN KEY (course_id)
        REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE lesson_progress (
    user_id      INT UNSIGNED      NOT NULL,
    lesson_id    SMALLINT UNSIGNED NOT NULL,
    is_completed TINYINT(1)   NOT NULL DEFAULT 0,
    completed_at TIMESTAMP    NULL DEFAULT NULL,

    PRIMARY KEY (user_id, lesson_id),
    CONSTRAINT fk_progress_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_progress_lesson FOREIGN KEY (lesson_id)
        REFERENCES lessons(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE quiz_attempts (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED      NOT NULL,
    quiz_id         SMALLINT UNSIGNED NOT NULL,
    selected_option ENUM('a','b','c','d') NOT NULL,
    is_correct      TINYINT(1)   NOT NULL DEFAULT 0,
    attempted_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_attempt_user (user_id),
    CONSTRAINT fk_attempt_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_attempt_quiz FOREIGN KEY (quiz_id)
        REFERENCES quizzes(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================================
-- SECTION 6 : SEARCH SUPPORT
--  FULLTEXT index over bilingual content. Used by the global search bar.
-- ============================================================================

CREATE TABLE search_index (
    entity_type  ENUM('topic','combo','course','lesson','mantra') NOT NULL,
    entity_id    INT UNSIGNED NOT NULL,
    title        VARCHAR(255) NOT NULL,
    body_np      MEDIUMTEXT     DEFAULT NULL,
    body_en      MEDIUMTEXT     DEFAULT NULL,
    url          VARCHAR(255) NOT NULL,

    PRIMARY KEY (entity_type, entity_id),
    KEY idx_search_body_np (body_np(50)),
    FULLTEXT KEY ft_search (title, body_np, body_en)
) ENGINE=InnoDB;

-- ============================================================================
-- SECTION 7 : MANTRAS  (devotional content : mantra / aarati / chalisa)
--  paras holds the mantra text as JSON : [{"label":"","lines":["..."]}, ...]
-- ============================================================================

CREATE TABLE mantras (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cat_code    ENUM('mantra','aarati','chalisa','naya') NOT NULL DEFAULT 'mantra',
    grp         VARCHAR(150)  NOT NULL DEFAULT '',
    slug        VARCHAR(190)  NOT NULL,
    title_np    VARCHAR(220)  NOT NULL,
    image       VARCHAR(220)  DEFAULT NULL,
    intro_np    TEXT          DEFAULT NULL,
    paras       MEDIUMTEXT    NOT NULL,
    is_new      TINYINT(1)    NOT NULL DEFAULT 0,
    sort_order  INT UNSIGNED  NOT NULL DEFAULT 0,
    created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uniq_mantra_slug (slug),
    KEY idx_mantra_cat (cat_code),
    KEY idx_mantra_new (is_new)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- SECTION 8 : AUDIT LOG  (audit trail)
-- ============================================================================

CREATE TABLE activity_log (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    action      VARCHAR(60)  NOT NULL,
    entity      VARCHAR(60)  DEFAULT NULL,
    entity_id   INT UNSIGNED DEFAULT NULL,
    ip_address  VARCHAR(45)  DEFAULT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_log_user (user_id),
    KEY idx_log_date (created_at),
    CONSTRAINT fk_log_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================================
-- SEED DATA : categories
-- ============================================================================

INSERT INTO categories (code, name_en, name_np, sort_order) VALUES
('bhava',    'Bhava / Houses',      'भाव / गृह',     1),
('rashi',    'Rashi / Zodiac Signs','राशि / राशि चक्र', 2),
('graha',    'Graha / Planets',     'ग्रह',            3),
('nakshatra','Nakshatra',           'नक्षत्र',         4),
('tithi',    'Tithi',               'तिथि',            5),
('vara',     'Vara / Weekdays',     'वार',             6),
('yoga',     'Yoga',                'योग',             7),
('karana',   'Karana',              'करण',            8),
('panchanga','Panchanga',            'पञ्चाङ्ग',        9),
('ratna',    'Ratna / Gemstones',    'रत्न / रत्न शास्त्र', 10);

-- ============================================================================
-- SEED DATA : grahas (9)
-- ============================================================================

INSERT INTO grahas (id, sanskrit_name, name_en, name_np, symbol, sort_order) VALUES
(1, 'Surya',    'Sun',     'सूर्य',   'Su',  1),
(2, 'Chandra',  'Moon',    'चन्द्र',  'Ch',  2),
(3, 'Mangala',  'Mars',    'मङ्गल',   'Ma',  3),
(4, 'Budha',    'Mercury', 'बुध',     'Bu',  4),
(5, 'Guru',     'Jupiter', 'गुरु',    'Gu',  5),
(6, 'Shukra',   'Venus',   'शुक्र',   'Sk',  6),
(7, 'Shani',    'Saturn',  'शनि',    'Sa',  7),
(8, 'Rahu',     'Rahu',    'राहु',   'Ra',  8),
(9, 'Ketu',     'Ketu',    'केतु',   'Ke',  9);

-- ============================================================================
-- SEED DATA : bhavas (12)
-- ============================================================================

INSERT INTO bhavas (id, house_number, sanskrit_name, name_en, name_np, sort_order) VALUES
(1,  1,  'Lagna',   'Ascendant',     'लग्न',      1),
(2,  2,  'Dhana',   'House of Wealth','धन भाव',   2),
(3,  3,  'Sahaja',  'House of Siblings','सहज भाव',3),
(4,  4,  'Sukha',   'House of Comfort','सुख भाव', 4),
(5,  5,  'Putra',   'House of Children','पुत्र भाव',5),
(6,  6,  'Ripu',    'House of Enemies','रिपु भाव', 6),
(7,  7,  'Suta',    'House of Marriage','सुता भाव',7),
(8,  8,  'Randhra', 'House of Transformation','रन्द्र भाव',8),
(9,  9,  'Dharma',  'House of Fortune','धर्म भाव', 9),
(10, 10, 'Karma',   'House of Career','कर्म भाव',   10),
(11, 11, 'Labha',   'House of Gains','लाभ भाव',   11),
(12, 12, 'Vyaya',   'House of Loss','व्यय भाव',    12);

-- ============================================================================
-- SEED DATA : rashis (12)
-- ============================================================================

INSERT INTO rashis (id, sanskrit_name, name_en, name_np, symbol, element, ruler_graha_id, sort_order) VALUES
(1,  'Mesha',       'Aries',       'मेष',       'Aries',    'fire',  3, 1),
(2,  'Vrishabha',   'Taurus',      'वृषभ',      'Taurus',   'earth', 6, 2),
(3,  'Mithuna',     'Gemini',      'मिथुन',     'Gemini',   'air',   4, 3),
(4,  'Karka',       'Cancer',      'कर्क',      'Cancer',   'water', 2, 4),
(5,  'Simha',       'Leo',         'सिंह',      'Leo',      'fire',  1, 5),
(6,  'Kanya',       'Virgo',       'कन्या',     'Virgo',    'earth', 4, 6),
(7,  'Tula',        'Libra',       'तुला',      'Libra',    'air',   6, 7),
(8,  'Vrishchika',  'Scorpio',     'वृश्चिक',   'Scorpio',  'water', 3, 8),
(9,  'Dhanu',       'Sagittarius', 'धनु',       'Sagittarius','fire',5, 9),
(10, 'Makara',      'Capricorn',   'मकर',       'Capricorn','earth',7, 10),
(11, 'Kumbha',      'Aquarius',    'कुम्भ',     'Aquarius', 'air',   7, 11),
(12, 'Meena',       'Pisces',      'मीन',       'Pisces',   'water', 5, 12);

-- ============================================================================
-- SEED DATA : default admin
--
--  email    : admin@vedic.local
--  password : admin123
--
--  The hash below is a real bcrypt hash in PHP's $2y$ format.  Change the
--  password immediately after the first login.  To generate your own:
--
--      php -r "echo password_hash('admin123', PASSWORD_DEFAULT), PHP_EOL;"
--
--  Login form must use password_verify(), never a plain comparison.
-- ===========================================================================

INSERT INTO users (name, email, phone_np, password_hash, role) VALUES
('Site Admin', 'admin@vedic.local', '9800000000',
 '$2y$12$89dQ1G58ABEvLc6I7OFws.TzgZU27OWZ1n4dN/jUbIOInlSj9h/wS', 'admin');

-- ============================================================================
-- VERIFICATION QUERIES
-- ============================================================================

-- Expected: 9
-- SELECT COUNT(*) FROM grahas;
-- Expected: 12
-- SELECT COUNT(*) FROM bhavas;
-- Expected: 12
-- SELECT COUNT(*) FROM rashis;
-- Expected: 10 (incl. ratna)
-- SELECT COUNT(*) FROM categories;
-- Expected: 396 mantras (388 source + 8 नयाँ मन्त्र)
-- SELECT COUNT(*) FROM mantras;
