-- ============================================================================
--  Seed Content : Rashi (12 zodiac signs)
--  Run AFTER schema.sql, seed_topics.sql, seed_grahas.sql
-- ============================================================================

USE vedic_astrology_learn;

INSERT INTO topics (id, category_id, slug, sanskrit_name, name_en, name_np, sort_order, is_published) VALUES
(41,2,'mesha','Mesha','Aries','मेष राशि',1,1),
(42,2,'vrishabha','Vrishabha','Taurus','वृषभ राशि',2,1),
(43,2,'mithuna','Mithuna','Gemini','मिथुन राशि',3,1),
(44,2,'karka','Karka','Cancer','कर्क राशि',4,1),
(45,2,'simha','Simha','Leo','सिंह राशि',5,1),
(46,2,'kanya','Kanya','Virgo','कन्या राशि',6,1),
(47,2,'tula','Tula','Libra','तुला राशि',7,1),
(48,2,'vrishchika','Vrishchika','Scorpio','वृश्चिक राशि',8,1),
(49,2,'dhanu','Dhanu','Sagittarius','धनु राशि',9,1),
(50,2,'makara','Makara','Capricorn','मकर राशि',10,1),
(51,2,'kumbha','Kumbha','Aquarius','कुम्भ राशि',11,1),
(52,2,'meena','Meena','Pisces','मीन राशि',12,1);

INSERT INTO topic_content (topic_id, summary_np, summary_en, characteristics, effects, classical_reference, sanskrit_term, sanskrit_meaning) VALUES
(41,'मेष कुण्डलीको पहिलो राशि हो र यसको स्वामी मङ्गल हो। यो अग्नि तत्त्वको चर राशि हो जसले ऊर्जा, नेतृत्व र नयाँ सुरुवातलाई जनाउँछ।','Aries is the first sign of the zodiac, ruled by Mars. It is a movable fire sign representing energy, leadership and new beginnings.',
'1. अग्नि तत्त्वको ऊर्जा र उत्साह
2. चर राशि — नयाँ कुरा सुरु गर्ने
3. नेतृत्व र स्वतन्त्र विचार
4. साहसी र आक्रामक स्वभाव
5. मङ्गलले साहस दिन्छ','1. नयाँ परियोजनामा सफलता
2. ऊर्जा र तत्परता
3. प्रतिस्पर्धामा जित
4. अत्यधिक जल्दबाजी
5. सिर र माथिल्लो शरीरमा चोट','Brihat Parashara Hora Shastra, Adhyaya 25 (Rashi Phala)','मेष','बोक्रो — माथिल्लो भागबाट उदय'),
(42,'वृषभ दोस्रो राशि हो र यसको स्वामी शुक्र हो। यो स्थिर पृथ्वी तत्त्वको राशि हो जसले धैर्य, धन र स्थिरतालाई जनाउँछ।','Taurus is the second sign, ruled by Venus. It is a fixed earth sign representing patience, wealth and stability.',
'1. स्थिर पृथ्वी तत्त्वको स्थिरता
2. धन र सामग्रीको भण्डारण
3. धैर्य र टिकाउ व्यवहार
4. सौन्दर्य र कलामा रुचि
5. परिवर्तनसँग अनिच्छा','1. धन र सम्पत्तिमा वृद्धि
2. लामो समयसम्म टिक्ने शक्ति
3. शान्त र दयालु स्वभाव
4. अति जिद्दीले झगडा
5. गला र गर्दनमा समस्या','Brihat Parashara Hora Shastra, Adhyaya 25','वृषभ','बोक्रो — शरीरको भार बोक्ने'),
(43,'मिथुन तेस्रो राशि हो र यसको स्वामी बुध हो। यो वायु तत्त्वको द्विराशि हो जसले बुद्धि, बोली र सञ्चारलाई जनाउँछ।','Gemini is the third sign, ruled by Mercury. It is a dual air sign representing intelligence, speech and communication.',
'1. द्विराशि — दुई व्यक्तित्वको स्वभाव
2. वायु तत्त्वको बुद्धि र चतुराई
3. भाषा र लेखन कला
4. जिज्ञासु प्रकृति
5. शीघ्र निर्णय लिने क्षमता','1. बौद्धिक दक्षता र शिक्षा
2. सञ्चार र यात्रामा सफलता
3. मित्र वृद्धि
4. ध्यान केन्द्रित गर्न कठिनाइ
5. मुख र हातमा समस्या','Brihat Parashara Hora Shastra, Adhyaya 25','मिथुन','दुई व्यक्ति — जुमला'),
(44,'कर्क चौथो राशि हो र यसको स्वामी चन्द्र हो। यो जल तत्त्वको कारक राशि हो जसले मातृत्व, भावना र संरक्षणलाई जनाउँछ।','Cancer is the fourth sign, ruled by the Moon. It is a cardinal water sign representing maternity, emotion and protection.',
'1. जल तत्त्वको भावनात्मक गहिराइ
2. मातृत्व र परिवार प्रतिको समर्पण
3. घर र स्थायित्वको चाहना
4. सुरक्षा र संरक्षणको भावना
5. चन्द्रले संवेदनशीलता दिन्छ','1. पारिवारिक सुख र एकता
2. भावनात्मक सहानुभूति
3. भोजन र जलसँग सम्बन्ध
4. मन चञ्चलता
5. पेट र छातीमा समस्या','Brihat Parashara Hora Shastra, Adhyaya 25','कर्क','केंकडा — सुरक्षा कवच'),
(45,'सिंह पाँचौं राशि हो र यसको स्वामी सूर्य हो। यो अग्नि तत्त्वको स्थिर राशि हो जसले राज्य, गौरव र नेतृत्वलाई जनाउँछ।','Leo is the fifth sign, ruled by the Sun. It is a fixed fire sign representing royalty, dignity and leadership.',
'1. सूर्यको प्रकाश र गौरव
2. स्थिर अग्नि तत्त्वको दृढता
3. राज्य र नेतृत्व प्रवृत्ति
4. उदार र नेतृत्वमा सक्षम
5. दर्प र अहंकारको प्रवृत्ति','1. सम्मान र प्रतिष्ठा
2. सृजनात्मक उत्कृष्टता
3. नेतृत्व र प्रशासनमा सफलता
4. अति अहंकारले कठिनाइ
5. हृदय र दिमागमा सावधानी','Brihat Parashara Hora Shastra, Adhyaya 25','सिंह','सिंह — शेर, राजा'),
(46,'कन्या छैटौं राशि हो र यसको स्वामी बुध हो। यो पृथ्वी तत्त्वको द्विराशि हो जसले विश्लेषण, सेवा र परिशुद्धतालाई जनाउँछ।','Virgo is the sixth sign, ruled by Mercury. It is a dual earth sign representing analysis, service and precision.',
'1. पृथ्वी तत्त्वको व्यावहारिकता
2. विश्लेषण र तर्क क्षमता
3. स्वच्छता र परिशुद्धता
4. सेवा र उपचार प्रवृत्ति
5. क्रम र नियम प्रिय','1. विश्लेषणात्मक काममा सफलता
2. स्वास्थ्य र उपचारमा योग्यता
3. विस्तारमा ध्यान दिने गुण
4. अति चिन्ता र आलोचनात्मक स्वभाव
5. पेट र आन्द्रासँग सम्बन्ध','Brihat Parashara Hora Shastra, Adhyaya 25','कन्या','कन्या — कुमारी'),
(47,'तुला सातौं राशि हो र यसको स्वामी शुक्र हो। यो वायु तत्त्वको स्थिर राशि हो जसले सन्तुलन, न्याय र सम्झौतालाई जनाउँछ।','Libra is the seventh sign, ruled by Venus. It is a fixed air sign representing balance, justice and agreement.',
'1. सन्तुलन र समताको भावना
2. न्याय र निष्पक्षता
3. सम्झौता र कूटनीतिक क्षमता
4. सौन्दर्य र कलामा रुचि
5. अनिर्णय प्रवृत्ति','1. सम्झौता र साझेदारीमा सफलता
2. सामाजिक सम्बन्धमा सुधार
3. कलात्मक क्षमता
4. निर्णय गर्न गाह्रो हुने
5. किडनी र मूत्राशयमा समस्या','Brihat Parashara Hora Shastra, Adhyaya 25','तुला','तराजू — सन्तुलन'),
(48,'वृश्चिक आउठौं राशि हो र यसको स्वामी मङ्गल हो। यो जल तत्त्वको स्थिर राशि हो जसले रहस्य, गहिराइ र परिवर्तनलाई जनाउँछ।','Scorpio is the eighth sign, ruled by Mars. It is a fixed water sign representing mystery, depth and transformation.',
'1. गहिरो रहस्यमय प्रकृति
2. जल तत्त्वको तीव्र भावना
3. परिवर्तन र पुनर्जन्मको शक्ति
4. अनुसन्धान र गूढ विद्यामा रुचि
5. शत्रुता र प्रतिशोध प्रवृत्ति','1. गूढ विद्या र अनुसन्धानमा दक्षता
2. संकटमा टिकाउ शक्ति
3. गोपनीय काममा सफलता
4. अत्यधिक शंका र ईर्ष्या
5. रोग र दुर्घटनाबाट पीडा','Brihat Parashara Hora Shastra, Adhyaya 25','वृश्चिक','बिच्छु — विष र रहस्य'),
(49,'धनु नौं राशि हो र यसको स्वामी गुरु हो। यो अग्नि तत्त्वको चर राशि हो जसले धर्म, ज्ञान र यात्रालाई जनाउँछ।','Sagittarius is the ninth sign, ruled by Jupiter. It is a mutable fire sign representing dharma, knowledge and travel.',
'1. अग्नि तत्त्वको उज्ज्वल बुद्धि
2. धर्म र न्याय प्रिय
3. ज्ञान र दर्शनमा रुचि
4. यात्रा र विदेश यात्रा
5. उदार र शिक्षाप्रिय स्वभाव','1. उच्च शिक्षा र ज्ञान प्राप्ति
2. दूर स्थानमा यात्रा
3. गुरु र मार्गदर्शन प्राप्ति
4. अति आशावादले कठिनाइ
5. जिगर र जाँघमा समस्या','Brihat Parashara Hora Shastra, Adhyaya 25','धनु','धनुष — लक्ष्यमा सटीक'),
(50,'मकर दसौं राशि हो र यसको स्वामी शनि हो। यो पृथ्वी तत्त्वको स्थिर राशि हो जसले कर्म, अनुशासन र उच्चावचलाई जनाउँछ।','Capricorn is the tenth sign, ruled by Saturn. It is a fixed earth sign representing karma, discipline and rise and fall.',
'1. शनिको अनुशासन र कर्म
2. पृथ्वी तत्त्वको व्यावहारिकता
3. लक्ष्य प्राप्तिको दृढ संकल्प
4. क्रमिक उन्नति र परिश्रम
5. उमेर जस्तै धीरे तर स्थिर वृद्धि','1. कर्म र व्यवसायमा उन्नति
2. अनुशासन र नियमबद्धता
3. सामाजिक सम्मान
4. सानो उमेरमा कठिनाइ
5. जोर्नी र हड्डीमा पीडा','Brihat Parashara Hora Shastra, Adhyaya 25','मकर','मगर — कठिन यात्रा पछि विजय'),
(51,'कुम्भ एघारौं राशि हो र यसको स्वामी शनि हो। यो वायु तत्त्वको स्थिर राशि हो जसले वैज्ञानिक बुद्धि, स्वतन्त्रता र मानवतालाई जनाउँछ।','Aquarius is the eleventh sign, ruled by Saturn. It is a fixed air sign representing scientific thinking, freedom and humanitarianism.',
'1. वैज्ञानिक र तार्किक बुद्धि
2. स्वतन्त्र विचार र सुधारक प्रवृत्ति
3. मानवतावादी दृष्टिकोण
4. मित्र समूह र सामाजिक कार्य
5. भविष्यवाणी र आविष्कार','1. विज्ञान र प्रविधिमा सफलता
2. लाभ र आय वृद्धि
3. मानवताको काममा योगदान
4. भावनात्मक दूरी
5. पाँचवाँ तालुमा समस्या','Brihat Parashara Hora Shastra, Adhyaya 25','कुम्भ','जलपात्र — ज्ञान र प्रवाह'),
(52,'मीन बाह्रौं राशि हो र यसको स्वामी गुरु हो। यो जल तत्त्वको द्विराशि हो जसले आध्यात्मिकता, करुणा र मुक्तिलाई जनाउँछ।','Pisces is the twelfth sign, ruled by Jupiter. It is a dual water sign representing spirituality, compassion and liberation.',
'1. जल तत्त्वको भावनात्मक गहिराइ
2. आध्यात्मिकता र मुक्ति प्रवृत्ति
3. करुणा र दयालुता
4. कला, संगीत र कल्पनाशक्ति
5. द्विराशिको स्वभाव','1. आध्यात्मिक उन्नति र मोक्षको दिशा
2. कलात्मक उत्कृष्टता
3. दयालुताले सम्मान
4. भ्रम र अनिर्णय
5. पैर र चम्पासँग सम्बन्ध','Brihat Parashara Hora Shastra, Adhyaya 25','मीन','माछा — मुक्ति र प्रवाह');

INSERT INTO topic_remedies (topic_id, remedy_np, remedy_en, sort_order) VALUES
(41,'मङ्गलबार हनुमान चालीसाको पाठ गर्ने।','Recite Hanuman Chalisa on Tuesdays.',1),
(42,'शुक्रबार मा लक्ष्मी मन्त्र जप्ने।','Chant the Lakshmi mantra on Fridays.',1),
(43,'बुधवार गणेशलाई दूर्वा चढाउने।','Offer durva grass to Ganesh on Wednesdays.',1),
(44,'सोमबार चन्द्र ग्रहका मन्त्र जप्ने।','Chant the Moon mantra on Mondays.',1),
(45,'रविवार सूर्यलाई जल अर्पण गर्ने।','Offer water to the Sun on Sundays.',1),
(46,'बुधवार गायलाई हरियो घाँस खुवाउने।','Feed green grass to a cow on Wednesdays.',1),
(47,'शुक्रबार शिवलिंगमा दूध चढाउने।','Offer milk to a Shiva linga on Fridays.',1),
(48,'मङ्गलबार हनुमान मन्त्र जप्ने।','Chant the Hanuman mantra on Tuesdays.',1),
(49,'गुरुवार विष्णु मन्त्र जप्ने।','Chant the Vishnu mantra on Thursdays.',1),
(50,'शनिवार शनि मन्त्र जप्ने।','Chant the Saturn mantra on Saturdays.',1),
(51,'शनिवार तिल तेल दान गर्ने।','Donate sesame oil on Saturdays.',1),
(52,'गुरुवार गायलाई चना खुवाउने।','Feed chickpeas to a cow on Thursdays.',1);
