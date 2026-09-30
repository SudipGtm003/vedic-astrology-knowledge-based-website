-- ============================================================================
--  Seed Content : Vedic Astrology Learn
--  Run AFTER sql/schema.sql
--    mysql -u root -p < sql/seed_topics.sql
--  Contains: 12 Bhava, 9 Graha, 12 Rashi topics + sample combinations
-- ============================================================================

USE vedic_astrology_learn;

-- ---------------------------------------------------------------------------
-- BHAVA TOPICS (category_id = 1)
-- ---------------------------------------------------------------------------

INSERT INTO topics (id, category_id, slug, sanskrit_name, name_en, name_np, sort_order, is_published) VALUES
(1,1,'lagna','Lagna','Ascendant / 1st House','लग्न (पहिलो भाव)',1,1),
(2,1,'dhana','Dhana','House of Wealth / 2nd House','धन भाव (दोस्रो भाव)',2,1),
(3,1,'sahaja','Sahaja','House of Siblings / 3rd House','सहज भाव (तेस्रो भाव)',3,1),
(4,1,'sukha','Sukha','House of Comfort / 4th House','सुख भाव (चौथो भाव)',4,1),
(5,1,'putra','Putra','House of Children / 5th House','पुत्र भाव (पाँचौं भाव)',5,1),
(6,1,'ripu','Ripu','House of Enemies / 6th House','रिपु भाव (छैटौं भाव)',6,1),
(7,1,'suta','Suta','House of Marriage / 7th House','सुता भाव (सातौं भाव)',7,1),
(8,1,'randhra','Randhra','House of Longevity / 8th House','रन्द्र भाव (आउठौं भाव)',8,1),
(9,1,'dharma','Dharma','House of Fortune / 9th House','धर्म भाव (नौं भाव)',9,1),
(10,1,'karma','Karma','House of Career / 10th House','कर्म भाव (दसौं भाव)',10,1),
(11,1,'labha','Labha','House of Gains / 11th House','लाभ भाव (एघारौं भाव)',11,1),
(12,1,'vyaya','Vyaya','House of Losses / 12th House','व्यय भाव (बाह्रौं भाव)',12,1);

INSERT INTO topic_content (topic_id, summary_np, summary_en, characteristics, effects, classical_reference, sanskrit_term, sanskrit_meaning) VALUES
(1,'लग्न भनेको जन्मको ठ्याक्कै समयमा पूर्व दिशातर्फ उदय भएको राशि हो। ज्योतिषमा यसलाई कुण्डलीको आधार मानिन्छ र जातकको शारीरिक रूप, स्वभाव र जीवनको समग्र दिशा यसैबाट बुझिन्छ।','The Ascendant is the zodiac sign rising on the eastern horizon at the exact moment of birth. It forms the foundation of the chart and indicates the native constitution, temperament and overall direction of life.',
'1. व्यक्तिको शारीरिक बनावट र ऊर्ध्वाधर गठन
2. जन्म नै देखिने व्यवहार र पहिलो छाप
3. दैनिक जीवनमा लिइने निर्णयको ढाँचा
4. रोग र आयुसम्बन्धी विचार पनि यसैबाट सुरु हुन्छ
5. सप्तम र सप्तमेशको दृष्टिले वैवाहिक जीवन थाहा पाइन्छ','1. देखिने शारीरिक गुण र उमेर
2. मानसिक प्रवृत्ति र आत्मविश्वास
3. वातावरणसँग मिल्ने क्षमता
4. नयाँ सुरुवात र परिवर्तनको अवसर
5. जीवनभर दोहोरिने विषयहरू','Brihat Parashara Hora Shastra, Adhyaya 1 (Lagna Phala Adhyaya)','लग्न','उदय — पूर्व दिशातर्फ उठेको राशि'),
(2,'दोस्रो भावलाई धन भाव भनिन्छ। यसले जातकको कुल सम्पत्ति, बोली, कुटुम्बको अवस्था र मौखिक क्षमता देखाउँछ। यो भाव आकाशसँग दोस्रो घर जोडिएको भएकाले कुटुम्ब र वंशसँग पनि सम्बन्ध राख्छ।','The second house signifies accumulated wealth, speech, family background and oral ability. Being the twelfth from the third, it also relates to the family line.',
'1. खानेकुरा, पानी र जीविकाको प्राप्ति
2. वाणीमा संयम र भाषा कला
3. कुटुम्बको सहयोग र सम्पत्तिको संग्रह
4. दाँत, आँखा र बोक्रासँग सम्बन्ध
5. धन बचत गर्ने प्रवृत्ति','1. खानपान र जीवनयापनको स्तर
2. बचत र निवेशको क्षमता
3. मौखिक प्रभाव र परामर्श दिने गुण
4. पारिवारिक एकता वा दूरी
5. अति खर्चीलो हुने खतरा','Brihat Parashara Hora Shastra, Adhyaya 4 (Dhana Phala)','धन','धन — सम्पत्ति र संग्रह'),
(3,'तेस्रो भाव साहस, छोरा छोरीको सन्तान, छोटा भाइबहिनी, शक्ति र पराक्रमलाई जनाउँछ। यसलाई पराक्रम र उत्साहको भाव मानिन्छ।','The third house rules courage, younger siblings, energy and initiative. It is regarded as the house of valour.',
'1. साहस र शारीरिक बल
2. छोटा भाइबहिनीसँगको सम्बन्ध
3. लेखन, पत्रकारिता र सञ्चार
4. छोटो यात्रा र दैनिक अभ्यास
5. माता र चाचासँग पनि सम्बन्ध','1. पराक्रम र आत्मविश्वास
2. छोटा भाइबहिनीको स्वास्थ्य
3. मित्रवत् सहयोग
4. अति साहसी हुँदा दुर्घटना
5. लेखन र सञ्चारमा सफलता','Brihat Parashara Hora Shastra, Adhyaya 5 (Sahaja Phala)','सहज','सहज — जन्मजात शक्ति र पराक्रम'),
(4,'चौथो भाव सुख, वाहन, भूमि, घर र मातासँग सम्बन्ध राख्छ। यो जन्मकुण्डलीको चतुर्थ भाव आकाशको नीचातिर आउँदा भाव शुद्ध हुन्छ भन्ने सिद्धान्त अनुसार शान्ति र आनन्दको विषय हो।','The fourth house governs happiness, vehicles, land, home and the mother. Being at the bottom of the chart, it is treated as a house of peace and contentment.',
'1. घर, भूमि र वाहनको सुख
2. माताको सहयोग र मातृप्रेम
3. मनको शान्ति र आत्मिक संतुष्टि
4. विद्या, ज्ञान र गहन अध्ययन
5. अन्तिम जीवनको बसोबास','1. भौतिक सुख र निर्माण
2. मानसिक शान्ति र चिन्ता
3. माताको स्वास्थ्य
4. कर्ज र शत्रुबाट पीडा
5. वाहनमा सावधानी आवश्यक','Brihat Parashara Hora Shastra, Adhyaya 7 (Sukha Phala)','सुख','सुख — सुख-समृद्धि र शान्ति'),
(5,'पाँचौं भाव सन्तान, बुद्धि, पूर्वजन्मको पुण्य, शिक्षा र अध्ययनलाई जनाउँछ। यसलाई विद्या र आध्यात्मिक वृद्धिको भाव मानिन्छ।','The fifth house signifies children, intellect, past-life merit, education and learning. It is the house of wisdom and spiritual growth.',
'1. सन्तान र सृजनात्मक उत्पादन
2. तर्कशक्ति र बुद्धिमत्ता
3. पूर्वजन्मको पुण्यफल
4. अध्ययन र परीक्षामा सफलता
5. मन्त्र, जप र आध्यात्म अभ्यास','1. बच्चाको स्वास्थ्य र शिक्षा
2. बौद्धिक विकास र शिक्षा पूरा
3. सट्टा र जुवाबाट लाभ
4. अहंकार बढ्दा कठिनाइ
5. सन्तान पक्षबाट सन्तुष्टि','Brihat Parashara Hora Shastra, Adhyaya 8 (Putra Phala)','पुत्र','पुत्र — सन्तान र बुद्धि'),
(6,'छैटौं भाव रोग, शत्रु, कर्ज, चिकित्सा र सेवा सँग सम्बन्ध राख्छ। यसलाई कालपुरुष कुण्डलीमा दुःख भाव मानिन्छ।','The sixth house relates to disease, enemies, debts, service and healing. In the Kalapurusha chart it is the house of suffering.',
'1. रोग र शारीरिक कमजोरी
2. शत्रु र कानूनी झगडा
3. कर्ज र ऋणको बोझ
4. सेवा, नोकरी र दैनिक काम
5. औषधि र उपचारमा रुचि','1. शत्रु पराजय र विजय
2. रोग नियन्त्रण र उपचार
3. नोकरी र सेवा क्षेत्रमा स्थिरता
4. ऋण फिर्ता गर्ने कठिनाइ
5. अत्यधिक चिन्ताले नरोगी हुन सक्छ','Brihat Parashara Hora Shastra, Adhyaya 9 (Ripu Phala)','रिपु','रिपु — शत्रु र दुःख'),
(7,'सातौं भाव वैवाहिक जीवन, जीवनसाथी, साझेदारी र व्यापारिक सम्बन्धलाई जनाउँछ। कालपुरुष कुण्डलीमा यो स्त्री भाव मानिन्छ।','The seventh house indicates marriage, spouse, partnership and business relations. In the Kalapurusha chart it is the house of the wife.',
'1. जीवनसाथीको स्वभाव र गुण
2. विवाह, साझेदारी र सम्झौता
3. जनतासँगको सम्बन्ध र लोकप्रियता
4. खुल्ला शत्रु र प्रतिस्पर्धा
5. व्यापार र विदेश सँग सम्बन्ध','1. वैवाहिक सुख र सामञ्जस्य
2. साझेदारीमा लाभ
3. सम्झौतामा सफलता
4. अहम् टकरावले विवाद
5. जनसम्पर्कले अवसर','Brihat Parashara Hora Shastra, Adhyaya 12 (Vivaha Phala)','सुता','सुता — जीवनसाथी र सन्तान'),
(8,'आउठौं भाव आयु, मृत्यु, गोपनीय कुरा, विरासत र आध्यात्मिक रहस्यसँग सम्बन्ध राख्छ। यसलाई अचानक परिवर्तनको भाव मानिन्छ।','The eighth house governs longevity, death, secrets, inheritance and occult matters. It is regarded as a house of sudden transformation.',
'1. आयु र जीवन दीर्घायु
2. गोपनीय रहस्य र अनुसन्धान
3. विरासत, बीमा र सरकारी स्रोत
4. ज्योतिष, तन्त्र र गूढ विद्या
5. अचानक दुर्घटना र परिवर्तन','1. दीर्घायु र स्वास्थ्य टिकारी
2. विरासत र अन्तिम सम्पत्ति
3. गूढ विद्यामा गहिरो रुचि
4. अचानक घटनाबाट सतर्कता
5. शल्यक्रिया र उपचारमा सफलता','Brihat Parashara Hora Shastra, Adhyaya 14 (Ayur Phala)','रन्द्र','रन्द्र — गड्ढा, गहिराइ र मृत्यु'),
(9,'नौं भाव भाग्य, धर्म, पिता, तीर्थयात्रा र उच्च शिक्षालाई जनाउँछ। यसलाई भाग्य स्थान भनिन्छ र लक्ष्मीसँग पनि सम्बन्ध राख्छ।','The ninth house signifies fortune, dharma, father, pilgrimage and higher learning. It is called the house of fortune and is linked to Lakshmi.',
'1. भाग्य र सौभाग्यको वृद्धि
2. धार्मिक विचार र नैतिकता
3. पिताको सहयोग र सम्मान
4. उच्च शिक्षा र विदेश यात्रा
5. गुरु र आध्यात्मिक मार्गदर्शन','1. भाग्यले समर्थन गर्ने अवसर
2. धर्म र तपस्यामा रुचि
3. यात्रा र तीर्थको लाभ
4. पितासँगको सम्बन्ध सुधार
5. अन्धविश्वासमा परे कठिनाइ','Brihat Parashara Hora Shastra, Adhyaya 16 (Bhagya Phala)','धर्म','धर्म — कर्तव्य र भाग्य'),
(10,'दसौं भाव कर्म, व्यवसाय, सम्मान र सार्वजनिक स्थितिलाई जनाउँछ। कालपुरुष कुण्डलीमा यो राज्य भाव मानिन्छ र व्यक्तिको जीवनमा उच्चावचको कारक हो।','The tenth house signifies karma, profession, honour and public standing. In the Kalapurusha chart it is the house of the ruler and governs rise and fall.',
'1. व्यवसाय र कर्मक्षेत्र
2. सम्मान र सार्वजनिक प्रतिष्ठा
3. शासन, प्रशासन र नीति निर्माण
4. पिताको कर्मसँग पनि सम्बन्ध
5. चन्द्र, शनि यहाँ स्थित भए प्रतिष्ठा दिलाउँछ','1. कर्म र व्यवसायमा उन्नति
2. पद र अधिकारको प्राप्ति
3. सरकारी काममा सफलता
4. अति महत्वाकांक्षाले निराशा
5. धैर्य र निरन्तर परिश्रमले बलियो','Brihat Parashara Hora Shastra, Adhyaya 19 (Karma Phala)','कर्म','कर्म — कार्य र व्यवसाय'),
(11,'एघारौं भाव लाभ, आय, मित्र र आकांक्षाको पूर्तिलाई जनाउँछ। यो कुण्डलीको सबैभन्दा शुभ स्थान मध्ये एक मानिन्छ।','The eleventh house indicates gains, income, friends and fulfilment of desires. It is considered one of the most auspicious houses in the chart.',
'1. आय र लाभको स्रोत
2. मित्र, समूह र सामाजिक सम्बन्ध
3. आकांक्षा पूरा हुने समय
4. वृद्धि र विस्तारको अवसर
5. चन्द्र, गुरुले यहाँ लाभ दिन्छ','1. नयाँ आय र रोजगारी
2. शुभ मित्रको सहयोग
3. लाभ र बचत वृद्धि
4. अत्यधिक आशाले निराशा
5. त्याग र सहयोगले थप लाभ','Brihat Parashara Hora Shastra, Adhyaya 21 (Labha Phala)','लाभ','लाभ — आय र प्राप्ति'),
(12,'बाह्रौं भाव विदेश, मोक्ष, लागन, खर्च र अन्तिम जीवनलाई जनाउँछ। यसलाई दुःख स्थान भने पनि आध्यात्मिक मुक्तिको द्वार मानिन्छ।','The twelfth house signifies foreign travel, moksha, expenditure, confinement and the end of life. Though a house of loss, it is also the gateway to spiritual liberation.',
'1. विदेश निवास र यात्रा
2. खर्च, कर र लागन
3. निद्रा, ध्यान र अस्पताल
4. गुप्त शत्रु र मानसिक चिन्ता
5. मोक्ष र आध्यात्मिक सिद्धि','1. विदेशमा स्थायी हुने अवसर
2. खर्च नियन्त्रण र बचत
3. ध्यान र साधनामा शान्ति
4. अनावश्यक खर्चले तनाव
5. समाजसेवा र त्यागले कीर्ति','Brihat Parashara Hora Shastra, Adhyaya 24 (Vyaya Phala)','व्यय','व्यय — खर्च र त्याग');

INSERT INTO topic_remedies (topic_id, remedy_np, remedy_en, sort_order) VALUES
(1,'सुता (सातौं) भावलाई बलियो गर्न सोमबार रोज गायलाई गुड खुवाउने।','Feed jaggery to a cow on Mondays to strengthen the spouse house.',1),
(1,'लग्न बलियो गर्न प्रातःकालमा सूर्यलाई जल अर्पण गर्ने।','Offer water to the Sun at sunrise to strengthen the ascendant.',2),
(3,'मङ्गलबार मंगल ग्रहका मन्त्र जप्ने।','Chant the Mangala mantra on Tuesdays.',1),
(4,'चौथो भाव बलियो गर्न सोमबार कृष्ण प्रतिमामा दूध चढाउने।','Offer milk to a Krishna image on Mondays.',1),
(5,'पुत्र भावको लागि विष्णु सहस्त्रनामको पाठ गर्ने।','Recite Vishnu Sahasranama for the children house.',1),
(6,'रोग र शत्रु शान्तिका लागि महामृत्युञ्जय मन्त्रको जप गर्ने।','Chant the Maha Mrityunjaya mantra for health and enemies.',1),
(7,'वैवाहिक सुखका लागि शुक्रबार शिवलिंगमा जल चढाउने।','Offer water to a Shiva linga on Fridays for marital harmony.',1),
(8,'आउठौं भावको शान्तिका लागि महामृत्युञ्जय मन्त्र र प्रदक्षिणा गर्ने।','Chant the Maha Mrityunjaya mantra and perform circumambulation.',1),
(9,'भाग्य बलियो गर्न गुरुवार गायलाई चना खुवाउने।','Feed chickpeas to a cow on Thursdays to strengthen fortune.',1),
(10,'कर्म भाव बलियो गर्न सोमबार मा शिवलिंगमा दूध चढाउने।','Offer milk to a Shiva linga on Mondays to strengthen career.',1),
(11,'लाभ भाव बलियो गर्न प्रत्येक पूर्णिमामा शिवलिंगमा जल चढाउने।','Offer water to a Shiva linga on every full moon for gains.',1),
(12,'विदेश र मोक्षका लागि महाप्रसादमा भोजन गर्ने।','Take food as Mahaprasad for foreign prospects and liberation.',1);
