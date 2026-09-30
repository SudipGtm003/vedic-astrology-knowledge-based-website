-- ===========================================================================
--  Vedic Astrology Learn - Course / Lesson / Quiz seeds
--  File    : sql/seed_courses.sql
--  Run AFTER : schema.sql
--  Note    : quizzes has UNIQUE KEY on lesson_id  =>  one question per lesson
-- ===========================================================================

USE vedic_astrology_learn;

-- ---------------------------------------------------------------------------
-- COURSES
-- ---------------------------------------------------------------------------
INSERT INTO courses (id, slug, title_np, title_en, description, is_published) VALUES
(1,'jyotish-mul-adhar','ज्योतिषको मूल आधार','Fundamentals of Jyotish','नेपाली परम्परामा ज्योतिषको आधारभूत परिचय: ग्रह, राशि र भाव।',1),
(2,'graha-phaal-vigyan','ग्रह फल विज्ञान','Planetary Results','सूर्यदेखि गुरुसम्म प्रमुख ग्रहहरूको कुण्डलीमा देखिने फल र प्रभाव।',1),
(3,'kundali-vishleshan-vidhi','कुण्डली विश्लेषण विधि','Chart Analysis Method','लग्न, भावेश र दशाको क्रममा कुण्डली पढ्ने व्यवस्थित तरिका।',1);

-- ---------------------------------------------------------------------------
-- LESSONS  (course 1)
-- ---------------------------------------------------------------------------
INSERT INTO lessons (id, course_id, slug, title_np, title_en, content_np, content_en, sort_order, is_published) VALUES
(1,1,'what-is-jyotish','ज्योतिष के हो?','What is Jyotish?',
'ज्योतिष भनेको प्रकाशको विज्ञान हो। संस्कृत शब्द "ज्योति" को अर्थ प्रकाश र "अ" को अर्थ गति हुन्छ, त्यसैले ज्योतिष भनेको प्रकाशको गति वा ग्रहगतिको अध्ययन हो।\n\nवैदिक ज्योतिषमा सूर्य, चन्द्र र मङ्गलदेखि शनिसम्मका नवग्रह, बाह्र राशि र बाह्र भावलाई आधार बनाइन्छ। जन्मको ठ्याक्कै समय र ठाउँमा आकाशमा कुन राशि उभिएको थियो भन्ने कुरा नै लग्न हो।\n\nयो विषय नेपालमा वैदिक कालदेखि नै परम्परागत रूपमा अध्ययन गरिँदै आएको छ। हिन्दू विवाह, व्रत, मुहूर्त र जातका कार्यहरूमा ज्योतिषको प्रयोग हुन्छ।\n\nयो पाठ्यक्रम शैक्षिक उद्देश्यका लागि छ। यहाँ सिकेको ज्ञानले व्यक्तिगत परामर्शको विकल्प दिँदैन।',
'Jyotish means the science of light. In Sanskrit, "Jyoti" means light and "as" means motion, so Jyotish is the study of luminous motion - the movement of the planets.\n\nVedic astrology is built on the nine grahas from Surya through Shani, the twelve rashis and the twelve bhavas. The sign rising on the eastern horizon at the exact moment and place of birth is called the Lagna.\n\nIn Nepal this subject has been studied in a traditional way since the Vedic period. Hindu marriage, vows, muhurta and rites all use Jyotish.\n\nThis course is for academic purposes only. What you learn here is not a substitute for personal consultation.',1,1),

(2,1,'nine-grahas','नवग्रह परिचय','The Nine Grahas',
'ज्योतिषमा ग्रह भनेको "पकड्ने" वा "स्थान रोक्ने" वाला हुन्। सूर्य, चन्द्र, मङ्गल, बुध, गुरु, शुक्र, शनि यी सात दृश्य ग्रह हुन् र राहु, केतु यी दुई छाया ग्रह हुन्।\n\nसूर्य आत्मा र आत्मविश्वासका कारक हुन्। चन्द्र मन, माता र सुखका कारक हुन्। मङ्गल साहस, शक्ति र भाइको कारक हुन्।\n\nबुध बुद्धि, वाणी र व्यापारका कारक हुन्। गुरु ज्ञान, गुरु, सन्तान र धर्मका कारक हुन्। शुक्र कला, सुन्दरता र वैवाहिक सुखका कारक हुन्।\n\nशनि कर्म, श्रम, अनुशासन र समयका कारक हुन्। राहु र केतु ग्रहण बिन्दु हुन् र यिनले जीवनमा अचानक परिवर्तन र आध्यात्मिक झुकाव ल्याउँछन्।',
'In Jyotish a graha is that which seizes or holds a place. Surya, Chandra, Mangala, Budha, Guru, Shukra and Shani are the seven visible grahas, while Rahu and Ketu are the shadow grahas.\n\nSurya signifies the soul and confidence. Chandra signifies the mind, the mother and comfort. Mangala signifies courage, strength and siblings.\n\nBudha signifies intelligence, speech and trade. Guru signifies knowledge, the teacher, children and dharma. Shukra signifies art, beauty and marital happiness.\n\nShani signifies karma, labour, discipline and time. Rahu and Ketu are the eclipse points and bring sudden change and an inward turn in life.',2,1),

(3,1,'twelve-rashis','बाह्र राशि','The Twelve Rashis',
'राशि भनेको सूर्यले एक वर्षमा पार गर्ने बाह्र भाग हो। मेष, वृषभ, मिथुन, कर्क, सिंह, कन्या, तुला, वृश्चिक, धनु, मकर, कुम्भ र मीन यी बाह्र राशिहरू हुन्।\n\nराशिहरूलाई तीन प्रकारले वर्गीकरण गरिन्छ: त्रिभुवन (मेष, सिंह, धनु), उद्वत (वृषभ, कन्या, मकर), द्विस्वभाव (मिथुन, तुला, कुम्भ), कालरात्रि (वृश्चिक, मीन, कर्क)।\n\nतत्वका आधारमा अग्नि (मेष, सिंह, धनु), पृथ्वी (वृषभ, कन्या, मकर), वायु (मिथुन, तुला, कुम्भ) र जल (कर्क, वृश्चिक, मीन) हुन्।\n\nप्रत्येक राशिको एउटा स्वामी ग्रह हुन्छ र यसले त्यो राशिको स्वभाव निर्धारण गर्छ। उदाहरणका लागि मङ्गल मेष र वृश्चिकको स्वामी हुन्।',
'A rashi is one of the twelve divisions the sun passes through in a year. Mesha, Vrishabha, Mithuna, Karka, Simha, Kanya, Tula, Vrischika, Dhanu, Makara, Kumbha and Meena are the twelve rashis.\n\nRashis are classified in three ways: trinal (Mesha, Simha, Dhanu), fixed (Vrishabha, Kanya, Makara), dual (Mithuna, Tula, Kumbha) and nodal (Vrischika, Meena, Karka).\n\nBy element they are fire (Mesha, Simha, Dhanu), earth (Vrishabha, Kanya, Makara), air (Mithuna, Tula, Kumbha) and water (Karka, Vrischika, Meena).\n\nEach rashi has a ruling graha which determines its nature. For example Mangala rules Mesha and Vrischika.',3,1),

(4,1,'twelve-bhavas','बाह्र भाव','The Twelve Bhavas',
'भाव भनेको कुण्डलीमा बन्ने बाह्र घर हुन्। यी घरहरूले जीवनका विभिन्न पक्षहरूलाई देखाउँछन्।\n\nपहिलो भाव शरीर, स्वास्थ्य र व्यक्तित्वको हो। तेस्रो भाव साहस र भाइबहिनीको। पञ्चम भाव विद्या र सन्तानको। सातौँ भाव विवाह र साझेदारीको। दशौँ भाव कर्म र करियरको।\n\nलग्नबाट सुरु गरेर एकपछि अर्को क्रममा गरिने गणना हुन्छ र यसलाई भाव गणना भनिन्छ। कुण्डली दक्षिणावर्त (शीर्ष राशि मेष) र वामावर्त (शीर्ष राशि तुला) दुई प्रकारका हुन्।\n\nनेपाली परम्परामा भाव विश्लेषणलाई केन्द्र (केन्द्र भाव १, ४, ७, १०) र त्रिकोण (५, ९) लाई बलियो मानिन्छ र ६, ८, १२ लाई कष्टकर मानिन्छ।',
'Bhavas are the twelve houses formed in a chart. They show the different areas of life.\n\nThe first house is body, health and personality. The third is courage and siblings. The fifth is learning and children. The seventh is marriage and partnership. The tenth is karma and career.\n\nCounting starts from the Lagna and proceeds in order, which is called bhava counting. Charts are of two kinds, south Indian (Mesha at the top) and north Indian (Tula at the top).\n\nIn the Nepali tradition the centre houses (1, 4, 7, 10) and trines (5, 9) are considered strong while 6, 8 and 12 are considered difficult.',4,1);

-- ---------------------------------------------------------------------------
-- LESSONS  (course 2)
-- ---------------------------------------------------------------------------
INSERT INTO lessons (id, course_id, slug, title_np, title_en, content_np, content_en, sort_order, is_published) VALUES
(5,2,'sun-in-chart','सूर्यको फल','Results of Surya',
'सूर्य आत्मा, पिता, सरकार र आत्मविश्वासका कारक हुन्। कुण्डलीमा सूर्य बलियो भए व्यक्तिमा नेतृत्व, सम्मान र स्पष्ट निर्णय लिने क्षमता हुन्छ।\n\nसूर्य मेष र सिंह राशिमा मित्र तुला र कुम्भमा शत्रु हुन्छन्। सूर्य सिंहमा उच्च र तुलामा नीच हुन्छन्।\n\nसूर्य कमजोर भए आत्मविश्वासको कमी, पितासँग दूरी र सरकारी कार्यमा बाधा देखिन्छ। उपायका रूपमा सूर्यलाई जल अर्पण गर्ने र आदित्य हृदय स्तोत्रको पाठ गर्ने विधान छ।\n\nक्लेश गणनामा सूर्य छठाँ भावमा बसेमा शत्रु विजय हुन्छ भन्ने मान्यता छ।',
'Surya signifies the soul, the father, government and confidence. When Surya is strong the person has leadership, respect and clear judgement.\n\nSurya is a friend in Mesha and Simha and an enemy in Tula and Kumbha. Surya is exalted in Simha and debilitated in Tula.\n\nA weak Surya shows low confidence, distance from the father and obstacles in government work. As a remedy the tradition prescribes offering water to the sun and reciting the Aditya Hridaya Stotra.\n\nIn Kala Chakra counting, a Surya in the sixth house is said to bring victory over enemies.',1,1),

(6,2,'moon-in-chart','चन्द्रको फल','Results of Chandra',
'चन्द्र मन, माता, जल र जनसम्पर्कका कारक हुन्। चन्द्र बलियो भए मन शान्त, स्मरणशक्ति राम्रो र जनसम्पर्क सुलभ हुन्छ।\n\nचन्द्र वृषभ र वृश्चिकमा मित्र सिंह र मेषमा शत्रु हुन्छन्। चन्द्र वृषभमा उच्च र वृश्चिकमा नीच हुन्छन्।\n\nचन्द्र कमजोर भए चिन्ता, अनिद्रा, भावनात्मक अस्थिरता र आमासँगको सम्बन्धमा उतारचढाव आउँछ।\n\nचन्द्रस्थितिको अध्ययन गर्दा नक्षत्र पनि हेरिन्छ। चन्द्र जुन नक्षत्रमा छ, त्यसको स्वामीको अवस्थाले फल दिन्छ। यसैले नक्षत्र गणना चन्द्र विश्लेषणको मुख्य आधार हो।',
'Chandra signifies the mind, the mother, water and public contact. A strong Chandra gives a calm mind, good memory and easy social connection.\n\nChandra is a friend in Vrishabha and Vrischika and an enemy in Simha and Mesha. Chandra is exalted in Vrishabha and debilitated in Vrischika.\n\nA weak Chandra brings anxiety, insomnia, emotional instability and ups and downs in the relationship with the mother.\n\nWhen studying Chandra the nakshatra is also examined. The condition of the nakshatra lord gives the result. That is why nakshatra counting is the main basis of Chandra analysis.',2,1),

(7,2,'mars-in-chart','मङ्गलको फल','Results of Mangala',
'मङ्गल साहस, शक्ति, भूमि, भाइ र तकनीकका कारक हुन्। मङ्गल बलियो भए निडरता, शारीरिक बल र कार्यमा गति हुन्छ।\n\nमङ्गल मकर र मीनमा मित्र सिंह र वृश्चिकमा मित्र हुन्छन्। मङ्गल मकरमा उच्च र कर्कमा नीच हुन्छन्।\n\nमङ्गल कमजोर भए हिम्मतको कमी, रक्तविकार, भाइसँग मतभेद र दुर्घटनाको जोखिम बढ्छ।\n\nमङ्गल अष्टम भावमा भए मङ्गल दोष मानिन्छ। यसको उपायका रूपमा हनुमानचालीसा, मङ्गलवारमा लाल वस्तु दान र मङ्गल मन्त्र जप विधान छ।\n\nतकनीकी र सैनिक क्षेत्रमा काम गर्नेमा मङ्गलको प्रभाव सधैं देखिन्छ।',
'Mangala signifies courage, strength, land, siblings and technology. A strong Mangala gives boldness, physical energy and speed in work.\n\nMangala is a friend in Makara and Meena and a friend in Simha and Vrischika. Mangala is exalted in Makara and debilitated in Karka.\n\nA weak Mangala brings lack of courage, blood disorders, disputes with siblings and higher risk of accidents.\n\nMangala in the eighth house is considered Mangala dosha. The prescribed remedies are reciting the Hanuman Chalisa, donating red objects on Tuesday and chanting the Mangala mantra.\n\nThe influence of Mangala is always seen in people working in technical and military fields.',3,1),

(8,2,'jupiter-in-chart','गुरुको फल','Results of Guru',
'गुरु ज्ञान, धर्म, गुरु, सन्तान र सम्पत्तिका कारक हुन्। गुरु बलियो भए विद्या, शुद्ध विचार, सन्तान सुख र सम्मान प्राप्त हुन्छ।\n\nगुरु कर्क र मीनमा मित्र मेष र सिंहमा शत्रु हुन्छन्। गुरु कर्कमा उच्च र मकरमा नीच हुन्छन्।\n\nगुरु कमजोर भए विद्यामा बाधा, धर्ममा शंका, सन्तानमा कठिनाई र वित्तीय अस्थिरता आउँछ।\n\nगुरुको सबैभन्दा शुभ प्रभाव जीवनमा देखिने गुरु चाँडो भएको अवस्था हो। शास्त्रमा तीनवटा बरुष मानिन्छ, जसमा गुरु सबैभन्दा कमजोर ग्रह मानिन्छ।\n\nवैवाहिक जीवन र धार्मिक अध्ययनमा गुरुको स्थिति सधैं हेरिन्छ।',
'Guru signifies knowledge, dharma, the teacher, children and wealth. A strong Guru gives learning, clean thought, happiness from children and respect.\n\nGuru is a friend in Karka and Meena and an enemy in Mesha and Simha. Guru is exalted in Karka and debilitated in Makara.\n\nA weak Guru brings obstacles in study, doubt in dharma, difficulty with children and financial instability.\n\nThe most auspicious effect of Guru is an early Guru transit. In the scriptures three bharus are counted, of which Guru is considered the weakest graha.\n\nThe position of Guru is always examined in married life and in religious study.',4,1);

-- ---------------------------------------------------------------------------
-- LESSONS  (course 3)
-- ---------------------------------------------------------------------------
INSERT INTO lessons (id, course_id, slug, title_np, title_en, content_np, content_en, sort_order, is_published) VALUES
(9,3,'lagna-analysis','लग्न विश्लेषण','Analysing the Lagna',
'लग्न भनेको जन्मको समयमा पूर्वदिशामा उभिएको राशि हो। कुण्डली पढ्ने क्रम सधैं लग्नबाट सुरु हुन्छ।\n\nलग्नमा ग्रह बसेमा त्यो ग्रहको फल व्यक्तिको शरीर, स्वास्थ्य र व्यवहारमा सीधा देखिन्छ। लग्न खाली भए लग्नेशको अवस्था हेरिन्छ।\n\nलग्नसँग पञ्चम र नवम भावको ग्रह देखिन्छ। यी तीनवटै त्रिकोण स्थान हुन् र यहाँ बसेको ग्रहले जीवनको दिशा तोक्छ।\n\nविश्लेषणको क्रम यस्तो छ: पहिले लग्न र लग्नेश, त्यसपछि भाव गणना, त्यसपछि ग्रहको बलाबल, अन्त्यमा दशा र गोचर।',
'The Lagna is the sign rising in the east at the time of birth. Reading a chart always begins from the Lagna.\n\nWhen a graha sits in the Lagna its result is directly visible in the body, health and behaviour of the person. If the Lagna is empty the condition of the Lagnesha is examined.\n\nGrahas in the fifth and ninth houses from the Lagna are also seen. These three are trine positions and a graha placed here sets the direction of life.\n\nThe order of analysis is: first Lagna and Lagnesha, then bhava counting, then the strength of the grahas, and finally dasha and transit.',1,1),

(10,3,'house-lords','भावेश विश्लेषण','Analysing House Lords',
'प्रत्येक भावको एउटा स्वामी ग्रह हुन्छ, जसलाई भावेश भनिन्छ। भावेश कुन भावमा बस्छ र त्यो भावसँग कस्तो सम्बन्ध राख्छ भन्ने कुरा नै मुख्य विश्लेषण हो।\n\nउदाहरणका लागि यदि लग्नेश पञ्चम भावमा बस्छ भने जातक बुद्धिमान र विद्यावान हुन्छ, तर शरीर कमजोर हुन सक्छ।\n\nभावेश पन्ध्रवटा भावबाट जुन भावमा दृष्टि पाउँछ, त्यस भावमा फल प्राप्त हुन्छ। यसैले दृष्टि गणना अत्यन्त महत्त्वपूर्ण छ।\n\nकेन्द्र र त्रिकोण भावमा भावेश बलियो भए शुभ फल, षष्ठ, अष्टम र द्वादश भावमा बसेमा कष्टकर फल दिन्छ।',
'Every bhava has a ruling graha called its lord or bhavesha. Where the bhavesha sits and what relation it keeps with that house is the core of the analysis.\n\nFor example if the Lagnesha sits in the fifth house the person is intelligent and learned, though the body may be weak.\n\nWhichever bhava the bhavesha aspects from the fifteenth position, results are received in that bhava. That is why aspect counting is extremely important.\n\nWhen the bhavesha is strong in centre or trine houses it gives auspicious results, and when it sits in the sixth, eighth or twelfth it gives difficult results.',2,1),

(11,3,'dasha-overview','दशा परिचय','Introduction to Dasha',
'दशा भनेको समय चक्र हो। विश्वेश्वरी दशा पद्धतिमा कीरक, शुक्र, सूर्य, चन्द्र, मङ्गल, राहु, गुरु, शनि यी नवग्रहले क्रमशः शासन गर्छन्।\n\nसबैभन्दा लामो महादशा केतुको ७ वर्ष हुन्छ भने सबैभन्दा छोटो बुधको १६ महिना हुन्छ। कुल १२० वर्षको चक्र बन्छ।\n\nदशा विश्लेषण गर्दा पहिले जन्म नक्षत्र निकालिन्छ। जन्म नक्षत्रको स्वामी ग्रहको अन्तिम अंशबाट दशा शुरु हुन्छ।\n\nअन्तिम अंश = नक्षत्र समाप्ति डिग्री बाट १३३३३ भाग गरेर बाँकी भागलाई १२० ले गुणन गरिन्छ। यो गणना हातले गर्नुपर्छ।\n\nदशा र गोचर दुवैलाई जोडेर मात्र फल निर्णय गर्ने परम्परा छ।',
'Dasha is the cycle of time. In the Vimshottari system Ketu, Shukra, Surya, Chandra, Mangala, Rahu, Guru and Shani rule in order.\n\nThe longest mahadasha of Ketu is 7 years while the shortest of Budha is 16 months. Together they form a cycle of 120 years.\n\nTo analyse a dasha the birth nakshatra is first found. The dasha starts from the balance of the last pada of the birth nakshatra.\n\nBalance = remaining degrees of the nakshatra multiplied by 120 and divided by 13333. This calculation has to be done by hand.\n\nThe tradition is to decide results only by combining dasha and transit.',3,1);

-- ---------------------------------------------------------------------------
-- QUIZZES  (one question per lesson)
-- ---------------------------------------------------------------------------
INSERT INTO quizzes (id, lesson_id, question_np, question_en, option_a, option_b, option_c, option_d, correct_option, explanation_np) VALUES
(1,1,'ज्योतिषको शाब्दिक अर्थ के हो?','What is the literal meaning of Jyotish?','प्रकाश र गति / Light and motion','राशि र भाव / Sign and house','समय र काल / Time and age','ग्रह र नक्षत्र / Planet and star','a','संस्कृत "ज्योति" अर्थात् प्रकाश र "अ" अर्थात् गति भन्ने बाटोबाट ज्योतिष शब्द बनेको हो।'),

(2,2,'निम्नमध्ये कुन ग्रह छाया ग्रह हो?','Which of the following is a shadow graha?','बुध / Budha','गुरु / Guru','राहु / Rahu','शुक्र / Shukra','c','राहु र केतु ग्रहण बिन्दु हुन्, यसैले यी छाया ग्रह भनिन्छन्।'),

(3,3,'बाह्र राशिमध्ये पृथ्वी तत्वका राशिहरू कुन हुन्?','Which rashis belong to the earth element?','मेष, सिंह, धनु','वृषभ, कन्या, मकर','मिथुन, तुला, कुम्भ','कर्क, वृश्चिक, मीन','b','वृषभ, कन्या र मकर पृथ्वी तत्वका राशि हुन्।'),

(4,4,'करियर र कर्मको भाव कुन हुन्?','Which bhava signifies career and karma?','सातौँ भाव','पञ्चम भाव','दशौँ भाव','दोस्रो भाव','c','दशौँ भाव कर्म र करियरको भाव मानिन्छ।'),

(5,5,'सूर्य कुन राशिमा उच्च (exalted) हुन्छन्?','In which rashi is Surya exalted?','मकर','तुला','वृषभ','सिंह','d','सूर्य सिंह राशिमा उच्च र तुलामा नीच हुन्छन्।'),

(6,6,'चन्द्र कसका कारक हुन्?','What does Chandra signify?','पिता र सरकार','मन र माता','साहस र शक्ति','विद्या र धर्म','b','चन्द्र मन, माता, जल र जनसम्पर्कका कारक हुन्।'),

(7,7,'कुन भावमा मङ्गल बसेमा मङ्गल दोष मानिन्छ?','Mangala dosha is formed when Mangala sits in which bhava?','पञ्चम भाव','अष्टम भाव','दशौँ भाव','पहिलो भाव','b','अष्टम भावमा मङ्गल बसेमा मङ्गल दोष मानिन्छ।'),

(8,8,'गुरु कुन राशिमा नीच (debilitated) हुन्छन्?','In which rashi is Guru debilitated?','मकर','कर्क','मीन','मेष','a','गुरु कर्कमा उच्च र मकरमा नीच हुन्छन्।'),

(9,9,'कुण्डली पढ्ने क्रम कहाँबाट सुरु हुन्छ?','Where does reading a chart begin?','पञ्चम भावबाट','चन्द्रबाट','लग्नबाट','शनिबाट','c','कुण्डली पढ्ने क्रम सधैं लग्नबाट सुरु हुन्छ।'),

(10,10,'भावसँग सम्बन्धित राशिको स्वामी ग्रहलाई के भनिन्छ?','What is the lord of the rashi related to a bhava called?','लग्नेश','भावेश','ग्रहेश','नक्षत्रेश','b','भावको स्वामी ग्रहलाई भावेश भनिन्छ।'),

(11,11,'विश्वेश्वरी दशा कति वर्षको चक्र हो?','How many years is the Vimshottari dasha cycle?','१०० वर्ष','१२० वर्ष','१०८ वर्ष','३६५ वर्ष','b','विश्वेश्वरी दशाको कुल चक्र १२० वर्षको हुन्छ।');
