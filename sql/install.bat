@echo off
REM =========================================================================
REM  Vedic Astrology Learn - Database Installer (Windows / XAMPP)
REM
REM  Usage:  double-click install.bat
REM          or run from cmd:  install.bat root  <root-password>
REM
REM  Default MySQL user: root   (XAMPP default has no password)
REM =========================================================================

setlocal

set MYSQL=
if exist "C:\xampp\mysql\bin\mysql.exe" set MYSQL=C:\xampp\mysql\bin\mysql.exe
if exist "S:\xampp\mysql\bin\mysql.exe" set MYSQL=S:\xampp\mysql\bin\mysql.exe
if "%~3" neq "" set MYSQL=%~3
set USER=%1
set PASS=%2

if "%USER%"=="" set USER=root
if "%PASS%"=="" set PASS=

if "%MYSQL%"=="" (
    echo [ERROR] mysql.exe not found. Checked C:\xampp and S:\xampp.
    echo.
    echo         Run:  install.bat root "" "D:\path\to\mysql.exe"
    pause
    exit /b 1
)

echo Using: %MYSQL%

echo ============================================================
echo  Vedic Astrology Learn - Importing database
echo ============================================================
echo.

call :run schema.sql
if errorlevel 1 goto fail
echo [1/12] schema.sql

call :run seed_topics.sql
if errorlevel 1 goto fail
echo [2/12] seed_topics.sql

call :run seed_grahas.sql
if errorlevel 1 goto fail
echo [3/12] seed_grahas.sql

call :run seed_rashis.sql
if errorlevel 1 goto fail
echo [4/12] seed_rashis.sql

call :run seed_nakshatras.sql
if errorlevel 1 goto fail
echo [5/12] seed_nakshatras.sql

call :run seed_panchanga.sql
if errorlevel 1 goto fail
echo [6/12] seed_panchanga.sql    OK   (tithi 30 / vara 7 / yoga 27 / karana 11 / panchanga 5)

call :run seed_combo_expanded.sql
if errorlevel 1 goto fail
call :run seed_combo_bhava_a.sql
if errorlevel 1 goto fail
call :run seed_combo_bhava_b.sql
if errorlevel 1 goto fail
call :run seed_combo_bhava_full_a.sql
if errorlevel 1 goto fail
call :run seed_combo_bhava_full_b.sql
if errorlevel 1 goto fail
call :run seed_combo_bhava_full_c.sql
if errorlevel 1 goto fail
call :run seed_combo_rashi.sql
if errorlevel 1 goto fail
echo [7/12] combination seeds     OK   (graha_bhava 108 = 9 grahas x 12 bhavas)

call :run seed_courses.sql
if errorlevel 1 goto fail
echo [8/12] seed_courses.sql     OK

call :run seed_ratna.sql
if errorlevel 1 goto fail
echo [9/12] seed_ratna.sql       OK

call :run seed_mantras.sql
if errorlevel 1 goto fail
echo [10/12] seed_mantras.sql     OK

call :run seed_topic_quiz.sql
if errorlevel 1 goto fail
echo [11/12] seed_topic_quiz.sql  OK   (150 quiz questions, one per topic)

echo [12/12] verifying counts

if "%PASS%"=="" (
    "%MYSQL%" -u %USER% --default-character-set=utf8mb4 -e "USE vedic_astrology_learn; SELECT 'categories' AS tbl, COUNT(*) AS n FROM categories UNION ALL SELECT 'topics', COUNT(*) FROM topics UNION ALL SELECT 'topic_content', COUNT(*) FROM topic_content UNION ALL SELECT 'remedies', COUNT(*) FROM topic_remedies UNION ALL SELECT 'graha_bhava', COUNT(*) FROM graha_bhava UNION ALL SELECT 'graha_rashi', COUNT(*) FROM graha_rashi UNION ALL SELECT 'courses', COUNT(*) FROM courses UNION ALL SELECT 'lessons', COUNT(*) FROM lessons UNION ALL SELECT 'quizzes', COUNT(*) FROM quizzes UNION ALL SELECT 'mantras', COUNT(*) FROM mantras UNION ALL SELECT 'topic_quizzes', COUNT(*) FROM topic_quizzes UNION ALL SELECT 'graha_bhava_rashi', COUNT(*) FROM graha_bhava_rashi UNION ALL SELECT 'graha_nakshatra', COUNT(*) FROM graha_nakshatra UNION ALL SELECT 'graha_graha', COUNT(*) FROM graha_graha UNION ALL SELECT 'dasha_faladesh', COUNT(*) FROM dasha_faladesh;"
) else (
    "%MYSQL%" -u %USER% -p%PASS% --default-character-set=utf8mb4 -e "USE vedic_astrology_learn; SELECT 'categories' AS tbl, COUNT(*) AS n FROM categories UNION ALL SELECT 'topics', COUNT(*) FROM topics UNION ALL SELECT 'topic_content', COUNT(*) FROM topic_content UNION ALL SELECT 'remedies', COUNT(*) FROM topic_remedies UNION ALL SELECT 'graha_bhava', COUNT(*) FROM graha_bhava UNION ALL SELECT 'graha_rashi', COUNT(*) FROM graha_rashi UNION ALL SELECT 'courses', COUNT(*) FROM courses UNION ALL SELECT 'lessons', COUNT(*) FROM lessons UNION ALL SELECT 'quizzes', COUNT(*) FROM quizzes UNION ALL SELECT 'mantras', COUNT(*) FROM mantras UNION ALL SELECT 'topic_quizzes', COUNT(*) FROM topic_quizzes UNION ALL SELECT 'graha_bhava_rashi', COUNT(*) FROM graha_bhava_rashi UNION ALL SELECT 'graha_nakshatra', COUNT(*) FROM graha_nakshatra UNION ALL SELECT 'graha_graha', COUNT(*) FROM graha_graha UNION ALL SELECT 'dasha_faladesh', COUNT(*) FROM dasha_faladesh;"
)

echo.
echo Expected: 10 / 150 / 150 / 87 / 108 / 12 / 3 / 11 / 11 / 396 / 150 / 0 / 0 / 0 / 0
echo (10 categories, 150 topics incl. 30 tithi, 7 vara, 27 yoga, 11 karana, 5 panchanga, 10 ratna)
echo (396 mantras, 150 topic-quiz questions — one per topic)
echo.
echo ============================================================
echo  Setup complete.
echo.
echo  Site      : http://localhost/vedic-astrology/
echo  Admin     : admin@vedic.local  /  admin123
echo.
echo  Change the admin password right after the first login.
echo  After content edits, rebuild the search index from the
echo  admin panel (admin/search-rebuild.php).
echo ============================================================
echo.
pause
exit /b 0

:run
if "%PASS%"=="" (
    "%MYSQL%" -u %USER% --default-character-set=utf8mb4 < "%~dp0%~1"
) else (
    "%MYSQL%" -u %USER% -p%PASS% --default-character-set=utf8mb4 < "%~dp0%~1"
)
exit /b %errorlevel%

:fail
echo.
echo [ERROR] Import failed. See message above.
pause
exit /b 1
